<?php
session_start();

require_once __DIR__ . '/../../app/middleware/verifica_sessao.php';
require_once __DIR__ . '/../../app/controllers/patrocinador_contro/CadastrarPatrocinadorController.php';

$controller = new CadastrarPatrocinadorController($conn);
$usuario_id = $_SESSION['usuario_id'] ?? null;

// 🚫 Impede reenvio se já houver empresa
if ($controller->verificarExistente($usuario_id)) {
    header("Location: patrocinador_dashboard.php");
    exit;
}

// ✅ Cadastro da empresa
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome_empresa'];
    $contrato = $_POST['contrato'];
    $telefone = $_POST['telefone'] ?? null;
    $logo_path = null;

    if (!empty($_FILES['logo']['name'])) {
        $upload_dir = __DIR__ . '/../../public/img/patrocinadores/';
        if (!is_dir($upload_dir)) mkdir($upload_dir, 0755, true);

        $ext = pathinfo($_FILES['logo']['name'], PATHINFO_EXTENSION);
        $nome_final = uniqid() . "." . $ext;
        $destino = $upload_dir . $nome_final;

        if (move_uploaded_file($_FILES['logo']['tmp_name'], $destino)) {
            $logo_path = 'public/img/patrocinadores/' . $nome_final;
        }
    }

    $controller->criar($nome, $contrato, $telefone, $logo_path, $usuario_id);

    header("Location: patrocinador_dashboard.php");
    exit;
}

// ✅ Exibe formulário
require_once __DIR__ . '/../../public/views/patrocinador/cadastro_patrocinador.php';
