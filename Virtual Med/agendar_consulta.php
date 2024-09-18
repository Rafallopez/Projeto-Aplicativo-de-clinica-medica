<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'medico') {
    header("Location: login.html");
    exit();
}

include 'db_connect.php';

// Função para obter todos os pacientes
function get_pacientes($conn) {
    $stmt = $conn->prepare("SELECT id, nome FROM usuarios WHERE role = 'paciente'");
    $stmt->execute();
    return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}

// Função para verificar se há conflito de horários
function has_conflict($conn, $medico_id, $paciente_id, $data, $hora) {
    $stmt = $conn->prepare("
        SELECT * FROM consultas 
        WHERE (medico_id = ? OR paciente_id = ?) 
        AND data = ? 
        AND hora = ?
    ");
    $stmt->bind_param("iiss", $medico_id, $paciente_id, $data, $hora);
    $stmt->execute();
    return $stmt->get_result()->num_rows > 0;
}

// Função para agendar nova consulta
function agendar_consulta($conn, $medico_id, $paciente_id, $data, $hora, $detalhes) {
    $stmt = $conn->prepare("INSERT INTO consultas (medico_id, paciente_id, data, hora, detalhes_medico) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("iisss", $medico_id, $paciente_id, $data, $hora, $detalhes);
    return $stmt->execute();
}

// Obtém a lista de pacientes
$pacientes = get_pacientes($conn);

// Processa o formulário de agendamento
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $paciente_id = $_POST['paciente'];
    $data = $_POST['data'];
    $hora = $_POST['hora'];
    $detalhes = $_POST['detalhes'];
    $medico_id = $_SESSION['user_id'];

    // Validação para evitar conflitos de horário
    if (has_conflict($conn, $medico_id, $paciente_id, $data, $hora)) {
        $error = "Conflito de horário: O médico ou o paciente já têm uma consulta agendada neste horário.";
    } else {
        // Agendar consulta
        if (agendar_consulta($conn, $medico_id, $paciente_id, $data, $hora, $detalhes)) {
            $success = "Consulta agendada com sucesso!";
        } else {
            $error = "Erro ao agendar a consulta. Tente novamente.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agendar Nova Consulta</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        form {
            width: 400px;
            margin: 20px auto;
            background-color: #f9f9f9;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin-bottom: 10px;
            font-weight: bold;
        }

        input, select, textarea {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        button {
            width: 100%;
            padding: 10px;
            background-color: #32CD32;
            color: white;
            border: none;
            border-radius: 8px;
            font-weight: bold;
            cursor: pointer;
        }

        button:hover {
            background-color: #228B22;
        }

        .success {
            background-color: #d4edda;
            color: #155724;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 5px;
        }

        .error {
            background-color: #f8d7da;
            color: #721c24;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <header>
        <h1>Agendar Nova Consulta</h1>
    </header>

    <div class="container">
        <?php if (isset($success)): ?>
            <div class="success"><?php echo $success; ?></div>
        <?php elseif (isset($error)): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>

        <form method="POST" action="">
            <label for="paciente">Selecione o Paciente:</label>
            <select name="paciente" id="paciente" required>
                <option value="">-- Selecione --</option>
                <?php foreach ($pacientes as $paciente): ?>
                    <option value="<?php echo $paciente['id']; ?>"><?php echo $paciente['nome']; ?></option>
                <?php endforeach; ?>
            </select>

            <label for="data">Data da Consulta:</label>
            <input type="date" name="data" id="data" min="<?php echo date('Y-m-d'); ?>" required>

            <label for="hora">Hora da Consulta (entre 07:00 e 22:00):</label>
            <input type="time" name="hora" id="hora" min="07:00" max="22:00" step="1800" required>

            <label for="detalhes">Detalhes da Consulta:</label>
            <textarea name="detalhes" id="detalhes" rows="4" required></textarea>

            <button type="submit">Agendar Consulta</button>
        </form>

        <a href="medico_dashboard.php">Voltar ao Dashboard</a>
    </div>

    <footer>
        <p>&copy; 2024 Clínica Médica. Todos os direitos reservados.</p>
    </footer>
</body>
</html>
