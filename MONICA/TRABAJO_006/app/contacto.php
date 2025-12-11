<?php
session_start();
require_once 'config/Database.php';

$mensajes = [];
try {
    $database = new Database();
    $conn = $database->getConnection();
    if($conn) {
        $stmt = $conn->query("SELECT * FROM usuarios ORDER BY fecha_registro DESC LIMIT 10");
        $mensajes = $stmt->fetchAll();
    }
} catch(PDOException $e){}

if($_SERVER['REQUEST_METHOD']==='POST'){
    $name=trim($_POST['name']??'');
    $email=trim($_POST['email']??'');
    $message=trim($_POST['message']??'');

    if($name==='' || $email==='' || $message==='' || !filter_var($email,FILTER_VALIDATE_EMAIL)){
        $_SESSION['error']='Rellena todos los campos correctamente.';
    } else {
        try{
            $stmt = $conn->prepare("INSERT INTO usuarios(nombre,email,telefono,mensaje) VALUES(:nombre,:email,'',:mensaje)");
            $stmt->bindParam(':nombre',$name);
            $stmt->bindParam(':email',$email);
            $stmt->bindParam(':mensaje',$message);
            if($stmt->execute()) $_SESSION['success']='Mensaje enviado correctamente.';
        } catch(PDOException $e){ $_SESSION['error']='Error al enviar el mensaje.'; }
    }
    header('Location: contacto.php'); exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Contacto - AulaX</title>
<link rel="stylesheet" href="css/style.css">
</head>
<body>
<header>
    <div class="logo">AulaX</div>
    <nav><a href="index.php">Inicio</a></nav>
</header>

<div class="container">
    <h2>Contacto</h2>
    <p>Rellena el formulario y nos pondremos en contacto contigo.</p>

    <?php if(!empty($_SESSION['error'])): ?>
        <div class="message error"><?=htmlspecialchars($_SESSION['error'])?></div>
        <?php unset($_SESSION['error']); endif; ?>
    <?php if(!empty($_SESSION['success'])): ?>
        <div class="message success"><?=htmlspecialchars($_SESSION['success'])?></div>
        <?php unset($_SESSION['success']); endif; ?>

    <form action="contacto.php" method="post" class="contact-form">
        <label for="name">Nombre</label>
        <input id="name" name="name" type="text" required>

        <label for="email">Email</label>
        <input id="email" name="email" type="email" required>

        <label for="message">Mensaje</label>
        <textarea id="message" name="message" rows="5" required></textarea>

        <button type="submit" class="btn btn-primary">Enviar mensaje</button>
    </form>

    <?php if(!empty($mensajes)): ?>
        <hr>
        <h2>Últimos mensajes recibidos</h2>
        <div class="features">
            <?php foreach($mensajes as $m): ?>
                <div class="card fade-up">
                    <strong><?=htmlspecialchars($m['nombre'])?></strong> (<?=htmlspecialchars($m['email'])?>)
                    <p><?=nl2br(htmlspecialchars($m['mensaje']))?></p>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<footer>
    <div>
        <h3>AulaX</h3>
        <a href="index.php">Inicio</a>
        <a href="contacto.php">Contacto</a>
    </div>
    <div>
        <p>Copyright © AulaX 2025</p>
    </div>
</footer>

<script>
const faders = document.querySelectorAll('.fade-up');
window.addEventListener('scroll', ()=>{
    faders.forEach(f=> {
        const top = f.getBoundingClientRect().top;
        const screen = window.innerHeight;
        if(top < screen - 50) f.classList.add('show');
    });
});
</script>

</body>
</html>
