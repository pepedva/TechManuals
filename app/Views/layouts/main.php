<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?= esc($title ?? 'TechManuals Store') ?></title>

  <!-- Fuentes: Cormorant Garamond (display elegante) + DM Sans (body limpio) -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;1,400;1,600&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet" />

  <!-- Font Awesome para íconos -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

  <style>
    /* ═══════════════════════════════════════════════════════
       VARIABLES Y RESET
    ═══════════════════════════════════════════════════════ */
    :root {
      --rose:       #d4507a;
      --rose-deep:  #b03060;
      --rose-light: #f7d6e3;
      --mauve:      #9b6b9b;
      --cream:      #fdf8f2;
      --ivory:      #fef9f5;
      --charcoal:   #2c2c2c;
      --gray-light: #f0ebe6;
      --gold:       #c9a84c;
      --gold-light: #f0e0b0;
      --white:      #ffffff;
      --shadow:     0 4px 24px rgba(180, 80, 100, 0.12);
      --shadow-lg:  0 16px 48px rgba(180, 80, 100, 0.18);
      --font-display: 'Cormorant Garamond', Georgia, serif;
      --font-body:    'DM Sans', system-ui, sans-serif;
      --radius:     12px;
      --radius-lg:  24px;
      --transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
    }

    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    html { scroll-behavior: smooth; }

    body {
      font-family: var(--font-body);
      background: var(--cream);
      color: var(--charcoal);
      line-height: 1.7;
      font-size: 16px;
    }

    a { color: var(--rose); text-decoration: none; transition: var(--transition); }
    a:hover { color: var(--rose-deep); }

    img { max-width: 100%; height: auto; display: block; }

    /* ═══════════════════════════════════════════════════════
       NAVBAR
    ═══════════════════════════════════════════════════════ */
    .navbar {
      position: fixed;
      top: 0; left: 0; right: 0;
      z-index: 999;
      background: rgba(253, 248, 242, 0.92);
      backdrop-filter: blur(16px);
      -webkit-backdrop-filter: blur(16px);
      border-bottom: 1px solid rgba(212, 80, 122, 0.12);
      padding: 0 5%;
      height: 72px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      transition: var(--transition);
    }

    .navbar.scrolled {
      box-shadow: 0 4px 20px rgba(180, 80, 100, 0.1);
    }

    .nav-logo {
      display: flex;
      align-items: center;
      gap: 10px;
      font-family: var(--font-display);
      font-size: 1.6rem;
      font-weight: 600;
      color: var(--charcoal);
    }

    .nav-logo span {
      color: var(--rose);
    }

    .nav-logo .logo-icon {
      width: 38px;
      height: 38px;
      background: linear-gradient(135deg, var(--rose), var(--mauve));
      border-radius: 10px;
      display: flex;
      align-items: center;
      justify-content: center;
      color: white;
      font-size: 16px;
    }

    .nav-links {
      display: flex;
      align-items: center;
      gap: 2px;
      list-style: none;
    }

    .nav-links a {
      font-family: var(--font-body);
      font-size: 0.875rem;
      font-weight: 500;
      color: var(--charcoal);
      padding: 8px 14px;
      border-radius: 8px;
      letter-spacing: 0.02em;
      transition: var(--transition);
    }

    .nav-links a:hover,
    .nav-links a.active {
      color: var(--rose);
      background: var(--rose-light);
    }

    .nav-actions {
      display: flex;
      align-items: center;
      gap: 12px;
    }

    .btn-nav-login {
      font-size: 0.875rem;
      font-weight: 500;
      color: var(--rose);
      border: 1.5px solid var(--rose);
      padding: 8px 20px;
      border-radius: 50px;
      transition: var(--transition);
    }

    .btn-nav-login:hover {
      background: var(--rose);
      color: white;
    }

    .user-avatar-nav {
      width: 36px;
      height: 36px;
      border-radius: 50%;
      object-fit: cover;
      border: 2px solid var(--rose);
    }

    .nav-user-menu {
      position: relative;
    }

    .nav-user-menu .dropdown {
      display: none;
      position: absolute;
      top: calc(100% + 12px);
      right: 0;
      background: white;
      border: 1px solid var(--rose-light);
      border-radius: var(--radius);
      box-shadow: var(--shadow-lg);
      min-width: 180px;
      overflow: hidden;
    }

    .nav-user-menu:hover .dropdown {
      display: block;
    }

    .dropdown a {
      display: block;
      padding: 12px 16px;
      font-size: 0.875rem;
      color: var(--charcoal);
      border-bottom: 1px solid var(--gray-light);
    }

    .dropdown a:hover {
      background: var(--gray-light);
      color: var(--rose);
    }

    .hamburger {
      display: none;
      flex-direction: column;
      gap: 5px;
      cursor: pointer;
      padding: 6px;
    }

    .hamburger span {
      display: block;
      width: 24px;
      height: 2px;
      background: var(--charcoal);
      border-radius: 2px;
      transition: var(--transition);
    }

    /* ═══════════════════════════════════════════════════════
       FLASH MESSAGES
    ═══════════════════════════════════════════════════════ */
    .flash-container {
      position: fixed;
      top: 84px;
      right: 20px;
      z-index: 998;
      display: flex;
      flex-direction: column;
      gap: 8px;
    }

    .flash {
      padding: 14px 20px;
      border-radius: var(--radius);
      font-size: 0.9rem;
      font-weight: 500;
      box-shadow: var(--shadow);
      animation: slideIn .4s ease forwards;
      max-width: 380px;
    }

    .flash.success { background: #f0faf0; border-left: 4px solid #4caf50; color: #2e7d32; }
    .flash.error   { background: #fdf0f4; border-left: 4px solid var(--rose); color: var(--rose-deep); }
    .flash.info    { background: #f0f4ff; border-left: 4px solid #5c6bc0; color: #3949ab; }

    @keyframes slideIn {
      from { transform: translateX(120%); opacity: 0; }
      to   { transform: translateX(0);   opacity: 1; }
    }

    /* ═══════════════════════════════════════════════════════
       MAIN CONTENT
    ═══════════════════════════════════════════════════════ */
    main {
      padding-top: 72px;
    }

    /* ═══════════════════════════════════════════════════════
       BOTONES GLOBALES
    ═══════════════════════════════════════════════════════ */
    .btn {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      padding: 14px 32px;
      border-radius: 50px;
      font-family: var(--font-body);
      font-size: 0.9rem;
      font-weight: 600;
      letter-spacing: 0.04em;
      cursor: pointer;
      border: none;
      transition: var(--transition);
      text-decoration: none;
    }

    .btn-primary {
      background: linear-gradient(135deg, var(--rose), var(--mauve));
      color: white;
      box-shadow: 0 6px 20px rgba(212, 80, 122, 0.35);
    }

    .btn-primary:hover {
      transform: translateY(-2px);
      box-shadow: 0 10px 30px rgba(212, 80, 122, 0.45);
      color: white;
    }

    .btn-outline {
      background: transparent;
      color: var(--rose);
      border: 2px solid var(--rose);
    }

    .btn-outline:hover {
      background: var(--rose);
      color: white;
    }

    .btn-gold {
      background: linear-gradient(135deg, var(--gold), #e6c06a);
      color: white;
      box-shadow: 0 6px 20px rgba(201, 168, 76, 0.35);
    }

    .btn-gold:hover {
      transform: translateY(-2px);
      box-shadow: 0 10px 30px rgba(201, 168, 76, 0.45);
      color: white;
    }

    /* ═══════════════════════════════════════════════════════
       SECTION HEADERS
    ═══════════════════════════════════════════════════════ */
    .section-header {
      text-align: center;
      margin-bottom: 60px;
    }

    .section-tag {
      display: inline-block;
      font-size: 0.78rem;
      font-weight: 600;
      letter-spacing: 0.12em;
      text-transform: uppercase;
      color: var(--rose);
      background: var(--rose-light);
      padding: 6px 16px;
      border-radius: 50px;
      margin-bottom: 16px;
    }

    .section-title {
      font-family: var(--font-display);
      font-size: clamp(2rem, 4vw, 3rem);
      font-weight: 600;
      color: var(--charcoal);
      line-height: 1.2;
      margin-bottom: 16px;
    }

    .section-title em {
      color: var(--rose);
      font-style: italic;
    }

    .section-subtitle {
      font-size: 1.05rem;
      color: #777;
      max-width: 560px;
      margin: 0 auto;
    }

    /* ═══════════════════════════════════════════════════════
       FOOTER
    ═══════════════════════════════════════════════════════ */
    footer {
      background: var(--charcoal);
      color: rgba(255,255,255,.75);
      padding: 64px 5% 32px;
    }

    .footer-grid {
      display: grid;
      grid-template-columns: 2fr 1fr 1fr 1fr;
      gap: 48px;
      margin-bottom: 48px;
    }

    .footer-brand h3 {
      font-family: var(--font-display);
      font-size: 1.8rem;
      color: white;
      margin-bottom: 12px;
    }

    .footer-brand h3 span { color: var(--rose); }

    .footer-brand p {
      font-size: 0.9rem;
      line-height: 1.7;
      margin-bottom: 20px;
    }

    .social-links {
      display: flex;
      gap: 12px;
    }

    .social-links a {
      width: 40px;
      height: 40px;
      background: rgba(255,255,255,.1);
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      color: rgba(255,255,255,.8);
      transition: var(--transition);
    }

    .social-links a:hover {
      background: var(--rose);
      color: white;
    }

    .footer-col h4 {
      font-family: var(--font-body);
      font-size: 0.8rem;
      font-weight: 600;
      letter-spacing: 0.1em;
      text-transform: uppercase;
      color: white;
      margin-bottom: 20px;
    }

    .footer-col ul {
      list-style: none;
    }

    .footer-col ul li {
      margin-bottom: 10px;
    }

    .footer-col ul a {
      color: rgba(255,255,255,.65);
      font-size: 0.9rem;
      transition: var(--transition);
    }

    .footer-col ul a:hover {
      color: var(--rose);
      padding-left: 4px;
    }

    .footer-bottom {
      border-top: 1px solid rgba(255,255,255,.1);
      padding-top: 28px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      font-size: 0.82rem;
    }

    .footer-bottom a { color: var(--rose); }

    /* ═══════════════════════════════════════════════════════
       FORM GLOBAL STYLES
    ═══════════════════════════════════════════════════════ */
    .form-group {
      margin-bottom: 20px;
    }

    .form-group label {
      display: block;
      font-size: 0.85rem;
      font-weight: 600;
      color: var(--charcoal);
      margin-bottom: 8px;
      letter-spacing: 0.02em;
    }

    .form-control {
      width: 100%;
      padding: 13px 16px;
      border: 1.5px solid #e0d8d4;
      border-radius: var(--radius);
      font-family: var(--font-body);
      font-size: 0.95rem;
      color: var(--charcoal);
      background: var(--ivory);
      transition: var(--transition);
      outline: none;
    }

    .form-control:focus {
      border-color: var(--rose);
      background: white;
      box-shadow: 0 0 0 4px rgba(212, 80, 122, 0.1);
    }

    .form-error {
      font-size: 0.82rem;
      color: var(--rose);
      margin-top: 6px;
    }

    /* ═══════════════════════════════════════════════════════
       RESPONSIVE
    ═══════════════════════════════════════════════════════ */
    @media (max-width: 900px) {
      .footer-grid { grid-template-columns: 1fr 1fr; }
    }

    @media (max-width: 768px) {
      .nav-links { display: none; }
      .hamburger { display: flex; }

      .nav-links.open {
        display: flex;
        flex-direction: column;
        position: fixed;
        top: 72px; left: 0; right: 0;
        background: var(--ivory);
        padding: 20px 5%;
        border-bottom: 1px solid var(--rose-light);
        box-shadow: var(--shadow);
        z-index: 998;
      }

      .footer-grid { grid-template-columns: 1fr; }
    }

    /* ═══════════════════════════════════════════════════════
       ANIMACIONES DE ENTRADA
    ═══════════════════════════════════════════════════════ */
    .reveal {
      opacity: 0;
      transform: translateY(30px);
      transition: opacity 0.7s ease, transform 0.7s ease;
    }
    .reveal.visible {
      opacity: 1;
      transform: translateY(0);
    }
  </style>

  <?= $extra_css ?? '' ?>
</head>
<body>

  <!-- ───────── NAVBAR ───────── -->
  <nav class="navbar" id="navbar">
    <a href="/" class="nav-logo">
      <div class="logo-icon"><i class="fas fa-book-open"></i></div>
      Tech<span>Manuals</span>
    </a>

    <ul class="nav-links" id="navLinks">
      <li><a href="/"                class="<?= ($section ?? '') === 'inicio'        ? 'active' : '' ?>">Inicio</a></li>
      <li><a href="/mision"          class="<?= ($section ?? '') === 'mision'        ? 'active' : '' ?>">Misión</a></li>
      <li><a href="/vision"          class="<?= ($section ?? '') === 'vision'        ? 'active' : '' ?>">Visión</a></li>
      <li><a href="/quienes-somos"   class="<?= ($section ?? '') === 'quienes-somos' ? 'active' : '' ?>">Quiénes Somos</a></li>
      <li><a href="/portafolio"      class="<?= ($section ?? '') === 'portafolio'    ? 'active' : '' ?>">Portafolio</a></li>
      <li><a href="/contacto"        class="<?= ($section ?? '') === 'contacto'      ? 'active' : '' ?>">Contacto</a></li>
    </ul>

    <div class="nav-actions">
      <?php if (session()->get('user_id')): ?>
        <div class="nav-user-menu">
          <?php if (session()->get('user_avatar')): ?>
            <img src="<?= esc(session()->get('user_avatar')) ?>" class="user-avatar-nav" alt="avatar" />
          <?php else: ?>
            <div class="user-avatar-nav" style="background:var(--rose);display:flex;align-items:center;justify-content:center;color:white;font-weight:bold;">
              <?= strtoupper(mb_substr(session()->get('user_name'), 0, 1)) ?>
            </div>
          <?php endif; ?>
          <div class="dropdown">
            <a href="/mis-compras"><i class="fas fa-download" style="margin-right:8px;color:var(--rose)"></i> Mis Compras</a>
            <?php if (session()->get('user_role') === 'admin'): ?>
              <a href="/admin"><i class="fas fa-cog" style="margin-right:8px;color:var(--mauve)"></i> Panel Admin</a>
            <?php endif; ?>
            <a href="/logout" style="color:#e53935"><i class="fas fa-sign-out-alt" style="margin-right:8px"></i> Cerrar Sesión</a>
          </div>
        </div>
      <?php else: ?>
        <a href="/login" class="btn-nav-login">Iniciar Sesión</a>
      <?php endif; ?>
    </div>

    <div class="hamburger" id="hamburger" onclick="toggleMenu()">
      <span></span><span></span><span></span>
    </div>
  </nav>

  <!-- ───────── FLASH MESSAGES ───────── -->
  <?php if (session()->getFlashdata('success')): ?>
    <div class="flash-container">
      <div class="flash success">✅ <?= session()->getFlashdata('success') ?></div>
    </div>
  <?php endif; ?>
  <?php if (session()->getFlashdata('error')): ?>
    <div class="flash-container">
      <div class="flash error">❌ <?= session()->getFlashdata('error') ?></div>
    </div>
  <?php endif; ?>
  <?php if (session()->getFlashdata('info')): ?>
    <div class="flash-container">
      <div class="flash info">ℹ️ <?= session()->getFlashdata('info') ?></div>
    </div>
  <?php endif; ?>

  <!-- ───────── CONTENIDO PRINCIPAL ───────── -->
  <main>
    <?= $content ?>
  </main>

  <!-- ───────── FOOTER ───────── -->
  <footer>
    <div class="footer-grid">
      <div class="footer-brand">
        <h3>Tech<span>Manuals</span></h3>
        <p>Tu plataforma de confianza para aprender tecnología con manuales digitales de alta calidad, creados por expertas para el mundo tech.</p>
        <div class="social-links">
          <a href="#" title="Instagram"><i class="fab fa-instagram"></i></a>
          <a href="#" title="Twitter"><i class="fab fa-twitter"></i></a>
          <a href="#" title="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
          <a href="#" title="YouTube"><i class="fab fa-youtube"></i></a>
        </div>
      </div>

      <div class="footer-col">
        <h4>Navegación</h4>
        <ul>
          <li><a href="/">Inicio</a></li>
          <li><a href="/portafolio">Portafolio</a></li>
          <li><a href="/mision">Misión</a></li>
          <li><a href="/vision">Visión</a></li>
          <li><a href="/quienes-somos">Quiénes Somos</a></li>
          <li><a href="/contacto">Contacto</a></li>
        </ul>
      </div>

      <div class="footer-col">
        <h4>Categorías</h4>
        <ul>
          <li><a href="/portafolio?categoria=python">Python</a></li>
          <li><a href="/portafolio?categoria=frontend">Frontend</a></li>
          <li><a href="/portafolio?categoria=javascript">JavaScript</a></li>
          <li><a href="/portafolio?categoria=ia-ml">IA & ML</a></li>
          <li><a href="/portafolio?categoria=devops">DevOps</a></li>
          <li><a href="/portafolio?categoria=seguridad">Seguridad</a></li>
        </ul>
      </div>

      <div class="footer-col">
        <h4>Soporte</h4>
        <ul>
          <li><a href="/mis-compras">Mis Compras</a></li>
          <li><a href="/contacto">Centro de Ayuda</a></li>
          <li><a href="#">Política de Reembolso</a></li>
          <li><a href="#">Términos de Uso</a></li>
          <li><a href="#">Privacidad</a></li>
        </ul>
      </div>
    </div>

    <div class="footer-bottom">
      <p>© <?= date('Y') ?> TechManuals Store. Todos los derechos reservados.</p>
      <p>Pagos seguros procesados por <a href="#">PayPal</a></p>
    </div>
  </footer>

  <script>
    // Navbar scroll effect
    window.addEventListener('scroll', () => {
      document.getElementById('navbar').classList.toggle('scrolled', window.scrollY > 20);
    });

    // Mobile menu
    function toggleMenu() {
      document.getElementById('navLinks').classList.toggle('open');
    }

    // Auto-dismiss flash messages
    setTimeout(() => {
      document.querySelectorAll('.flash').forEach(el => {
        el.style.transition = 'opacity .5s';
        el.style.opacity = '0';
        setTimeout(() => el.remove(), 500);
      });
    }, 4000);

    // Scroll reveal
    const observer = new IntersectionObserver((entries) => {
      entries.forEach(e => { if (e.isIntersecting) e.target.classList.add('visible'); });
    }, { threshold: 0.1 });
    document.querySelectorAll('.reveal').forEach(el => observer.observe(el));
  </script>

  <?= $extra_js ?? '' ?>
</body>
</html>
