<?php
session_start();
require_once __DIR__ . '/../../../app/middleware/verifica_sessao.php';
?>

<?php include '../cabecalho/header.php'; ?>
<?php include '../cabecalho/tabela_patrocinador.php'; ?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Painel do Patrocinador</title>
    <link href="../../../assets/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h2 class="mb-4 text-center">Painel do Patrocinador</h2>

    <div class="alert alert-info text-center">
        🛠️ A área de funcionalidades para patrocinadores está em desenvolvimento.
    </div>

    <div class="text-center mt-4">
        <p>Em breve, você poderá visualizar os times patrocinados, registrar novos contratos e acessar relatórios detalhados.</p>
    </div>
</div>

<?php include '../cabecalho/footer.php'; ?>
<script src="../../../assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>
