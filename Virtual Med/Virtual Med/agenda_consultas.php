<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'medico') {
    header("Location: login.html");
    exit();
}

include 'db_connect.php';
include 'functions.php';

// Pega as consultas do médico logado
$consultas = get_consultas($conn, $_SESSION['user_id']);

// Lida com o cancelamento de consultas
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['cancelar_consulta'])) {
    $consulta_id = $_POST['consulta_id'];

    if (delete_consulta($conn, $consulta_id)) {
        echo "<p>Consulta cancelada com sucesso!</p>";
        // Recarrega as consultas atualizadas
        $consultas = get_consultas($conn, $_SESSION['user_id']);
    } else {
        echo "<p>Erro ao cancelar consulta.</p>";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agenda de Consultas</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Agenda de Consultas - Dr(a). <?php echo $_SESSION['username']; ?></h1>
    </header>

    <div class="container">
        <h2>Próximas Consultas</h2>
        <table>
            <tr>
                <th>Data</th>
                <th>Hora</th>
                <th>Paciente</th>
                <th>Detalhes</th>
                <th>Ações</th>
            </tr>
            <?php foreach ($consultas as $consulta): ?>
                <tr>
                    <td><?php echo $consulta['data']; ?></td>
                    <td><?php echo $consulta['hora']; ?></td>
                    <td><?php echo $consulta['detalhes_paciente']; ?></td>
                    <td>
                        <!-- Formulário para cancelar consulta -->
                        <form action="agenda_consultas.php" method="post" style="display:inline;">
                            <input type="hidden" name="consulta_id" value="<?php echo $consulta['id']; ?>">
                            <input type="submit" name="cancelar_consulta" value="Cancelar">
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>

        <a href="medico_dashboard.php">Voltar ao Dashboard</a>
        <a href="logout.php">Sair</a>
    </div>

    <footer>
        <p>&copy; 2024 Clínica Médica. Todos os direitos reservados.</p>
    </footer>
</body>
</html>

