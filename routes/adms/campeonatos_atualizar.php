<?php
session_start();
$restrito_para = ['Administrador', 'Organizador'];

require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../app/Models/Campeonato.php';

$model = new Campeonato($conn);

// Dados recebidos do formulário
$id         = $_POST['id'] ?? null;
$nome       = $_POST['nome'] ?? '';
$descricao  = $_POST['descricao'] ?? '';
$temporada  = $_POST['temporada'] ?? '';
$formato    = $_POST['formato'] ?? '';
$modalidade = $_POST['modalidade'] ?? '';
$status     = $_POST['status'] ?? 'ativo';

$qrCodePath = null;

// Verifica se um novo QR foi enviado
if (isset($_FILES['qr_code']) && $_FILES['qr_code']['error'] === UPLOAD_ERR_OK) {
    $ext = pathinfo($_FILES['qr_code']['name'], PATHINFO_EXTENSION);
    $novoNome = 'qr_code_' . uniqid() . '.' . $ext;
    $destino = 'public/img/qrcodes/' . $novoNome;

    if (!is_dir(__DIR__ . '/../../public/img/qrcodes')) {
        mkdir(__DIR__ . '/../../public/img/qrcodes', 0777, true);
    }

    if (move_uploaded_file($_FILES['qr_code']['tmp_name'], __DIR__ . '/../../' . $destino)) {
        $qrCodePath = $destino;

        // Atualiza somente o campo do QR Code
        $stmt = $conn->prepare("UPDATE campeonatos SET qr_code_localizacao = ? WHERE id = ?");
        $stmt->bind_param("si", $qrCodePath, $id);
        $stmt->execute();
    }
}

// Atualiza dados principais do campeonato
$atualizado = $model->atualizar($id, $nome, $descricao, $temporada, $formato, $modalidade, $status);

// Mensagem de retorno
if ($atualizado) {
    $_SESSION['mensagem_sucesso'] = "Campeonato atualizado com sucesso!";
} else {
    $_SESSION['mensagem_erro'] = "Erro ao atualizar o campeonato.";
}

// Redireciona de volta para a tela de edição
header("Location: campeonato_editar.php?id=" . $id);
exit;
