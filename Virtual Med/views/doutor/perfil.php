<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil - Virtual Med</title>
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
                <h2>Meu Perfil</h2>
                <img src="https://cdn.builder.io/api/v1/image/assets/TEMP/b922b5f9f2a8c8eaef60c88a3cf8764bbd71788eca43a7407868abe3b03e8dda" alt="Profile Icon" class="header-icon">
            </div>
        </header>

        <?php if (isset($_SESSION['erro'])): ?>
            <div class="alert alert-error"><?= $_SESSION['erro']; ?><?php unset($_SESSION['erro']); ?></div>
        <?php endif; ?>

        <?php if (isset($_SESSION['sucesso'])): ?>
            <div class="alert alert-success"><?= $_SESSION['sucesso']; ?><?php unset($_SESSION['sucesso']); ?></div>
        <?php endif; ?>

        <div class="form-container">
            <form action="index.php?action=atualizar_perfil" method="POST">
                <div class="form-grid">
                    <div class="consultation-card">
                        <div class="card-header">
                            <h3>Informações Pessoais</h3>
                        </div>
                        <div class="card-content">
                            <div class="form-group">
                                <label>Nome:</label>
                                <input type="text" value="<?= htmlspecialchars($doutor['nome']) ?>" readonly>
                            </div>
                            <div class="form-group">
                                <label>CRM:</label>
                                <input type="text" value="<?= htmlspecialchars($doutor['crm']) ?>" readonly>
                            </div>
                            <div class="form-group">
                                <label>Especialidade:</label>
                                <input type="text" value="<?= htmlspecialchars($doutor['especialidade']) ?>" readonly>
                            </div>
                        </div>
                    </div>

                    <div class="consultation-card">
                        <div class="card-header">
                            <h3>Dados de Acesso</h3>
                        </div>
                        <div class="card-content">
                            <div class="form-group">
                                <label>Email:</label>
                                <input type="email" name="email" value="<?= htmlspecialchars($doutor['email']) ?>" required>
                            </div>
                            <div class="form-group">
                                <label>Nova Senha:</label>
                                <input type="password" name="nova_senha" minlength="6">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="action-buttons">
                    <button type="submit" class="save-button">Salvar Alterações</button>
                    <a href="index.php?action=painel_doutor" class="cancel-button">Voltar ao Painel</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
