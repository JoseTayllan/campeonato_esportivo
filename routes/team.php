<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../app/controllers/TeamController.php';

session_start(); // Iniciar sessão para armazenar mensagens

$timeController = new TeamController($conn);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // ✅ BLOCO NOVO: Criação de time via campo oculto (form direto na dashboard)
    if (isset($_POST['criar_time']) && isset($_POST['nome'], $_POST['cidade'], $_POST['estadio'])) {
        $nome = $_POST['nome'];
        $cidade = $_POST['cidade'];
        $estadio = $_POST['estadio'];
        $escudo = NULL;

        if (isset($_FILES['escudo']) && $_FILES['escudo']['error'] === UPLOAD_ERR_OK) {
            $extensao = pathinfo($_FILES['escudo']['name'], PATHINFO_EXTENSION);
            $novoNome = uniqid("escudo_") . "." . $extensao;
            $caminhoDestino = __DIR__ . "/../public/img/times/" . $novoNome;

            if (move_uploaded_file($_FILES['escudo']['tmp_name'], $caminhoDestino)) {
                $escudo = "img/times/" . $novoNome;
            } else {
                $_SESSION['mensagem_erro'] = "Erro ao salvar o escudo.";
                header("Location: ../public/views/time/dashboard_time.php");
                exit();
            }
        }

        $resultado = $timeController->criarTime($nome, $escudo, $cidade, $estadio);

        if (strpos($resultado, 'sucesso') !== false) {
            $_SESSION['mensagem_sucesso'] = "Time cadastrado com sucesso!";
        } else {
            $_SESSION['mensagem_erro'] = "Erro ao cadastrar time: " . $resultado;
        }

        header("Location: ../public/views/time/dashboard_time.php");
        exit();
    }

    // ✅ Edição de time existente
    if (isset($_POST['editar_time']) && isset($_POST['time_id'], $_POST['nome'], $_POST['cidade'])) {
        $id = $_POST['time_id'];
        $nome = $_POST['nome'];
        $cidade = $_POST['cidade'];
        $escudo = NULL;

        if (isset($_FILES['escudo']) && $_FILES['escudo']['error'] === UPLOAD_ERR_OK) {
            $extensao = pathinfo($_FILES['escudo']['name'], PATHINFO_EXTENSION);
            $novoNome = uniqid("escudo_") . "." . $extensao;
            $caminhoDestino = __DIR__ . "/../public/img/times/" . $novoNome;

            if (move_uploaded_file($_FILES['escudo']['tmp_name'], $caminhoDestino)) {
                $escudo = "img/times/" . $novoNome;
            } else {
                $_SESSION['mensagem_erro'] = "Erro ao salvar o novo escudo.";
                header("Location: ../public/views/time/dashboard_time.php");
                exit();
            }
        }

        $resultado = $timeController->editarTime($id, $nome, $cidade, $escudo);

        if ($resultado) {
            $_SESSION['mensagem_sucesso'] = "Time atualizado com sucesso!";
        } else {
            $_SESSION['mensagem_erro'] = "Erro ao atualizar time.";
        }

        header("Location: ../public/views/time/dashboard_time.php");
        exit();
    }

    // Segurança extra (fallback)
    $_SESSION['mensagem_erro'] = "Parâmetros inválidos.";
    header("Location: ../public/views/time/dashboard_time.php");
    exit();
} else {
    $_SESSION['mensagem_erro'] = "Método inválido.";
    header("Location: ../public/views/time/dashboard_time.php");
    exit();
}
