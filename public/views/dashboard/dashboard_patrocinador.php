<?php
// Proteger contra acesso direto
if (!isset($_SERVER['HTTP_REFERER']) || empty($_SERVER['HTTP_REFERER'])) {
    echo "<div style='text-align:center; padding:20px; font-family:sans-serif;'>
            <h2 style='color:red;'>Erro: Acesso direto não permitido!</h2>
            <p>Utilize o sistema normalmente para acessar esta página.</p>
          </div>";
    exit();
} 
session_start();
$restrito_para = ['Patrocinador'];
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
            <p>Em breve, você poderá visualizar os times patrocinados, registrar novos contratos e acessar relatórios
                detalhados.</p>
        </div>
    </div>

    <?php include '../cabecalho/footer.php'; ?>
    <script src="../../../assets/js/bootstrap.bundle.min.js"></script>
</body>

</html>