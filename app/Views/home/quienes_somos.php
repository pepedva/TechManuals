<!-- app/Views/home/quienes_somos.php -->
<style>
  .page-hero { background: linear-gradient(135deg, #fff0f6 0%, #f5eeff 100%); padding: 90px 5% 70px; text-align: center; }
  .page-hero h1 { font-family: var(--font-display); font-size: clamp(2.2rem,4vw,3.2rem); color: var(--charcoal); }
  .page-hero h1 em { color: var(--rose); font-style: italic; }
  .page-hero p { color: #888; font-size: 1.05rem; max-width: 520px; margin: 16px auto 0; }

  .about-content { max-width: 1100px; margin: 0 auto; padding: 80px 5%; }

  .about-intro {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 64px;
    align-items: center;
    margin-bottom: 80px;
  }

  .about-text h2 {
    font-family: var(--font-display);
    font-size: 2rem;
    color: var(--charcoal);
    margin-bottom: 20px;
    line-height: 1.3;
  }

  .about-text h2 em { color: var(--rose); font-style: italic; }
  .about-text p { color: #777; font-size: 1rem; line-height: 1.85; margin-bottom: 16px; }

  .about-visual {
    background: linear-gradient(135deg, var(--rose), var(--mauve));
    border-radius: var(--radius-lg);
    padding: 48px;
    color: white;
    text-align: center;
  }

  .about-visual .big-emoji { font-size: 80px; margin-bottom: 20px; }
  .about-visual h3 { font-family: var(--font-display); font-size: 1.6rem; margin-bottom: 12px; }
  .about-visual p { font-size: 0.95rem; opacity: .85; }

  .team-section {
    text-align: center;
    margin-bottom: 80px;
  }

  .team-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 28px;
    margin-top: 48px;
  }

  .team-card {
    background: white;
    border-radius: var(--radius-lg);
    padding: 32px 24px;
    border: 1.5px solid var(--gray-light);
    text-align: center;
    transition: var(--transition);
  }

  .team-card:hover {
    border-color: var(--rose-light);
    box-shadow: var(--shadow);
    transform: translateY(-4px);
  }

  .team-avatar {
    width: 80px;
    height: 80px;
    background: linear-gradient(135deg, var(--rose), var(--mauve));
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 32px;
    margin: 0 auto 16px;
    color: white;
    font-family: var(--font-display);
    font-size: 28px;
    font-weight: 600;
  }

  .team-card h4 { font-family: var(--font-display); font-size: 1.1rem; color: var(--charcoal); margin-bottom: 4px; }
  .team-card .role { font-size: 0.8rem; color: var(--rose); font-weight: 600; text-transform: uppercase; letter-spacing: .06em; margin-bottom: 12px; }
  .team-card p { font-size: 0.83rem; color: #aaa; line-height: 1.6; }

  .story-section { background: var(--cream); border-radius: var(--radius-lg); padding: 60px; margin-top: 60px; }
  .story-section h2 { font-family: var(--font-display); font-size: 2rem; color: var(--charcoal); margin-bottom: 24px; }
  .story-section h2 em { color: var(--rose); font-style: italic; }
  .story-section p { color: #777; font-size: 1rem; line-height: 1.85; margin-bottom: 16px; }

  @media (max-width: 768px) {
    .about-intro { grid-template-columns: 1fr; }
    .story-section { padding: 32px 24px; }
  }
</style>

<section class="page-hero">
  <span class="section-tag">Quiénes Somos</span>
  <h1>El equipo detrás de <em>TechManuals</em></h1>
  <p>Personas apasionadas por la tecnología y la educación accesible</p>
</section>

<section class="about-content">

  <!-- Intro -->
  <div class="about-intro">
    <div class="about-text reveal">
      <h2>Somos <em>creadoras</em> de conocimiento digital</h2>
      <p>TechManuals nació en 2024 de un grupo de desarrolladoras y docentes que identificaron una brecha enorme: excelentes profesionales en tecnología sin acceso a material de calidad en español y a precios accesibles.</p>
      <p>Lo que empezó como un proyecto personal se convirtió en una plataforma que hoy ayuda a cientos de estudiantes a dar sus primeros pasos (y muchos avanzados también) en el mundo del desarrollo de software.</p>
      <a href="/portafolio" class="btn btn-primary" style="margin-top:8px">Ver nuestros manuales</a>
    </div>
    <div class="about-visual reveal">
      <div class="big-emoji">👩‍💻</div>
      <h3>Expertas apasionadas</h3>
      <p>Cada manual es creado por profesionales con años de experiencia real en la industria tecnológica.</p>
    </div>
  </div>

  <!-- Equipo -->
  <div class="team-section reveal">
    <span class="section-tag">Nuestro equipo</span>
    <h2 class="section-title">Las mentes detrás del <em>proyecto</em></h2>

    <div class="team-grid">
      <div class="team-card reveal">
        <div class="team-avatar">FF</div>
        <h4>María Fernanda Fajardo Nava</h4>
        <div class="role">Fundadora & CEO</div>
        <p>Desarrolladora full-stack con 8 años de experiencia. Especialista en Python y arquitecturas de software.</p>
      </div>
      <div class="team-card reveal">
        <div class="team-avatar">JR</div>
        <h4>Jennifer Amelí Rodriguez Narvaez</h4>
        <div class="role">Directora de Contenido</div>
        <p>Docente universitaria y experta en pedagogía digital. Convierte conceptos complejos en aprendizaje claro.</p>
      </div>
      <div class="team-card reveal">
        <div class="team-avatar">PP</div>
        <h4>José Dolores Vera Arce</h4>
        <div class="role">Frontend & UX Lead</div>
        <p>Diseñador y desarrollador frontend apasionada por crear experiencias digitales accesibles y hermosas.</p>
      </div>
      <div class="team-card reveal">
        <div class="team-avatar">MN</div>
        <h4>Mariana Novelo Denis</h4>
        <div class="role">Especialista y Mente Maestra en DevOps & Cloud</div>
        <p>Ingeniera de infraestructura con experiencia en AWS, Docker y arquitecturas en la nube.</p>
      </div>
    </div>
  </div>

  <!-- Historia -->
  <div class="story-section reveal">
    <h2>Nuestra <em>historia</em></h2>
    <p>En 2023, mientras preparábamos material de estudio para un grupo de colegas, nos dimos cuenta de algo: no existía una plataforma en español que ofreciera manuales técnicos de calidad a precios accesibles para estudiantes latinoamericanos.</p>
    <p>Decidimos crear lo que necesitábamos. Pasamos meses investigando, redactando, revisando y perfeccionando el primer manual. La respuesta fue inmediata: estudiantes en México, Colombia, Argentina y Chile empezaron a escribirnos para contarnos cómo ese material había cambiado su trayectoria profesional.</p>
    <p>Hoy, TechManuals es mucho más que una tienda de manuales — es una comunidad de personas que creen que el conocimiento tecnológico debe ser para todas.</p>
  </div>

</section>
