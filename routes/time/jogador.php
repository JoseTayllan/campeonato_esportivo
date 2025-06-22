<?php

require_once __DIR__ . '/../../app/controllers/time_contro/TeamController.php';
session_start();

$controller = new TeamController($conn);
$admin_id = $_SESSION['usuario_id'];

// 🔥 Busca o time do admin logado
$stmt = $conn->prepare("SELECT id FROM times WHERE admin_id = ?");
$stmt->bind_param("i", $admin_id);
$stmt->execute();
$result = $stmt->get_result();
$time = $result->fetch_assoc();

if (!$time || !isset($time['id'])) {
    die("Time não encontrado ou acesso não autorizado.");
}

$time_id = $time['id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // ✅ Editar jogador
    if (isset($_POST['editar_jogador'])) {
        $id = $_POST['jogador_id'] ?? '';
        $nome = $_POST['nome'] ?? '';
        $posicao = $_POST['posicao'] ?? '';
        $idade = $_POST['idade'] ?? 0;
        $nacionalidade = $_POST['nacionalidade'] ?? '';
        $cpf = $_POST['cpf'] ?? null;
        $data_nascimento = $_POST['data_nascimento'] ?? null;

        // 🔥 Pega a imagem atual do jogador
        $jogador = $controller->buscarJogador($id);
        $imagem = $jogador['imagem'] ?? null;

        // 🔥 Upload de imagem (se houver)
        if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK) {
            $ext = pathinfo($_FILES['imagem']['name'], PATHINFO_EXTENSION);
            $imagem_nome = uniqid() . "." . $ext;
            $destino = __DIR__ . '/../../public/img/jogadores/' . $imagem_nome;

            if (move_uploaded_file($_FILES['imagem']['tmp_name'], $destino)) {
                $imagem = $imagem_nome;
            }
        }

        if ($controller->editarJogador($id, $nome, $posicao, $idade, $nacionalidade, $cpf, $data_nascimento, $imagem)) {
            $_SESSION['mensagem_sucesso'] = "Jogador editado com sucesso!";
        } else {
            $_SESSION['mensagem_erro'] = "Erro ao editar jogador.";
        }

        header("Location: dashboard_time.php");
        exit();
    }

    // ✅ Adicionar jogador
    $nome = $_POST['nome'] ?? '';
    $posicao = $_POST['posicao'] ?? '';
    $idade = $_POST['idade'] ?? 0;
    $nacionalidade = $_POST['nacionalidade'] ?? '';
    $cpf = $_POST['cpf'] ?? null;
    $data_nascimento = $_POST['data_nascimento'] ?? null;
    $imagem = null;

    // 🔥 Upload de imagem (se houver)
    if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK) {
        $ext = pathinfo($_FILES['imagem']['name'], PATHINFO_EXTENSION);
        $imagem_nome = uniqid() . "." . $ext;
        $destino = __DIR__ . '/../../public/img/jogadores/' . $imagem_nome;

        if (move_uploaded_file($_FILES['imagem']['tmp_name'], $destino)) {
            $imagem = $imagem_nome;
        }
    }

    if ($controller->adicionarJogador($nome, $posicao, $idade, $nacionalidade, $cpf, $data_nascimento, $time_id, $imagem)) {
        $_SESSION['mensagem_sucesso'] = "Jogador adicionado com sucesso!";
    } else {
        $_SESSION['mensagem_erro'] = "Erro ao adicionar jogador.";
    }

    header("Location: dashboard_time.php");
    exit();
}
?>
