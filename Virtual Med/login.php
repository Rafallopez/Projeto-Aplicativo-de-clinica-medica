<?php
session_start();
include 'db_connect.php';  // Inclui o arquivo de conexão

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = $_POST['username'];
    $pass = md5($_POST['password']);  // Use um hash mais seguro na produção, como bcrypt

    $sql = "SELECT * FROM usuarios WHERE username = ? AND password = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Erro ao preparar a consulta: " . $conn->error);
    }
    $stmt->bind_param("ss", $user, $pass);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $_SESSION['username'] = $row['username'];
        $_SESSION['role'] = $row['role'];
        $_SESSION['user_id'] = $row['id'];  // Armazena o ID do usuário na sessão
        
        if ($row['role'] == 'medico') {
            header("Location: medico_dashboard.php");
        } else if ($row['role'] == 'paciente') {
            header("Location: paciente_dashboard.php");
        }
        exit();
    } else {
        echo "Usuário ou senha inválidos.";

    }

    $stmt->close();
}

$conn->close();
?>
