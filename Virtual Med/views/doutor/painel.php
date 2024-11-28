<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel do Médico - Virtual Med</title>
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
                <h2>Painel do <?= $_SESSION['user_role'] === 'doutor' ? 'Médico' : 'Paciente' ?></h2>
                <a href="index.php?action=perfil">
                    <img src="https://cdn.builder.io/api/v1/image/assets/TEMP/b922b5f9f2a8c8eaef60c88a3cf8764bbd71788eca43a7407868abe3b03e8dda" alt="Profile Icon" class="header-icon">
                </a>
            </div>
        </header>
        <h1 class="welcome-text">O que você gostaria de fazer hoje?</h1>

        <div class="consultations-grid">
            <div class="consultation-card">
                <div class="card-header">
                    <h3>Agendar Nova Consulta</h3>
                </div>
                <div class="card-content">
                    <img src="https://cdn.builder.io/api/v1/image/assets/TEMP/20a53b75d71749571aecce5bed6592aad5cf4b1e23dd0b97bc0d5d8b649dbece" alt="Schedule Icon" class="action-icon">
                    <a href="index.php?action=agendar_consulta" class="action-button">Acessar</a>
                </div>
            </div>

            <div class="consultation-card">
                <div class="card-header">
                    <h3>Visualizar/Editar Consultas</h3>
                </div>
                <div class="card-content">
                    <img src="https://cdn.builder.io/api/v1/image/assets/TEMP/e06ffdcd5db860a70292731db2ecc2146490a506bb70b8f373fd6b3145b7052f" alt="View Icon" class="action-icon">
                    <a href="index.php?action=visualizar_consultas" class="action-button">Acessar</a>
                </div>
            </div>

            <div class="consultation-card">
                <div class="card-header">
                    <h3>Banco de Dados Pacientes</h3>
                </div>
                <div class="card-content">
                    <img src="https://cdn.builder.io/api/v1/image/assets/TEMP/b1ca289ed33dfc05062cd69c43f8d080f4c6ed8e2406b1a7e540c252f9d88720" alt="Database Icon" class="action-icon">
                    <a href="index.php?action=banco_dados_pacientes" class="action-button">Acessar</a>
                </div>
            </div>

            <div class="consultation-card">
                <div class="card-header">
                    <h3>Chat com Pacientes</h3>
                </div>
                <div class="card-content">
                    <img src="https://cdn.builder.io/api/v1/image/assets/TEMP/39389728d2f4c4a8b896af7fb04950c5be9f4ce939159ef1fd3e437216f44502" alt="Chat Icon" class="action-icon">
                    <a href="index.php?action=chat" class="action-button">Acessar</a>
                </div>
            </div>

            <div class="consultation-card">
                <div class="card-header">
                    <h3>Resumos de Consultas</h3>
                </div>
                <div class="card-content">
                    <img src="https://cdn.builder.io/api/v1/image/assets/TEMP/717c829cb379209249bcfa352206aa398976f30c99517531f4696e540117e5ab" alt="Summary Icon" class="action-icon">
                    <a href="index.php?action=resumo_consultas" class="action-button">Acessar</a>
                </div>
            </div>

            <div class="consultation-card">
                <div class="card-header">
                    <h3>Sair</h3>
                </div>
                <div class="card-content">
                    <img src="https://cdn.builder.io/api/v1/image/assets/TEMP/bade85a62ff053246109ff92baf027fca25b029c86db2f4038bdfaefe8399cca" alt="Logout Icon" class="action-icon">
                    <a href="index.php?action=sair" class="action-button">Sair</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>