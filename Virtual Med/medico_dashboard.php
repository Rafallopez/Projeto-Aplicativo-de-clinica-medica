<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'medico') {
    header("Location: login.html");
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Médico</title>
</head>
<body>
    <h1>Bem-vindo,  <?php echo $_SESSION['username']; ?>!</h1>
    <p>Esta é a sua área restrita.</p>
    <a href="agenda_consultas.php">Gerenciar Consultas</a>
    <a href="logout.php">Logout</a>
</body>
</html>

