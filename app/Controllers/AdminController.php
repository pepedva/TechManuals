<?php
// app/Controllers/AdminController.php
namespace App\Controllers;

use App\Models\ManualModel;
use App\Models\OrderModel;
use App\Models\UserModel;

/**
 * AdminController
 * Panel de administración — solo accesible con rol 'admin'.
 * El filtro AdminFilter ya verifica el acceso antes de llegar aquí.
 */
class AdminController extends BaseController
{
    protected ManualModel $manualModel;
    protected OrderModel  $orderModel;
    protected UserModel   $userModel;

    public function __construct()
    {
        $this->manualModel = new ManualModel();
        $this->orderModel  = new OrderModel();
        $this->userModel   = new UserModel();
    }

    // ══════════════════════════════════════════════════════
    // DASHBOARD — Resumen general
    // ══════════════════════════════════════════════════════

    public function index(): string
    {
        $db = \Config\Database::connect();

        $data = [
            'title'   => 'Panel Admin — TechManuals',
            'section' => 'admin',

            // Estadísticas rápidas
            'stats' => [
                'total_users'    => $this->userModel->countAll(),
                'total_manuals'  => $this->manualModel->where('active', 1)->countAllResults(),
                'total_orders'   => $this->orderModel->where('status', 'completed')->countAllResults(),
                'total_revenue'  => $db->query("SELECT COALESCE(SUM(amount),0) AS total FROM orders WHERE status='completed'")->getRow()->total,
            ],

            // Últimas 5 órdenes
            'recent_orders' => $db->query("
                SELECT o.*, u.name AS user_name, u.email AS user_email, m.title AS manual_title
                FROM orders o
                JOIN users u   ON u.id = o.user_id
                JOIN manuals m ON m.id = o.manual_id
                ORDER BY o.created_at DESC
                LIMIT 5
            ")->getResultArray(),

            // Manuales más vendidos
            'top_manuals' => $db->query("
                SELECT m.title, m.price, COUNT(o.id) AS sales, SUM(o.amount) AS revenue
                FROM manuals m
                LEFT JOIN orders o ON o.manual_id = m.id AND o.status = 'completed'
                GROUP BY m.id
                ORDER BY sales DESC
                LIMIT 5
            ")->getResultArray(),

            // Mensajes no leídos
            'unread_messages' => $db->query("
                SELECT COUNT(*) AS total FROM contact_messages WHERE read_at IS NULL
            ")->getRow()->total,
        ];

        return view('layouts/main', $data + ['content' => view('admin/index', $data)]);
    }

    // ══════════════════════════════════════════════════════
    // MANUALES — Listado
    // ══════════════════════════════════════════════════════

    public function manuals(): string
    {
        $data = [
            'title'   => 'Gestionar Manuales — Admin',
            'section' => 'admin',
            'manuals' => $this->manualModel->select('manuals.*, categories.name AS category_name')
                             ->join('categories', 'categories.id = manuals.category_id')
                             ->orderBy('manuals.created_at', 'DESC')
                             ->findAll(),
        ];

        return view('layouts/main', $data + ['content' => view('admin/manuals', $data)]);
    }

    // ── Formulario para nuevo manual ─────────────────────
    public function newManual(): string
    {
        $db = \Config\Database::connect();
        $data = [
            'title'      => 'Nuevo Manual — Admin',
            'section'    => 'admin',
            'categories' => $db->table('categories')->orderBy('name')->get()->getResultArray(),
            'manual'     => null,
        ];

        return view('layouts/main', $data + ['content' => view('admin/manual_form', $data)]);
    }

    // ── Guardar nuevo manual ─────────────────────────────
    public function createManual()
    {
        $rules = [
            'title'       => 'required|min_length[5]|max_length[250]',
            'category_id' => 'required|integer',
            'price'       => 'required|decimal',
            'level'       => 'required|in_list[Básico,Intermedio,Avanzado]',
            'short_desc'  => 'required|max_length[400]',
            'description' => 'required',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Manejar subida del archivo PDF
        $file = $this->request->getFile('pdf_file');
        $filePath = null;

        if ($file && $file->isValid() && ! $file->hasMoved()) {
            if ($file->getMimeType() !== 'application/pdf') {
                return redirect()->back()->withInput()->with('errors', ['pdf_file' => 'Solo se permiten archivos PDF.']);
            }
            $fileName = $file->getRandomName();
            $file->move(ROOTPATH . 'storage/manuals/', $fileName);
            $filePath = '/manuals/' . $fileName;
        }

        // Manejar subida de imagen de portada
        $cover = $this->request->getFile('cover_image');
        $coverPath = null;

        if ($cover && $cover->isValid() && ! $cover->hasMoved()) {
            $coverName = $cover->getRandomName();
            $cover->move(WRITEPATH . '../public/images/covers/', $coverName);
            $coverPath = '/public/images/covers/' . $coverName;
        }

        // Generar slug único
        $slug = url_title($this->request->getPost('title'), '-', true);
        $slugBase = $slug;
        $i = 1;
        while ($this->manualModel->where('slug', $slug)->countAllResults() > 0) {
            $slug = $slugBase . '-' . $i++;
        }

        $this->manualModel->insert([
            'category_id' => $this->request->getPost('category_id'),
            'title'       => $this->request->getPost('title'),
            'slug'        => $slug,
            'short_desc'  => $this->request->getPost('short_desc'),
            'description' => $this->request->getPost('description'),
            'price'       => $this->request->getPost('price'),
            'level'       => $this->request->getPost('level'),
            'pages'       => $this->request->getPost('pages') ?: null,
            'language'    => $this->request->getPost('language') ?: 'Español',
            'file_path'   => $filePath ?? '/manuals/placeholder.pdf',
            'cover_image' => $coverPath,
            'featured'    => $this->request->getPost('featured') ? 1 : 0,
            'active'      => 1,
        ]);

        return redirect()->to('/admin/manuales')->with('success', 'Manual creado correctamente.');
    }

    // ── Formulario editar manual ─────────────────────────
    public function editManual(int $id): string
    {
        $db = \Config\Database::connect();
        $manual = $this->manualModel->find($id);

        if (! $manual) {
            return redirect()->to('/admin/manuales')->with('error', 'Manual no encontrado.');
        }

        $data = [
            'title'      => 'Editar Manual — Admin',
            'section'    => 'admin',
            'manual'     => $manual,
            'categories' => $db->table('categories')->orderBy('name')->get()->getResultArray(),
        ];

        return view('layouts/main', $data + ['content' => view('admin/manual_form', $data)]);
    }

    // ── Actualizar manual ────────────────────────────────
    public function updateManual(int $id)
    {
        $manual = $this->manualModel->find($id);
        if (! $manual) {
            return redirect()->to('/admin/manuales')->with('error', 'Manual no encontrado.');
        }

        $rules = [
            'title'       => 'required|min_length[5]|max_length[250]',
            'category_id' => 'required|integer',
            'price'       => 'required|decimal',
            'level'       => 'required|in_list[Básico,Intermedio,Avanzado]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $updateData = [
            'category_id' => $this->request->getPost('category_id'),
            'title'       => $this->request->getPost('title'),
            'short_desc'  => $this->request->getPost('short_desc'),
            'description' => $this->request->getPost('description'),
            'price'       => $this->request->getPost('price'),
            'level'       => $this->request->getPost('level'),
            'pages'       => $this->request->getPost('pages') ?: null,
            'language'    => $this->request->getPost('language') ?: 'Español',
            'featured'    => $this->request->getPost('featured') ? 1 : 0,
            'active'      => $this->request->getPost('active') ? 1 : 0,
        ];

        // Nuevo PDF si se subió uno
        $file = $this->request->getFile('pdf_file');
        if ($file && $file->isValid() && ! $file->hasMoved()) {
            if ($file->getMimeType() !== 'application/pdf') {
                return redirect()->back()->withInput()->with('errors', ['pdf_file' => 'Solo se permiten archivos PDF.']);
            }
            // Eliminar archivo anterior si existe
            $oldPath = ROOTPATH . 'storage' . $manual['file_path'];
            if (file_exists($oldPath)) {
                @unlink($oldPath);
            }
            $fileName = $file->getRandomName();
            $file->move(ROOTPATH . 'storage/manuals/', $fileName);
            $updateData['file_path'] = '/manuals/' . $fileName;
        }

        // Nueva portada si se subió una
        $cover = $this->request->getFile('cover_image');
        if ($cover && $cover->isValid() && ! $cover->hasMoved()) {
            $coverName = $cover->getRandomName();
            $cover->move(WRITEPATH . '../public/images/covers/', $coverName);
            $updateData['cover_image'] = '/public/images/covers/' . $coverName;
        }

        $this->manualModel->update($id, $updateData);

        return redirect()->to('/admin/manuales')->with('success', 'Manual actualizado correctamente.');
    }

    // ── Eliminar (desactivar) manual ─────────────────────
    public function deleteManual(int $id)
    {
        $this->manualModel->update($id, ['active' => 0]);
        return redirect()->to('/admin/manuales')->with('success', 'Manual desactivado.');
    }

    // ══════════════════════════════════════════════════════
    // ÓRDENES — Listado con filtros
    // ══════════════════════════════════════════════════════

    public function orders(): string
    {
        $db     = \Config\Database::connect();
        $status = $this->request->getGet('status') ?? '';

        $query = "
            SELECT o.*, u.name AS user_name, u.email AS user_email, m.title AS manual_title
            FROM orders o
            JOIN users u   ON u.id = o.user_id
            JOIN manuals m ON m.id = o.manual_id
        ";
        if ($status) {
            $query .= " WHERE o.status = " . $db->escape($status);
        }
        $query .= " ORDER BY o.created_at DESC LIMIT 100";

        $data = [
            'title'   => 'Órdenes — Admin',
            'section' => 'admin',
            'orders'  => $db->query($query)->getResultArray(),
            'filter'  => $status,
        ];

        return view('layouts/main', $data + ['content' => view('admin/orders', $data)]);
    }

    // ══════════════════════════════════════════════════════
    // MENSAJES DE CONTACTO
    // ══════════════════════════════════════════════════════

    public function messages(): string
    {
        $db = \Config\Database::connect();

        // Marcar todos como leídos al entrar
        $db->query("UPDATE contact_messages SET read_at = NOW() WHERE read_at IS NULL");

        $data = [
            'title'    => 'Mensajes — Admin',
            'section'  => 'admin',
            'messages' => $db->table('contact_messages')
                             ->orderBy('created_at', 'DESC')
                             ->get()->getResultArray(),
        ];

        return view('layouts/main', $data + ['content' => view('admin/messages', $data)]);
    }

    // ══════════════════════════════════════════════════════
    // USUARIOS
    // ══════════════════════════════════════════════════════

    public function users(): string
    {
        $db = \Config\Database::connect();

        $data = [
            'title'   => 'Usuarios — Admin',
            'section' => 'admin',
            'users'   => $db->query("
                SELECT u.*, COUNT(o.id) AS total_orders, COALESCE(SUM(o.amount),0) AS total_spent
                FROM users u
                LEFT JOIN orders o ON o.user_id = u.id AND o.status = 'completed'
                GROUP BY u.id
                ORDER BY u.created_at DESC
            ")->getResultArray(),
        ];

        return view('layouts/main', $data + ['content' => view('admin/users', $data)]);
    }
}
