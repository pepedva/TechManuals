<!-- app/Views/shop/download_error.php -->
<style>
  .error-page {
    min-height: calc(100vh - 72px);
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 60px 20px;
    background: linear-gradient(135deg, #fff0f6 0%, #f5eeff 100%);
  }

  .error-card {
    background: white;
    border-radius: var(--radius-lg);
    padding: 56px 48px;
    text-align: center;
    max-width: 540px;
    width: 100%;
    box-shadow: var(--shadow-lg);
    border: 1px solid rgba(212, 80, 122, .08);
    animation: fadeUp .5s ease forwards;
  }

  @keyframes fadeUp {
    from { opacity: 0; transform: translateY(24px); }
    to   { opacity: 1; transform: translateY(0); }
  }

  /* Ícono animado */
  .error-icon-wrap {
    width: 100px;
    height: 100px;
    margin: 0 auto 28px;
    position: relative;
  }

  .error-icon-circle {
    width: 100px;
    height: 100px;
    border-radius: 50%;
    background: linear-gradient(135deg, #fff0f6, var(--rose-light));
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 44px;
    border: 2px solid var(--rose-light);
    animation: pulse 2.5s ease infinite;
  }

  @keyframes pulse {
    0%, 100% { box-shadow: 0 0 0 0 rgba(212, 80, 122, .15); }
    50%       { box-shadow: 0 0 0 14px rgba(212, 80, 122, 0); }
  }

  .error-card h1 {
    font-family: var(--font-display);
    font-size: 1.9rem;
    color: var(--charcoal);
    margin-bottom: 12px;
    line-height: 1.2;
  }

  .error-reason {
    font-size: .98rem;
    color: #888;
    line-height: 1.75;
    margin-bottom: 28px;
    max-width: 400px;
    margin-left: auto;
    margin-right: auto;
  }

  /* Caja de hint */
  .error-hint {
    background: var(--gray-light);
    border-radius: var(--radius);
    padding: 16px 20px;
    font-size: .88rem;
    color: #666;
    margin-bottom: 28px;
    text-align: left;
    display: flex;
    gap: 12px;
    align-items: flex-start;
  }

  .error-hint i {
    color: var(--rose);
    font-size: 18px;
    margin-top: 1px;
    flex-shrink: 0;
  }

  /* Explicación de por qué expiran */
  .why-expire {
    border: 1.5px solid var(--rose-light);
    border-radius: var(--radius);
    padding: 20px;
    margin-bottom: 28px;
    text-align: left;
  }

  .why-expire h4 {
    font-size: .85rem;
    font-weight: 700;
    color: var(--rose-deep);
    margin-bottom: 10px;
    display: flex;
    align-items: center;
    gap: 8px;
  }

  .why-expire ul {
    list-style: none;
    padding: 0;
  }

  .why-expire ul li {
    font-size: .83rem;
    color: #888;
    padding: 4px 0;
    display: flex;
    align-items: center;
    gap: 8px;
  }

  .why-expire ul li i {
    color: var(--rose-light);
    font-size: 11px;
  }

  /* Botones de acción */
  .error-actions {
    display: flex;
    flex-direction: column;
    gap: 12px;
  }

  .error-actions .btn {
    width: 100%;
    justify-content: center;
  }

  /* Separador */
  .error-divider {
    display: flex;
    align-items: center;
    gap: 12px;
    margin: 4px 0;
  }

  .error-divider::before,
  .error-divider::after {
    content: '';
    flex: 1;
    height: 1px;
    background: var(--gray-light);
  }

  .error-divider span {
    font-size: .75rem;
    color: #ccc;
    text-transform: uppercase;
    letter-spacing: .06em;
  }

  /* Soporte */
  .support-note {
    margin-top: 28px;
    padding-top: 24px;
    border-top: 1px solid var(--gray-light);
    font-size: .82rem;
    color: #bbb;
  }

  .support-note a {
    color: var(--rose);
    font-weight: 600;
  }

  @media (max-width: 480px) {
    .error-card { padding: 40px 24px; }
  }
</style>

<section class="error-page">
  <div class="error-card">

    <!-- Ícono -->
    <div class="error-icon-wrap">
      <div class="error-icon-circle">⏰</div>
    </div>

    <h1>Link de descarga inválido</h1>

    <p class="error-reason">
      <?= esc($reason ?? 'El link de descarga es inválido, ya fue utilizado o ha expirado.') ?>
    </p>

    <!-- Hint de solución -->
    <?php if (!empty($hint)): ?>
      <div class="error-hint">
        <i class="fas fa-lightbulb"></i>
        <span><?= $hint /* contiene HTML, viene del controlador de forma segura */ ?></span>
      </div>
    <?php endif; ?>

    <!-- Por qué expiran los links -->
    <div class="why-expire">
      <h4><i class="fas fa-shield-alt"></i> ¿Por qué expiran los links?</h4>
      <ul>
        <li><i class="fas fa-circle"></i> Protegen tu compra de accesos no autorizados</li>
        <li><i class="fas fa-circle"></i> Evitan la distribución ilegal del contenido</li>
        <li><i class="fas fa-circle"></i> Garantizan que solo tú puedas descargar tu manual</li>
        <li><i class="fas fa-circle"></i> Puedes generar un nuevo link en cualquier momento</li>
      </ul>
    </div>

    <!-- Acciones -->
    <div class="error-actions">
      <?php if (session()->get('user_id')): ?>
        <a href="/mis-compras" class="btn btn-primary">
          <i class="fas fa-download"></i> Ir a Mis Compras
        </a>

        <div class="error-divider"><span>o</span></div>

        <a href="/portafolio" class="btn btn-outline">
          <i class="fas fa-book-open"></i> Explorar el catálogo
        </a>
      <?php else: ?>
        <a href="/login" class="btn btn-primary">
          <i class="fas fa-sign-in-alt"></i> Iniciar sesión
        </a>

        <div class="error-divider"><span>o</span></div>

        <a href="/portafolio" class="btn btn-outline">
          <i class="fas fa-book-open"></i> Ver el catálogo
        </a>
      <?php endif; ?>
    </div>

    <!-- Soporte -->
    <div class="support-note">
      ¿Tienes problemas con tu descarga? Escríbenos a
      <a href="mailto:soporte@techmanuals.com">soporte@techmanuals.com</a>
      y lo resolvemos en menos de 24 horas.
    </div>

  </div>
</section>
