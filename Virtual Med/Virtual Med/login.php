<?php
session_start();
include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = md5($_POST['password']);

    $stmt = $conn->prepare("SELECT id, username, role FROM usuarios WHERE username = ? AND password = ?");
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];

        if ($user['role'] == 'medico') {
            header("Location: medico_dashboard.php");
        } elseif ($user['role'] == 'paciente') {
            header("Location: paciente_dashboard.php");
        }
        exit();
    } else {
        echo "<p>Nome de usuário ou senha inválidos.</p>";
        header("Location: login.html");
    }
    $stmt->close();
}
$conn->close();
?>
