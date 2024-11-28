<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Chat - Conversa</title>
    <link rel="stylesheet" href="public/css/chat.css">
    <link rel="stylesheet" href="public/css/messages.css">
</head>
<body>
    <main class="chat-container">
        <header class="header">
            <div class="logo-section">
                <div class="logo-wrapper">
                    <div class="logo-container">
                        <img loading="lazy" src="https://cdn.builder.io/api/v1/image/assets/TEMP/b2ecff3ad51fbd10197ed00bf22a584a784ec0e9b74ca924de797e92c2dbcc89?placeholderIfAbsent=true&apiKey=e119ae73fe1b477c9e55373f0bb60c2f" alt="Virtual Med Logo" class="logo" />
                    </div>

                </div>
            </div>
            <div class="chat-header">
                <img loading="lazy" src="https://cdn.builder.io/api/v1/image/assets/TEMP/b922b5f9f2a8c8eaef60c88a3cf8764bbd71788eca43a7407868abe3b03e8dda?placeholderIfAbsent=true&apiKey=e119ae73fe1b477c9e55373f0bb60c2f" alt="Chat Icon" class="chat-icon" />
            </div>
        </header>

        <div class="messages-container" id="mensagens">
            <?php foreach ($mensagens as $mensagem): ?>
                <?php if ($mensagem['remetente_id'] == $_SESSION['user_id']): ?>
                    <section class="doctor-section">
                        <div><?= htmlspecialchars($mensagem['nome_remetente']) ?></div>
                        <div class="doctor-message" role="log">
                            <?= htmlspecialchars($mensagem['mensagem']) ?>
                            <div class="message-time"><?= date('H:i', strtotime($mensagem['data_envio'])) ?></div>
                        </div>
                    </section>
                <?php else: ?>
                    <section class="patient-section">
                        <div class="patient-name-label">Nome do Paciente: <?= htmlspecialchars($mensagem['nome_remetente']) ?></div>
                        <div class="patient-message" role="log">
                            <?= htmlspecialchars($mensagem['mensagem']) ?>
                            <div class="message-time"><?= date('H:i', strtotime($mensagem['data_envio'])) ?></div>
                        </div>
                    </section>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>

        <form class="chat-controls" method="POST" action="index.php?action=enviar_mensagem">
            <input type="hidden" name="destinatario_id" value="<?= $_GET['id'] ?>">
            <button type="button" class="back-button" onclick="window.location.href='index.php?action=chat'">Voltar</button>
            <input type="text" name="mensagem" id="messageInput" class="message-input" placeholder="Digite sua mensagem..." required />
            <button type="submit" class="send-button">Enviar</button>
        </form>
    </main>

    <!--<script>
        const mensagensContainer = document.getElementById('mensagens');
        mensagensContainer.scrollTop = mensagensContainer.scrollHeight;
        
        setInterval(() => {
            location.reload();
        }, 10000);
    </script>-->
</body>
</html>
