<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'medico') {
    header("Location: login.html");
    exit();
}

include 'db_connect.php';
include 'functions.php';

$recent_patients = get_recent_patients($conn, $_SESSION['user_id']);
$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard do Médico</title>
</head>
<body>
    <h1>Bem-vindo, Dr. <?php echo $_SESSION['username']; ?></h1>
    <h2>Pacientes Recentes</h2>
    <table border="1">
        <tr>
            <th>Nome</th>
            <th>Email</th>
            <th>Telefone</th>
        </tr>
        <?php foreach ($recent_patients as $patient): ?>
            <tr>
                <td><?php echo $patient['nome']; ?></td>
                <td><?php echo $patient['email']; ?></td>
                <td><?php echo $patient['telefone']; ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
    <a href="agenda_consultas.php">Gerenciar Consultas</a>
    <a href="logout.php">Sair</a>
</body>
</html>
