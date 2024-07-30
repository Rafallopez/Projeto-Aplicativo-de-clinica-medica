<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'paciente') {
    header("Location: login.html");
    exit();
}

include 'db_connect.php';
include 'functions.php';

$historico_consultas = get_historico_consultas($conn, $_SESSION['user_id']);
$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard do Paciente</title>
</head>
<body>
    <h1>Bem-vindo, <?php echo $_SESSION['username']; ?></h1>
    <h2>Histórico de Consultas</h2>
    <table border="1">
        <tr>
            <th>Data</th>
            <th>Hora</th>
            <th>Médico</th>
            <th>Detalhes</th>
        </tr>
        <?php foreach ($historico_consultas as $consulta): ?>
            <tr>
                <td><?php echo $consulta['data']; ?></td>
                <td><?php echo $consulta['hora']; ?></td>
                <td><?php echo $consulta['medico_nome']; ?></td>
                <td><?php echo $consulta['detalhes_paciente']; ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
    <a href="logout.php">Sair</a>
</body>
</html>
