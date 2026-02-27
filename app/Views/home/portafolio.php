<!-- app/Views/home/portafolio.php -->
<style>
  .portafolio-hero {
    background: linear-gradient(135deg, #fff0f6 0%, #f5eeff 100%);
    padding: 80px 5% 60px;
    text-align: center;
    border-bottom: 1px solid var(--rose-light);
  }

  .portafolio-hero h1 {
    font-family: var(--font-display);
    font-size: clamp(2rem, 4vw, 3.2rem);
    color: var(--charcoal);
    margin-bottom: 12px;
  }

  .portafolio-hero h1 em { color: var(--rose); font-style: italic; }

  .portafolio-hero p {
    color: #888;
    font-size: 1.05rem;
    max-width: 520px;
    margin: 0 auto;
  }

  /* ── FILTROS ─────────────────── */
  .filters-bar {
    background: white;
    border-bottom: 1px solid var(--gray-light);
    padding: 20px 5%;
    position: sticky;
    top: 72px;
    z-index: 100;
    display: flex;
    gap: 12px;
    flex-wrap: wrap;
    align-items: center;
  }

  .filter-label {
    font-size: 0.8rem;
    font-weight: 600;
    color: #aaa;
    text-transform: uppercase;
    letter-spacing: 0.06em;
    margin-right: 4px;
  }

  .filter-pill {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 7px 16px;
    border-radius: 50px;
    font-size: 0.83rem;
    font-weight: 500;
    cursor: pointer;
    border: 1.5px solid var(--gray-light);
    background: white;
    color: #888;
    text-decoration: none;
    transition: var(--transition);
  }

  .filter-pill:hover,
  .filter-pill.active {
    border-color: var(--rose);
    color: var(--rose);
    background: var(--rose-light);
  }

  .filter-pill.active {
    font-weight: 600;
  }

  .filter-sep {
    width: 1px;
    height: 24px;
    background: var(--gray-light);
    margin: 0 4px;
  }

  /* ── GRID DE MANUALES ────────── */
  .catalog-section {
    padding: 60px 5%;
    max-width: 1300px;
    margin: 0 auto;
  }

  .catalog-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 36px;
  }

  .catalog-count {
    font-size: 0.9rem;
    color: #aaa;
  }

  .catalog-count span {
    color: var(--rose);
    font-weight: 600;
  }

  .manuals-catalog {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 28px;
  }

  .catalog-card {
    background: white;
    border-radius: var(--radius-lg);
    overflow: hidden;
    border: 1.5px solid rgba(212,80,122,.06);
    box-shadow: 0 2px 16px rgba(0,0,0,.04);
    transition: var(--transition);
    display: flex;
    flex-direction: column;
  }

  .catalog-card:hover {
    transform: translateY(-5px);
    box-shadow: var(--shadow-lg);
    border-color: var(--rose-light);
  }

  .catalog-cover {
    height: 160px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 56px;
    position: relative;
  }

  .catalog-cover-python   { background: linear-gradient(135deg, #306998, #ffd43b); }
  .catalog-cover-frontend { background: linear-gradient(135deg, #e34c26, #264de4); }
  .catalog-cover-js       { background: linear-gradient(135deg, #f0db4f, #2c3e50); }
  .catalog-cover-mysql    { background: linear-gradient(135deg, #00758f, #f29111); }
  .catalog-cover-node     { background: linear-gradient(135deg, #3c873a, #303030); }
  .catalog-cover-git      { background: linear-gradient(135deg, #f05033, #221e1e); }
  .catalog-cover-react    { background: linear-gradient(135deg, #61dbfb, #282c34); }
  .catalog-cover-security { background: linear-gradient(135deg, #2c2c2c, #e91e8c); }
  .catalog-cover-docker   { background: linear-gradient(135deg, #2496ed, #1a1a2e); }
  .catalog-cover-ml       { background: linear-gradient(135deg, #ff6b6b, #7c3aed); }

  .catalog-level-badge {
    position: absolute;
    top: 12px; left: 12px;
    font-size: 0.7rem;
    font-weight: 700;
    padding: 4px 10px;
    border-radius: 50px;
    background: rgba(255,255,255,.2);
    color: white;
    backdrop-filter: blur(4px);
    border: 1px solid rgba(255,255,255,.3);
  }

  .catalog-pages {
    position: absolute;
    top: 12px; right: 12px;
    font-size: 0.7rem;
    color: rgba(255,255,255,.85);
    background: rgba(0,0,0,.25);
    padding: 4px 10px;
    border-radius: 50px;
  }

  .catalog-body {
    padding: 20px;
    flex: 1;
    display: flex;
    flex-direction: column;
  }

  .catalog-cat {
    font-size: 0.72rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.08em;
    color: var(--mauve);
    margin-bottom: 8px;
    display: flex;
    align-items: center;
    gap: 6px;
  }

  .catalog-title {
    font-family: var(--font-display);
    font-size: 1.12rem;
    font-weight: 600;
    color: var(--charcoal);
    line-height: 1.3;
    margin-bottom: 10px;
  }

  .catalog-desc {
    font-size: 0.83rem;
    color: #aaa;
    line-height: 1.65;
    flex: 1;
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
  }

  .catalog-footer {
    margin-top: 18px;
    padding-top: 16px;
    border-top: 1px solid var(--gray-light);
    display: flex;
    align-items: center;
    justify-content: space-between;
  }

  .catalog-price {
    font-family: var(--font-display);
    font-size: 1.5rem;
    font-weight: 600;
    color: var(--rose);
  }

  .catalog-actions {
    display: flex;
    gap: 8px;
  }

  .btn-detail {
    padding: 9px 18px;
    font-size: 0.82rem;
    border-radius: 50px;
    background: white;
    border: 1.5px solid var(--rose);
    color: var(--rose);
    font-weight: 600;
    cursor: pointer;
    transition: var(--transition);
    text-decoration: none;
  }

  .btn-detail:hover { background: var(--rose); color: white; }

  .btn-buy {
    padding: 9px 18px;
    font-size: 0.82rem;
    border-radius: 50px;
    background: linear-gradient(135deg, var(--rose), var(--mauve));
    color: white;
    font-weight: 600;
    cursor: pointer;
    transition: var(--transition);
    text-decoration: none;
    border: none;
  }

  .btn-buy:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 18px rgba(212,80,122,.4);
    color: white;
  }

  /* ── EMPTY STATE ──────────────── */
  .empty-state {
    text-align: center;
    padding: 80px 20px;
    color: #bbb;
  }

  .empty-state i {
    font-size: 64px;
    color: var(--rose-light);
    margin-bottom: 20px;
  }

  .empty-state h3 {
    font-family: var(--font-display);
    font-size: 1.5rem;
    color: #ccc;
    margin-bottom: 8px;
  }

  @media (max-width: 768px) {
    .manuals-catalog { grid-template-columns: 1fr; }
    .catalog-header { flex-direction: column; gap: 12px; align-items: flex-start; }
  }
</style>

<!-- HERO -->
<section class="portafolio-hero">
  <span class="section-tag">Nuestro Portafolio</span>
  <h1>Catálogo de <em>Manuales Técnicos</em></h1>
  <p>Explora nuestra colección de manuales digitales y elige el que impulsa tu carrera</p>
</section>

<!-- FILTROS -->
<div class="filters-bar">
  <span class="filter-label">Categoría:</span>
  <a href="/portafolio" class="filter-pill <?= empty($filters['categoria']) ? 'active' : '' ?>">🔍 Todos</a>
  <a href="/portafolio?categoria=python"       class="filter-pill <?= ($filters['categoria'] ?? '') === 'python'         ? 'active' : '' ?>">🐍 Python</a>
  <a href="/portafolio?categoria=frontend"     class="filter-pill <?= ($filters['categoria'] ?? '') === 'frontend'       ? 'active' : '' ?>">🌐 Frontend</a>
  <a href="/portafolio?categoria=javascript"   class="filter-pill <?= ($filters['categoria'] ?? '') === 'javascript'     ? 'active' : '' ?>">⚡ JavaScript</a>
  <a href="/portafolio?categoria=bases-de-datos" class="filter-pill <?= ($filters['categoria'] ?? '') === 'bases-de-datos' ? 'active' : '' ?>">🗄️ BD</a>
  <a href="/portafolio?categoria=backend"      class="filter-pill <?= ($filters['categoria'] ?? '') === 'backend'        ? 'active' : '' ?>">🚀 Backend</a>
  <a href="/portafolio?categoria=devops"       class="filter-pill <?= ($filters['categoria'] ?? '') === 'devops'         ? 'active' : '' ?>">🔀 DevOps</a>
  <a href="/portafolio?categoria=seguridad"    class="filter-pill <?= ($filters['categoria'] ?? '') === 'seguridad'      ? 'active' : '' ?>">🔒 Seguridad</a>
  <a href="/portafolio?categoria=ia-ml"        class="filter-pill <?= ($filters['categoria'] ?? '') === 'ia-ml'          ? 'active' : '' ?>">🧠 IA & ML</a>

  <div class="filter-sep"></div>
  <span class="filter-label">Nivel:</span>
  <a href="/portafolio<?= !empty($filters['categoria']) ? '?categoria='.$filters['categoria'] : '' ?>" class="filter-pill <?= empty($filters['nivel']) ? 'active' : '' ?>">Todos</a>
  <a href="/portafolio?nivel=Básico<?= !empty($filters['categoria']) ? '&categoria='.$filters['categoria'] : '' ?>"       class="filter-pill <?= ($filters['nivel'] ?? '') === 'Básico'      ? 'active' : '' ?>">🟢 Básico</a>
  <a href="/portafolio?nivel=Intermedio<?= !empty($filters['categoria']) ? '&categoria='.$filters['categoria'] : '' ?>"   class="filter-pill <?= ($filters['nivel'] ?? '') === 'Intermedio'  ? 'active' : '' ?>">🟡 Intermedio</a>
  <a href="/portafolio?nivel=Avanzado<?= !empty($filters['categoria']) ? '&categoria='.$filters['categoria'] : '' ?>"     class="filter-pill <?= ($filters['nivel'] ?? '') === 'Avanzado'    ? 'active' : '' ?>">🔴 Avanzado</a>
</div>

<!-- CATÁLOGO -->
<section class="catalog-section">
  <div class="catalog-header">
    <div class="catalog-count">
      Mostrando <span><?= count($manuals) ?></span> manual<?= count($manuals) !== 1 ? 'es' : '' ?>
    </div>
  </div>

  <?php
  $coverClasses = [
    'python'    => 'catalog-cover-python',
    'frontend'  => 'catalog-cover-frontend',
    'javascript'=> 'catalog-cover-js',
    'bases-de-datos' => 'catalog-cover-mysql',
    'backend'   => 'catalog-cover-node',
    'devops'    => ['catalog-cover-git', 'catalog-cover-docker'],
    'seguridad' => 'catalog-cover-security',
    'ia-ml'     => 'catalog-cover-ml',
  ];
  $emojis = [
    'python'    => '🐍',
    'frontend'  => '🌐',
    'javascript'=> '⚡',
    'bases-de-datos' => '🗄️',
    'backend'   => '🚀',
    'devops'    => '🔀',
    'seguridad' => '🔒',
    'ia-ml'     => '🧠',
  ];
  $coverIdx = [];
  ?>

  <?php if (empty($manuals)): ?>
    <div class="empty-state">
      <i class="fas fa-book-open"></i>
      <h3>No se encontraron manuales</h3>
      <p>Prueba con otros filtros o <a href="/portafolio">ver todos</a></p>
    </div>
  <?php else: ?>
    <div class="manuals-catalog">
      <?php foreach ($manuals as $m):
        $slug = $m['category_slug'];
        $coverClass = is_array($coverClasses[$slug] ?? null)
          ? $coverClasses[$slug][$coverIdx[$slug] = (($coverIdx[$slug] ?? 0) % count($coverClasses[$slug]))]
          : ($coverClasses[$slug] ?? 'catalog-cover-python');
        $emoji = $emojis[$slug] ?? '📘';
      ?>
        <div class="catalog-card reveal">
          <div class="catalog-cover <?= $coverClass ?>">
            <span style="position:relative;z-index:1"><?= $emoji ?></span>
            <span class="catalog-level-badge"><?= esc($m['level']) ?></span>
            <?php if ($m['pages']): ?>
              <span class="catalog-pages"><?= esc($m['pages']) ?> pág</span>
            <?php endif; ?>
          </div>

          <div class="catalog-body">
            <div class="catalog-cat">
              <i class="<?= esc($m['category_icon']) ?>"></i>
              <?= esc($m['category_name']) ?>
            </div>
            <h3 class="catalog-title"><?= esc($m['title']) ?></h3>
            <p class="catalog-desc"><?= esc($m['short_desc']) ?></p>

            <div class="catalog-footer">
              <span class="catalog-price">$<?= number_format($m['price'], 2) ?></span>
              <div class="catalog-actions">
                <a href="/portafolio/<?= esc($m['slug']) ?>" class="btn-detail">Ver más</a>
                <?php if (session()->get('user_id')): ?>
                  <a href="/checkout/<?= esc($m['id']) ?>" class="btn-buy">Comprar</a>
                <?php else: ?>
                  <a href="/login" class="btn-buy">Comprar</a>
                <?php endif; ?>
              </div>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>
</section>
