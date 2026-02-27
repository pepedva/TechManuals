<!-- app/Views/auth/register.php -->
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
    max-width: 480px;
    box-shadow: var(--shadow-lg);
    border: 1px solid rgba(212, 80, 122, .08);
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
  .auth-logo p { font-size: .9rem; color: #aaa; }

  /* OAuth */
  .oauth-group { display: flex; flex-direction: column; gap: 12px; margin-bottom: 28px; }

  .oauth-btn {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 12px;
    padding: 13px;
    border-radius: var(--radius);
    font-size: .9rem;
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
    font-size: .78rem;
    color: #ccc;
    text-transform: uppercase;
    letter-spacing: .08em;
    font-weight: 600;
  }

  /* Errores */
  .error-box {
    background: #fff0f4;
    border: 1.5px solid var(--rose-light);
    border-radius: var(--radius);
    padding: 14px 16px;
    margin-bottom: 20px;
  }

  .error-box div {
    font-size: .85rem;
    color: var(--rose-deep);
    margin-bottom: 4px;
  }

  .error-box div:last-child { margin-bottom: 0; }

  /* Indicador de fortaleza de contraseña */
  .password-strength {
    margin-top: 8px;
    display: flex;
    gap: 4px;
  }

  .strength-bar {
    height: 4px;
    flex: 1;
    border-radius: 2px;
    background: var(--gray-light);
    transition: var(--transition);
  }

  .strength-bar.active.weak   { background: #f44336; }
  .strength-bar.active.medium { background: #ff9800; }
  .strength-bar.active.strong { background: #4caf50; }

  .strength-label {
    font-size: .75rem;
    color: #bbb;
    margin-top: 6px;
  }

  /* Términos */
  .terms-check {
    display: flex;
    align-items: flex-start;
    gap: 10px;
    margin: 16px 0 20px;
  }

  .terms-check input[type="checkbox"] {
    margin-top: 3px;
    accent-color: var(--rose);
    width: 16px;
    height: 16px;
    flex-shrink: 0;
    cursor: pointer;
  }

  .terms-check label {
    font-size: .83rem;
    color: #888;
    cursor: pointer;
    font-weight: 400;
    margin-bottom: 0;
  }

  .terms-check a { color: var(--rose); font-weight: 600; }

  /* Footer */
  .auth-footer {
    text-align: center;
    margin-top: 24px;
    font-size: .88rem;
    color: #aaa;
  }

  .auth-footer a { color: var(--rose); font-weight: 600; }

  /* Beneficios rápidos */
  .register-benefits {
    display: flex;
    flex-direction: column;
    gap: 8px;
    background: var(--gray-light);
    border-radius: var(--radius);
    padding: 16px 20px;
    margin-bottom: 24px;
  }

  .benefit-item {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: .83rem;
    color: #666;
  }

  .benefit-item i {
    color: var(--rose);
    font-size: 12px;
    width: 14px;
  }
</style>

<section class="auth-page">
  <div class="auth-card">

    <div class="auth-logo">
      <h2>Tech<span>Manuals</span></h2>
      <p>Crea tu cuenta gratis y empieza a aprender</p>
    </div>

    <!-- Beneficios -->
    <div class="register-benefits">
      <div class="benefit-item"><i class="fas fa-check-circle"></i> Acceso a todos los manuales del catálogo</div>
      <div class="benefit-item"><i class="fas fa-check-circle"></i> Historial de compras en un solo lugar</div>
      <div class="benefit-item"><i class="fas fa-check-circle"></i> Links de descarga siempre disponibles</div>
    </div>

    <!-- Errores -->
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
        Registrarse con Google
      </a>

      <a href="/auth/facebook" class="oauth-btn facebook">
        <i class="fab fa-facebook-f" style="font-size:18px"></i>
        Registrarse con Facebook
      </a>
    </div>

    <div class="divider"><span>o con tu email</span></div>

    <!-- Formulario -->
    <form action="/register" method="POST">
      <?= csrf_field() ?>

      <div class="form-group">
        <label for="name">Nombre completo</label>
        <input
          type="text"
          id="name"
          name="name"
          class="form-control"
          value="<?= old('name') ?>"
          placeholder="Tu nombre"
          required
          autocomplete="name"
        />
      </div>

      <div class="form-group">
        <label for="email">Email</label>
        <input
          type="email"
          id="email"
          name="email"
          class="form-control"
          value="<?= old('email') ?>"
          placeholder="tu@email.com"
          required
          autocomplete="email"
        />
      </div>

      <div class="form-group">
        <label for="password">Contraseña</label>
        <input
          type="password"
          id="password"
          name="password"
          class="form-control"
          placeholder="Mínimo 8 caracteres"
          required
          autocomplete="new-password"
          oninput="checkStrength(this.value)"
        />
        <!-- Barra de fortaleza -->
        <div class="password-strength">
          <div class="strength-bar" id="bar1"></div>
          <div class="strength-bar" id="bar2"></div>
          <div class="strength-bar" id="bar3"></div>
          <div class="strength-bar" id="bar4"></div>
        </div>
        <div class="strength-label" id="strengthLabel">Ingresa una contraseña</div>
      </div>

      <div class="form-group">
        <label for="confirm">Confirmar contraseña</label>
        <input
          type="password"
          id="confirm"
          name="confirm"
          class="form-control"
          placeholder="Repite tu contraseña"
          required
          autocomplete="new-password"
        />
      </div>

      <div class="terms-check">
        <input type="checkbox" id="terms" name="terms" required />
        <label for="terms">
          Acepto los <a href="#">Términos de Uso</a> y la
          <a href="#">Política de Privacidad</a> de TechManuals
        </label>
      </div>

      <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center">
        <i class="fas fa-user-plus"></i> Crear mi cuenta
      </button>
    </form>

    <div class="auth-footer">
      ¿Ya tienes cuenta? <a href="/login">Inicia sesión</a>
    </div>

  </div>
</section>

<script>
  function checkStrength(value) {
    const bars   = [
      document.getElementById('bar1'),
      document.getElementById('bar2'),
      document.getElementById('bar3'),
      document.getElementById('bar4'),
    ];
    const label  = document.getElementById('strengthLabel');

    // Resetear
    bars.forEach(b => { b.className = 'strength-bar'; });

    if (value.length === 0) {
      label.textContent = 'Ingresa una contraseña';
      label.style.color = '#bbb';
      return;
    }

    let score = 0;
    if (value.length >= 8)              score++;
    if (/[A-Z]/.test(value))            score++;
    if (/[0-9]/.test(value))            score++;
    if (/[^A-Za-z0-9]/.test(value))     score++;

    const levels = ['weak','weak','medium','strong'];
    const labels = ['Muy débil','Débil','Moderada','Fuerte 💪'];
    const colors = ['#f44336','#f44336','#ff9800','#4caf50'];

    for (let i = 0; i < score; i++) {
      bars[i].classList.add('active', levels[score - 1]);
    }

    label.textContent  = 'Contraseña ' + labels[score - 1];
    label.style.color  = colors[score - 1];
  }
</script>
