<?php
// app/Controllers/AuthController.php
namespace App\Controllers;

use App\Models\UserModel;

/**
 * AuthController
 * Login local + OAuth Google y Facebook.
 *
 * Dependencias (instalar con Composer):
 *   composer require google/apiclient:"^2.0"
 *   composer require facebook/graph-sdk:"^5.7"
 */
class AuthController extends BaseController
{
    protected UserModel $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    // ══════════════════════════════════════════════════════════
    // LOGIN LOCAL
    // ══════════════════════════════════════════════════════════

    public function loginForm(): string
    {
        if (session()->get('user_id')) {
            return redirect()->to('/');
        }
        return view('layouts/main', [
            'title'   => 'Iniciar Sesión — TechManuals',
            'section' => 'login',
            'content' => view('auth/login'),
        ]);
    }

    public function loginPost()
    {
        $rules = [
            'email'    => 'required|valid_email',
            'password' => 'required|min_length[6]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $email = $this->request->getPost('email');
        $pass  = $this->request->getPost('password');
        $user  = $this->userModel->findByEmail($email);

        if (! $user || ! password_verify($pass, $user['password'])) {
            return redirect()->back()->withInput()->with('error', 'Credenciales incorrectas.');
        }

        $this->setUserSession($user);
        return redirect()->to(session()->get('redirect_after_login') ?? '/')->with('success', '¡Bienvenida de vuelta, ' . $user['name'] . '!');
    }

    // ══════════════════════════════════════════════════════════
    // REGISTRO LOCAL
    // ══════════════════════════════════════════════════════════

    public function registerForm(): string
    {
        return view('layouts/main', [
            'title'   => 'Crear Cuenta — TechManuals',
            'section' => 'register',
            'content' => view('auth/register'),
        ]);
    }

    public function registerPost()
    {
        $rules = [
            'name'     => 'required|min_length[2]|max_length[150]',
            'email'    => 'required|valid_email|is_unique[users.email]',
            'password' => 'required|min_length[8]',
            'confirm'  => 'required|matches[password]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $id = $this->userModel->insert([
            'name'           => $this->request->getPost('name'),
            'email'          => $this->request->getPost('email'),
            'password'       => password_hash($this->request->getPost('password'), PASSWORD_BCRYPT),
            'provider'       => 'local',
            'email_verified' => 1,
        ]);

        $user = $this->userModel->find($id);
        $this->setUserSession($user);
        return redirect()->to('/portafolio')->with('success', '¡Cuenta creada! Explora nuestros manuales.');
    }

    // ══════════════════════════════════════════════════════════
    // GOOGLE OAUTH
    // ══════════════════════════════════════════════════════════

    public function googleRedirect()
    {
        $client = $this->getGoogleClient();
        return redirect()->to($client->createAuthUrl());
    }

    public function googleCallback()
    {
        $code = $this->request->getGet('code');
        if (! $code) {
            return redirect()->to('/login')->with('error', 'Autenticación con Google cancelada.');
        }

        try {
            $client = $this->getGoogleClient();
            $token  = $client->fetchAccessTokenWithAuthCode($code);

            if (isset($token['error'])) {
                throw new \Exception($token['error_description'] ?? 'Error de Google OAuth');
            }

            $client->setAccessToken($token);
            $service  = new \Google\Service\Oauth2($client);
            $userInfo = $service->userinfo->get();

            $user = $this->userModel->findOrCreateOAuth([
                'name'        => $userInfo->getName(),
                'email'       => $userInfo->getEmail(),
                'avatar'      => $userInfo->getPicture(),
                'provider'    => 'google',
                'provider_id' => $userInfo->getId(),
            ]);

            $this->setUserSession($user);
            return redirect()->to(session()->get('redirect_after_login') ?? '/')->with('success', '¡Bienvenida, ' . $user['name'] . '!');

        } catch (\Exception $e) {
            log_message('error', 'Google OAuth: ' . $e->getMessage());
            return redirect()->to('/login')->with('error', 'Error al iniciar sesión con Google. Intenta de nuevo.');
        }
    }

    private function getGoogleClient(): \Google\Client
    {
        $client = new \Google\Client();
        $client->setClientId(getenv('GOOGLE_CLIENT_ID'));
        $client->setClientSecret(getenv('GOOGLE_CLIENT_SECRET'));
        $client->setRedirectUri(base_url('auth/google/callback'));
        $client->addScope(\Google\Service\Oauth2::USERINFO_EMAIL);
        $client->addScope(\Google\Service\Oauth2::USERINFO_PROFILE);
        $client->setAccessType('offline');
        return $client;
    }

    // ══════════════════════════════════════════════════════════
    // FACEBOOK OAUTH  (usa league/oauth2-facebook)
    // ══════════════════════════════════════════════════════════

    public function facebookRedirect()
    {
        $provider = $this->getFacebookProvider();
        $url      = $provider->getAuthorizationUrl(['scope' => ['email', 'public_profile']]);
        session()->set('oauth2_facebook_state', $provider->getState());
        return redirect()->to($url);
    }

    public function facebookCallback()
    {
        $state = $this->request->getGet('state');
        $code  = $this->request->getGet('code');

        if (! $code) {
            return redirect()->to('/login')->with('error', 'Autenticación con Facebook cancelada.');
        }

        // Verificar state para prevenir CSRF
        if ($state !== session()->get('oauth2_facebook_state')) {
            return redirect()->to('/login')->with('error', 'Estado inválido. Intenta de nuevo.');
        }

        try {
            $provider    = $this->getFacebookProvider();
            $token       = $provider->getAccessToken('authorization_code', ['code' => $code]);
            $fbUser      = $provider->getResourceOwner($token);
            $fbUserArray = $fbUser->toArray();

            $user = $this->userModel->findOrCreateOAuth([
                'name'        => $fbUser->getName(),
                'email'       => $fbUser->getEmail() ?? 'fb_' . $fbUser->getId() . '@facebook.local',
                'avatar'      => $fbUserArray['picture']['data']['url'] ?? null,
                'provider'    => 'facebook',
                'provider_id' => $fbUser->getId(),
            ]);

            $this->setUserSession($user);
            return redirect()->to(session()->get('redirect_after_login') ?? '/')->with('success', '¡Bienvenida, ' . $user['name'] . '!');

        } catch (\Exception $e) {
            log_message('error', 'Facebook OAuth: ' . $e->getMessage());
            return redirect()->to('/login')->with('error', 'Error al iniciar sesión con Facebook. Intenta de nuevo.');
        }
    }

    private function getFacebookProvider(): \League\OAuth2\Client\Provider\Facebook
    {
        return new \League\OAuth2\Client\Provider\Facebook([
            'clientId'        => getenv('FACEBOOK_APP_ID'),
            'clientSecret'    => getenv('FACEBOOK_APP_SECRET'),
            'redirectUri'     => base_url('auth/facebook/callback'),
            'graphApiVersion' => 'v18.0',
        ]);
    }

    // ══════════════════════════════════════════════════════════
    // LOGOUT
    // ══════════════════════════════════════════════════════════

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/')->with('success', 'Sesión cerrada correctamente.');
    }

    // ── Helper: guardar datos en sesión ──────────────────────
    private function setUserSession(array $user): void
    {
        session()->set([
            'user_id'     => $user['id'],
            'user_name'   => $user['name'],
            'user_email'  => $user['email'],
            'user_avatar' => $user['avatar'],
            'user_role'   => $user['role'],
        ]);
        session()->remove('redirect_after_login');
    }
}
