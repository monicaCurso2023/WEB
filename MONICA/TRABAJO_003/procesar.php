<?php
/**
 * Procesar datos del formulario de contacto
 * Valida, sanitiza y procesa la información enviada
 */

// Variables para almacenar errores
$errores = [];
$datos_limpios = [];

// Verificar que la solicitud sea POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
   
    // ============================================
    // 1. FUNCIÓN: Sanitizar entradas
    // ============================================
    function sanitizar($dato) {
        $dato = trim($dato);                    // Elimina espacios
        $dato = stripslashes($dato);            // Elimina barras invertidas
        $dato = htmlspecialchars($dato);        // Convierte caracteres especiales a entidades HTML
        return $dato;
    }

    // ============================================
    // 2. VALIDAR Y SANITIZAR: Nombre
    // ============================================
    if (empty($_POST["nombre"])) {
        $errores["nombre"] = "El nombre es obligatorio";
    } else {
        $nombre = sanitizar($_POST["nombre"]);
       
        // Validar que contiene solo letras y espacios
        if (!preg_match("/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/", $nombre)) {
            $errores["nombre"] = "El nombre solo puede contener letras y espacios";
        } else {
            $datos_limpios["nombre"] = $nombre;
        }
    }

    // ============================================
    // 3. VALIDAR Y SANITIZAR: Email
    // ============================================
    if (empty($_POST["email"])) {
        $errores["email"] = "El email es obligatorio";
    } else {
        $email = sanitizar($_POST["email"]);
       
        // Validar formato de email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errores["email"] = "El formato del email no es válido";
        } else {
            $datos_limpios["email"] = $email;
        }
    }

    // ============================================
    // 4. VALIDAR Y SANITIZAR: Teléfono (opcional)
    // ============================================
    if (!empty($_POST["telefono"])) {
        $telefono = sanitizar($_POST["telefono"]);
       
        // Validar que contiene solo números y caracteres permitidos
        if (!preg_match("/^[0-9+\s\-]{7,}$/", $telefono)) {
            $errores["telefono"] = "El teléfono no tiene un formato válido";
        } else {
            $datos_limpios["telefono"] = $telefono;
        }
    } else {
        $datos_limpios["telefono"] = "No proporcionado";
    }

    // ============================================
    // 5. VALIDAR Y SANITIZAR: Asunto
    // ============================================
    if (empty($_POST["asunto"])) {
        $errores["asunto"] = "El asunto es obligatorio";
    } else {
        $asunto = sanitizar($_POST["asunto"]);
       
        if (strlen($asunto) < 5) {
            $errores["asunto"] = "El asunto debe tener al menos 5 caracteres";
        } else {
            $datos_limpios["asunto"] = $asunto;
        }
    }

    // ============================================
    // 6. VALIDAR Y SANITIZAR: Mensaje
    // ============================================
    if (empty($_POST["mensaje"])) {
        $errores["mensaje"] = "El mensaje es obligatorio";
    } else {
        $mensaje = sanitizar($_POST["mensaje"]);
       
        if (strlen($mensaje) < 10) {
            $errores["mensaje"] = "El mensaje debe tener al menos 10 caracteres";
        } else {
            $datos_limpios["mensaje"] = $mensaje;
        }
    }

    // ============================================
    // 7. PROCESAR: Si no hay errores
    // ============================================
    if (empty($errores)) {
        // Aquí es donde irían acciones reales:
        // - Guardar en base de datos
        // - Enviar email
        // - Registrar en archivo log
        // Por ahora, simplemente mostramos confirmación
       
        // Guardar en archivo de log (ejemplo)
        $contenido_log = date("Y-m-d H:i:s") . " - " .
                        $datos_limpios["nombre"] . " - " .
                        $datos_limpios["email"] . "\n";
       
        // Crear archivo de log si no existe
        file_put_contents("contactos_log.txt", $contenido_log, FILE_APPEND);
       
        // Mostrar página de éxito
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
                <p>Tu mensaje ha sido enviado correctamente. Nos pondremos en contacto contigo lo antes posible.</p>

                <div class="resumen">
                    <div class="resumen-item">
                        <div class="resumen-label">📝 Nombre:</div>
                        <div class="resumen-valor"><?php echo $datos_limpios["nombre"]; ?></div>
                    </div>
                    <div class="resumen-item">
                        <div class="resumen-label">📧 Email:</div>
                        <div class="resumen-valor"><?php echo $datos_limpios["email"]; ?></div>
                    </div>
                    <div class="resumen-item">
                        <div class="resumen-label">📱 Teléfono:</div>
                        <div class="resumen-valor"><?php echo $datos_limpios["telefono"]; ?></div>
                    </div>
                    <div class="resumen-item">
                        <div class="resumen-label">💬 Asunto:</div>
                        <div class="resumen-valor"><?php echo $datos_limpios["asunto"]; ?></div>
                    </div>
                    <div class="resumen-item">
                        <div class="resumen-label">📨 Mensaje:</div>
                        <div class="resumen-valor"><?php echo nl2br($datos_limpios["mensaje"]); ?></div>
                    </div>
                </div>

                <a href="index.php">← Volver al formulario</a>
            </div>
        </body>
        </html>
        <?php
        exit;
    } else {
        // Si hay errores, volver al formulario con los errores
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
                    <?php
                    foreach ($errores as $error) {
                        echo "<div class='error-item'>$error</div>";
                    }
                    ?>
                </div>
                <a href="index.php">← Volver y corregir</a>
            </div>
        </body>
        </html>
        <?php
        exit;
    }
} else {
    // Si no es POST, redirigir al formulario
    header("Location: index.php");
    exit;
}
?>