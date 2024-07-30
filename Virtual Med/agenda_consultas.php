<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'medico') {
    header("Location: login.html");
    exit();
}

include 'db_connect.php';
include 'functions.php';

// Funções para adicionar, editar, cancelar e visualizar consultas
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['add_consulta'])) {
        $data = $_POST['data'];
        $hora = $_POST['hora'];
        $detalhes_paciente = $_POST['detalhes_paciente'];
        add_consulta($conn, $_SESSION['user_id'], $data, $hora, $detalhes_paciente);
    } elseif (isset($_POST['edit_consulta'])) {
        $consulta_id = $_POST['consulta_id'];
        $data = $_POST['data'];
        $hora = $_POST['hora'];
        $detalhes_paciente = $_POST['detalhes_paciente'];
        $sql = "UPDATE consultas SET data = ?, hora = ?, detalhes_paciente = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssi", $data, $hora, $detalhes_paciente, $consulta_id);
        $stmt->execute();
    } elseif (isset($_POST['cancel_consulta'])) {
        $consulta_id = $_POST['consulta_id'];
        $sql = "DELETE FROM consultas WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $consulta_id);
        $stmt->execute();
    }
}

$sql = "SELECT * FROM consultas WHERE medico_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();
$consultas = $result->fetch_all(MYSQLI_ASSOC);

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agenda de Consultas</title>
</head>
<body>
    <h1>Gerenciar Consultas</h1>

    <!-- Formulário para adicionar nova consulta -->
    <h2>Adicionar Nova Consulta</h2>
    <form action="agenda_consultas.php" method="post">
        <input type="date" name="data" required>
        <input type="time" name="hora" required>
        <input type="text" name="detalhes_paciente" placeholder="Detalhes do Paciente" required>
        <input type="submit" name="add_consulta" value="Adicionar">
    </form>

    <!-- Lista de consultas -->
    <h2>Consultas Agendadas</h2>
    <table border="1">
        <tr>
            <th>Data</th>
            <th>Hora</th>
            <th>Detalhes do Paciente</th>
            <th>Ações</th>
        </tr>
        <?php foreach ($consultas as $consulta): ?>
            <tr>
                <td><?php echo $consulta['data']; ?></td>
                <td><?php echo $consulta['hora']; ?></td>
                <td><?php echo $consulta['detalhes_paciente']; ?></td>
                <td>
                    <!-- Formulário para editar consulta -->
                    <form action="agenda_consultas.php" method="post" style="display:inline;">
                        <input type="hidden" name="consulta_id" value="<?php echo $consulta['id']; ?>">
                        <input type="date" name="data" value="<?php echo $consulta['data']; ?>" required>
                        <input type="time" name="hora" value="<?php echo $consulta['hora']; ?>" required>
                        <input type="text" name="detalhes_paciente" value="<?php echo $consulta['detalhes_paciente']; ?>" required>
                        <input type="submit" name="edit_consulta" value="Editar">
                    </form>
                    <!-- Formulário para cancelar consulta -->
                    <form action="agenda_consultas.php" method="post" style="display:inline;">
                        <input type="hidden" name="consulta_id" value="<?php echo $consulta['id']; ?>">
                        <input type="submit" name="cancel_consulta" value="Cancelar">
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>

    <a href="medico_dashboard.php">Voltar ao Dashboard</a>
</body>
</html>
