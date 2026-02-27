<!-- app/Views/home/index.php -->
<style>
  /* ── HERO ────────────────────────────── */
  .hero {
    min-height: 100vh;
    background: linear-gradient(145deg, #fff0f6 0%, #fdf8f2 40%, #f5eeff 100%);
    display: flex;
    align-items: center;
    padding: 80px 5% 60px;
    position: relative;
    overflow: hidden;
  }

  .hero::before {
    content: '';
    position: absolute;
    top: -200px; right: -200px;
    width: 700px; height: 700px;
    background: radial-gradient(circle, rgba(212,80,122,.08) 0%, transparent 70%);
    border-radius: 50%;
  }

  .hero::after {
    content: '';
    position: absolute;
    bottom: -150px; left: -100px;
    width: 500px; height: 500px;
    background: radial-gradient(circle, rgba(155,107,155,.07) 0%, transparent 70%);
    border-radius: 50%;
  }

  .hero-content {
    max-width: 1200px;
    margin: 0 auto;
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 80px;
    align-items: center;
    position: relative;
    z-index: 1;
  }

  .hero-badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: var(--rose-light);
    color: var(--rose-deep);
    font-size: 0.8rem;
    font-weight: 600;
    letter-spacing: 0.06em;
    padding: 8px 16px;
    border-radius: 50px;
    margin-bottom: 24px;
  }

  .hero-badge i { font-size: 12px; animation: pulse 2s ease infinite; }

  @keyframes pulse {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.3); }
  }

  .hero h1 {
    font-family: var(--font-display);
    font-size: clamp(2.4rem, 5vw, 3.8rem);
    font-weight: 600;
    line-height: 1.15;
    color: var(--charcoal);
    margin-bottom: 24px;
  }

  .hero h1 em {
    color: var(--rose);
    font-style: italic;
  }

  .hero-desc {
    font-size: 1.08rem;
    color: #777;
    margin-bottom: 36px;
    max-width: 460px;
    line-height: 1.8;
  }

  .hero-cta {
    display: flex;
    gap: 16px;
    flex-wrap: wrap;
    margin-bottom: 48px;
  }

  .hero-stats {
    display: flex;
    gap: 32px;
  }

  .stat {
    text-align: center;
  }

  .stat-number {
    font-family: var(--font-display);
    font-size: 1.8rem;
    font-weight: 600;
    color: var(--rose);
  }

  .stat-label {
    font-size: 0.78rem;
    color: #999;
    letter-spacing: 0.06em;
    text-transform: uppercase;
  }

  /* ── HERO VISUAL (derecha) ──────────── */
  .hero-visual {
    position: relative;
  }

  .hero-cards {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 16px;
  }

  .hero-card {
    background: white;
    border-radius: 16px;
    padding: 20px;
    box-shadow: var(--shadow);
    border: 1px solid rgba(212,80,122,.06);
    transition: var(--transition);
    position: relative;
    overflow: hidden;
  }

  .hero-card::before {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0;
    height: 3px;
    background: linear-gradient(90deg, var(--rose), var(--mauve));
  }

  .hero-card:hover {
    transform: translateY(-4px);
    box-shadow: var(--shadow-lg);
  }

  .hero-card:nth-child(2) { margin-top: 28px; }
  .hero-card:nth-child(4) { margin-top: 28px; }

  .card-icon {
    width: 44px;
    height: 44px;
    background: var(--rose-light);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--rose);
    font-size: 18px;
    margin-bottom: 12px;
  }

  .hero-card h4 {
    font-family: var(--font-display);
    font-size: 1rem;
    font-weight: 600;
    color: var(--charcoal);
    margin-bottom: 4px;
  }

  .hero-card p {
    font-size: 0.78rem;
    color: #aaa;
  }

  .hero-card .price {
    font-size: 1rem;
    font-weight: 700;
    color: var(--rose);
    margin-top: 8px;
  }

  /* ── SECCIÓN CARACTERÍSTICAS ───────── */
  .features {
    padding: 100px 5%;
    background: white;
  }

  .features-grid {
    max-width: 1200px;
    margin: 0 auto;
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 40px;
  }

  .feature-card {
    text-align: center;
    padding: 40px 28px;
    border-radius: var(--radius-lg);
    border: 1.5px solid var(--gray-light);
    transition: var(--transition);
  }

  .feature-card:hover {
    border-color: var(--rose-light);
    box-shadow: var(--shadow);
    transform: translateY(-4px);
  }

  .feature-icon {
    width: 64px;
    height: 64px;
    background: linear-gradient(135deg, var(--rose-light), #f5eeff);
    border-radius: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 26px;
    color: var(--rose);
    margin: 0 auto 20px;
  }

  .feature-card h3 {
    font-family: var(--font-display);
    font-size: 1.25rem;
    color: var(--charcoal);
    margin-bottom: 12px;
  }

  .feature-card p {
    font-size: 0.9rem;
    color: #888;
    line-height: 1.7;
  }

  /* ── MANUALES DESTACADOS ────────────── */
  .featured-section {
    padding: 100px 5%;
    background: var(--cream);
  }

  .featured-section .inner {
    max-width: 1200px;
    margin: 0 auto;
  }

  .manuals-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 28px;
  }

  .manual-card {
    background: white;
    border-radius: var(--radius-lg);
    overflow: hidden;
    box-shadow: 0 2px 12px rgba(0,0,0,.05);
    border: 1px solid rgba(212,80,122,.06);
    transition: var(--transition);
  }

  .manual-card:hover {
    transform: translateY(-6px);
    box-shadow: var(--shadow-lg);
  }

  .manual-cover {
    height: 180px;
    background: linear-gradient(135deg, var(--rose), var(--mauve));
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 64px;
    position: relative;
    overflow: hidden;
  }

  .manual-cover::after {
    content: '';
    position: absolute;
    inset: 0;
    background: linear-gradient(to bottom, transparent 50%, rgba(0,0,0,.2));
  }

  .manual-badge {
    position: absolute;
    top: 14px; right: 14px;
    background: white;
    color: var(--rose);
    font-size: 0.72rem;
    font-weight: 700;
    padding: 4px 10px;
    border-radius: 50px;
    z-index: 1;
  }

  .manual-body {
    padding: 20px;
  }

  .manual-meta {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 10px;
  }

  .manual-category {
    font-size: 0.75rem;
    color: var(--mauve);
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.06em;
  }

  .manual-level {
    font-size: 0.72rem;
    background: var(--gray-light);
    color: #888;
    padding: 3px 10px;
    border-radius: 50px;
  }

  .manual-title {
    font-family: var(--font-display);
    font-size: 1.1rem;
    font-weight: 600;
    color: var(--charcoal);
    margin-bottom: 8px;
    line-height: 1.3;
  }

  .manual-desc {
    font-size: 0.83rem;
    color: #999;
    line-height: 1.6;
    margin-bottom: 16px;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
  }

  .manual-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding-top: 14px;
    border-top: 1px solid var(--gray-light);
  }

  .manual-price {
    font-family: var(--font-display);
    font-size: 1.5rem;
    font-weight: 600;
    color: var(--rose);
  }

  /* ── CTA BANNER ─────────────────────── */
  .cta-banner {
    padding: 80px 5%;
    background: linear-gradient(135deg, var(--rose) 0%, var(--mauve) 100%);
    text-align: center;
    position: relative;
    overflow: hidden;
  }

  .cta-banner::before {
    content: '';
    position: absolute;
    top: -100px; left: -100px;
    width: 400px; height: 400px;
    background: rgba(255,255,255,.06);
    border-radius: 50%;
  }

  .cta-banner h2 {
    font-family: var(--font-display);
    font-size: clamp(2rem, 4vw, 3rem);
    color: white;
    margin-bottom: 16px;
    position: relative;
  }

  .cta-banner p {
    color: rgba(255,255,255,.85);
    font-size: 1.08rem;
    margin-bottom: 32px;
    position: relative;
  }

  .btn-white {
    background: white;
    color: var(--rose);
    font-weight: 700;
  }

  .btn-white:hover {
    background: var(--rose-light);
    color: var(--rose-deep);
    transform: translateY(-2px);
  }

  @media (max-width: 768px) {
    .hero-content { grid-template-columns: 1fr; gap: 40px; }
    .features-grid { grid-template-columns: 1fr; }
    .hero-visual { display: none; }
  }
