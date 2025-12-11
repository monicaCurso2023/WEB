<?php
session_start();
if(empty($_SESSION['username'])) { $_SESSION['error']='Debes iniciar sesión.'; header('Location: login.php'); exit; }
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Dashboard - AulaX</title>
<link rel="stylesheet" href="css/style.css">
</head>
<body>

<header>
    <div class="logo">AulaX</div>
    <nav>
        <a href="index.php#inicio">Inicio</a>
        <a href="index.php#funciones">Funcionalidades</a>
        <a href="index.php#contacto">Contacto</a>
        <a href="logout.php">Cerrar Sesión</a>
    </nav>
</header>

<section class="hero">
    <h1>Bienvenido, <?= htmlspecialchars($_SESSION['username']) ?></h1>
    <p>Gestiona cursos, usuarios y progreso desde tu panel moderno y seguro.</p>
</section>

<div class="container">
    <section id="funciones">
        <h2>Panel de Control</h2>
        <div class="features">
            <div class="card fade-up"><h3>Mis Cursos</h3><p>Crea, organiza y administra tus cursos fácilmente.</p></div>
            <div class="card fade-up"><h3>Usuarios</h3><p>Administra alumnos, profesores y roles.</p></div>
            <div class="card fade-up"><h3>Progreso</h3><p>Visualiza el avance y estadísticas en tiempo real.</p></div>
        </div>
    </section>
</div>

<footer>
    <div>
        <h3>AulaX</h3>
        <a href="index.php#inicio">Inicio</a>
        <a href="index.php#funciones">Funcionalidades</a>
        <a href="index.php#contacto">Contacto</a>
    </div>
</footer>

<script>
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
