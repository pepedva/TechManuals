-- ============================================================
-- TechManuals Store - Esquema de Base de Datos
-- Motor: MySQL 8.0+
-- ============================================================

CREATE DATABASE IF NOT EXISTS techmanuals_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE techmanuals_db;

-- ------------------------------------------------------------
-- Usuarios (soporta login local + OAuth Google/Facebook)
-- ------------------------------------------------------------
CREATE TABLE users (
    id              INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    name            VARCHAR(150)    NOT NULL,
    email           VARCHAR(191)    NOT NULL UNIQUE,
    password        VARCHAR(255)    NULL COMMENT 'NULL si es OAuth',
    avatar          VARCHAR(500)    NULL,
    provider        ENUM('local','google','facebook') NOT NULL DEFAULT 'local',
    provider_id     VARCHAR(255)    NULL COMMENT 'ID en Google o Facebook',
    email_verified  TINYINT(1)      NOT NULL DEFAULT 0,
    role            ENUM('user','admin') NOT NULL DEFAULT 'user',
    created_at      TIMESTAMP       DEFAULT CURRENT_TIMESTAMP,
    updated_at      TIMESTAMP       DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_provider (provider, provider_id)
) ENGINE=InnoDB;

-- ------------------------------------------------------------
-- Categorías de manuales
-- ------------------------------------------------------------
CREATE TABLE categories (
    id          INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    name        VARCHAR(100) NOT NULL,
    slug        VARCHAR(110) NOT NULL UNIQUE,
    icon        VARCHAR(50)  NULL COMMENT 'Nombre del icono (Font Awesome)',
    created_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ------------------------------------------------------------
-- Manuales digitales
-- ------------------------------------------------------------
CREATE TABLE manuals (
    id              INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    category_id     INT UNSIGNED    NOT NULL,
    title           VARCHAR(250)    NOT NULL,
    slug            VARCHAR(270)    NOT NULL UNIQUE,
    description     TEXT            NULL,
    short_desc      VARCHAR(400)    NULL,
    price           DECIMAL(8,2)    NOT NULL DEFAULT 0.00,
    cover_image     VARCHAR(500)    NULL,
    file_path       VARCHAR(500)    NOT NULL COMMENT 'Ruta interna, nunca pública',
    pages           SMALLINT        NULL,
    language        VARCHAR(50)     NOT NULL DEFAULT 'Español',
    level           ENUM('Básico','Intermedio','Avanzado') NOT NULL DEFAULT 'Básico',
    active          TINYINT(1)      NOT NULL DEFAULT 1,
    featured        TINYINT(1)      NOT NULL DEFAULT 0,
    downloads_count INT UNSIGNED    NOT NULL DEFAULT 0,
    created_at      TIMESTAMP       DEFAULT CURRENT_TIMESTAMP,
    updated_at      TIMESTAMP       DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE RESTRICT
) ENGINE=InnoDB;

-- ------------------------------------------------------------
-- Órdenes de compra
-- ------------------------------------------------------------
CREATE TABLE orders (
    id                      INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    user_id                 INT UNSIGNED    NOT NULL,
    manual_id               INT UNSIGNED    NOT NULL,
    paypal_order_id         VARCHAR(255)    NULL COMMENT 'ID de orden PayPal',
    paypal_transaction_id   VARCHAR(255)    NULL COMMENT 'ID de transacción PayPal',
    amount                  DECIMAL(8,2)    NOT NULL,
    currency                VARCHAR(10)     NOT NULL DEFAULT 'USD',
    status                  ENUM('pending','completed','failed','refunded') NOT NULL DEFAULT 'pending',
    buyer_email             VARCHAR(191)    NULL,
    created_at              TIMESTAMP       DEFAULT CURRENT_TIMESTAMP,
    updated_at              TIMESTAMP       DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id)   REFERENCES users(id)   ON DELETE CASCADE,
    FOREIGN KEY (manual_id) REFERENCES manuals(id) ON DELETE RESTRICT,
    INDEX idx_status (status),
    INDEX idx_paypal_order (paypal_order_id)
) ENGINE=InnoDB;

-- ------------------------------------------------------------
-- Tokens de descarga (expiran en 24 horas)
-- ------------------------------------------------------------
CREATE TABLE download_tokens (
    id          INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    order_id    INT UNSIGNED    NOT NULL,
    token       CHAR(64)        NOT NULL UNIQUE COMMENT 'SHA-256 hex',
    expires_at  DATETIME        NOT NULL,
    used        TINYINT(1)      NOT NULL DEFAULT 0,
    used_at     DATETIME        NULL,
    ip_address  VARCHAR(45)     NULL,
    created_at  TIMESTAMP       DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
    INDEX idx_token (token),
    INDEX idx_expires (expires_at)
) ENGINE=InnoDB;

