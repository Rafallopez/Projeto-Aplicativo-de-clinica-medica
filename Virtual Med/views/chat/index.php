<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat - Virtual Med</title>
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
                <h2>Chat</h2>
                <img src="https://cdn.builder.io/api/v1/image/assets/TEMP/39389728d2f4c4a8b896af7fb04950c5be9f4ce939159ef1fd3e437216f44502" alt="Chat Icon" class="header-icon">
            </div>
        </header>

        <div class="search-section">
            <input type="text" id="searchInput" placeholder="Pesquisar contatos..." class="search-input">
        </div>

        <div class="consultations-grid">
            <?php foreach ($contatos as $contato): ?>
                <div class="consultation-card">
                    <div class="card-header">
                        <h3><?= htmlspecialchars($contato['nome']) ?></h3>
                        <span class="specialty"><?= ucfirst($contato['tipo']) ?></span>
                    </div>
                    <div class="card-content">
                        <div class="action-buttons">
                            <a href="index.php?action=chat_conversa&id=<?= $contato['id'] ?>" class="chat-button">
                                Iniciar Chat
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="button-container">
            <a href="index.php?action=<?= $_SESSION['user_role'] === 'doutor' ? 'painel_doutor' : 'painel_paciente' ?>" class="back-button">
                Voltar ao Painel
            </a>
        </div>
    </div>

    <script>
        const searchInput = document.getElementById('searchInput');
        const contactCards = document.querySelectorAll('.consultation-card');

        searchInput.addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            
            contactCards.forEach(card => {
                const cardText = card.textContent.toLowerCase();
                card.style.display = cardText.includes(searchTerm) ? '' : 'none';
            });
        });
    </script>
</body>
</html>
