<!-- app/Views/shop/detail.php -->
<style>
  .detail-page {
    max-width: 1100px;
    margin: 60px auto;
    padding: 0 5%;
    display: grid;
    grid-template-columns: 1fr 1.6fr;
    gap: 60px;
    align-items: start;
  }

  /* ── COLUMNA IZQUIERDA: portada + compra ── */
  .detail-sidebar {
    position: sticky;
    top: 92px;
  }

  .detail-cover {
    border-radius: var(--radius-lg);
    overflow: hidden;
    margin-bottom: 24px;
    aspect-ratio: 3/4;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 100px;
    background: linear-gradient(135deg, var(--rose), var(--mauve));
    box-shadow: var(--shadow-lg);
    position: relative;
  }

  .detail-cover .cover-emoji {
    position: relative;
    z-index: 1;
    filter: drop-shadow(0 8px 20px rgba(0,0,0,.2));
  }

  .detail-cover::after {
    content: '';
    position: absolute;
    inset: 0;
    background: linear-gradient(to bottom, transparent 40%, rgba(0,0,0,.25));
  }

  .detail-cover .cover-title {
    position: absolute;
    bottom: 20px;
    left: 20px;
    right: 20px;
    z-index: 2;
    color: white;
    font-family: var(--font-display);
    font-size: 1.1rem;
    font-weight: 600;
    line-height: 1.3;
    text-shadow: 0 2px 8px rgba(0,0,0,.3);
  }

  /* Tarjeta de compra */
  .buy-card {
    background: white;
    border-radius: var(--radius-lg);
    padding: 28px;
    border: 1.5px solid rgba(212,80,122,.1);
    box-shadow: var(--shadow);
  }

  .buy-price {
    font-family: var(--font-display);
    font-size: 2.8rem;
    font-weight: 600;
    color: var(--rose);
    margin-bottom: 4px;
    line-height: 1;
  }

  .buy-price-note {
    font-size: .8rem;
    color: #bbb;
    margin-bottom: 20px;
  }

  .buy-card .btn {
    width: 100%;
    justify-content: center;
    margin-bottom: 12px;
    font-size: 1rem;
  }

  .buy-already {
    background: #f0faf0;
    border: 1.5px solid #c8e6c9;
    border-radius: var(--radius);
    padding: 14px 16px;
    font-size: .88rem;
    color: #388e3c;
    text-align: center;
    margin-bottom: 12px;
  }

  .buy-already a { color: #2e7d32; font-weight: 600; }

  .buy-includes {
    margin-top: 16px;
    padding-top: 16px;
    border-top: 1px solid var(--gray-light);
  }

  .buy-includes h4 {
    font-size: .8rem;
    font-weight: 700;
    color: #bbb;
    text-transform: uppercase;
    letter-spacing: .08em;
    margin-bottom: 12px;
  }

  .include-item {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: .85rem;
    color: #666;
    margin-bottom: 8px;
  }

  .include-item i {
    color: var(--rose);
    width: 16px;
    font-size: 13px;
  }

  /* ── COLUMNA DERECHA: info del manual ── */
  .detail-content {}

  .detail-breadcrumb {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: .82rem;
    color: #bbb;
    margin-bottom: 20px;
  }

  .detail-breadcrumb a { color: var(--rose); }
  .detail-breadcrumb i { font-size: 10px; }

  .detail-category {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    font-size: .75rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .08em;
    color: var(--mauve);
    background: #f5eeff;
    padding: 5px 14px;
    border-radius: 50px;
    margin-bottom: 16px;
  }

  .detail-title {
    font-family: var(--font-display);
    font-size: clamp(1.8rem, 3.5vw, 2.6rem);
    font-weight: 600;
    color: var(--charcoal);
    line-height: 1.2;
    margin-bottom: 16px;
  }

  .detail-short-desc {
    font-size: 1.05rem;
    color: #777;
    line-height: 1.8;
    margin-bottom: 28px;
  }

  /* Badges de info rápida */
  .detail-badges {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    margin-bottom: 32px;
  }

  .detail-badge {
    display: flex;
    align-items: center;
    gap: 6px;
    padding: 8px 16px;
    background: var(--gray-light);
    border-radius: 50px;
    font-size: .82rem;
    font-weight: 500;
    color: #666;
  }

  .detail-badge i { color: var(--rose); }

  /* Sección descripción */
  .detail-section {
    margin-bottom: 36px;
  }

  .detail-section h3 {
    font-family: var(--font-display);
    font-size: 1.3rem;
    color: var(--charcoal);
    margin-bottom: 14px;
    padding-bottom: 10px;
    border-bottom: 2px solid var(--rose-light);
  }

  .detail-section p {
    font-size: .95rem;
    color: #666;
    line-height: 1.85;
  }

  /* Lo que aprenderás */
  .learn-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 10px;
  }

  .learn-item {
    display: flex;
    align-items: flex-start;
    gap: 10px;
    font-size: .88rem;
    color: #555;
    padding: 10px 14px;
    background: var(--cream);
    border-radius: var(--radius);
    border: 1px solid var(--gray-light);
  }

  .learn-item i {
    color: var(--rose);
    margin-top: 2px;
    font-size: 12px;
    flex-shrink: 0;
  }

  /* Manuales relacionados */
  .related-section {
    margin-top: 60px;
    padding-top: 48px;
    border-top: 1px solid var(--gray-light);
    max-width: 1100px;
    margin-left: auto;
    margin-right: auto;
    padding-left: 5%;
    padding-right: 5%;
  }

  .related-section h2 {
    font-family: var(--font-display);
    font-size: 1.8rem;
    color: var(--charcoal);
    margin-bottom: 28px;
  }

  .related-section h2 em { color: var(--rose); font-style: italic; }

  .related-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
    gap: 20px;
  }

  .related-card {
    background: white;
    border-radius: var(--radius-lg);
    overflow: hidden;
    border: 1.5px solid var(--gray-light);
    transition: var(--transition);
    display: flex;
    flex-direction: column;
  }

  .related-card:hover {
    border-color: var(--rose-light);
    box-shadow: var(--shadow);
    transform: translateY(-3px);
  }

  .related-cover {
    height: 100px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 40px;
    background: linear-gradient(135deg, var(--rose), var(--mauve));
  }

  .related-body {
    padding: 16px;
    flex: 1;
    display: flex;
    flex-direction: column;
  }

  .related-body h4 {
    font-family: var(--font-display);
    font-size: .95rem;
    color: var(--charcoal);
    margin-bottom: 8px;
    line-height: 1.3;
    flex: 1;
  }

  .related-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 12px;
    padding-top: 10px;
    border-top: 1px solid var(--gray-light);
  }

  .related-price {
    font-family: var(--font-display);
    font-size: 1.1rem;
    font-weight: 600;
    color: var(--rose);
  }

  @media (max-width: 768px) {
    .detail-page { grid-template-columns: 1fr; }
    .detail-sidebar { position: static; }
    .detail-cover { aspect-ratio: 2/1; font-size: 60px; }
    .learn-grid { grid-template-columns: 1fr; }
  }
