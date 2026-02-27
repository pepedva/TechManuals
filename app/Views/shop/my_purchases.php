<!-- app/Views/shop/my_purchases.php -->
<style>
  .purchases-page { max-width: 900px; margin: 60px auto; padding: 0 5%; }

  .purchases-header { margin-bottom: 40px; }
  .purchases-header h1 { font-family: var(--font-display); font-size: 2rem; color: var(--charcoal); }
  .purchases-header h1 em { color: var(--rose); font-style: italic; }
  .purchases-header p { color: #aaa; font-size: .95rem; margin-top: 8px; }

  .purchase-card {
    background: white;
    border-radius: var(--radius-lg);
    padding: 24px;
    border: 1.5px solid var(--gray-light);
    margin-bottom: 20px;
    display: grid;
    grid-template-columns: auto 1fr auto;
    gap: 20px;
    align-items: center;
    transition: var(--transition);
  }

  .purchase-card:hover { box-shadow: var(--shadow); border-color: var(--rose-light); }

  .purchase-icon {
    width: 60px; height: 60px;
    background: linear-gradient(135deg, var(--rose), var(--mauve));
    border-radius: var(--radius);
    display: flex; align-items: center; justify-content: center;
    font-size: 28px; flex-shrink: 0;
  }

  .purchase-info h3 {
    font-family: var(--font-display);
    font-size: 1.1rem;
    color: var(--charcoal);
    margin-bottom: 4px;
  }

  .purchase-meta { font-size: .8rem; color: #bbb; display: flex; gap: 16px; flex-wrap: wrap; margin-top: 4px; }

  .purchase-actions { display: flex; flex-direction: column; gap: 8px; align-items: flex-end; }

  .price-tag {
    font-family: var(--font-display);
    font-size: 1.2rem;
    font-weight: 600;
    color: var(--rose);
  }

  .download-btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 9px 18px;
    background: linear-gradient(135deg, var(--rose), var(--mauve));
    color: white;
    border-radius: 50px;
    font-size: .83rem;
    font-weight: 600;
    text-decoration: none;
    transition: var(--transition);
  }

  .download-btn:hover { transform: translateY(-2px); box-shadow: 0 6px 18px rgba(212,80,122,.4); color: white; }

  .btn-regen {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 7px 14px;
    border: 1.5px solid #ddd;
    border-radius: 50px;
    font-size: .78rem;
    color: #aaa;
    text-decoration: none;
    transition: var(--transition);
  }

  .btn-regen:hover { border-color: var(--rose); color: var(--rose); }

  .token-expired { font-size:.78rem; color: #ccc; font-style: italic; }
  .token-used    { font-size:.78rem; color: #bbb; }

  .empty-purchases {
    text-align: center;
    padding: 80px 20px;
    color: #ccc;
  }
  .empty-purchases i { font-size: 64px; margin-bottom: 20px; display: block; }
  .empty-purchases h2 { font-family: var(--font-display); font-size: 1.5rem; color: #ddd; margin-bottom: 12px; }

  @media (max-width: 600px) {
    .purchase-card { grid-template-columns: auto 1fr; }
    .purchase-actions { grid-column: 1 / -1; flex-direction: row; }
  }
</style>

<div class="purchases-page">
  <div class="purchases-header">
    <h1>Mis <em>compras</em></h1>
    <p>Aquí encontrarás todos los manuales que has adquirido</p>
  </div>

  <?php if (empty($purchases)): ?>
    <div class="empty-purchases reveal">
      <i class="fas fa-shopping-bag"></i>
      <h2>Aún no tienes compras</h2>
      <p style="margin-bottom:24px">Explora nuestro catálogo y encuentra el manual perfecto para ti</p>
      <a href="/portafolio" class="btn btn-primary">Ver portafolio</a>
    </div>
  <?php else: ?>
    <?php foreach ($purchases as $p): ?>
      <?php
        $isExpired = strtotime($p['expires_at']) < time();
        $isUsed    = (bool)$p['used'];
      ?>
      <div class="purchase-card reveal">
        <div class="purchase-icon">📘</div>

        <div class="purchase-info">
          <h3><?= esc($p['title']) ?></h3>
          <div class="purchase-meta">
            <span>💰 $<?= number_format($p['amount'], 2) ?> <?= esc($p['currency']) ?></span>
            <span>📅 <?= date('d/m/Y', strtotime($p['created_at'])) ?></span>
            <?php if ($p['token']): ?>
              <?php if ($isExpired): ?>
                <span style="color:#e53935">⏰ Link expirado</span>
              <?php elseif ($isUsed): ?>
                <span style="color:#66bb6a">✅ Descargado</span>
              <?php else: ?>
                <span style="color:#4caf50">🟢 Link activo hasta <?= date('d/m H:i', strtotime($p['expires_at'])) ?>h</span>
              <?php endif; ?>
            <?php endif; ?>
          </div>
        </div>

        <div class="purchase-actions">
          <?php if ($p['token'] && !$isExpired && !$isUsed): ?>
            <a href="/descargar/<?= esc($p['token']) ?>" class="download-btn">
              <i class="fas fa-download"></i> Descargar
            </a>
          <?php elseif ($p['token']): ?>
            <a href="/descargar/regenerar/<?= (int)$p['id'] ?>" class="btn-regen" onclick="return confirm('¿Generar nuevo link de descarga? El anterior quedará inválido.')">
              <i class="fas fa-redo"></i> Nuevo link
            </a>
          <?php endif; ?>
        </div>
      </div>
    <?php endforeach; ?>
  <?php endif; ?>
</div>
