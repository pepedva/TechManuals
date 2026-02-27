<!-- app/Views/shop/success.php -->
<style>
  .success-page {
    min-height: 60vh;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 60px 5%;
    background: linear-gradient(135deg, #f0fff4, #fff0f6);
  }

  .success-card {
    background: white;
    border-radius: var(--radius-lg);
    padding: 56px 48px;
    text-align: center;
    max-width: 560px;
    box-shadow: var(--shadow-lg);
    border: 1px solid rgba(76,175,80,.12);
  }

  .success-icon {
    width: 96px;
    height: 96px;
    background: linear-gradient(135deg, #4caf50, #8bc34a);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 42px;
    margin: 0 auto 28px;
    animation: bounceIn .6s ease;
  }

  @keyframes bounceIn {
    0%   { transform: scale(0); opacity: 0; }
    60%  { transform: scale(1.15); }
    100% { transform: scale(1); opacity: 1; }
  }

  .success-card h1 {
    font-family: var(--font-display);
    font-size: 2rem;
    color: var(--charcoal);
    margin-bottom: 12px;
  }

  .success-card p { color: #888; font-size: 1rem; margin-bottom: 8px; }

  .success-manual {
    background: var(--gray-light);
    border-radius: var(--radius);
    padding: 20px;
    margin: 28px 0;
    font-weight: 600;
    color: var(--charcoal);
    font-family: var(--font-display);
    font-size: 1.1rem;
  }

  .download-section {
    margin-top: 20px;
  }

  .email-note {
    background: #e8f5e9;
    border-radius: var(--radius);
    padding: 16px;
    font-size: 0.85rem;
    color: #388e3c;
    margin: 20px 0;
    display: flex;
    align-items: center;
    gap: 10px;
    text-align: left;
  }

  .success-actions {
    display: flex;
    gap: 12px;
    justify-content: center;
    flex-wrap: wrap;
    margin-top: 28px;
  }
</style>

<section class="success-page">
  <div class="success-card reveal">
    <div class="success-icon">✅</div>

    <h1>¡Compra exitosa!</h1>
    <p>Tu pago fue procesado correctamente.</p>

    <div class="success-manual">
      📘 <?= esc($order['title']) ?>
    </div>

    <div class="email-note">
      <i class="fas fa-envelope" style="font-size:20px;flex-shrink:0"></i>
      <span>
        Te enviamos un email con el link de descarga a <strong><?= esc($order['buyer_email']) ?></strong>.
        El link es de un solo uso y válido por 24 horas.
      </span>
    </div>

    <?php if (!empty($order['token']) && !$order['used'] && strtotime($order['expires_at']) > time()): ?>
      <div class="download-section">
        <p style="font-size:.88rem;color:#aaa;margin-bottom:12px">También puedes descargar directamente aquí:</p>
        <a href="/descargar/<?= esc($order['token']) ?>" class="btn btn-primary" style="width:100%;justify-content:center">
          <i class="fas fa-download"></i> Descargar mi manual ahora
        </a>
      </div>
    <?php endif; ?>

    <div class="success-actions">
      <a href="/portafolio" class="btn btn-outline">Ver más manuales</a>
      <a href="/mis-compras" class="btn btn-outline">Mis compras</a>
    </div>
  </div>
</section>
