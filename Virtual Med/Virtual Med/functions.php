<?php
function authenticate_user($conn, $username, $password) {
    $password = md5($password);  // Use um hash mais seguro na produção, como bcrypt
    $sql = "SELECT * FROM usuarios WHERE username = ? AND password = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Erro ao preparar a consulta: " . $conn->error);
    }
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        return $result->fetch_assoc();
    } else {
        return false;
    }
}

function add_consulta($conn, $medico_id, $data, $hora, $detalhes_paciente) {
    $sql = "INSERT INTO consultas (medico_id, paciente_id, data, hora, detalhes_paciente) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Erro ao preparar a consulta: " . $conn->error);
    }
    $stmt->bind_param("iisss", $medico_id, $_SESSION['user_id'], $data, $hora, $detalhes_paciente);
    return $stmt->execute();
}

function get_consultas($conn, $medico_id) {
    $sql = "SELECT * FROM consultas WHERE medico_id = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Erro ao preparar a consulta: " . $conn->error);
    }
    $stmt->bind_param("i", $medico_id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_all(MYSQLI_ASSOC);
}

function update_consulta($conn, $consulta_id, $data, $hora, $detalhes_paciente) {
    $sql = "UPDATE consultas SET data = ?, hora = ?, detalhes_paciente = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Erro ao preparar a consulta: " . $conn->error);
    }
    $stmt->bind_param("sssi", $data, $hora, $detalhes_paciente, $consulta_id);
    return $stmt->execute();
}

function delete_consulta($conn, $consulta_id) {
    $sql = "DELETE FROM consultas WHERE id = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Erro ao preparar a consulta: " . $conn->error);
    }
    $stmt->bind_param("i", $consulta_id);
    return $stmt->execute();
}

function get_recent_patients($conn, $medico_id, $days = 14) {
    $sql = "SELECT p.* FROM pacientes p
            JOIN consultas c ON p.id = c.paciente_id
            WHERE c.medico_id = ? AND c.data >= DATE_SUB(CURDATE(), INTERVAL ? DAY)
            GROUP BY p.id";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Erro ao preparar a consulta: " . $conn->error);
    }
    $stmt->bind_param("ii", $medico_id, $days);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_all(MYSQLI_ASSOC);
}

function get_historico_consultas($conn, $paciente_id) {
    $sql = "SELECT c.*, u.nome AS medico_nome FROM consultas c
            JOIN usuarios u ON c.medico_id = u.id
            WHERE c.paciente_id = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Erro ao preparar a consulta: " . $conn->error);
    }
    $stmt->bind_param("i", $paciente_id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_all(MYSQLI_ASSOC);
}
?>