-- ------------------------------------------------------------
-- Mensajes de contacto
-- ------------------------------------------------------------
CREATE TABLE contact_messages (
    id          INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    name        VARCHAR(150) NOT NULL,
    email       VARCHAR(191) NOT NULL,
    subject     VARCHAR(250) NOT NULL,
    message     TEXT         NOT NULL,
    ip_address  VARCHAR(45)  NULL,
    read_at     DATETIME     NULL,
    created_at  TIMESTAMP    DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ============================================================
-- DATOS INICIALES
-- ============================================================

INSERT INTO categories (name, slug, icon) VALUES
('Python',         'python',         'fa-python'),
('Frontend',       'frontend',       'fa-code'),
('JavaScript',     'javascript',     'fa-js'),
('Base de Datos',  'bases-de-datos', 'fa-database'),
('Backend',        'backend',        'fa-server'),
('DevOps',         'devops',         'fa-cogs'),
('Seguridad',      'seguridad',      'fa-shield-alt'),
('Inteligencia Artificial', 'ia-ml', 'fa-robot');

INSERT INTO manuals
    (category_id, title, slug, short_desc, description, price, cover_image, file_path, pages, level, featured)
VALUES
(1, 'Fundamentos de Python desde Cero',
 'fundamentos-python-desde-cero',
 'Aprende Python desde cero con ejercicios prácticos y proyectos reales.',
 'Este manual te lleva de la mano desde instalar Python hasta programar tus primeros scripts funcionales. Incluye estructuras de datos, funciones, POO y manejo de errores con ejemplos del mundo real.',
 9.99,  '/public/images/covers/python.jpg',    '/storage/manuals/python-fundamentos.pdf',   180, 'Básico', 1),

(2, 'Diseño Web con HTML5 & CSS3',
 'diseno-web-html5-css3',
 'Crea páginas web modernas y responsivas desde cero con HTML5 y CSS3.',
 'Domina la estructura semántica del HTML5 y los estilos modernos de CSS3. Aprende Flexbox, Grid, animaciones y diseño responsivo con proyectos incluidos.',
 7.99,  '/public/images/covers/html-css.jpg',  '/storage/manuals/html5-css3.pdf',           150, 'Básico', 1),

(3, 'JavaScript Moderno ES6+',
 'javascript-moderno-es6',
 'Domina el JavaScript moderno: arrow functions, promesas, async/await y más.',
 'Manual completo sobre las características modernas de JavaScript: destructuring, módulos, Promises, async/await, fetch API y conceptos de programación funcional aplicados al desarrollo web.',
 12.99, '/public/images/covers/javascript.jpg','/storage/manuals/javascript-moderno.pdf',   220, 'Intermedio', 1),

(4, 'Base de Datos con MySQL',
 'base-de-datos-mysql',
 'Diseña y administra bases de datos relacionales con MySQL de forma profesional.',
 'Aprende desde los fundamentos del modelo relacional hasta consultas avanzadas con JOINs, subconsultas, índices, transacciones y optimización de queries en MySQL.',
 8.99,  '/public/images/covers/mysql.jpg',     '/storage/manuals/mysql-completo.pdf',        170, 'Básico', 0),

(5, 'APIs REST con Node.js y Express',
 'apis-rest-nodejs-express',
 'Construye APIs robustas y escalables con Node.js, Express y MongoDB.',
 'Manual práctico para crear servicios web RESTful desde cero: routing, middlewares, autenticación JWT, validaciones y despliegue en producción con Node.js y Express.',
 14.99, '/public/images/covers/nodejs.jpg',    '/storage/manuals/nodejs-express-api.pdf',   250, 'Intermedio', 1),

(6, 'Git & GitHub: Control de Versiones',
 'git-github-control-versiones',
 'Aprende a gestionar tu código de forma profesional con Git y GitHub.',
 'Desde git init hasta flujos de trabajo en equipo: branching, merging, pull requests, resolución de conflictos y CI/CD básico con GitHub Actions.',
 6.99,  '/public/images/covers/git.jpg',       '/storage/manuals/git-github.pdf',            120, 'Básico', 0),

(3, 'React.js para Principiantes',
 'reactjs-para-principiantes',
 'Construye interfaces de usuario dinámicas con React.js y hooks modernos.',
 'Domina React desde los componentes funcionales hasta hooks avanzados como useContext y useReducer. Incluye proyectos completos: lista de tareas, app del clima y carrito de compras.',
 15.99, '/public/images/covers/react.jpg',     '/storage/manuals/reactjs-principiantes.pdf',260, 'Intermedio', 1),

(7, 'Ciberseguridad Básica para Desarrolladores',
 'ciberseguridad-basica-desarrolladores',
 'Protege tus aplicaciones web de las amenazas más comunes en internet.',
 'Manual esencial sobre OWASP Top 10, XSS, SQL Injection, CSRF, manejo seguro de contraseñas, HTTPS y buenas prácticas de seguridad en el desarrollo web moderno.',
 11.99, '/public/images/covers/security.jpg',  '/storage/manuals/ciberseguridad-basica.pdf',200, 'Intermedio', 0),

(6, 'Docker & Contenedores para Developers',
 'docker-contenedores-developers',
 'Conteneriza tus aplicaciones y domina Docker desde cero hasta producción.',
 'Aprende a usar Docker para crear ambientes de desarrollo reproducibles: imágenes, contenedores, Docker Compose, volúmenes, redes y despliegue en la nube.',
 13.99, '/public/images/covers/docker.jpg',    '/storage/manuals/docker-contenedores.pdf',  190, 'Intermedio', 0),

(8, 'Introducción a Machine Learning con Python',
 'introduccion-machine-learning-python',
 'Entra al mundo de la IA con scikit-learn, pandas y visualización de datos.',
 'Manual completo para iniciarte en Machine Learning: preprocesamiento de datos con pandas, algoritmos supervisados y no supervisados con scikit-learn, evaluación de modelos y visualizaciones con matplotlib.',
 19.99, '/public/images/covers/ml.jpg',        '/storage/manuals/machine-learning-python.pdf', 300, 'Avanzado', 1);

-- Admin por defecto (contraseña: Admin1234! → cambiar en producción)
INSERT INTO users (name, email, password, role, email_verified) VALUES
('Administradora', 'admin@techmanuals.com',
 '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uivHJ/Iu', -- Admin1234!
 'admin', 1);
