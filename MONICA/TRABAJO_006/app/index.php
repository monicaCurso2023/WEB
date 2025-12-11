<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>AulaX - Formación que avanza contigo</title>
<link rel="stylesheet" href="css/style.css">
</head>
<body>

<!-- HEADER -->
<header>
    <div class="logo">AulaX</div>
    <nav>
    <a href="#inicio">Inicio</a>
    <a href="#funciones">Funcionalidades</a>
    <a href="#contacto">Contacto</a>
    <?php if(!empty($_SESSION['username'])): ?>
        <a href="dashboard.php">Dashboard</a>
        <a href="logout.php">Cerrar Sesión</a>
    <?php else: ?>
        <a href="login.php">Acceder</a>
        <a href="registro.php">Registrarse</a>
    <?php endif; ?>
</nav>

</header>

<!-- HERO -->
<section class="hero" id="inicio">
    <h1>AulaX: Formación que avanza contigo</h1>
    <p>Gestiona cursos, usuarios y todo tu proceso formativo desde una plataforma moderna y eficiente.</p>
    <?php if(empty($_SESSION['username'])): ?>
        <a href="registro.php" class="btn btn-primary">Regístrate</a>
        <a href="login.php" class="btn btn-secondary">Iniciar Sesión</a>
    <?php else: ?>
        <a href="dashboard.php" class="btn btn-primary">Ir al Dashboard</a>
        <a href="logout.php" class="btn btn-secondary">Cerrar Sesión</a>
    <?php endif; ?>
</section>

<!-- CONTENIDO -->
<div class="container">

    <!-- Mensajes -->
    <?php if(!empty($_SESSION['success'])): ?>
        <div class="message success"><?= htmlspecialchars($_SESSION['success']) ?></div>
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>
    <?php if(!empty($_SESSION['error'])): ?>
        <div class="message error"><?= htmlspecialchars($_SESSION['error']) ?></div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <!-- FUNCIONALIDADES -->
    <section id="funciones">
        <h2>Funcionalidades principales</h2>
        <div class="features">
            <div class="card fade-up"><h3>AulaX Cursos</h3><p>Crea, organiza y publica cursos en minutos.</p></div>
            <div class="card fade-up"><h3>AulaX Usuarios</h3><p>Gestión completa de alumnos, profesores y roles.</p></div>
            <div class="card fade-up"><h3>AulaX Progreso</h3><p>Seguimiento visual del aprendizaje.</p></div>
            <div class="card fade-up"><h3>AulaX Certifica</h3><p>Genera certificados automáticamente.</p></div>
            <div class="card fade-up"><h3>AulaX Docs</h3><p>Documentos centralizados y accesibles.</p></div>
            <div class="card fade-up"><h3>AulaX Analytics</h3><p>Informes y estadísticas en tiempo real.</p></div>
        </div>
    </section>

    <!-- CONTACTO -->
    <section id="contacto">
        <hr>
        <h2>Contacto</h2>
        <form action="contacto.php" method="post" class="contact-form">
            <label for="name">Nombre:</label>
            <input id="name" name="name" type="text" required>

            <label for="email">Email:</label>
            <input id="email" name="email" type="email" required>

            <label for="message">Mensaje:</label>
            <textarea id="message" name="message" rows="5" required></textarea>

            <button type="submit" class="btn btn-primary">Enviar mensaje</button>
        </form>
    </section>
</div>

<!-- FOOTER -->
<footer>
    <div>
        <h3>AulaX</h3>
        <a href="#inicio">Inicio</a>
        <a href="#funciones">Funcionalidades</a>
        <a href="#contacto">Contacto</a>
    </div>
    <div>
        <p>Copyright © AulaX 2025</p>
    </div>
</footer>

<script>
// Animación cards fade-up
const faders = document.querySelectorAll('.fade-up');
window.addEventListener('scroll', ()=>{
    faders.forEach(f=>{
        const top = f.getBoundingClientRect().top;
        if(top < window.innerHeight - 50) f.classList.add('show');
    });
});
</script>
</body>
</html>
