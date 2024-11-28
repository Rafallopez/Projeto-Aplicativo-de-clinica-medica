<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Informações de Emergência</title>
    <link rel="stylesheet" href="public/css/emergency.css">
</head>
<body>
    <div class="emergency-container">
        <header class="header-section">
            <div class="logo-section">
                <div class="logo-wrapper">
                    <img src="https://cdn.builder.io/api/v1/image/assets/TEMP/b2ecff3ad51fbd10197ed00bf22a584a784ec0e9b74ca924de797e92c2dbcc89" alt="Logo" class="logo-image">
                </div>
            </div>
            <div class="header-title">
                <h2>Informações de Emergência</h2>
                <img src="https://cdn.builder.io/api/v1/image/assets/TEMP/b922b5f9f2a8c8eaef60c88a3cf8764bbd71788eca43a7407868abe3b03e8dda" alt="Emergency Icon" class="header-icon">
            </div>
        </header>

        <div class="info-container">
            <div class="info-group">
                <h3>Tipo Sanguíneo:</h3>
                <p><?= htmlspecialchars($info['tipo_sanguineo'] ?? 'Não informado') ?></p>
            </div>

            <div class="info-group">
                <h3>Alergias:</h3>
                <p><?= htmlspecialchars($info['alergias'] ?? 'Nenhuma alergia registrada') ?></p>
            </div>

            <div class="info-group">
                <h3>Medicamentos em Uso:</h3>
                <p><?= htmlspecialchars($info['medicamentos'] ?? 'Nenhum medicamento registrado') ?></p>
            </div>

            <div class="info-group">
                <h3>Condições Médicas:</h3>
                <p><?= htmlspecialchars($info['condicoes_medicas'] ?? 'Nenhuma condição registrada') ?></p>
            </div>

            <div class="info-group">
                <h3>Contato de Emergência 1:</h3>
                <p>Nome: <?= htmlspecialchars($info['contato_emergencia_1_nome'] ?? 'Não informado') ?></p>
                <p>Telefone: <?= htmlspecialchars($info['contato_emergencia_1_telefone'] ?? 'Não informado') ?></p>
            </div>

            <div class="info-group">
                <h3>Contato de Emergência 2:</h3>
                <p>Nome: <?= htmlspecialchars($info['contato_emergencia_2_nome'] ?? 'Não informado') ?></p>
                <p>Telefone: <?= htmlspecialchars($info['contato_emergencia_2_telefone'] ?? 'Não informado') ?></p>
            </div>

            <div class="button-group">
                <a href="index.php?action=editar_info_emergencia" class="edit-button">Editar Informações</a>
                <a href="index.php?action=painel_paciente" class="back-button">Voltar</a>
            </div>
        </div>
    </div>
</body>
</html>
