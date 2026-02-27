<?php
// app/Controllers/PaymentController.php
namespace App\Controllers;

use App\Models\ManualModel;
use App\Models\OrderModel;
use App\Models\DownloadTokenModel;

/**
 * PaymentController — Integración con PayPal REST API (SDK v2).
 *
 * Instalar: composer require paypal/paypal-checkout-sdk
 * Docs: https://developer.paypal.com/docs/checkout/
 */
class PaymentController extends BaseController
{
    protected ManualModel       $manualModel;
    protected OrderModel        $orderModel;
    protected DownloadTokenModel $tokenModel;

    public function __construct()
    {
        $this->manualModel = new ManualModel();
        $this->orderModel  = new OrderModel();
        $this->tokenModel  = new DownloadTokenModel();
    }

    // ── Página de checkout ───────────────────────────────────
    public function checkout(int $manualId): string
    {
        $manual = $this->manualModel->find($manualId);
        if (! $manual || ! $manual['active']) {
            return redirect()->to('/portafolio')->with('error', 'Manual no disponible.');
        }

        if ($this->orderModel->hasPurchased(session()->get('user_id'), $manualId)) {
            return redirect()->to('/mis-compras')->with('info', 'Ya tienes este manual en tu biblioteca.');
        }

        return view('layouts/main', [
            'title'         => 'Checkout — ' . $manual['title'],
            'section'       => 'checkout',
            'manual'        => $manual,
            'paypalClientId'=> getenv('PAYPAL_CLIENT_ID'),
            'content'       => view('shop/checkout', ['manual' => $manual, 'paypalClientId' => getenv('PAYPAL_CLIENT_ID')]),
        ]);
    }

    // ── Crear orden en PayPal (llamada AJAX desde JS) ────────
    public function createOrder()
    {
        $manualId = $this->request->getPost('manual_id');
        $manual   = $this->manualModel->find($manualId);

        if (! $manual) {
            return $this->response->setJSON(['error' => 'Manual no encontrado'])->setStatusCode(404);
        }

        try {
            $client  = $this->getPayPalClient();
            $request = new \PayPalCheckoutSdk\Orders\OrdersCreateRequest();
            $request->prefer('return=representation');
            $request->body = [
                'intent'              => 'CAPTURE',
                'purchase_units'      => [[
                    'reference_id'    => 'manual_' . $manual['id'],
                    'description'     => $manual['title'],
                    'amount'          => [
                        'currency_code' => getenv('PAYPAL_CURRENCY') ?: 'USD',
                        'value'         => number_format($manual['price'], 2, '.', ''),
                    ],
                ]],
                'application_context' => [
                    'brand_name' => 'TechManuals Store',
                    'locale'     => 'es-MX',
                    'user_action'=> 'PAY_NOW',
                ],
            ];

            $response = $client->execute($request);

            // Crear orden pendiente en nuestra BD
            $orderId = $this->orderModel->insert([
                'user_id'        => session()->get('user_id'),
                'manual_id'      => $manual['id'],
                'paypal_order_id'=> $response->result->id,
                'amount'         => $manual['price'],
                'currency'       => getenv('PAYPAL_CURRENCY') ?: 'USD',
                'status'         => 'pending',
                'buyer_email'    => session()->get('user_email'),
            ]);

            return $this->response->setJSON([
                'id'       => $response->result->id,
                'order_db' => $orderId,
            ]);

        } catch (\Exception $e) {
            log_message('error', 'PayPal createOrder: ' . $e->getMessage());
            return $this->response->setJSON(['error' => 'Error al crear la orden de pago.'])->setStatusCode(500);
        }
    }

