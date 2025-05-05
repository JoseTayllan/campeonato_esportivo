<?php
session_start();
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../app/middleware/verifica_sessao.php';

if (isset($_POST['atualizar_banner']) && !empty($_FILES['logo']['name'])) {
    $usuario_id = $_SESSION['usuario_id'];

    $stmt = $conn->prepare("SELECT id FROM patrocinadores WHERE usuario_id = ?");
    $stmt->bind_param("i", $usuario_id);
    $stmt->execute();
    $res = $stmt->get_result();
    $patrocinador = $res->fetch_assoc();

    if ($patrocinador) {
        $upload_dir = __DIR__ . '/../../public/img/patrocinadores/';
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0755, true);
        }

        $nome_original = basename($_FILES['logo']['name']);
        $extensao = pathinfo($nome_original, PATHINFO_EXTENSION);
        $nome_limpo = preg_replace('/[^a-zA-Z0-9_\-\.]/', '_', pathinfo($nome_original, PATHINFO_FILENAME));
        $logo_nome = uniqid() . '_' . $nome_limpo . '.' . $extensao;

        $destino = $upload_dir . $logo_nome;

        if (move_uploaded_file($_FILES['logo']['tmp_name'], $destino)) {
            $logo_path = 'public/img/patrocinadores/' . $logo_nome;

            $stmt2 = $conn->prepare("UPDATE patrocinadores SET logo = ? WHERE id = ?");
            $stmt2->bind_param("si", $logo_path, $patrocinador['id']);
            $stmt2->execute();
        }
    }
}

header("Location: patrocinador_dashboard.php");
exit;
