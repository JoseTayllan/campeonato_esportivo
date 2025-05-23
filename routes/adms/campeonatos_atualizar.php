<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();
$restrito_para = ['Administrador', 'Organizador'];

require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../app/Models/Campeonato.php';

$model = new Campeonato($conn);

// Dados recebidos do formulário
$id         = $_POST['id'] ?? null;
$nome       = $_POST['nome'] ?? '';
$descricao  = $_POST['descricao'] ?? '';
$premiacao  = $_POST['premiacao'] ?? '';
$temporada  = $_POST['temporada'] ?? '';
$formato    = $_POST['formato'] ?? '';
$modalidade = $_POST['modalidade'] ?? '';
$status     = $_POST['status'] ?? 'ativo';

if (!$id) {
    $_SESSION['mensagem_erro'] = "ID do campeonato não recebido.";
    header("Location: /campeonato_esportivo/public/views/campeonatos/meus_campeonatos.php");
    exit;
}

// Upload do QR Code
if (isset($_FILES['qr_code']) && $_FILES['qr_code']['error'] === UPLOAD_ERR_OK) {
    $ext = pathinfo($_FILES['qr_code']['name'], PATHINFO_EXTENSION);
    $novoNome = 'qr_code_' . uniqid() . '.' . $ext;
    $destino = 'public/img/qrcodes/' . $novoNome;

    if (!is_dir(__DIR__ . '/../../public/img/qrcodes')) {
        mkdir(__DIR__ . '/../../public/img/qrcodes', 0777, true);
    }

    if (move_uploaded_file($_FILES['qr_code']['tmp_name'], __DIR__ . '/../../' . $destino)) {
        $qrCodePath = $destino;

        $stmt = $conn->prepare("UPDATE campeonatos SET qr_code_localizacao = ? WHERE id = ?");
        $stmt->bind_param("si", $qrCodePath, $id);
        $stmt->execute();
    }
}

// Upload do Banner
if (isset($_FILES['banner']) && $_FILES['banner']['error'] === UPLOAD_ERR_OK) {
    $ext = pathinfo($_FILES['banner']['name'], PATHINFO_EXTENSION);
    $novoNome = 'banner_' . uniqid() . '.' . $ext;
    $destino = 'public/img/banners/' . $novoNome;

    if (!is_dir(__DIR__ . '/../../public/img/banners')) {
        mkdir(__DIR__ . '/../../public/img/banners', 0777, true);
    }

    if (move_uploaded_file($_FILES['banner']['tmp_name'], __DIR__ . '/../../' . $destino)) {
        $bannerPath = $destino;

        $stmt = $conn->prepare("UPDATE campeonatos SET banner = ? WHERE id = ?");
        $stmt->bind_param("si", $bannerPath, $id);
        $stmt->execute();
    }
}

// Atualiza dados principais
$stmt = $conn->prepare("
    UPDATE campeonatos 
    SET nome = ?, descricao = ?, premiacao = ?, temporada = ?, formato = ?, modalidade = ?, status = ? 
    WHERE id = ?
");
$stmt->bind_param("sssssssi", $nome, $descricao, $premiacao, $temporada, $formato, $modalidade, $status, $id);
$atualizado = $stmt->execute();

// Mensagem de retorno
if ($atualizado) {
    $_SESSION['mensagem_sucesso'] = "Campeonato atualizado com sucesso!";
} else {
    $_SESSION['mensagem_erro'] = "Erro ao atualizar o campeonato.";
}

// Redirecionamento para editar_campeonato.php corretamente
header("Location: /campeonato_esportivo/public/views/campeonatos/editar_campeonato.php?id=" . $id);
exit;
?>
