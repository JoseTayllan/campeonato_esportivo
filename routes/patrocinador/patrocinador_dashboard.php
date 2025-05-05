<?php
session_start();
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../app/controllers/PatrocinadorController.php';
require_once __DIR__ . '/../../app/middleware/verifica_sessao.php';

$controller = new PatrocinadorController($conn); // ✅ MOVIDO PARA CIMA

// ✅ Vincular novo time
if (isset($_POST['vincular_time']) && isset($_POST['time_id'])) {
    $time_id = $_POST['time_id'];

    $stmt = $conn->prepare("SELECT id FROM patrocinadores WHERE usuario_id = ?");
    $stmt->bind_param("i", $_SESSION['usuario_id']);
    $stmt->execute();
    $res = $stmt->get_result();
    $patrocinador = $res->fetch_assoc();

    if ($patrocinador) {
        $patrocinador_id = $patrocinador['id'];
        $stmt2 = $conn->prepare("INSERT INTO patrocinador_time (patrocinador_id, time_id, data_inicio) VALUES (?, ?, CURDATE())");
        $stmt2->bind_param("ii", $patrocinador_id, $time_id);
        $stmt2->execute();
    }

    header("Location: patrocinador_dashboard.php");
    exit;
}

// ✅ Desvincular time
if (isset($_POST['desvincular_time']) && isset($_POST['time_id'])) {
    $time_id = $_POST['time_id'];
    $patrocinador_id = (int) $_SESSION['usuario_id'];

    $stmt = $conn->prepare("SELECT id FROM patrocinadores WHERE usuario_id = ?");
    $stmt->bind_param("i", $patrocinador_id);
    $stmt->execute();
    $res = $stmt->get_result();
    $patrocinador = $res->fetch_assoc();

    if ($patrocinador) {
        $controller->desvincularTime($patrocinador['id'], $time_id);
    }

    header("Location: patrocinador_dashboard.php");
    exit;
}


// ✅ Cadastro de patrocinador
if (isset($_POST['criar_patrocinador'])) {
    $nome = $_POST['nome_empresa'];
    $contrato = $_POST['contrato'];
    $valor = $_POST['valor_investido'];
    $time_id = $_POST['time_id'] ?? null;

    $logo_path = null;
    if (!empty($_FILES['logo']['name'])) {
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
        }
    }

    $stmt = $conn->prepare("INSERT INTO patrocinadores (nome_empresa, contrato, valor_investido, logo, usuario_id) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssdsi", $nome, $contrato, $valor, $logo_path, $_SESSION['usuario_id']);
    $stmt->execute();
    $patrocinador_id = $stmt->insert_id;

    if (!empty($time_id)) {
        $stmt2 = $conn->prepare("INSERT INTO patrocinador_time (patrocinador_id, time_id, data_inicio) VALUES (?, ?, CURDATE())");
        $stmt2->bind_param("ii", $patrocinador_id, $time_id);
        $stmt2->execute();
    }

    header("Location: patrocinador_dashboard.php");
    exit;
}

// ✅ Acesso apenas para patrocinador
$restrito_para = ['patrocinador'];

// ✅ Verifica se empresa já foi cadastrada
$stmt = $conn->prepare("SELECT id, logo FROM patrocinadores WHERE usuario_id = ?");
$stmt->bind_param("i", $_SESSION['usuario_id']);
$stmt->execute();
$res = $stmt->get_result();
$patrocinador = $res->fetch_assoc();

if (!$patrocinador) {
    require_once __DIR__ . '/../../public/includes/assinatura_patrocinador.php';
    echo '<div class="container py-5">';
    echo '<div class="alert alert-warning text-center shadow mb-4">';
    echo '<h5>Você ainda não cadastrou sua empresa patrocinadora.</h5>';
    echo '<p>Para acessar suas funcionalidades, é necessário cadastrar sua empresa abaixo:</p>';
    echo '<a href="/campeonato_esportivo/public/views/patrocinador/cadastro_patrocinador.php" class="btn btn-primary mt-3">';
    echo '<i class="bi bi-building-add me-1"></i> Cadastrar Agora';
    echo '</a>';
    echo '</div>';
    echo '</div>';
    exit;
}

// ✅ Empresa existe — carregar dashboard
$patrocinador_id = $patrocinador['id'];
$logo_banner = $patrocinador['logo'] ?? null;

$controller = new PatrocinadorController($conn);
$times = $controller->obterTimesPatrocinados($patrocinador_id);

$dados_dashboard = [];
foreach ($times as $time) {
    $estatisticas = $controller->obterDesempenhoTime($time['id']);
    $dados_dashboard[] = [
        'time' => $time,
        'estatisticas' => $estatisticas,
        'logo' => $time['logo'] ?? null,
        'valor_investido' => $time['valor_investido'] ?? 0
    ];
}

require_once __DIR__ . '/../../public/views/patrocinador/dashboard.php';