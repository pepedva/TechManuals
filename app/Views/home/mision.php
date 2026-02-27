<!-- app/Views/home/mision.php -->
<style>
  .page-hero {
    background: linear-gradient(135deg, #fff0f6 0%, #f5eeff 100%);
    padding: 90px 5% 70px;
    text-align: center;
  }
  .page-hero h1 { font-family: var(--font-display); font-size: clamp(2.2rem,4vw,3.2rem); color: var(--charcoal); }
  .page-hero h1 em { color: var(--rose); font-style: italic; }
  .page-hero p { color: #888; font-size: 1.05rem; max-width: 520px; margin: 16px auto 0; }

  .mision-content {
    max-width: 900px;
    margin: 80px auto;
    padding: 0 5%;
  }

  .mision-lead {
    font-family: var(--font-display);
    font-size: 1.7rem;
    color: var(--charcoal);
    line-height: 1.5;
    margin-bottom: 32px;
    font-style: italic;
    border-left: 4px solid var(--rose);
    padding-left: 28px;
  }

  .mision-body { font-size: 1.05rem; color: #666; line-height: 1.9; margin-bottom: 32px; }

  .values-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 24px;
    margin-top: 48px;
  }

  .value-card {
    background: white;
    border: 1.5px solid var(--rose-light);
    border-radius: var(--radius-lg);
    padding: 28px 24px;
    text-align: center;
    transition: var(--transition);
  }

  .value-card:hover {
    transform: translateY(-4px);
    box-shadow: var(--shadow);
  }

  .value-icon { font-size: 36px; margin-bottom: 12px; }

  .value-card h4 {
    font-family: var(--font-display);
    font-size: 1.1rem;
    color: var(--charcoal);
    margin-bottom: 8px;
  }

  .value-card p { font-size: 0.85rem; color: #aaa; }
</style>

<section class="page-hero">
  <span class="section-tag">Nuestra Misión</span>
  <h1>Lo que nos <em>mueve cada día</em></h1>
  <p>El propósito que guía cada manual que creamos</p>
</section>

<section class="mision-content">
  <p class="mision-lead reveal">
    "Democratizar el conocimiento tecnológico, haciendo el aprendizaje accesible, práctico y empoderador para todas las personas que deseen dominar el mundo digital."
  </p>

  <p class="mision-body reveal">
    En <strong>TechManuals</strong>, creemos que aprender tecnología no debe ser un privilegio reservado para unos pocos. Nacimos con la convicción de que cada persona merece acceso a recursos de calidad que le permitan desarrollar habilidades técnicas reales, a su propio ritmo y desde cualquier lugar del mundo.
  </p>

  <p class="mision-body reveal">
    Nuestros manuales digitales son el resultado de horas de investigación, experiencia práctica y pasión por la enseñanza. Cada página está diseñada para ser clara, directa y aplicable desde el primer momento — sin relleno, sin términos innecesariamente complejos, solo conocimiento que transforma.
  </p>

  <div class="section-header reveal" style="margin-top:60px">
    <span class="section-tag">Nuestros valores</span>
    <h2 class="section-title">Los pilares de <em>TechManuals</em></h2>
  </div>

  <div class="values-grid">
    <div class="value-card reveal">
      <div class="value-icon">💡</div>
      <h4>Claridad</h4>
      <p>Explicamos conceptos complejos de forma simple y entendible para todos los niveles.</p>
    </div>
    <div class="value-card reveal">
      <div class="value-icon">🎯</div>
      <h4>Practicidad</h4>
      <p>Cada manual incluye ejemplos reales y ejercicios que puedes aplicar de inmediato.</p>
    </div>
    <div class="value-card reveal">
      <div class="value-icon">🌸</div>
      <h4>Inclusión</h4>
      <p>Creamos contenido pensando en toda la diversidad de personas que aprenden tecnología.</p>
    </div>
    <div class="value-card reveal">
      <div class="value-icon">🔄</div>
      <h4>Actualización</h4>
      <p>Mantenemos nuestros manuales al día con las últimas versiones y mejores prácticas.</p>
    </div>
  </div>
</section>
