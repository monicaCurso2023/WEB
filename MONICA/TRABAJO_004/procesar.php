<?php
/**
 * ============================================
 * ARCHIVO: procesar.php (PostgreSQL + PDO)
 * PROPÓSITO: Validar, sanitizar y guardar en BD
 * ============================================
 */

require_once 'config.php';     // constantes BD, DEBUG, etc.
require_once 'Database.php';   // clase PDO para PostgreSQL

$errores = [];
$datos_limpios = [];

// -------------------------
// Función de sanitización
// -------------------------
function sanitizar(string $dato): string {
    $dato = trim($dato);
    $dato = stripslashes($dato);
    $dato = htmlspecialchars($dato, ENT_QUOTES, 'UTF-8');
    return $dato;
}

// -------------------------
// Solo aceptar método POST
// --------------------]-----
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

/* ==============================
 *  VALIDACIONES DEL FORMULARIO
 * ============================== */

// NOMBRE
if (empty($_POST['nombre'])) {
    $errores['nombre'] = 'El nombre es obligatorio';
} else {
    $nombre = sanitizar($_POST['nombre']);
    if (!preg_match("/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/", $nombre)) {
        $errores['nombre'] = 'El nombre solo puede contener letras y espacios';
    } else {
        $datos_limpios['nombre'] = $nombre;
    }
}

// EMAIL
if (empty($_POST['email'])) {
    $errores['email'] = 'El email es obligatorio';
} else {
    $email = sanitizar($_POST['email']);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errores['email'] = 'El formato del email no es válido';
    } else {
        $datos_limpios['email'] = $email;
    }
}

// TELÉFONO (opcional)
if (!empty($_POST['telefono'])) {
    $telefono = sanitizar($_POST['telefono']);
    if (!preg_match("/^[0-9+\s\-]{7,}$/", $telefono)) {
        $errores['telefono'] = 'El teléfono no tiene un formato válido';
    } else {
        $datos_limpios['telefono'] = $telefono;
    }
} else {
    $datos_limpios['telefono'] = null; // será NULL en la BD
}

// ASUNTO
if (empty($_POST['asunto'])) {
    $errores['asunto'] = 'El asunto es obligatorio';
} else {
    $asunto = sanitizar($_POST['asunto']);
    if (strlen($asunto) < 5) {
        $errores['asunto'] = 'El asunto debe tener al menos 5 caracteres';
    } else {
        $datos_limpios['asunto'] = $asunto;
    }
}

// MENSAJE
if (empty($_POST['mensaje'])) {
    $errores['mensaje'] = 'El mensaje es obligatorio';
} else {
    $mensaje = sanitizar($_POST['mensaje']);
    if (strlen($mensaje) < 10) {
        $errores['mensaje'] = 'El mensaje debe tener al menos 10 caracteres';
    } else {
        $datos_limpios['mensaje'] = $mensaje;
    }
}

/* ==============================
 *  SI HAY ERRORES → MOSTRARLOS
 * ============================== */

if (!empty($errores)) {
    ?>
    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Error en el Formulario</title>
        <link rel="stylesheet" href="styles.css">
    </head>
    <body>
        <div class="contenedor">
            <div class="icono-error">⚠️</div>
            <h1>Errores en el Formulario</h1>

            <div class="errores">
                <?php foreach ($errores as $error): ?>
                    <div class="error-item"><?php echo $error; ?></div>
                <?php endforeach; ?>
            </div>

            <a href="index.php">← Volver y corregir</a>
        </div>
    </body>
    </html>
    <?php
    exit;
}

/* =======================================
 *  SIN ERRORES → GUARDAR EN POSTGRESQL
 * ======================================= */

try {
    // Obtener conexión PDO (PostgreSQL)
    $pdo = Database::getInstance();

    // INSERT con placeholders nombrados
    $sql = "INSERT INTO contactos (nombre, email, telefono, asunto, mensaje, estado)
            VALUES (:nombre, :email, :telefono, :asunto, :mensaje, :estado)";

    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        ':nombre'   => $datos_limpios['nombre'],
        ':email'    => $datos_limpios['email'],
        ':telefono' => $datos_limpios['telefono'],
        ':asunto'   => $datos_limpios['asunto'],
        ':mensaje'  => $datos_limpios['mensaje'],
        ':estado'   => 'pendiente',
    ]);

    // En PostgreSQL, lastInsertId puede necesitar el nombre de la secuencia,
    // pero con campo SERIAL simple muchas veces funciona sin parámetro.[web:79][web:80]
    $nuevo_id = $pdo->lastInsertId() ?: 'N/D';

} catch (PDOException $e) {
    error_log('❌ Error al insertar en PostgreSQL: ' . $e->getMessage());
    ?>
    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Error en el servidor</title>
        <link rel="stylesheet" href="styles.css">
    </head>
    <body>
        <div class="contenedor">
            <div class="icono-error">⚠️</div>
            <h1>Error en el servidor</h1>
            <div class="errores">
                <div class="error-item">
                    Ha ocurrido un error al guardar tus datos. Inténtalo de nuevo más tarde.
                </div>
            </div>
            <a href="index.php">← Volver al formulario</a>
        </div>
    </body>
    </html>
    <?php
    exit;
}

/* ==============================
 *  PÁGINA DE ÉXITO
 * ============================== */
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario Enviado</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="contenedor">
        <div class="icono-exito">✅</div>
        <h1>¡Gracias por contactarnos!</h1>
        <p>Tu mensaje ha sido enviado correctamente y guardado en nuestra base de datos.</p>

        <div class="id-contacto">
            <strong>Número de referencia:</strong> #<?php echo htmlspecialchars($nuevo_id); ?><br>
            Guarda este número para futuras consultas.
        </div>

        <div class="resumen">
            <div class="resumen-item">
                <div class="resumen-label">📝 Nombre:</div>
                <div class="resumen-valor"><?php echo $datos_limpios['nombre']; ?></div>
            </div>
            <div class="resumen-item">
                <div class="resumen-label">📧 Email:</div>
                <div class="resumen-valor"><?php echo $datos_limpios['email']; ?></div>
            </div>
            <div class="resumen-item">
                <div class="resumen-label">📱 Teléfono:</div>
                <div class="resumen-valor">
                    <?php echo $datos_limpios['telefono'] ?: 'No proporcionado'; ?>
                </div>
            </div>
            <div class="resumen-item">
                <div class="resumen-label">💬 Asunto:</div>
                <div class="resumen-valor"><?php echo $datos_limpios['asunto']; ?></div>
            </div>
            <div class="resumen-item">
                <div class="resumen-label">📨 Mensaje:</div>
                <div class="resumen-valor"><?php echo nl2br($datos_limpios['mensaje']); ?></div>
            </div>
            <div class="resumen-item">
                <div class="resumen-label">🕐 Fecha de registro:</div>
                <div class="resumen-valor"><?php echo date('d/m/Y H:i:s'); ?></div>
            </div>
        </div>

        <a href="index.php">← Volver al formulario</a>
    </div>
</body>
</html>