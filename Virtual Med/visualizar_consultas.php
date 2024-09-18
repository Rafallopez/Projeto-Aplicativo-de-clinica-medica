<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visualizar e Editar Consultas</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f8ff;
            color: #333;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid #32CD32;
        }

        th, td {
            padding: 15px;
            text-align: left;
        }

        th {
            background-color: #00CED1;
            color: white;
        }

        td {
            background-color: #f9f9f9;
        }

        form {
            background-color: #f9f9f9;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
            max-width: 600px;
            margin: 0 auto;
        }

        label {
            display: block;
            margin-bottom: 10px;
            font-weight: bold;
        }

        input, textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        button {
            padding: 12px;
            background-color: #32CD32;
            color: white;
            border: none;
            border-radius: 8px;
            font-weight: bold;
            cursor: pointer;
            width: 100%;
            font-size: 16px;
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

        .table-container {
            overflow-x: auto;
        }

        /* Melhorando a largura da tabela e aumentando o espaço das ações */
        table {
            width: 100%;
        }

        th, td {
            text-align: left;
            padding: 15px;
        }

        th {
            background-color: #00CED1;
            color: white;
            text-align: left;
        }

        td {
            background-color: #fff;
        }

        form {
            padding: 20px;
            border-radius: 8px;
            background-color: #e0f7fa;
        }

        .actions-container {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }

        .actions-container button {
            width: 150px;
            margin-left: 10px;
        }
    </style>
</head>
<body>
    <header>
        <h1>Visualizar e Editar Consultas</h1>
    </header>

    <div class="container">
        <?php if (isset($success)): ?>
            <div class="success"><?php echo $success; ?></div>
        <?php elseif (isset($error)): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>

        <div class="table-container">
            <table>
                <tr>
                    <th>Data</th>
                    <th>Hora</th>
                    <th>Paciente</th>
                    <th>Detalhes</th>
                    <th style="min-width: 250px;">Ações</th>
                </tr>
                <?php foreach ($consultas as $consulta): ?>
                    <tr>
                        <td><?php echo $consulta['data']; ?></td>
                        <td><?php echo $consulta['hora']; ?></td>
                        <td><?php echo $consulta['paciente_nome']; ?></td>
                        <td><?php echo $consulta['detalhes_medico']; ?></td>
                        <td>
                            <form method="POST" action="">
                                <input type="hidden" name="consulta_id" value="<?php echo $consulta['id']; ?>">
                                <label for="data">Nova Data:</label>
                                <input type="date" name="data" min="<?php echo date('Y-m-d'); ?>" value="<?php echo $consulta['data']; ?>" required>

                                <label for="hora">Nova Hora (entre 07:00 e 22:00):</label>
                                <input type="time" name="hora" min="07:00" max="22:00" step="1800" value="<?php echo $consulta['hora']; ?>" required>

                                <label for="detalhes">Detalhes:</label>
                                <textarea name="detalhes" rows="4" required><?php echo $consulta['detalhes_medico']; ?></textarea>

                                <div class="actions-container">
                                    <button type="submit">Salvar</button>
                                </div>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>

        <a href="medico_dashboard.php">Voltar ao Dashboard</a>
    </div>

    <footer>
        <p>&copy; 2024 Clínica Médica. Todos os direitos reservados.</p>
    </footer>
</body>
</html>
