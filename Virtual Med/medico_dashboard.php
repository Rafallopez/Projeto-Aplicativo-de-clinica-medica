<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'medico') {
    header("Location: login.html");
    exit();
}

include 'db_connect.php';

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard do Médico</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        .menu {
            margin: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #00CED1; /* Cor ciano */
            padding: 10px;
            border-radius: 8px;
        }

        .menu a {
            text-decoration: none;
            padding: 10px 20px;
            background-color: #32CD32; /* Cor verde */
            color: white;
            font-weight: bold;
            border-radius: 8px;
            transition: background-color 0.3s;
        }

        .menu a:hover {
            background-color: #228B22; /* Verde mais escuro ao passar o mouse */
        }

        .container {
            text-align: center;
            margin-top: 30px;
        }

        h1 {
            color: #32CD32;
        }
    </style>
</head>
<body>
    <header>
        <h1>Bem-vindo(a), Dr(a). <?php echo $_SESSION['username']; ?></h1>
    </header>

    <div class="menu">
        <a href="agendar_consulta.php">Agendar Nova Consulta</a>
        <a href="visualizar_consultas.php">Visualizar/Editar Consultas</a>
        <a href="pacientes.php">Banco de Dados de Pacientes</a>
        <a href="logout.php">Sair</a>
    </div>

    <div class="container">
        <h2>O que você gostaria de fazer hoje?</h2>
        <p>Escolha uma das opções acima para navegar pelas funcionalidades disponíveis.</p>
    </div>

    <footer>
        <p>&copy; 2024 Clínica Médica. Todos os direitos reservados.</p>
    </footer>
</body>
</html>
