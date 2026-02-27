<?php
// app/Controllers/ShopController.php
namespace App\Controllers;

use App\Models\ManualModel;
use App\Models\OrderModel;

/**
 * ShopController — Catálogo y detalle de manuales.
 */
class ShopController extends BaseController
{
    protected ManualModel $manualModel;
    protected OrderModel  $orderModel;

    public function __construct()
    {
        $this->manualModel = new ManualModel();
        $this->orderModel  = new OrderModel();
    }

    // ── PORTAFOLIO / Catálogo ────────────────────────────────
    public function portafolio(): string
    {
        $category = $this->request->getGet('categoria');
        $level    = $this->request->getGet('nivel');

        $data = [
            'title'    => 'Portafolio de Manuales — TechManuals',
            'section'  => 'portafolio',
            'manuals'  => $this->manualModel->getPortafolio($category, $level),
            'filters'  => ['categoria' => $category, 'nivel' => $level],
        ];

        return view('layouts/main', $data + ['content' => view('home/portafolio', $data)]);
    }

    // ── DETALLE de un manual ─────────────────────────────────
    public function detail(string $slug): string
    {
        $manual = $this->manualModel->getBySlug($slug);

        if (! $manual) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("Manual no encontrado: $slug");
        }

        $alreadyPurchased = false;
        if (session()->get('user_id')) {
            $alreadyPurchased = $this->orderModel->hasPurchased(
                session()->get('user_id'),
                $manual['id']
            );
        }

        $data = [
            'title'            => $manual['title'] . ' — TechManuals',
            'section'          => 'portafolio',
            'manual'           => $manual,
            'alreadyPurchased' => $alreadyPurchased,
            'paypalClientId'   => getenv('PAYPAL_CLIENT_ID'),
        ];

        return view('layouts/main', $data + ['content' => view('shop/detail', $data)]);
    }
}