</style>

<!-- HERO -->
<section class="hero">
  <div class="hero-content">
    <div class="hero-text">
      <div class="hero-badge">
        <i class="fas fa-circle" style="color:var(--rose)"></i>
        Más de 500 estudiantes ya aprenden con nosotras
      </div>

      <h1>
        Domina la tecnología con <em>manuales digitales</em> de primer nivel
      </h1>

      <p class="hero-desc">
        Descarga manuales técnicos pensados para tu ritmo de aprendizaje.
        Desde Python hasta Machine Learning — todo en un solo lugar.
      </p>

      <div class="hero-cta">
        <a href="/portafolio" class="btn btn-primary">
          <i class="fas fa-book-open"></i> Ver Portafolio
        </a>
        <a href="/quienes-somos" class="btn btn-outline">
          Conocernos <i class="fas fa-arrow-right"></i>
        </a>
      </div>

      <div class="hero-stats">
        <div class="stat">
          <div class="stat-number">10+</div>
          <div class="stat-label">Manuales</div>
        </div>
        <div class="stat">
          <div class="stat-number">500+</div>
          <div class="stat-label">Estudiantes</div>
        </div>
        <div class="stat">
          <div class="stat-number">98%</div>
          <div class="stat-label">Satisfacción</div>
        </div>
      </div>
    </div>

    <div class="hero-visual reveal">
      <div class="hero-cards">
        <div class="hero-card">
          <div class="card-icon"><i class="fab fa-python"></i></div>
          <h4>Python desde Cero</h4>
          <p>180 páginas · Básico</p>
          <div class="price">$9.99</div>
        </div>
        <div class="hero-card">
          <div class="card-icon"><i class="fab fa-react"></i></div>
          <h4>React.js Moderno</h4>
          <p>260 páginas · Intermedio</p>
          <div class="price">$15.99</div>
        </div>
        <div class="hero-card">
          <div class="card-icon"><i class="fas fa-robot"></i></div>
          <h4>Machine Learning</h4>
          <p>300 páginas · Avanzado</p>
          <div class="price">$19.99</div>
        </div>
        <div class="hero-card">
          <div class="card-icon"><i class="fab fa-node-js"></i></div>
          <h4>APIs con Node.js</h4>
          <p>250 páginas · Intermedio</p>
          <div class="price">$14.99</div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- CARACTERÍSTICAS -->
