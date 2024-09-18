<?php
$servername = "localhost"; // Altere se necessário
$username = "root";        // Altere se necessário
$password = "";            // Altere se necessário
$dbname = "clinica";       // Altere se necessário

// Cria uma nova conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica se a conexão foi bem-sucedida
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Configura o conjunto de caracteres para garantir que caracteres especiais sejam tratados corretamente
$conn->set_charset("utf8mb4");
?>
