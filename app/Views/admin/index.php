<!-- app/Views/admin/index.php -->
<style>
  .admin-layout {
    display: grid;
    grid-template-columns: 240px 1fr;
    min-height: calc(100vh - 72px);
  }

  /* ── SIDEBAR ADMIN ───────────────── */
  .admin-sidebar {
    background: var(--charcoal);
    padding: 32px 0;
    position: sticky;
    top: 72px;
    height: calc(100vh - 72px);
    overflow-y: auto;
  }

  .admin-sidebar-title {
    font-size: .72rem;
    font-weight: 700;
    letter-spacing: .12em;
    text-transform: uppercase;
    color: rgba(255,255,255,.3);
    padding: 0 24px;
    margin-bottom: 12px;
    margin-top: 24px;
  }

  .admin-sidebar-title:first-child { margin-top: 0; }

  .admin-nav-item {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 11px 24px;
    font-size: .88rem;
    font-weight: 500;
    color: rgba(255,255,255,.65);
    text-decoration: none;
    transition: var(--transition);
    position: relative;
  }

  .admin-nav-item:hover,
  .admin-nav-item.active {
    color: white;
    background: rgba(212,80,122,.15);
  }

  .admin-nav-item.active::before {
    content: '';
    position: absolute;
    left: 0; top: 0; bottom: 0;
    width: 3px;
    background: var(--rose);
    border-radius: 0 2px 2px 0;
  }

  .admin-nav-item i {
    width: 18px;
    text-align: center;
    font-size: 15px;
    color: var(--rose);
    opacity: .8;
  }

  .admin-nav-item.active i { opacity: 1; }

  .nav-badge {
    margin-left: auto;
    background: var(--rose);
    color: white;
    font-size: .68rem;
    font-weight: 700;
    padding: 2px 7px;
    border-radius: 50px;
  }

  /* ── CONTENIDO ADMIN ─────────────── */
  .admin-content {
    background: #f8f4f0;
    padding: 40px;
    overflow-x: auto;
  }

  .admin-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 36px;
  }

  .admin-header h1 {
    font-family: var(--font-display);
    font-size: 2rem;
    color: var(--charcoal);
    line-height: 1.2;
  }

  .admin-header h1 em { color: var(--rose); font-style: italic; }

  .admin-header p {
    font-size: .88rem;
    color: #aaa;
    margin-top: 4px;
  }

  .admin-date {
    font-size: .82rem;
    color: #bbb;
    background: white;
    padding: 8px 16px;
    border-radius: 50px;
    border: 1px solid var(--gray-light);
  }

  /* ── TARJETAS DE ESTADÍSTICAS ────── */
  .stats-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 20px;
    margin-bottom: 36px;
  }

  .stat-card {
    background: white;
    border-radius: var(--radius-lg);
    padding: 24px;
    border: 1px solid rgba(0,0,0,.04);
    box-shadow: 0 2px 12px rgba(0,0,0,.04);
    transition: var(--transition);
    position: relative;
    overflow: hidden;
  }

  .stat-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(0,0,0,.08);
  }

  .stat-card::after {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0;
    height: 3px;
  }

  .stat-card.rose::after   { background: linear-gradient(90deg, var(--rose), var(--mauve)); }
  .stat-card.green::after  { background: linear-gradient(90deg, #4caf50, #8bc34a); }
  .stat-card.blue::after   { background: linear-gradient(90deg, #2196f3, #03a9f4); }
  .stat-card.gold::after   { background: linear-gradient(90deg, var(--gold), #e6c06a); }

  .stat-icon {
    width: 48px;
    height: 48px;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    margin-bottom: 16px;
  }

  .stat-card.rose  .stat-icon { background: var(--rose-light); color: var(--rose); }
  .stat-card.green .stat-icon { background: #e8f5e9; color: #4caf50; }
  .stat-card.blue  .stat-icon { background: #e3f2fd; color: #2196f3; }
  .stat-card.gold  .stat-icon { background: var(--gold-light); color: var(--gold); }

  .stat-value {
    font-family: var(--font-display);
    font-size: 2.2rem;
    font-weight: 600;
    color: var(--charcoal);
    line-height: 1;
    margin-bottom: 6px;
  }

  .stat-label {
    font-size: .82rem;
    color: #aaa;
    font-weight: 500;
  }

  /* ── GRIDS DE TABLAS ─────────────── */
  .dashboard-grid {
    display: grid;
    grid-template-columns: 1.4fr 1fr;
    gap: 24px;
  }

  .admin-card {
    background: white;
    border-radius: var(--radius-lg);
    overflow: hidden;
    box-shadow: 0 2px 12px rgba(0,0,0,.04);
    border: 1px solid rgba(0,0,0,.04);
  }

  .admin-card-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 20px 24px;
    border-bottom: 1px solid var(--gray-light);
  }

  .admin-card-header h3 {
    font-family: var(--font-display);
    font-size: 1.1rem;
    color: var(--charcoal);
  }

  .admin-card-header a {
    font-size: .78rem;
    font-weight: 600;
    color: var(--rose);
  }

  /* Tabla de órdenes recientes */
  .admin-table {
    width: 100%;
    border-collapse: collapse;
  }

  .admin-table th {
    font-size: .72rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .08em;
    color: #bbb;
    padding: 14px 16px;
    text-align: left;
    background: #fafafa;
    border-bottom: 1px solid var(--gray-light);
  }

  .admin-table td {
    padding: 14px 16px;
    font-size: .85rem;
    color: var(--charcoal);
    border-bottom: 1px solid #f5f5f5;
    vertical-align: middle;
  }

  .admin-table tr:last-child td { border-bottom: none; }

  .admin-table tr:hover td { background: #fdf8f2; }

  /* Badges de estado */
  .status-badge {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 4px 10px;
    border-radius: 50px;
    font-size: .72rem;
    font-weight: 700;
  }

  .status-badge.completed { background: #e8f5e9; color: #388e3c; }
  .status-badge.pending   { background: #fff8e1; color: #f57f17; }
  .status-badge.failed    { background: #fce4ec; color: #c62828; }
  .status-badge.refunded  { background: #e3f2fd; color: #1565c0; }

  /* Top manuales */
  .top-manual-item {
    display: flex;
    align-items: center;
    gap: 14px;
    padding: 14px 24px;
    border-bottom: 1px solid #f5f5f5;
    transition: var(--transition);
  }

  .top-manual-item:last-child { border-bottom: none; }
  .top-manual-item:hover { background: #fdf8f2; }

  .top-rank {
    width: 28px;
    height: 28px;
    border-radius: 50%;
    background: var(--rose-light);
    color: var(--rose);
    font-size: .78rem;
    font-weight: 700;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
  }

  .top-rank.gold-rank { background: var(--gold-light); color: var(--gold); }

  .top-manual-info { flex: 1; min-width: 0; }

  .top-manual-info h4 {
    font-size: .88rem;
    font-weight: 600;
    color: var(--charcoal);
    margin-bottom: 2px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
  }

  .top-manual-info p {
    font-size: .75rem;
    color: #aaa;
  }

  .top-manual-revenue {
    font-family: var(--font-display);
    font-size: 1rem;
    font-weight: 600;
    color: var(--rose);
    text-align: right;
    flex-shrink: 0;
  }

  .top-manual-revenue span {
    display: block;
    font-size: .72rem;
    color: #bbb;
    font-family: var(--font-body);
    font-weight: 400;
    text-align: right;
  }

  /* Quick actions */
  .quick-actions {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 12px;
    padding: 20px 24px;
  }

  .quick-action-btn {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 14px 16px;
    border-radius: var(--radius);
    font-size: .85rem;
    font-weight: 600;
    text-decoration: none;
    transition: var(--transition);
    border: 1.5px solid var(--gray-light);
    color: var(--charcoal);
    background: white;
  }

  .quick-action-btn:hover {
    border-color: var(--rose);
    color: var(--rose);
    background: var(--rose-light);
  }

  .quick-action-btn i {
    width: 32px;
    height: 32px;
    background: var(--gray-light);
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 14px;
    color: var(--rose);
    transition: var(--transition);
  }

  .quick-action-btn:hover i { background: var(--rose-light); }

  @media (max-width: 1200px) {
    .stats-grid { grid-template-columns: repeat(2, 1fr); }
    .dashboard-grid { grid-template-columns: 1fr; }
  }

  @media (max-width: 900px) {
    .admin-layout { grid-template-columns: 1fr; }
    .admin-sidebar { display: none; }
    .admin-content { padding: 24px 16px; }
  }
</style>

<div class="admin-layout">

  <!-- ── SIDEBAR ── -->
  <aside class="admin-sidebar">
    <div class="admin-sidebar-title">Principal</div>
    <a href="/admin" class="admin-nav-item active">
      <i class="fas fa-tachometer-alt"></i> Dashboard
    </a>

    <div class="admin-sidebar-title">Catálogo</div>
    <a href="/admin/manuales" class="admin-nav-item">
      <i class="fas fa-book"></i> Manuales
    </a>
    <a href="/admin/manuales/nuevo" class="admin-nav-item">
      <i class="fas fa-plus-circle"></i> Nuevo Manual
    </a>

    <div class="admin-sidebar-title">Ventas</div>
    <a href="/admin/ordenes" class="admin-nav-item">
      <i class="fas fa-shopping-bag"></i> Órdenes
    </a>
    <a href="/admin/usuarios" class="admin-nav-item">
      <i class="fas fa-users"></i> Usuarios
    </a>

    <div class="admin-sidebar-title">Comunicación</div>
    <a href="/admin/mensajes" class="admin-nav-item">
      <i class="fas fa-envelope"></i> Mensajes
      <?php if (($unread_messages ?? 0) > 0): ?>
        <span class="nav-badge"><?= $unread_messages ?></span>
      <?php endif; ?>
    </a>

    <div class="admin-sidebar-title">Sitio</div>
    <a href="/" target="_blank" class="admin-nav-item">
      <i class="fas fa-external-link-alt"></i> Ver sitio
    </a>
    <a href="/logout" class="admin-nav-item" style="color:rgba(255,80,80,.7)">
      <i class="fas fa-sign-out-alt" style="color:rgba(255,80,80,.7)"></i> Cerrar sesión
    </a>
  </aside>

  <!-- ── CONTENIDO ── -->
  <div class="admin-content">

    <!-- Header -->
    <div class="admin-header">
      <div>
        <h1>Panel de <em>Administración</em></h1>
        <p>Bienvenida, <?= esc(session()->get('user_name')) ?> 👋</p>
      </div>
      <div class="admin-date">
        <i class="fas fa-calendar-alt" style="color:var(--rose);margin-right:6px"></i>
        <?= date('d \d\e F, Y') ?>
      </div>
    </div>

    <!-- Stats -->
    <div class="stats-grid">
      <div class="stat-card rose">
        <div class="stat-icon"><i class="fas fa-users"></i></div>
        <div class="stat-value"><?= number_format($stats['total_users']) ?></div>
        <div class="stat-label">Usuarios registrados</div>
      </div>
      <div class="stat-card green">
        <div class="stat-icon"><i class="fas fa-book"></i></div>
        <div class="stat-value"><?= number_format($stats['total_manuals']) ?></div>
        <div class="stat-label">Manuales activos</div>
      </div>
      <div class="stat-card blue">
        <div class="stat-icon"><i class="fas fa-shopping-bag"></i></div>
        <div class="stat-value"><?= number_format($stats['total_orders']) ?></div>
        <div class="stat-label">Ventas completadas</div>
      </div>
      <div class="stat-card gold">
        <div class="stat-icon"><i class="fas fa-dollar-sign"></i></div>
        <div class="stat-value">$<?= number_format($stats['total_revenue'], 2) ?></div>
        <div class="stat-label">Ingresos totales (USD)</div>
      </div>
    </div>

    <!-- Dashboard grid -->
    <div class="dashboard-grid">

      <!-- Órdenes recientes -->
      <div class="admin-card">
        <div class="admin-card-header">
          <h3>📋 Órdenes recientes</h3>
          <a href="/admin/ordenes">Ver todas →</a>
        </div>
        <table class="admin-table">
          <thead>
            <tr>
              <th>#</th>
              <th>Usuario</th>
              <th>Manual</th>
              <th>Monto</th>
              <th>Estado</th>
            </tr>
          </thead>
          <tbody>
            <?php if (empty($recent_orders)): ?>
              <tr>
                <td colspan="5" style="text-align:center;color:#ccc;padding:32px">
                  No hay órdenes aún
                </td>
              </tr>
            <?php else: ?>
              <?php foreach ($recent_orders as $order): ?>
                <tr>
                  <td style="color:#bbb;font-size:.78rem">#<?= $order['id'] ?></td>
                  <td>
                    <div style="font-weight:600;font-size:.85rem"><?= esc($order['user_name']) ?></div>
                    <div style="font-size:.75rem;color:#bbb"><?= esc($order['user_email']) ?></div>
                  </td>
                  <td style="max-width:160px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap">
                    <?= esc($order['manual_title']) ?>
                  </td>
                  <td style="font-weight:600;color:var(--rose)">
                    $<?= number_format($order['amount'], 2) ?>
                  </td>
                  <td>
                    <span class="status-badge <?= $order['status'] ?>">
                      <?php
                      $icons = ['completed'=>'✅','pending'=>'⏳','failed'=>'❌','refunded'=>'↩️'];
                      echo ($icons[$order['status']] ?? '') . ' ' . ucfirst($order['status']);
                      ?>
                    </span>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php endif; ?>
          </tbody>
        </table>
      </div>

      <!-- Panel derecho -->
      <div style="display:flex;flex-direction:column;gap:24px">

        <!-- Top manuales -->
        <div class="admin-card">
          <div class="admin-card-header">
            <h3>🏆 Más vendidos</h3>
            <a href="/admin/manuales">Ver todos →</a>
          </div>
          <?php if (empty($top_manuals)): ?>
            <p style="padding:24px;color:#ccc;font-size:.88rem;text-align:center">Sin datos aún</p>
          <?php else: ?>
            <?php foreach ($top_manuals as $i => $m): ?>
              <div class="top-manual-item">
                <div class="top-rank <?= $i === 0 ? 'gold-rank' : '' ?>">
                  <?= $i === 0 ? '🥇' : ($i + 1) ?>
                </div>
                <div class="top-manual-info">
                  <h4><?= esc($m['title']) ?></h4>
                  <p><?= (int)$m['sales'] ?> venta<?= $m['sales'] != 1 ? 's' : '' ?></p>
                </div>
                <div class="top-manual-revenue">
                  $<?= number_format($m['revenue'] ?? 0, 2) ?>
                  <span>ingresos</span>
                </div>
              </div>
            <?php endforeach; ?>
          <?php endif; ?>
        </div>

        <!-- Acciones rápidas -->
        <div class="admin-card">
          <div class="admin-card-header">
            <h3>⚡ Acciones rápidas</h3>
          </div>
          <div class="quick-actions">
            <a href="/admin/manuales/nuevo" class="quick-action-btn">
              <i class="fas fa-plus"></i> Nuevo manual
            </a>
            <a href="/admin/ordenes?status=pending" class="quick-action-btn">
              <i class="fas fa-clock"></i> Pendientes
            </a>
            <a href="/admin/mensajes" class="quick-action-btn">
              <i class="fas fa-envelope"></i>
              Mensajes
              <?php if (($unread_messages ?? 0) > 0): ?>
                <span style="background:var(--rose);color:white;font-size:.65rem;padding:1px 6px;border-radius:50px;margin-left:auto"><?= $unread_messages ?></span>
              <?php endif; ?>
            </a>
            <a href="/admin/usuarios" class="quick-action-btn">
              <i class="fas fa-users"></i> Usuarios
            </a>
          </div>
        </div>

      </div>
    </div>

  </div><!-- /admin-content -->
</div><!-- /admin-layout -->