</style>

<?php
// Emojis por categoría
$emojis = [
  'python'         => '🐍',
  'frontend'       => '🌐',
  'javascript'     => '⚡',
  'bases-de-datos' => '🗄️',
  'backend'        => '🚀',
  'devops'         => '🔀',
  'seguridad'      => '🔒',
  'ia-ml'          => '🧠',
];
$emoji = $emojis[$manual['category_slug'] ?? ''] ?? '📘';

// Gradientes por categoría
$gradients = [
  'python'         => 'linear-gradient(135deg, #306998, #ffd43b)',
  'frontend'       => 'linear-gradient(135deg, #e34c26, #264de4)',
  'javascript'     => 'linear-gradient(135deg, #f0db4f, #2c3e50)',
  'bases-de-datos' => 'linear-gradient(135deg, #00758f, #f29111)',
  'backend'        => 'linear-gradient(135deg, #3c873a, #303030)',
  'devops'         => 'linear-gradient(135deg, #2496ed, #1a1a2e)',
  'seguridad'      => 'linear-gradient(135deg, #2c2c2c, #e91e8c)',
  'ia-ml'          => 'linear-gradient(135deg, #ff6b6b, #7c3aed)',
];
$gradient = $gradients[$manual['category_slug'] ?? ''] ?? 'linear-gradient(135deg, var(--rose), var(--mauve))';
?>

<!-- Breadcrumb -->
<div style="padding: 24px 5% 0; max-width: 1100px; margin: 0 auto;">
  <div class="detail-breadcrumb">
    <a href="/">Inicio</a>
    <i class="fas fa-chevron-right"></i>
    <a href="/portafolio">Portafolio</a>
    <i class="fas fa-chevron-right"></i>
    <span><?= esc($manual['category_name']) ?></span>
    <i class="fas fa-chevron-right"></i>
    <span style="color: var(--charcoal)"><?= esc($manual['title']) ?></span>
  </div>
</div>