    // ── Capturar pago confirmado por PayPal ──────────────────
    public function captureOrder()
    {
        $paypalOrderId = $this->request->getPost('paypal_order_id');
        $orderDbId     = $this->request->getPost('order_db_id');

        if (! $paypalOrderId || ! $orderDbId) {
            return $this->response->setJSON(['error' => 'Datos incompletos'])->setStatusCode(400);
        }

        try {
            $client  = $this->getPayPalClient();
            $request = new \PayPalCheckoutSdk\Orders\OrdersCaptureRequest($paypalOrderId);
            $request->prefer('return=representation');

            $response    = $client->execute($request);
            $capture     = $response->result->purchase_units[0]->payments->captures[0];
            $captureId   = $capture->id;
            $captureStatus = $capture->status; // COMPLETED

            if ($captureStatus === 'COMPLETED') {
                // Actualizar orden en BD
                $this->orderModel->update($orderDbId, [
                    'paypal_transaction_id' => $captureId,
                    'status'                => 'completed',
                ]);

                // Obtener la orden completa
                $order = $this->orderModel->find($orderDbId);

                // Generar token de descarga (válido 24h)
                $hours = (int) (getenv('DOWNLOAD_LINK_HOURS') ?: 24);
                $token = $this->tokenModel->createToken((int) $orderDbId, $hours);

                // Incrementar contador de descargas del manual
                $this->manualModel->incrementDownload($order['manual_id']);

                // Enviar email con link de descarga
                $this->sendPurchaseEmail($order, $token, $hours);

                return $this->response->setJSON([
                    'success'       => true,
                    'redirect'      => base_url('checkout/success/' . $orderDbId),
                    'download_token'=> $token,
                ]);
            }

            return $this->response->setJSON(['error' => 'Pago no completado: ' . $captureStatus])->setStatusCode(400);

        } catch (\Exception $e) {
            log_message('error', 'PayPal captureOrder: ' . $e->getMessage());
            return $this->response->setJSON(['error' => 'Error al confirmar el pago.'])->setStatusCode(500);
        }
    }

    // ── Página de éxito ──────────────────────────────────────
    public function success(int $orderId): string
    {
        $order = $this->orderModel->getUserPurchases(session()->get('user_id'));
        $order = array_filter($order, fn($o) => $o['id'] == $orderId);
        $order = reset($order);

        if (! $order || $order['status'] !== 'completed') {
            return redirect()->to('/');
        }

        return view('layouts/main', [
            'title'   => '¡Compra Exitosa! — TechManuals',
            'section' => 'checkout',
            'order'   => $order,
            'content' => view('shop/success', ['order' => $order]),
        ]);
    }

    // ── Cancelación de pago ──────────────────────────────────
    public function cancel()
    {
        return redirect()->to('/portafolio')->with('info', 'Pago cancelado. Puedes intentarlo cuando quieras.');
    }

    // ── Mis compras ──────────────────────────────────────────
    public function myPurchases(): string
    {
        $data = [
            'title'     => 'Mis Compras — TechManuals',
            'section'   => 'mis-compras',
            'purchases' => $this->orderModel->getUserPurchases(session()->get('user_id')),
        ];
        return view('layouts/main', $data + ['content' => view('shop/my_purchases', $data)]);
    }

    // ── Helper: cliente PayPal ───────────────────────────────
    private function getPayPalClient(): \PayPalCheckoutSdk\Core\PayPalHttpClient
    {
        $mode = getenv('PAYPAL_MODE') === 'live' ? 'live' : 'sandbox';

        if ($mode === 'live') {
            $env = new \PayPalCheckoutSdk\Core\ProductionEnvironment(
                getenv('PAYPAL_CLIENT_ID'),
                getenv('PAYPAL_CLIENT_SECRET')
            );
        } else {
            $env = new \PayPalCheckoutSdk\Core\SandboxEnvironment(
                getenv('PAYPAL_CLIENT_ID'),
                getenv('PAYPAL_CLIENT_SECRET')
            );
        }

        return new \PayPalCheckoutSdk\Core\PayPalHttpClient($env);
    }

    // ── Helper: email de confirmación con link de descarga ───
    private function sendPurchaseEmail(array $order, string $token, int $hours): void
    {
        try {
            $manual    = $this->manualModel->find($order['manual_id']);
            $emailSvc  = \Config\Services::email();
            $emailSvc->setTo(session()->get('user_email'));
            $emailSvc->setSubject('✅ Tu manual está listo — TechManuals');
            $emailSvc->setMessage(view('email/purchase_confirmation', [
                'userName'     => session()->get('user_name'),
                'manualTitle'  => $manual['title'],
                'downloadLink' => base_url('descargar/' . $token),
                'expiresIn'    => $hours,
                'amount'       => $order['amount'],
                'currency'     => $order['currency'],
            ]));
            $emailSvc->send();
        } catch (\Exception $e) {
            log_message('error', 'sendPurchaseEmail: ' . $e->getMessage());
        }
    }
}
