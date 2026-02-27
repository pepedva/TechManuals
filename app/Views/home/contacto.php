<!-- app/Views/home/contacto.php -->
<style>
  .page-hero { background: linear-gradient(135deg, #fff0f6 0%, #f5eeff 100%); padding: 90px 5% 70px; text-align: center; }
  .page-hero h1 { font-family: var(--font-display); font-size: clamp(2.2rem,4vw,3.2rem); color: var(--charcoal); }
  .page-hero h1 em { color: var(--rose); font-style: italic; }
  .page-hero p { color: #888; font-size: 1.05rem; max-width: 520px; margin: 16px auto 0; }

  .contact-section {
    max-width: 1100px;
    margin: 80px auto;
    padding: 0 5%;
    display: grid;
    grid-template-columns: 1fr 1.5fr;
    gap: 64px;
    align-items: start;
  }

  /* Sidebar info */
  .contact-info h2 {
    font-family: var(--font-display);
    font-size: 1.8rem;
    color: var(--charcoal);
    margin-bottom: 16px;
  }

  .contact-info h2 em { color: var(--rose); font-style: italic; }
  .contact-info p { color: #888; font-size: 0.95rem; line-height: 1.8; margin-bottom: 32px; }

  .contact-item {
    display: flex;
    align-items: flex-start;
    gap: 16px;
    margin-bottom: 24px;
  }

  .contact-item-icon {
    width: 44px;
    height: 44px;
    background: var(--rose-light);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--rose);
    font-size: 18px;
    flex-shrink: 0;
  }

  .contact-item h4 { font-size: 0.85rem; font-weight: 600; color: var(--charcoal); margin-bottom: 4px; }
  .contact-item p  { font-size: 0.88rem; color: #aaa; margin: 0; }
  .contact-item a  { color: var(--rose); }

  /* Formulario */
  .contact-form-card {
    background: white;
    border-radius: var(--radius-lg);
    padding: 40px;
    box-shadow: var(--shadow);
    border: 1px solid rgba(212,80,122,.06);
  }

  .contact-form-card h3 {
    font-family: var(--font-display);
    font-size: 1.5rem;
    color: var(--charcoal);
    margin-bottom: 28px;
  }

  .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }

  .error-list {
    background: #fff0f4;
    border: 1.5px solid var(--rose-light);
    border-radius: var(--radius);
    padding: 16px 20px;
    margin-bottom: 24px;
  }

  .error-list li { font-size: 0.85rem; color: var(--rose-deep); margin-bottom: 4px; }

  .social-section {
    margin-top: 40px;
    padding-top: 28px;
    border-top: 1px solid var(--gray-light);
  }

  .social-section h4 { font-size: 0.85rem; font-weight: 600; color: #ccc; text-transform: uppercase; letter-spacing: .08em; margin-bottom: 16px; }

  .social-grid { display: flex; gap: 12px; }

  .social-btn {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 10px 18px;
    border-radius: 50px;
    font-size: 0.83rem;
    font-weight: 600;
    border: 1.5px solid var(--gray-light);
    color: #777;
    transition: var(--transition);
    text-decoration: none;
  }

  .social-btn:hover { border-color: var(--rose); color: var(--rose); background: var(--rose-light); }

  @media (max-width: 768px) {
    .contact-section { grid-template-columns: 1fr; }
    .form-row { grid-template-columns: 1fr; }
  }
</style>

<section class="page-hero">
  <span class="section-tag">Contáctanos</span>
  <h1>¿Tienes alguna <em>pregunta?</em></h1>
  <p>Estamos aquí para ayudarte. Escríbenos y te respondemos a la brevedad</p>
</section>

<section class="contact-section">
  <!-- Info lateral -->
  <div class="contact-info reveal">
    <h2>Hablemos <em>juntas</em></h2>
    <p>Ya sea que tengas una duda sobre un manual, un problema técnico o simplemente quieras saludarnos — nos encanta escucharte.</p>

    <div class="contact-item">
      <div class="contact-item-icon"><i class="fas fa-envelope"></i></div>
      <div>
        <h4>Email</h4>
        <p><a href="mailto:hola@techmanuals.com">hola@techmanuals.com</a></p>
        <p>Respondemos en menos de 24h</p>
      </div>
    </div>

    <div class="contact-item">
      <div class="contact-item-icon"><i class="fas fa-headset"></i></div>
      <div>
        <h4>Soporte técnico</h4>
        <p><a href="mailto:soporte@techmanuals.com">soporte@techmanuals.com</a></p>
        <p>Para problemas con descargas o pagos</p>
      </div>
    </div>

    <div class="contact-item">
      <div class="contact-item-icon"><i class="fas fa-clock"></i></div>
      <div>
        <h4>Horario de atención</h4>
        <p>Lunes a Viernes: 9:00 – 18:00 (UTC-6)</p>
      </div>
    </div>

    <div class="social-section">
      <h4>Síguenos</h4>
      <div class="social-grid">
        <a href="#" class="social-btn"><i class="fab fa-instagram"></i> Instagram</a>
        <a href="#" class="social-btn"><i class="fab fa-twitter"></i> Twitter</a>
        <a href="#" class="social-btn"><i class="fab fa-linkedin-in"></i> LinkedIn</a>
      </div>
    </div>
  </div>

  <!-- Formulario -->
  <div class="contact-form-card reveal">
    <h3>Envíanos un mensaje</h3>

    <?php if (session()->getFlashdata('errors')): ?>
      <ul class="error-list">
        <?php foreach (session()->getFlashdata('errors') as $e): ?>
          <li><?= esc($e) ?></li>
        <?php endforeach; ?>
      </ul>
    <?php endif; ?>

    <form action="/contacto/enviar" method="POST">
      <?= csrf_field() ?>

      <div class="form-row">
        <div class="form-group">
          <label for="name">Nombre *</label>
          <input type="text" id="name" name="name" class="form-control"
            value="<?= old('name', session()->get('user_name') ?? '') ?>"
            placeholder="Tu nombre" required />
        </div>
        <div class="form-group">
          <label for="email">Email *</label>
          <input type="email" id="email" name="email" class="form-control"
            value="<?= old('email', session()->get('user_email') ?? '') ?>"
            placeholder="tu@email.com" required />
        </div>
      </div>

      <div class="form-group">
        <label for="subject">Asunto *</label>
        <input type="text" id="subject" name="subject" class="form-control"
          value="<?= old('subject') ?>"
          placeholder="¿En qué podemos ayudarte?" required />
      </div>

      <div class="form-group">
        <label for="message">Mensaje *</label>
        <textarea id="message" name="message" class="form-control" rows="6"
          placeholder="Escribe tu mensaje aquí..." required
          style="resize:vertical"><?= old('message') ?></textarea>
      </div>

      <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center">
        <i class="fas fa-paper-plane"></i> Enviar mensaje
      </button>
    </form>
  </div>
</section>
