<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Editar Informações de Emergência</title>
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
                <h2>Editar Informações de Emergência</h2>
                <img src="https://cdn.builder.io/api/v1/image/assets/TEMP/b922b5f9f2a8c8eaef60c88a3cf8764bbd71788eca43a7407868abe3b03e8dda" alt="Emergency Icon" class="header-icon">
            </div>
        </header>

        <form action="index.php?action=salvar_info_emergencia" method="POST" class="info-container">
            <div class="info-group">
                <label>Tipo Sanguíneo:</label>
                <select name="tipo_sanguineo" required>
                    <?php
                    $tipos = ['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'];
                    foreach ($tipos as $tipo) {
                        $selected = ($info['tipo_sanguineo'] ?? '') === $tipo ? 'selected' : '';
                        echo "<option value='$tipo' $selected>$tipo</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="info-group">
                <label>Alergias:</label>
                <textarea name="alergias" rows="3"><?= htmlspecialchars($info['alergias'] ?? '') ?></textarea>
            </div>

            <div class="info-group">
                <label>Medicamentos em Uso:</label>
                <textarea name="medicamentos" rows="3"><?= htmlspecialchars($info['medicamentos'] ?? '') ?></textarea>
            </div>

            <div class="info-group">
                <label>Condições Médicas:</label>
                <textarea name="condicoes_medicas" rows="3"><?= htmlspecialchars($info['condicoes_medicas'] ?? '') ?></textarea>
            </div>

            <div class="info-group">
                <label>Contato de Emergência 1:</label>
                <input type="text" name="contato_emergencia_1_nome" placeholder="Nome" value="<?= htmlspecialchars($info['contato_emergencia_1_nome'] ?? '') ?>" required>
                <input type="tel" name="contato_emergencia_1_telefone" placeholder="Telefone" value="<?= htmlspecialchars($info['contato_emergencia_1_telefone'] ?? '') ?>" required>
            </div>

            <div class="info-group">
                <label>Contato de Emergência 2:</label>
                <input type="text" name="contato_emergencia_2_nome" placeholder="Nome" value="<?= htmlspecialchars($info['contato_emergencia_2_nome'] ?? '') ?>">
                <input type="tel" name="contato_emergencia_2_telefone" placeholder="Telefone" value="<?= htmlspecialchars($info['contato_emergencia_2_telefone'] ?? '') ?>">
            </div>

            <div class="button-group">
                <button type="submit" class="save-button">Salvar Alterações</button>
                <a href="index.php?action=info_emergencia" class="back-button">Cancelar</a>
            </div>
        </form>
    </div>
</body>
</html>
