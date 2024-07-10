<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'paciente') {
    header("Location: login.html");
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Paciente</title>
</head>
<body>
    <h1>Bem-vindo,  <?php echo $_SESSION['username']; ?>!</h1>
    <p>Esta é a sua área restrita.</p>
    <a href="logout.php">Logout</a>
</body>
</html>
