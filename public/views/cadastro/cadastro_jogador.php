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
$restrito_para = ['Administrador', 'Organizador'];
require_once __DIR__ . '/../../../app/middleware/verifica_sessao.php';
require_once __DIR__ . '/../../../config/database.php'; // Conexão com o banco
?>

<?php include '../cabecalho/header.php'; ?>
<?php
$tipo = strtolower($_SESSION['usuario_tipo'] ?? '');

switch ($tipo) {
    case 'administrador':
        include '../cabecalho/tabela_administrativa.php';
        break;
    case 'organizador':
        include '../cabecalho/tabela.php';
        break;
    case 'olheiro':
        include '../cabecalho/tabela_olheiro.php';
        break;
    case 'treinador':
        include '../cabecalho/tabela_treinador.php';
        break;
    case 'jogador':
        include '../cabecalho/tabela_jogador.php';
        break;
    case 'patrocinador':
        include '../cabecalho/tabela_patrocinador.php';
        break;
    default:
        include '../cabecalho/tabela.php';
}
?>


<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Jogador</title>
    <link href="../../../assets/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <div class="container mt-4">
        <h2 class="mb-4">Cadastro de Jogador</h2>

        <?php include '../partials/mensagens.php'; ?>

        <form action="../../../routes/players.php" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="nome" class="form-label">Nome do Jogador</label>
                <input type="text" class="form-control" name="nome" placeholder="Ex: João da Silva" required>
            </div>

            <div class="mb-3">
                <label for="idade" class="form-label">Idade</label>
                <input type="number" class="form-control" name="idade" min="10" max="60" placeholder="Ex: 22" required>
            </div>

            <div class="mb-3">
                <label for="nacionalidade" class="form-label">Nacionalidade</label>
                <input type="text" class="form-control" name="nacionalidade" placeholder="Ex: Brasileiro">
            </div>

            <div class="mb-3">
                <label for="posicao" class="form-label">Posição</label>
                <select class="form-control" name="posicao" required>
                    <option value="">Selecione a posição</option>
                    <option value="Goleiro">Goleiro</option>
                    <option value="Zagueiro">Zagueiro</option>
                    <option value="Volante">Volante</option>
                    <option value="Lateral">Lateral</option>
                    <option value="Meia">Meia</option>
                    <option value="Atacante">Atacante</option>
                </select>
                <small class="form-text text-muted">Ex: Zagueiro, Meia, Atacante...</small>
            </div>

            <div class="mb-3">
                <label for="time_id" class="form-label">Time</label>
                <select class="form-control" name="time_id" required>
                    <option value="">Selecione um time</option>
                    <?php
                $query = "SELECT id, nome FROM times";
                $result = $conn->query($query);
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='{$row['id']}'>{$row['nome']}</option>";
                }
                ?>
                </select>
                <small class="form-text text-muted">Selecione o time atual do jogador</small>
            </div>

             <!-- 🔥 Novo campo de upload de imagem -->
            <div class="mb-3">
                <label for="imagem" class="form-label">Imagem do Jogador</label>
                <input type="file" name="imagem" class="form-control" accept="image/*">
                <small class="form-text text-muted">Opcional: Escolha uma imagem de perfil para o jogador.</small>
            </div>

            <button type="submit" class="btn btn-primary">Cadastrar</button>
        </form>
    </div>
    <div class="row mt-4">
        <?php include '../cabecalho/footer.php'; ?>
        <script src="../../../assets/js/bootstrap.bundle.min.js"></script>
</body>

</html>