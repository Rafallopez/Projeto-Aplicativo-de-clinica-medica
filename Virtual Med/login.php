<?php
session_start();
include 'db_connect.php';
include 'functions.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = $_POST['username'];
    $pass = $_POST['password'];

    $user_data = authenticate_user($conn, $user, $pass);

    if ($user_data) {
        $_SESSION['username'] = $user_data['username'];
        $_SESSION['role'] = $user_data['role'];
        $_SESSION['user_id'] = $user_data['id'];  // Armazena o ID do usuário na sessão
        
        if ($user_data['role'] == 'medico') {
            header("Location: medico_dashboard.php");
        } else if ($user_data['role'] == 'paciente') {
            header("Location: paciente_dashboard.php");
        }
        exit();
    } else {
        $_SESSION['login_error'] = "Usuário ou senha inválidos.";
        header("Location: login.html");
        exit();
    }
}

$conn->close();
?>

?>
