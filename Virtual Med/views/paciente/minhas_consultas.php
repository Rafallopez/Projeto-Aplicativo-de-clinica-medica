<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Minhas Consultas - Virtual Med</title>
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
                <h2>Minhas Consultas</h2>
                <img src="https://cdn.builder.io/api/v1/image/assets/TEMP/717c829cb379209249bcfa352206aa398976f30c99517531f4696e540117e5ab" alt="Appointments Icon" class="header-icon">
            </div>
        </header>

        <div class="consultations-grid">
            <?php foreach ($consultas as $consulta): ?>
                <div class="consultation-card">
                    <div class="card-header">
                        <h3>Consulta com Dr(a). <?= htmlspecialchars($consulta['nome_doutor']) ?></h3>
                        <span class="specialty"><?= htmlspecialchars($consulta['especialidade']) ?></span>
                    </div>
                    <div class="card-content">
                        <div class="info-row">
                            <span class="label">Data:</span>
                            <span class="value"><?= date('d/m/Y', strtotime($consulta['data_hora'])) ?></span>
                        </div>
                        <div class="info-row">
                            <span class="label">Horário:</span>
                            <span class="value"><?= date('H:i', strtotime($consulta['data_hora'])) ?></span>
                        </div>
                        <div class="info-row">
                            <span class="label">Status:</span>
                            <span class="status-badge <?= strtolower($consulta['status']) ?>">
                                <?= htmlspecialchars($consulta['status']) ?>
                            </span>
                        </div>
                        <div class="details-section">
                            <span class="label">Detalhes:</span>
                            <p class="details-text"><?= htmlspecialchars($consulta['detalhes']) ?></p>
                        </div>
                        
                        <?php if($consulta['status'] === 'agendada'): ?>
                            <div class="action-buttons">
                                <a href="index.php?action=cancelar_consulta&id=<?= $consulta['id'] ?>" 
                                   class="cancel-button"
                                   onclick="return confirm('Tem certeza que deseja cancelar esta consulta?')">
                                    Cancelar Consulta
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="button-container">
            <a href="index.php?action=painel_paciente" class="back-button">Voltar ao Painel</a>
        </div>
    </div>
</body>
</html>
