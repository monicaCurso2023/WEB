<?php
// Tipo de BD: ahora pgsql
define('DB_DRIVER', 'pgsql');

// Servidor PostgreSQL
define('DB_HOST', 'localhost');

// Puerto por defecto PostgreSQL
define('DB_PORT', 5432);

// Nombre de la base de datos
define('DB_NAME', 'formularios_pg');

// Usuario y contraseña de PostgreSQL
define('DB_USER', 'monica');      // o el usuario que uses
define('DB_PASS', '123456');   // cambia esto

// Codificación
define('DB_CHARSET', 'utf8');

// Zona horaria
date_default_timezone_set('Europe/Madrid');

// Modo debug
define('DEBUG_MODE', true);