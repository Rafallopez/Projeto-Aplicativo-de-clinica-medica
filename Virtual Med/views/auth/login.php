<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Virtual Med - Login</title>    
    <link rel="stylesheet" href="public/css/login.css">

</head>
<body>
    <div class="page-wrapper">
        <header class="header">
            <div class="logo-container">
                <div class="brand-wrapper">
                    <div class="logo-column">
                        <img src="https://cdn.builder.io/api/v1/image/assets/TEMP/b2ecff3ad51fbd10197ed00bf22a584a784ec0e9b74ca924de797e92c2dbcc89?placeholderIfAbsent=true&apiKey=e119ae73fe1b477c9e55373f0bb60c2f" alt="Virtual Med Logo" class="logo" />
                    </div>
                </div>
            </div>
        </header>

        <main class="main-content">
            <div class="content-wrapper">
                <div class="image-column">
                    <img src="https://cdn.builder.io/api/v1/image/assets/TEMP/dee8f1a0c9170d30200d85a2101497bc4491b1f02598d86f9dfdbef10438d797?placeholderIfAbsent=true&apiKey=e119ae73fe1b477c9e55373f0bb60c2f" alt="Medical Professional" class="hero-image" />
                </div>
                <div class="login-column">
                    <form class="login-form" action="index.php?action=login" method="post">
                        <h2 class="login-title">LOGIN</h2>
                        
                        <?php if(isset($_SESSION['erro'])): ?>
                            <div class="alert alert-error">
                                <?= $_SESSION['erro']; ?>
                                <?php unset($_SESSION['erro']); ?>
                            </div>
                        <?php endif; ?>

                        <label for="email" class="input-label">EMAIL:</label>
                        <input type="email" id="email" name="email" class="text-input" required aria-required="true" />
                        
                        <label for="senha" class="input-label">DIGITE SUA SENHA:</label>
                        <input type="password" id="senha" name="senha" class="text-input" required aria-required="true" />
                        
                        
                        <div class="button-group">
                            <button type="submit" class="form-button">ENTRAR</button>
                            <button type="button" class="form-button" onclick="window.location.href='index.php'">CANCELAR</button>
                        </div>
                    </form>
                </div>
            </div>
        </main>

        <footer class="footer">
            <div class="footer-content">
                <div class="contact-info">
                    Central de Atendimento 31 9999-9999<br />
                    SAC 24 horas<br />
                    Informações, dúvidas, reclamações e comunicação de ocorrência de fraude
                </div>
                <div class="social-links">
                    <div class="social-group">
                        <img src="https://cdn.builder.io/api/v1/image/assets/TEMP/1d592ad365b33dad762a4142a4ebaac5bac3c64f742d569c76ce4089122a5e4e?placeholderIfAbsent=true&apiKey=e119ae73fe1b477c9e55373f0bb60c2f" alt="Social Media" class="social-icon" />
                        <img src="https://cdn.builder.io/api/v1/image/assets/TEMP/2801ab15986c4a19b298981be0a85eb68c7283c09ec220dd39c9a56676c6101b?placeholderIfAbsent=true&apiKey=e119ae73fe1b477c9e55373f0bb60c2f" alt="Social Media" class="social-icon" />
                    </div>
                    <div class="social-group">
                        <img src="https://cdn.builder.io/api/v1/image/assets/TEMP/bd7af86a451b9c3bdf6fdda31fae262d971fb8cce36b543c2f9e89bc68cc9584?placeholderIfAbsent=true&apiKey=e119ae73fe1b477c9e55373f0bb60c2f" alt="Social Media" class="social-icon" />
                        <img src="https://cdn.builder.io/api/v1/image/assets/TEMP/27311725b773027a29d348754818a08de909066d6178e3d910b13f9abe0bc699?placeholderIfAbsent=true&apiKey=e119ae73fe1b477c9e55373f0bb60c2f" alt="Social Media" class="social-icon" />
                    </div>
                </div>
            </div>
        </footer>
    </div>
</body>
</html>