<section class="features">
  <div style="max-width:1200px;margin:0 auto">
    <div class="section-header reveal">
      <span class="section-tag">¿Por qué elegirnos?</span>
      <h2 class="section-title">Aprende con <em>calidad y confianza</em></h2>
      <p class="section-subtitle">Todo lo que necesitas para dominar la tecnología, en un solo lugar</p>
    </div>

    <div class="features-grid">
      <div class="feature-card reveal">
        <div class="feature-icon">⬇️</div>
        <h3>Descarga Instantánea</h3>
        <p>Al confirmar tu pago, recibes un link seguro en tu correo para descargar tu manual de inmediato.</p>
      </div>
      <div class="feature-card reveal">
        <div class="feature-icon">🔒</div>
        <h3>Pago 100% Seguro</h3>
        <p>Procesamos tus pagos con PayPal, la plataforma más confiable del mundo. Tu dinero está protegido.</p>
      </div>
      <div class="feature-card reveal">
        <div class="feature-icon">🎓</div>
        <h3>Contenido de Calidad</h3>
        <p>Manuales redactados por profesionales del área, con ejemplos prácticos y proyectos reales.</p>
      </div>
    </div>
  </div>
</section>

<!-- MANUALES DESTACADOS -->
<section class="featured-section">
  <div class="inner">
    <div class="section-header reveal">
      <span class="section-tag">Populares</span>
      <h2 class="section-title">Manuales <em>destacados</em></h2>
      <p class="section-subtitle">Los más descargados por nuestra comunidad</p>
    </div>

    <div class="manuals-grid">
      <?php
      $emojis = ['🐍','🌐','⚡','🗄️','🚀','🔀','⚛️','🔒','🐳','🧠'];
      foreach ($featured as $i => $m): ?>
        <div class="manual-card reveal">
          <div class="manual-cover">
            <span style="position:relative;z-index:1;font-size:52px"><?= $emojis[$i % count($emojis)] ?></span>
            <span class="manual-badge"><?= esc($m['level']) ?></span>
          </div>
          <div class="manual-body">
            <div class="manual-meta">
              <span class="manual-category"><?= esc($m['category_name']) ?></span>
              <span class="manual-level"><?= esc($m['pages']) ?>p</span>
            </div>
            <h3 class="manual-title"><?= esc($m['title']) ?></h3>
            <p class="manual-desc"><?= esc($m['short_desc']) ?></p>
            <div class="manual-footer">
              <span class="manual-price">$<?= esc($m['price']) ?></span>
              <a href="/portafolio/<?= esc($m['slug']) ?>" class="btn btn-primary" style="padding:10px 20px;font-size:.82rem">
                Ver detalles
              </a>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>

    <div style="text-align:center;margin-top:48px">
      <a href="/portafolio" class="btn btn-outline">
        Ver todos los manuales <i class="fas fa-arrow-right"></i>
      </a>
    </div>
  </div>
</section>

<!-- CTA BANNER -->
<section class="cta-banner">
  <h2>¿Lista para comenzar tu viaje tecnológico?</h2>
  <p>Únete a nuestra comunidad y empieza a aprender hoy mismo</p>
  <a href="/register" class="btn btn-white">
    <i class="fas fa-rocket"></i> Crear cuenta gratis
  </a>
</section>
