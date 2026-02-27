<!-- app/Views/auth/login.php -->
<style>
  .auth-page {
    min-height: calc(100vh - 72px);
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 60px 20px;
    background: linear-gradient(135deg, #fff0f6 0%, #f5eeff 100%);
  }

  .auth-card {
    background: white;
    border-radius: var(--radius-lg);
    padding: 48px 40px;
    width: 100%;
    max-width: 460px;
    box-shadow: var(--shadow-lg);
    border: 1px solid rgba(212,80,122,.08);
  }

  .auth-logo {
    text-align: center;
    margin-bottom: 32px;
  }

  .auth-logo h2 {
    font-family: var(--font-display);
    font-size: 1.8rem;
    color: var(--charcoal);
    margin-bottom: 4px;
  }

  .auth-logo h2 span { color: var(--rose); }
  .auth-logo p { font-size: 0.9rem; color: #aaa; }

  /* OAuth buttons */
  .oauth-group { display: flex; flex-direction: column; gap: 12px; margin-bottom: 28px; }

  .oauth-btn {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 12px;
    padding: 14px;
    border-radius: var(--radius);
    font-size: 0.9rem;
    font-weight: 600;
    border: 1.5px solid var(--gray-light);
    background: white;
    color: var(--charcoal);
    cursor: pointer;
    transition: var(--transition);
    text-decoration: none;
  }

  .oauth-btn:hover {
    border-color: var(--rose);
    background: var(--rose-light);
    color: var(--rose-deep);
  }

  .oauth-btn img { width: 20px; height: 20px; }

  .oauth-btn.facebook {
    background: #1877f2;
    color: white;
    border-color: #1877f2;
  }

  .oauth-btn.facebook:hover {
    background: #166fe5;
    color: white;
    border-color: #166fe5;
  }

  .divider {
    display: flex;
    align-items: center;
    gap: 12px;
    margin: 24px 0;
  }

  .divider::before,
  .divider::after {
    content: '';
    flex: 1;
    height: 1px;
    background: var(--gray-light);
  }

  .divider span {
    font-size: 0.78rem;
    color: #ccc;
    text-transform: uppercase;
    letter-spacing: .08em;
    font-weight: 600;
  }

  .error-box {
    background: #fff0f4;
    border: 1.5px solid var(--rose-light);
    border-radius: var(--radius);
    padding: 14px 16px;
    font-size: 0.88rem;
    color: var(--rose-deep);
    margin-bottom: 20px;
  }

  .auth-footer {
    text-align: center;
    margin-top: 24px;
    font-size: 0.88rem;
    color: #aaa;
  }

  .auth-footer a { color: var(--rose); font-weight: 600; }
</style>

<section class="auth-page">
  <div class="auth-card">
    <div class="auth-logo">
      <h2>Tech<span>Manuals</span></h2>
      <p>Inicia sesión para acceder a tus manuales</p>
    </div>

    <?php if (session()->getFlashdata('error')): ?>
      <div class="error-box">❌ <?= session()->getFlashdata('error') ?></div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('errors')): ?>
      <div class="error-box">
        <?php foreach (session()->getFlashdata('errors') as $e): ?>
          <div>• <?= esc($e) ?></div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>

    <!-- OAuth -->
    <div class="oauth-group">
      <a href="/auth/google" class="oauth-btn">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20">
          <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
          <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
          <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/>
          <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
        </svg>
        Continuar con Google
      </a>

      <a href="/auth/facebook" class="oauth-btn facebook">
        <i class="fab fa-facebook-f" style="font-size:18px"></i>
        Continuar con Facebook
      </a>
    </div>

    <div class="divider"><span>o con tu email</span></div>

    <!-- Formulario -->
    <form action="/login" method="POST">
      <?= csrf_field() ?>

      <div class="form-group">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" class="form-control"
          value="<?= old('email') ?>" placeholder="tu@email.com" required autocomplete="email" />
      </div>

      <div class="form-group">
        <label for="password">Contraseña</label>
        <input type="password" id="password" name="password" class="form-control"
          placeholder="••••••••" required autocomplete="current-password" />
      </div>

      <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center;margin-top:8px">
        <i class="fas fa-sign-in-alt"></i> Iniciar sesión
      </button>
    </form>

    <div class="auth-footer">
      ¿No tienes cuenta? <a href="/register">Créala gratis</a>
    </div>
  </div>
</section>
