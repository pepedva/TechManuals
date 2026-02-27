<?php
// app/Controllers/HomeController.php
namespace App\Controllers;

use App\Models\ManualModel;
use App\Models\CategoryModel;
use CodeIgniter\Controller;

/**
 * HomeController
 * Maneja las 6 secciones principales del sitio:
 * Inicio, Misión, Visión, Quiénes Somos, Portafolio y Contacto.
 */
class HomeController extends BaseController
{
    protected ManualModel $manualModel;

    public function __construct()
    {
        $this->manualModel = new ManualModel();
    }

    // ── INICIO ───────────────────────────────────────────────
    public function index(): string
    {
        $data = [
            'title'    => 'TechManuals — Aprende tecnología a tu ritmo',
            'section'  => 'inicio',
            'featured' => $this->manualModel->getFeatured(6),
        ];
        return view('layouts/main', $data + ['content' => view('home/index', $data)]);
    }

    // ── MISIÓN ───────────────────────────────────────────────
    public function mision(): string
    {
        $data = [
            'title'   => 'Nuestra Misión — TechManuals',
            'section' => 'mision',
        ];
        return view('layouts/main', $data + ['content' => view('home/mision', $data)]);
    }

    // ── VISIÓN ───────────────────────────────────────────────
    public function vision(): string
    {
        $data = [
            'title'   => 'Nuestra Visión — TechManuals',
            'section' => 'vision',
        ];
        return view('layouts/main', $data + ['content' => view('home/vision', $data)]);
    }

    // ── QUIÉNES SOMOS ────────────────────────────────────────
    public function quienesSomos(): string
    {
        $data = [
            'title'   => 'Quiénes Somos — TechManuals',
            'section' => 'quienes-somos',
        ];
        return view('layouts/main', $data + ['content' => view('home/quienes_somos', $data)]);
    }

    // ── CONTACTO ─────────────────────────────────────────────
    public function contacto(): string
    {
        $data = [
            'title'   => 'Contacto — TechManuals',
            'section' => 'contacto',
        ];
        return view('layouts/main', $data + ['content' => view('home/contacto', $data)]);
    }

    // ── ENVIAR MENSAJE DE CONTACTO ───────────────────────────
    public function sendContact()
    {
        $rules = [
            'name'    => 'required|min_length[2]|max_length[150]',
            'email'   => 'required|valid_email',
            'subject' => 'required|min_length[5]|max_length[250]',
            'message' => 'required|min_length[10]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $db = \Config\Database::connect();
        $db->table('contact_messages')->insert([
            'name'       => $this->request->getPost('name'),
            'email'      => $this->request->getPost('email'),
            'subject'    => $this->request->getPost('subject'),
            'message'    => $this->request->getPost('message'),
            'ip_address' => $this->request->getIPAddress(),
        ]);

        // Enviar email de notificación al admin
        $email = \Config\Services::email();
        $email->setTo(getenv('email.fromEmail'));
        $email->setSubject('Nuevo mensaje de contacto: ' . $this->request->getPost('subject'));
        $email->setMessage(view('email/contact_notification', [
            'name'    => $this->request->getPost('name'),
            'email'   => $this->request->getPost('email'),
            'message' => $this->request->getPost('message'),
        ]));
        $email->send();

        return redirect()->to('/contacto')->with('success', '¡Mensaje enviado! Te responderemos pronto.');
    }
}
