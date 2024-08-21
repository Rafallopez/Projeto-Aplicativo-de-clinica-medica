<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'paciente') {
    header("Location: login.html");
    exit();
}

include 'db_connect.php';

// Função para obter o nome do médico a partir do ID
function get_medico_nome($conn, $medico_id) {
    $stmt = $conn->prepare("SELECT nome FROM usuarios WHERE id = ? AND role = 'medico'");
    $stmt->bind_param("i", $medico_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $medico = $result->fetch_assoc();
    return $medico['nome'];
}

// Função para obter as consultas do paciente
function get_consultas_paciente($conn, $paciente_id) {
    $stmt = $conn->prepare("SELECT * FROM consultas WHERE paciente_id = ?");
    $stmt->bind_param("i", $paciente_id);
    $stmt->execute();
    return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}

$paciente_id = $_SESSION['user_id'];
$consultas = get_consultas_paciente($conn, $paciente_id);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard do Paciente</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Dashboard do Paciente - <?php echo $_SESSION['username']; ?></h1>
    </header>

    <div class="container">
        <h2>Consultas Agendadas</h2>
        <table>
            <tr>
                <th>Data</th>
                <th>Hora</th>
                <th>Médico</th>
                <th>Detalhes</th>
            </tr>
            <?php foreach ($consultas as $consulta): ?>
                <tr>
                    <td><?php echo $consulta['data']; ?></td>
                    <td><?php echo $consulta['hora']; ?></td>
                    <td><?php echo get_medico_nome($conn, $consulta['medico_id']); ?></td>
                    <td><?php echo $consulta['detalhes_paciente']; ?></td>
                </tr>
            <?php endforeach; ?>
        </table>

        <a href="logout.php">Sair</a>
    </div>

    <footer>
        <p>&copy; 2024 Clínica Médica. Todos os direitos reservados.</p>
    </footer>
</body>
</html>
