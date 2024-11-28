<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Consulta - Virtual Med</title>
    <link rel="stylesheet" href="public/css/minhas_consultas.css">
</head>
<body>
    <div class="consultation-container">
        <header class="header-section">
            <div class="logo-section">
                <div class="logo-wrapper">
                    <img src="https://cdn.builder.io/api/v1/image/assets/TEMP/b2ecff3ad51fbd10197ed00bf22a584a784ec0e9b74ca924de797e92c2dbcc89" alt="Logo" class="logo-image">
                </div>
            </div>
            <div class="header-title">
                <h2>Editar Consulta</h2>
                <img src="https://cdn.builder.io/api/v1/image/assets/TEMP/717c829cb379209249bcfa352206aa398976f30c99517531f4696e540117e5ab" alt="Edit Icon" class="header-icon">
            </div>
        </header>

        <div class="form-container">
            <div class="consultation-card">
                <form action="index.php?action=atualizar_consulta" method="POST">
                    <input type="hidden" name="id" value="<?= $consulta['id'] ?>">
                    <div class="card-content">
                        <div class="form-group">
                            <label for="paciente_id">Paciente:</label>
                            <select id="paciente_id" name="paciente_id" required>
                                <?php foreach ($pacientes as $paciente): ?>
                                    <option value="<?= $paciente['id'] ?>" <?= ($paciente['id'] == $consulta['paciente_id']) ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($paciente['nome']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="data">Data:</label>
                            <input type="date" id="data" name="data" value="<?= date('Y-m-d', strtotime($consulta['data_hora'])) ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="hora">Horário:</label>
                            <select id="hora" name="hora" required>
                                <?php
                                $start = strtotime('08:00');
                                $end = strtotime('18:00');
                                $selected_time = date('H:i', strtotime($consulta['data_hora']));
                                
                                for ($time = $start; $time <= $end; $time += 1800) {
                                    $time_option = date('H:i', $time);
                                    $selected = ($time_option == $selected_time) ? 'selected' : '';
                                    echo "<option value='$time_option' $selected>$time_option</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="detalhes">Detalhes:</label>
                            <textarea id="detalhes" name="detalhes" required><?= htmlspecialchars($consulta['detalhes']) ?></textarea>
                        </div>

                        <div class="action-buttons">
                            <button type="submit" class="save-button">Salvar Alterações</button>
                            <a href="index.php?action=visualizar_consultas" class="cancel-button">Cancelar</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="public/js/datetimeverify.js"></script>
</body>
</html>
