<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Visualizar Consultas</title>
    <link rel="stylesheet" href="public/css/consultas.css">
</head>
<body>
    <div class="consultation-wrapper">
        <div class="header-container">
            <div class="logo-section">
                <div class="logo-wrapper">
                    <div class="logo-container">
                        <img loading="lazy" src="https://cdn.builder.io/api/v1/image/assets/TEMP/b2ecff3ad51fbd10197ed00bf22a584a784ec0e9b74ca924de797e92c2dbcc89?placeholderIfAbsent=true&apiKey=e119ae73fe1b477c9e55373f0bb60c2f" alt="Virtual Med Logo" class="logo-image" />
                    </div>
                    <div class="brand-container">
                        <h1 class="brand-title">VIRTUAL MED</h1>
                    </div>
                </div>
            </div>
            <div class="header-title-section">
                <h2 class="page-title">Visualizar e Editar consultas</h2>
                <img loading="lazy" src="https://cdn.builder.io/api/v1/image/assets/TEMP/b922b5f9f2a8c8eaef60c88a3cf8764bbd71788eca43a7407868abe3b03e8dda?placeholderIfAbsent=true&apiKey=e119ae73fe1b477c9e55373f0bb60c2f" alt="Consultation Management Icon" class="header-icon" />
            </div>
        </div>

        <div class="table-container">
            <?php foreach ($consultas as $consulta): ?>
                <div class="table-column">
                    <div class="column-header">Paciente</div>
                    <div class="column-divider"></div>
                    <div class="column-content"><?= htmlspecialchars($consulta['nome_paciente']) ?></div>
                </div>
                <div class="table-column">
                    <div class="column-header">Data</div>
                    <div class="column-divider"></div>
                    <div class="column-content"><?= date('d/m/Y', strtotime($consulta['data'])) ?></div>
                </div>
                <div class="table-column">
                    <div class="column-header">Hora</div>
                    <div class="column-divider"></div>
                    <div class="column-content"><?= date('H:i', strtotime($consulta['data'])) ?></div>
                </div>
                <div class="table-column">
                    <div class="column-header">Detalhes</div>
                    <div class="column-divider"></div>
                    <div class="column-content"><?= htmlspecialchars($consulta['detalhes']) ?></div>
                </div>
                <div class="actions-column">
                    <div class="column-header">Ações</div>
                    <div class="action-buttons">
                        <a href="index.php?action=editar_consulta&id=<?= $consulta['id'] ?>" class="action-button">Editar</a>
                        <button onclick="confirmarExclusao(<?= $consulta['id'] ?>)" class="action-button">Excluir</button>
                    </div>
                </div>
                <br>
            <?php endforeach; ?>
        </div>
    </div>

    <div class="back-section">
    <a href="index.php?action=painel_doutor" class="action-button">VOLTAR</a>
    </div>


    <script>
        function confirmarExclusao(id) {
            if (confirm('Tem certeza que deseja excluir esta consulta?')) {
                window.location.href = `index.php?action=excluir_consulta&id=${id}`;
            }
        }
    </script>
</body>
</html>

