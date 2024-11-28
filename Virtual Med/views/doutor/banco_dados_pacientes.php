<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Banco de Dados - Pacientes</title>
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
                <h2>Banco de Dados - Pacientes</h2>
                <img src="https://cdn.builder.io/api/v1/image/assets/TEMP/b922b5f9f2a8c8eaef60c88a3cf8764bbd71788eca43a7407868abe3b03e8dda" alt="Database Icon" class="header-icon">
            </div>
        </header>

        <div class="search-section">
            <input type="text" id="searchInput" placeholder="Pesquisar pacientes..." class="search-input">
        </div>

        <div class="consultations-grid">
            <?php foreach ($pacientes as $paciente): ?>
                <div class="consultation-card">
                    <div class="card-header">
                        <h3><?= htmlspecialchars($paciente['nome']) ?></h3>
                    </div>
                    <div class="card-content">
                        <div class="info-row">
                            <span class="label">Email:</span>
                            <span class="value"><?= htmlspecialchars($paciente['email']) ?></span>
                        </div>
                        <div class="info-row">
                            <span class="label">Data de Nascimento:</span>
                            <span class="value"><?= date('d/m/Y', strtotime($paciente['data_nascimento'])) ?></span>
                        </div>
                        <div class="info-row">
                            <span class="label">Plano de Saúde:</span>
                            <span class="value"><?= htmlspecialchars($paciente['plano_saude']) ?></span>
                        </div>
                        <div class="details-section">
                            <span class="label">Consultas Anteriores:</span>
                            <?php 
                            $consultas = explode(',', $paciente['consultas_anteriores']);
                            foreach ($consultas as $consulta): 
                                if ($consulta): ?>
                                    <p class="details-text"><?= date('d/m/Y H:i', strtotime($consulta)) ?></p>
                                <?php endif;
                            endforeach; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="button-container">
            <a href="index.php?action=painel_doutor" class="back-button">Voltar ao Painel</a>
        </div>
    </div>

    <script>
        const searchInput = document.getElementById('searchInput');
        const patientCards = document.querySelectorAll('.consultation-card');

        searchInput.addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            
            patientCards.forEach(card => {
                const cardText = card.textContent.toLowerCase();
                card.style.display = cardText.includes(searchTerm) ? '' : 'none';
            });
        });
    </script>
</body>
</html>
