<?php
// app/Controllers/DownloadController.php
namespace App\Controllers;

use App\Models\DownloadTokenModel;
use App\Models\OrderModel;
use App\Models\ManualModel;

/**
 * DownloadController
 * Valida el token temporal y sirve el archivo PDF de forma segura.
 * El archivo NUNCA está en una ruta pública del servidor.
 */
class DownloadController extends BaseController
{
    protected DownloadTokenModel $tokenModel;
    protected OrderModel         $orderModel;
    protected ManualModel        $manualModel;

    public function __construct()
    {
        $this->tokenModel  = new DownloadTokenModel();
        $this->orderModel  = new OrderModel();
        $this->manualModel = new ManualModel();
    }

    public function download(string $token)
    {
        // 1. Validar que el token exista, no esté usado y no haya expirado
        $tokenData = $this->tokenModel->validateToken($token);

        if (! $tokenData) {
            return view('layouts/main', [
                'title'   => 'Link inválido — TechManuals',
                'section' => '',
                'content' => view('shop/download_error', [
                    'reason' => 'El link de descarga es inválido, ya fue usado o ha expirado.',
                    'hint'   => 'Puedes generar un nuevo link desde <a href="/mis-compras">Mis Compras</a>.',
                ]),
            ]);
        }

        // 2. Obtener la orden y el manual
        $order  = $this->orderModel->find($tokenData['order_id']);
        $manual = $this->manualModel->find($order['manual_id']);

        if (! $order || $order['status'] !== 'completed' || ! $manual) {
            return redirect()->to('/')->with('error', 'No se encontró información de la compra.');
        }

        // 3. Construir la ruta real del archivo (fuera del webroot)
        //    Ejemplo: /var/www/storage/manuals/python-fundamentos.pdf
        $filePath = ROOTPATH . 'storage' . $manual['file_path'];
        // Alternativa si guardas por ID: ROOTPATH . 'storage/manuals/' . $manual['id'] . '.pdf'

        if (! file_exists($filePath)) {
            log_message('error', 'Archivo no encontrado: ' . $filePath);
            return redirect()->to('/mis-compras')->with('error', 'El archivo no está disponible temporalmente. Contacta soporte.');
        }

        // 4. Marcar el token como usado (un solo uso)
        $this->tokenModel->markUsed($token, $this->request->getIPAddress());

        // 5. Registrar la descarga
        $this->manualModel->incrementDownload($manual['id']);

        // 6. Servir el archivo de forma segura con headers correctos
        $fileName = slugify($manual['title']) . '.pdf';

        return $this->response
            ->setHeader('Content-Type', 'application/pdf')
            ->setHeader('Content-Disposition', 'attachment; filename="' . $fileName . '"')
            ->setHeader('Content-Length', filesize($filePath))
            ->setHeader('Cache-Control', 'no-store, no-cache, must-revalidate')
            ->setHeader('Pragma', 'no-cache')
            ->setHeader('Expires', '0')
            ->setBody(file_get_contents($filePath));
    }

    /**
     * Generar un nuevo token de descarga para una compra ya realizada.
     * (Por si el link original expiró)
     */
    public function regenerate(int $orderId)
    {
        if (! session()->get('user_id')) {
            return redirect()->to('/login');
        }

        $order = $this->orderModel->find($orderId);

        // Verificar que la orden pertenece al usuario
        if (! $order || $order['user_id'] != session()->get('user_id') || $order['status'] !== 'completed') {
            return redirect()->to('/mis-compras')->with('error', 'No tienes permiso para esta acción.');
        }

        $hours = (int) (getenv('DOWNLOAD_LINK_HOURS') ?: 24);
        $token = $this->tokenModel->createToken($orderId, $hours);

        return redirect()->to('/mis-compras')->with('success',
            '¡Nuevo link generado! Válido por ' . $hours . ' horas. <a href="' . base_url('descargar/' . $token) . '">Descargar ahora</a>'
        );
    }
}

// Helper simple de slugify
function slugify(string $text): string {
    $text = mb_strtolower($text, 'UTF-8');
    $text = preg_replace('/[áàä]/u', 'a', $text);
    $text = preg_replace('/[éèë]/u', 'e', $text);
    $text = preg_replace('/[íìï]/u', 'i', $text);
    $text = preg_replace('/[óòö]/u', 'o', $text);
    $text = preg_replace('/[úùü]/u', 'u', $text);
    $text = preg_replace('/ñ/u', 'n', $text);
    $text = preg_replace('/[^a-z0-9]+/', '-', $text);
    return trim($text, '-');
}
