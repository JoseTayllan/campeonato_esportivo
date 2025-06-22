<?php
session_start();
require_once __DIR__ . '/../../../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cpf = trim($_POST['cpf'] ?? '');
    $data_raw = $_POST['data_nascimento'] ?? '';

    // ✅ Corrigir formato de data caso venha em DD/MM/YYYY
    if (strpos($data_raw, '/') !== false) {
        $data_nascimento = date('Y-m-d', strtotime(str_replace('/', '-', $data_raw)));
    } else {
        $data_nascimento = $data_raw;
    }

    $stmt = $conn->prepare("SELECT * FROM jogadores WHERE cpf = ? AND data_nascimento = ?");
    $stmt->bind_param("ss", $cpf, $data_nascimento);
    $stmt->execute();
    $result = $stmt->get_result();
    $jogador = $result->fetch_assoc();

    if ($jogador) {
    $_SESSION['usuario_id'] = $jogador['id'];
    $_SESSION['tipo'] = 'jogador';

    // 🔥 ESSENCIAL: simular estrutura de sessão como nos outros logins
    $_SESSION['usuario'] = [
        'id' => $jogador['id'],
        'tipo' => 'jogador',
        'nome' => $jogador['nome'] ?? '',
        'cpf' => $jogador['cpf'] ?? '',
        'data_nascimento' => $jogador['data_nascimento'] ?? ''
        // adiciona outros campos se quiser
    ];

    header("Location: /campeonato_esportivo/routes/jogador/perfil.php");
    exit();
}

}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Login do Jogador</title>
    <link rel="stylesheet" href="/campeonato_esportivo/assets/css/bootstrap.min.css">
</head>
<body class="bg-light">
    <div class="container py-5">
        <div class="card shadow p-4">
            <h2 class="mb-4 text-center">Login do Jogador</h2>

            <?php if (!empty($erro)): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($erro) ?></div>
            <?php endif; ?>

            <form method="POST">
                <div class="mb-3">
                    <label class="form-label">CPF</label>
                    <input type="text" name="cpf" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Data de Nascimento</label>
                    <input type="date" name="data_nascimento" class="form-control" required>
                </div>

                <button type="submit" class="btn btn-primary w-100">Entrar</button>
            </form>

            <div class="text-center mt-3">
                <a href="/campeonato_esportivo/public/views/login/login.php">← Voltar para login principal</a>
            </div>
        </div>
    </div>
</body>
</html>
