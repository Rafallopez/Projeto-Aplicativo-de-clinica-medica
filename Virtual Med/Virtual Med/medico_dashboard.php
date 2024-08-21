<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'medico') {
    header("Location: login.html");
    exit();
}

include 'db_connect.php';

// Função para obter o nome do paciente a partir do ID
function get_paciente_nome($conn, $paciente_id) {
    $stmt = $conn->prepare("SELECT nome FROM usuarios WHERE id = ? AND role = 'paciente'");
    $stmt->bind_param("i", $paciente_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $paciente = $result->fetch_assoc();
    return $paciente['nome'];
}

// Função para verificar disponibilidade de horário
function is_horario_disponivel($conn, $medico_id, $data, $hora) {
    $stmt = $conn->prepare("SELECT COUNT(*) AS total FROM consultas WHERE medico_id = ? AND data = ? AND hora = ?");
    $stmt->bind_param("iss", $medico_id, $data, $hora);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();
    return $result['total'] == 0;
}

// Função para agendar nova consulta
function agendar_consulta($conn, $medico_id, $paciente_id, $data, $hora, $detalhes_paciente) {
    if (is_horario_disponivel($conn, $medico_id, $data, $hora)) {
        $stmt = $conn->prepare("INSERT INTO consultas (medico_id, paciente_id, data, hora, detalhes_paciente) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("iisss", $medico_id, $paciente_id, $data, $hora, $detalhes_paciente);
        return $stmt->execute();
    }
    return false;
}

// Processar agendamento de consulta
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['agendar_consulta'])) {
    $paciente_id = $_POST['paciente_id'];
    $data = $_POST['data'];
    $hora = $_POST['hora'];
    $detalhes_paciente = $_POST['detalhes_paciente'];

    if (agendar_consulta($conn, $_SESSION['user_id'], $paciente_id, $data, $hora, $detalhes_paciente)) {
        echo "<p>Consulta agendada com sucesso!</p>";
    } else {
        echo "<p>Erro ao agendar consulta ou horário já ocupado.</p>";
    }
}

// Obter todos os pacientes
function get_pacientes($conn) {
    $stmt = $conn->prepare("SELECT id, nome FROM usuarios WHERE role = 'paciente'");
    $stmt->execute();
    return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}

// Obter todas as consultas do médico
function get_consultas($conn, $medico_id) {
    $stmt = $conn->prepare("SELECT * FROM consultas WHERE medico_id = ?");
    $stmt->bind_param("i", $medico_id);
    $stmt->execute();
    return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}

$pacientes = get_pacientes($conn);
$consultas = get_consultas($conn, $_SESSION['user_id']);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard do Médico</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Agenda de Consultas - Dr(a). <?php echo $_SESSION['username']; ?></h1>
    </header>

    <div class="container">
        <h2>Agendar Nova Consulta</h2>
        <form action="medico_dashboard.php" method="post">
            <label for="paciente_id">Selecione o Paciente:</label>
            <select id="paciente_id" name="paciente_id" required>
                <?php foreach ($pacientes as $paciente): ?>
                    <option value="<?php echo $paciente['id']; ?>"><?php echo $paciente['nome']; ?></option>
                <?php endforeach; ?>
            </select>
            <br>
            <label for="data">Data:</label>
            <input type="date" id="data" name="data" required>
            <br>
            <label for="hora">Hora:</label>
            <input type="time" id="hora" name="hora" required pattern="(?:[0-9]{2}:[0-9]{2})" min="07:00" max="22:00">
            <br>
            <label for="detalhes_paciente">Detalhes do Paciente:</label>
            <textarea id="detalhes_paciente" name="detalhes_paciente" rows="4" cols="50" required></textarea>
            <br>
            <input type="submit" name="agendar_consulta" value="Agendar Consulta">
        </form>

        <h2>Consultas Agendadas</h2>
        <table>
            <tr>
                <th>Data</th>
                <th>Hora</th>
                <th>Paciente</th>
                <th>Detalhes</th>
            </tr>
            <?php foreach ($consultas as $consulta): ?>
                <tr>
                    <td><?php echo $consulta['data']; ?></td>
                    <td><?php echo $consulta['hora']; ?></td>
                    <td><?php echo get_paciente_nome($conn, $consulta['paciente_id']); ?></td>
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
