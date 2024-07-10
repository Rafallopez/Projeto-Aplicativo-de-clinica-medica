<?php
$servername = "localhost";
$username = "root";  // Altere conforme necessário
$password = "";      // Altere conforme necessário
$dbname = "clinica";

// Criar conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}
?>
