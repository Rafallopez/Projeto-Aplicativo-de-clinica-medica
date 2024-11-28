<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agendar Consulta - Virtual Med</title>
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
                <h2>Agendar Nova Consulta</h2>
                <img src="https://cdn.builder.io/api/v1/image/assets/TEMP/717c829cb379209249bcfa352206aa398976f30c99517531f4696e540117e5ab" alt="Schedule Icon" class="header-icon">
            </div>
        </header>

        <div class="form-container">
            <form action="index.php?action=salvar_consulta" method="POST">
                <div class="form-grid">
                    <div class="consultation-card">
                        <div class="card-header">
                            <h3>Selecionar Paciente</h3>
                        </div>
                        <div class="card-content">
                            <div class="form-group">
                                <select id="paciente_id" name="paciente_id" required>
                                    <option value="">Escolha um paciente</option>
                                    <?php foreach ($pacientes as $paciente): ?>
                                        <option value="<?= $paciente['id'] ?>">
                                            <?= htmlspecialchars($paciente['nome']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="consultation-card">
                        <div class="card-header">
                            <h3>Data da Consulta</h3>
                        </div>
                        <div class="card-content">
                            <div class="form-group">
                                <input type="date" id="data" name="data" required>
                            </div>
                        </div>
                    </div>

                    <div class="consultation-card">
                        <div class="card-header">
                            <h3>Horário</h3>
                        </div>
                        <div class="card-content">
                            <div class="form-group">
                                <select id="hora" name="hora" required>
                                    <?php
                                    $start = strtotime('08:00');
                                    $end = strtotime('18:00');
                                    for ($time = $start; $time <= $end; $time += 1800) {
                                        echo '<option value="' . date('H:i', $time) . '">' . date('H:i', $time) . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="consultation-card">
                        <div class="card-header">
                            <h3>Detalhes da Consulta</h3>
                        </div>
                        <div class="card-content">
                            <div class="form-group">
                                <textarea id="detalhes" name="detalhes" required></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="action-buttons">
                    <button type="submit" class="save-button">Agendar Consulta</button>
                    <a href="index.php?action=<?= $_SESSION['user_role'] === 'doutor' ? 'painel_doutor' : 'painel_paciente' ?>" class="cancel-button">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
    <script src="public/js/datetimeverify.js"></script>
</body>
</html>
