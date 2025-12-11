<?php
session_start();
if(!empty($_SESSION['username'])) { header('Location: dashboard.php'); exit; }
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Acceder - AulaX</title>
<link rel="stylesheet" href="css/style.css">
</head>
<body>

<header>
    <div class="logo">AulaX</div>
    <nav>
        <a href="index.php#inicio">Inicio</a>
        <a href="index.php#funciones">Funcionalidades</a>
        <a href="index.php#contacto">Contacto</a>
        <a href="registro.php">Registrarse</a>
    </nav>
</header>

<section class="hero">
    <h1>Iniciar Sesión</h1>
    <p>Accede a tu cuenta y gestiona tus cursos y usuarios</p>
</section>

<div class="container">
    <?php if(!empty($_SESSION['error'])): ?>
        <div class="message error"><?= htmlspecialchars($_SESSION['error']) ?></div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>
    
    <form action="login_process.php" method="post" class="contact-form">
        <label for="username">Usuario:</label>
        <input id="username" name="username" type="text" required>

        <label for="password">Contraseña:</label>
        <input id="password" name="password" type="password" required>

        <button type="submit" class="btn btn-primary">Acceder</button>
        <a href="registro.php" class="btn btn-secondary">Registrarse</a>
    </form>
</div>

<footer>
    <div>
        <h3>AulaX</h3>
        <a href="index.php#inicio">Inicio</a>
        <a href="index.php#funciones">Funcionalidades</a>
        <a href="index.php#contacto">Contacto</a>
    </div>
</footer>

</body>
</html>