<div class="detail-page">

  <!-- ── SIDEBAR IZQUIERDO ── -->
  <div class="detail-sidebar reveal">

    <!-- Portada -->
    <div class="detail-cover" style="background: <?= $gradient ?>">
      <span class="cover-emoji"><?= $emoji ?></span>
      <div class="cover-title"><?= esc($manual['title']) ?></div>
    </div>

    <!-- Tarjeta de compra -->
    <div class="buy-card">
      <div class="buy-price">$<?= number_format($manual['price'], 2) ?></div>
      <div class="buy-price-note">USD · Pago único · Descarga inmediata</div>

      <?php if ($alreadyPurchased): ?>
        <div class="buy-already">
          ✅ Ya tienes este manual.
          <br><a href="/mis-compras">Ver en Mis Compras →</a>
        </div>
      <?php elseif (session()->get('user_id')): ?>
        <a href="/checkout/<?= (int)$manual['id'] ?>" class="btn btn-primary">
          <i class="fas fa-shopping-cart"></i> Comprar ahora
        </a>
      <?php else: ?>
        <a href="/login" class="btn btn-primary">
          <i class="fas fa-lock"></i> Inicia sesión para comprar
        </a>
        <a href="/register" class="btn btn-outline">
          <i class="fas fa-user-plus"></i> Crear cuenta gratis
        </a>
      <?php endif; ?>

      <div class="buy-includes">
        <h4>Este manual incluye</h4>
        <div class="include-item"><i class="fas fa-file-pdf"></i> Archivo PDF de alta calidad</div>
        <div class="include-item"><i class="fas fa-infinity"></i> Acceso de por vida una vez descargado</div>
        <div class="include-item"><i class="fas fa-download"></i> Link de descarga en tu email (24h)</div>
        <div class="include-item"><i class="fas fa-mobile-alt"></i> Compatible con todos los dispositivos</div>
        <?php if ($manual['pages']): ?>
          <div class="include-item"><i class="fas fa-book"></i> <?= esc($manual['pages']) ?> páginas de contenido</div>
        <?php endif; ?>
        <div class="include-item"><i class="fas fa-language"></i> Idioma: <?= esc($manual['language']) ?></div>
      </div>
    </div>

  </div>

  <!-- ── CONTENIDO DERECHO ── -->
  <div class="detail-content">

    <div class="detail-category">
      <i class="<?= esc($manual['category_icon']) ?>"></i>
      <?= esc($manual['category_name']) ?>
    </div>

    <h1 class="detail-title"><?= esc($manual['title']) ?></h1>

    <p class="detail-short-desc"><?= esc($manual['short_desc']) ?></p>

    <!-- Badges rápidos -->
    <div class="detail-badges">
      <span class="detail-badge">
        <i class="fas fa-signal"></i> <?= esc($manual['level']) ?>
      </span>
      <?php if ($manual['pages']): ?>
        <span class="detail-badge">
          <i class="fas fa-file-alt"></i> <?= esc($manual['pages']) ?> páginas
        </span>
      <?php endif; ?>
      <span class="detail-badge">
        <i class="fas fa-language"></i> <?= esc($manual['language']) ?>
      </span>
      <span class="detail-badge">
        <i class="fas fa-download"></i> <?= number_format($manual['downloads_count']) ?> descargas
      </span>
      <span class="detail-badge">
        <i class="fas fa-file-pdf"></i> Formato PDF
      </span>
    </div>

    <!-- Descripción completa -->
    <div class="detail-section reveal">
      <h3>📖 Descripción</h3>
      <p><?= nl2br(esc($manual['description'])) ?></p>
    </div>

    <!-- Lo que aprenderás -->
    <div class="detail-section reveal">
      <h3>🎯 Lo que aprenderás</h3>
      <div class="learn-grid">
        <?php
        // Genera puntos de aprendizaje basados en la categoría
        $learningPoints = [
          'python'         => ['Sintaxis y estructuras básicas de Python', 'Programación orientada a objetos', 'Manejo de archivos y excepciones', 'Módulos y librerías populares', 'Buenas prácticas de código limpio', 'Proyectos prácticos reales'],
          'frontend'       => ['Estructura semántica HTML5', 'Estilos modernos con CSS3', 'Flexbox y CSS Grid', 'Diseño responsivo y mobile-first', 'Animaciones y transiciones', 'Formularios y validaciones'],
          'javascript'     => ['Fundamentos de ES6+', 'Funciones flecha y destructuring', 'Promesas y async/await', 'Manipulación del DOM', 'Fetch API y peticiones HTTP', 'Módulos y organización del código'],
          'bases-de-datos' => ['Modelo relacional y diseño de BD', 'Consultas SQL avanzadas', 'JOINs y subconsultas', 'Índices y optimización', 'Transacciones y seguridad', 'Backup y administración'],
          'backend'        => ['Configuración de Node.js y Express', 'Rutas y middlewares', 'Autenticación con JWT', 'Conexión a bases de datos', 'Validación de datos', 'Despliegue en producción'],
          'devops'         => ['Comandos esenciales de Git', 'Branches y merge strategies', 'Pull requests y code review', 'Resolución de conflictos', 'GitHub Actions básico', 'Flujos de trabajo en equipo'],
          'seguridad'      => ['OWASP Top 10 vulnerabilidades', 'Prevención de XSS y SQL Injection', 'Manejo seguro de contraseñas', 'HTTPS y certificados SSL', 'Autenticación segura', 'Auditoría y logging'],
          'ia-ml'          => ['Fundamentos del Machine Learning', 'Preprocesamiento con pandas', 'Algoritmos supervisados', 'Algoritmos no supervisados', 'Evaluación de modelos', 'Visualización con matplotlib'],
        ];
        $points = $learningPoints[$manual['category_slug'] ?? ''] ?? ['Conceptos fundamentales', 'Ejercicios prácticos', 'Proyectos reales', 'Buenas prácticas', 'Ejemplos del mundo real', 'Recursos adicionales'];
        foreach ($points as $point):
        ?>
          <div class="learn-item">
            <i class="fas fa-check-circle"></i>
            <?= esc($point) ?>
          </div>
        <?php endforeach; ?>
      </div>
    </div>

    <!-- Para quién es -->
    <div class="detail-section reveal">
      <h3>👩‍💻 ¿Para quién es este manual?</h3>
      <p>
        Este manual está dirigido a personas con nivel <strong><?= esc($manual['level']) ?></strong>
        que desean profundizar sus conocimientos en <?= esc($manual['category_name']) ?>.
        No necesitas experiencia previa
        <?= $manual['level'] === 'Básico' ? '— empezamos desde cero.' : 'más allá de lo indicado en el nivel.' ?>
        Ideal para estudiantes de sistemas, desarrolladoras autodidactas y profesionales que buscan actualizar sus habilidades técnicas.
      </p>
    </div>

    <!-- CTA mobile (visible solo en móvil) -->
    <div style="display:none" class="mobile-cta reveal">
      <?php if ($alreadyPurchased): ?>
        <a href="/mis-compras" class="btn btn-primary" style="width:100%;justify-content:center">
          <i class="fas fa-download"></i> Ir a Mis Compras
        </a>
      <?php elseif (session()->get('user_id')): ?>
        <a href="/checkout/<?= (int)$manual['id'] ?>" class="btn btn-primary" style="width:100%;justify-content:center">
          <i class="fas fa-shopping-cart"></i> Comprar por $<?= number_format($manual['price'], 2) ?>
        </a>
      <?php else: ?>
        <a href="/login" class="btn btn-primary" style="width:100%;justify-content:center">
          <i class="fas fa-lock"></i> Inicia sesión para comprar
        </a>
      <?php endif; ?>
    </div>

  </div>
