<!-- app/Views/home/vision.php -->
<style>
  .page-hero { background: linear-gradient(135deg, #fff0f6 0%, #f5eeff 100%); padding: 90px 5% 70px; text-align: center; }
  .page-hero h1 { font-family: var(--font-display); font-size: clamp(2.2rem,4vw,3.2rem); color: var(--charcoal); }
  .page-hero h1 em { color: var(--rose); font-style: italic; }
  .page-hero p { color: #888; font-size: 1.05rem; max-width: 520px; margin: 16px auto 0; }

  .vision-content { max-width: 900px; margin: 80px auto; padding: 0 5%; }

  .vision-quote {
    font-family: var(--font-display);
    font-size: 1.7rem;
    font-style: italic;
    color: var(--charcoal);
    line-height: 1.5;
    text-align: center;
    padding: 40px;
    background: linear-gradient(135deg, #fff0f6, #f5eeff);
    border-radius: var(--radius-lg);
    margin-bottom: 48px;
    position: relative;
  }

  .vision-quote::before {
    content: '"';
    font-size: 120px;
    color: var(--rose-light);
    position: absolute;
    top: -20px; left: 20px;
    font-family: var(--font-display);
    line-height: 1;
  }

  .vision-body { font-size: 1.05rem; color: #666; line-height: 1.9; margin-bottom: 32px; }

  .milestones {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 24px;
    margin-top: 48px;
  }

  .milestone {
    background: white;
    border-radius: var(--radius-lg);
    padding: 28px 24px;
    border: 1.5px solid var(--gray-light);
    text-align: center;
    transition: var(--transition);
    position: relative;
    overflow: hidden;
  }

  .milestone::before {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0;
    height: 4px;
    background: linear-gradient(90deg, var(--rose), var(--mauve));
  }

  .milestone:hover {
    transform: translateY(-4px);
    box-shadow: var(--shadow);
    border-color: var(--rose-light);
  }

  .milestone-year {
    font-family: var(--font-display);
    font-size: 2rem;
    font-weight: 600;
    color: var(--rose);
    margin-bottom: 8px;
  }

  .milestone h4 { font-size: 1rem; color: var(--charcoal); margin-bottom: 8px; }
  .milestone p { font-size: 0.83rem; color: #aaa; }
</style>

<section class="page-hero">
  <span class="section-tag">Nuestra Visión</span>
  <h1>Hacia donde <em>vamos juntas</em></h1>
  <p>El futuro que estamos construyendo día a día</p>
</section>

<section class="vision-content">
  <div class="vision-quote reveal">
    Ser la plataforma líder de manuales digitales en tecnología para Latinoamérica, referente en contenido accesible, de calidad y en español.
  </div>

  <p class="vision-body reveal">
    Visualizamos un futuro donde cualquier persona en Latinoamérica pueda acceder a educación tecnológica de primer nivel sin importar su ubicación geográfica, su presupuesto o su nivel de conocimiento previo. Queremos ser la plataforma que acelera el acceso de la región al mundo digital.
  </p>

  <p class="vision-body reveal">
    Para el año 2027, aspiramos a contar con más de <strong>50 manuales</strong>, una comunidad activa de más de <strong>5,000 estudiantes</strong> y alianzas con empresas tecnológicas que validen y certifiquen el conocimiento adquirido a través de nuestra plataforma.
  </p>

  <div class="section-header reveal" style="margin-top:60px">
    <span class="section-tag">Hoja de ruta</span>
    <h2 class="section-title">Nuestro camino al <em>futuro</em></h2>
  </div>

  <div class="milestones">
    <div class="milestone reveal">
      <div class="milestone-year">2024</div>
      <h4>Lanzamiento</h4>
      <p>10 manuales, plataforma estable y primeras 100 estudiantes.</p>
    </div>
    <div class="milestone reveal">
      <div class="milestone-year">2025</div>
      <h4>Crecimiento</h4>
      <p>30 manuales, comunidad de 1,000+ estudiantes y app móvil.</p>
    </div>
    <div class="milestone reveal">
      <div class="milestone-year">2026</div>
      <h4>Expansión</h4>
      <p>Certificaciones oficiales y alianzas con empresas tech regionales.</p>
    </div>
    <div class="milestone reveal">
      <div class="milestone-year">2027</div>
      <h4>Liderazgo</h4>
      <p>50+ manuales, presencia en 15 países y 5,000 estudiantes activas.</p>
    </div>
  </div>
</section>
