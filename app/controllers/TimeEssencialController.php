<?php 
require_once __DIR__ . '/../models/TimeEssencial.php';
require_once __DIR__ . '/../middleware/verifica_sessao.php';
require_once __DIR__ . '/../middleware/verifica_assinatura.php';
permite_acesso(['time', 'completo']);

$db = require __DIR__ . '/../config/database.php';
$timeModel = new TimeEssencial($db, $_SESSION['usuario']['id']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $cidade = $_POST['cidade'];
    $escudo = $_FILES['escudo']['name'];
    move_uploaded_file($_FILES['escudo']['tmp_name'], __DIR__ . "/../../public/uploads/$escudo");

    $timeModel->criarTime($nome, $cidade, $escudo);
    header('Location: ../../public/views/time/dashboard_time.php?sucesso=1');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['editar_time'])) {
    $nome = $_POST['nome'];
    $cidade = $_POST['cidade'];
    $escudo = null;

    if (!empty($_FILES['escudo']['name'])) {
        $escudo = $_FILES['escudo']['name'];
        move_uploaded_file($_FILES['escudo']['tmp_name'], __DIR__ . "/../../public/uploads/$escudo");
    }

    $meuTime = $timeModel->getMeuTime();
    $timeModel->atualizarTime($meuTime['id'], $nome, $cidade, $escudo);

    header('Location: ../../public/views/time/editar_time.php?sucesso=1');
    exit;
}




// ===== routes/time_essencial.php =====
require_once __DIR__ . '/../app/controllers/TimeEssencialController.php';
?>