<!-- app/Views/shop/checkout.php -->
<style>
  .checkout-page {
    max-width: 900px;
    margin: 60px auto;
    padding: 0 5%;
    display: grid;
    grid-template-columns: 1.2fr 1fr;
    gap: 40px;
    align-items: start;
  }

  .checkout-summary {
    background: white;
    border-radius: var(--radius-lg);
    padding: 32px;
    border: 1.5px solid var(--gray-light);
  }

  .checkout-summary h2 {
    font-family: var(--font-display);
    font-size: 1.4rem;
    color: var(--charcoal);
    margin-bottom: 24px;
    padding-bottom: 16px;
    border-bottom: 1px solid var(--gray-light);
  }

  .checkout-manual-info {
    display: flex;
    gap: 16px;
    margin-bottom: 24px;
  }

  .checkout-manual-img {
    width: 80px;
    height: 80px;
    background: linear-gradient(135deg, var(--rose), var(--mauve));
    border-radius: var(--radius);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 36px;
    flex-shrink: 0;
  }

  .checkout-manual-details h3 {
    font-family: var(--font-display);
    font-size: 1.05rem;
    color: var(--charcoal);
    margin-bottom: 4px;
  }

  .checkout-manual-details p {
    font-size: 0.82rem;
    color: #aaa;
  }

  .checkout-line {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 12px 0;
    border-bottom: 1px solid var(--gray-light);
    font-size: 0.9rem;
  }

  .checkout-line:last-child { border-bottom: none; }
  .checkout-line .label { color: #888; }
  .checkout-line .value { font-weight: 600; color: var(--charcoal); }

  .checkout-total {
    background: var(--rose-light);
    border-radius: var(--radius);
    padding: 16px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 16px;
  }

  .checkout-total .label {
    font-weight: 700;
    color: var(--rose-deep);
  }

  .checkout-total .value {
    font-family: var(--font-display);
    font-size: 1.8rem;
    font-weight: 600;
    color: var(--rose);
  }

  /* PayPal container */
  .payment-card {
    background: white;
    border-radius: var(--radius-lg);
    padding: 32px;
    border: 1.5px solid var(--gray-light);
    position: sticky;
    top: 92px;
  }

  .payment-card h2 {
    font-family: var(--font-display);
    font-size: 1.4rem;
    color: var(--charcoal);
    margin-bottom: 8px;
  }

  .payment-card p {
    font-size: 0.85rem;
    color: #aaa;
    margin-bottom: 24px;
  }

  #paypal-button-container {
    min-height: 52px;
  }

  .security-badge {
    display: flex;
    align-items: center;
    gap: 8px;
    background: #f0faf0;
    border-radius: var(--radius);
    padding: 12px 14px;
    margin-top: 16px;
    font-size: 0.8rem;
    color: #4caf50;
    font-weight: 600;
  }

  .loading-payment {
    text-align: center;
    padding: 20px;
    color: #aaa;
    font-size: 0.9rem;
  }

  @media (max-width: 768px) {
    .checkout-page { grid-template-columns: 1fr; }
    .payment-card { position: static; }
  }
</style>

<div style="background:linear-gradient(135deg,#fff0f6,#f5eeff);padding:50px 5% 30px;text-align:center;border-bottom:1px solid var(--rose-light)">
  <span class="section-tag">Paso final</span>
  <h1 style="font-family:var(--font-display);font-size:2rem;color:var(--charcoal)">
    Completa tu <em style="color:var(--rose)">compra</em>
  </h1>
</div>

<div class="checkout-page">
  <!-- Resumen -->
  <div class="checkout-summary reveal">
    <h2>📋 Resumen del pedido</h2>

    <div class="checkout-manual-info">
      <div class="checkout-manual-img">📘</div>
      <div class="checkout-manual-details">
        <h3><?= esc($manual['title']) ?></h3>
        <p>Manual Digital PDF · <?= esc($manual['pages']) ?> páginas · <?= esc($manual['level']) ?></p>
        <p>Idioma: <?= esc($manual['language']) ?></p>
      </div>
    </div>

    <div class="checkout-line">
      <span class="label">Precio del manual</span>
      <span class="value">$<?= number_format($manual['price'], 2) ?> USD</span>
    </div>
    <div class="checkout-line">
      <span class="label">Formato</span>
      <span class="value">PDF Digital</span>
    </div>
    <div class="checkout-line">
      <span class="label">Acceso</span>
      <span class="value">Link por email (24h)</span>
    </div>
    <div class="checkout-line">
      <span class="label">Impuestos</span>
      <span class="value">$0.00</span>
    </div>

    <div class="checkout-total">
      <span class="label">TOTAL</span>
      <span class="value">$<?= number_format($manual['price'], 2) ?> USD</span>
    </div>

    <p style="font-size:.78rem;color:#ccc;margin-top:16px;text-align:center">
      🔒 Transacción cifrada y segura con SSL
    </p>
  </div>

  <!-- Pago -->
  <div class="payment-card reveal">
    <h2>💳 Método de pago</h2>
    <p>Procesamos tu pago de forma segura a través de PayPal</p>

    <div id="paypal-button-container">
      <div class="loading-payment">
        <i class="fas fa-spinner fa-spin"></i> Cargando métodos de pago...
      </div>
    </div>

    <div class="security-badge">
      <i class="fas fa-shield-alt"></i>
      Pago 100% seguro con protección de compradores de PayPal
    </div>
  </div>
</div>

<!-- PayPal SDK -->
<script src="https://www.paypal.com/sdk/js?client-id=<?= esc($paypalClientId) ?>&currency=USD"></script>
<script>
  const MANUAL_ID  = <?= (int)$manual['id'] ?>;
  const CSRF_TOKEN = '<?= csrf_hash() ?>';

  paypal.Buttons({
    style: {
      shape: 'pill',
      color: 'gold',
      layout: 'vertical',
      label: 'pay',
    },

    // 1️⃣ Crear la orden en nuestro backend
    createOrder: async () => {
      const res = await fetch('/checkout/create-order', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `manual_id=${MANUAL_ID}&<?= csrf_token() ?>=${CSRF_TOKEN}`,
      });
      const data = await res.json();
      if (data.error) {
        alert('Error: ' + data.error);
        return;
      }
      // Guardar el ID de orden de nuestra BD para captura posterior
      window._orderDbId = data.order_db;
      return data.id; // ID de orden PayPal
    },

    // 2️⃣ Capturar el pago después de aprobarlo
    onApprove: async (data) => {
      const res = await fetch('/checkout/capture', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `paypal_order_id=${data.orderID}&order_db_id=${window._orderDbId}&<?= csrf_token() ?>=${CSRF_TOKEN}`,
      });
      const result = await res.json();
      if (result.success) {
        window.location.href = result.redirect;
      } else {
        alert('Error al procesar el pago: ' + (result.error || 'desconocido'));
      }
    },

    onError: (err) => {
      console.error('PayPal error:', err);
      alert('Ocurrió un error con PayPal. Por favor intenta de nuevo.');
    },

    onCancel: () => {
      window.location.href = '/checkout/cancel';
    },

  }).render('#paypal-button-container');
</script>