</div>

<!-- Manuales relacionados -->
<section class="related-section">
  <h2>También te puede <em>interesar</em></h2>
  <div class="related-grid">
    <?php
    // Relacionados: misma categoría, diferente manual
    $related = (new \App\Models\ManualModel())->getPortafolio($manual['category_slug']);
    $related  = array_filter($related, fn($r) => $r['id'] != $manual['id']);
    $related  = array_slice(array_values($related), 0, 4);
    $relEmojis = ['🐍','🌐','⚡','🗄️','🚀','🔀','⚛️','🔒','🐳','🧠'];
    foreach ($related as $r):
    ?>
      <div class="related-card reveal">
        <div class="related-cover" style="background: <?= $gradients[$r['category_slug']] ?? 'linear-gradient(135deg,var(--rose),var(--mauve))' ?>">
          <?= $emojis[$r['category_slug']] ?? '📘' ?>
        </div>
        <div class="related-body">
          <h4><?= esc($r['title']) ?></h4>
          <div class="related-footer">
            <span class="related-price">$<?= number_format($r['price'], 2) ?></span>
            <a href="/portafolio/<?= esc($r['slug']) ?>" class="btn btn-outline" style="padding:7px 14px;font-size:.78rem">Ver más</a>
          </div>
        </div>
      </div>
    <?php endforeach; ?>

    <?php if (empty($related)): ?>
      <p style="color:#bbb;font-size:.9rem;grid-column:1/-1">
        Explora todo nuestro <a href="/portafolio">catálogo de manuales</a>.
      </p>
    <?php endif; ?>
  </div>
</section>

<style>
  @media (max-width: 768px) {
    .mobile-cta { display: block !important; }
  }
</style>
