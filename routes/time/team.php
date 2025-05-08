<?php

require_once __DIR__ . '/../../app/controllers/time_contro/TeamController.php';

session_start();

$timeController = new TeamController($conn);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // ✅ Criação do time
    if (isset($_POST['nome'], $_POST['cidade'], $_POST['estadio'])) {
        $nome = $_POST['nome'];
        $cidade = $_POST['cidade'];
        $estadio = $_POST['estadio'];
        $escudo = null;

        $admin_id = $_POST['admin_id'] ?? ($_SESSION['usuario_id'] ?? null);
        if (!$admin_id) {
            $_SESSION['mensagem_erro'] = "Erro: Admin não identificado.";
            header("Location: /campeonato_esportivo/routes/time/dashboard_time.php");
            exit();
        }

        if (isset($_FILES['escudo']) && $_FILES['escudo']['error'] === UPLOAD_ERR_OK) {
            $extensao = pathinfo($_FILES['escudo']['name'], PATHINFO_EXTENSION);
            $novoNome = uniqid("escudo_") . "." . $extensao;
            $destino = __DIR__ . "/../../public/img/times/" . $novoNome;

            if (move_uploaded_file($_FILES['escudo']['tmp_name'], $destino)) {
                $escudo = "public/img/times/" . $novoNome;
            } else {
                $_SESSION['mensagem_erro'] = "Erro ao salvar o escudo.";
                header("Location: /campeonato_esportivo/routes/time/dashboard_time.php");
                exit();
            }
        }

        $resultado = $timeController->criarTime($nome, $escudo, $cidade, $estadio, $admin_id);

        if (strpos($resultado, 'sucesso') !== false) {
            $_SESSION['mensagem_sucesso'] = "Time cadastrado com sucesso!";
        } else {
            $_SESSION['mensagem_erro'] = "Erro ao cadastrar time: " . $resultado;
        }

        header("Location: /campeonato_esportivo/routes/time/dashboard_time.php");
        exit();
    }

    // ✅ Edição de time
    if (isset($_POST['editar_time'], $_POST['time_id'], $_POST['nome'], $_POST['cidade'])) {
        $id = $_POST['time_id'];
        $nome = $_POST['nome'];
        $cidade = $_POST['cidade'];
        $escudo = null;

        if (isset($_FILES['escudo']) && $_FILES['escudo']['error'] === UPLOAD_ERR_OK) {
            $extensao = pathinfo($_FILES['escudo']['name'], PATHINFO_EXTENSION);
            $novoNome = uniqid("escudo_") . "." . $extensao;
            $destino = __DIR__ . "/../../public/img/times/" . $novoNome;

            if (move_uploaded_file($_FILES['escudo']['tmp_name'], $destino)) {
                $escudo = "public/img/times/" . $novoNome;
            } else {
                $_SESSION['mensagem_erro'] = "Erro ao salvar o novo escudo.";
                header("Location: /campeonato_esportivo/routes/time/dashboard_time.php");
                exit();
            }
        }

        $resultado = $timeController->editarTime($id, $nome, $cidade, $escudo);

        if ($resultado) {
            $_SESSION['mensagem_sucesso'] = "Time atualizado com sucesso!";
        } else {
            $_SESSION['mensagem_erro'] = "Erro ao atualizar time.";
        }

        header("Location: /campeonato_esportivo/routes/time/dashboard_time.php");
        exit();
    }

    // Fallback
    $_SESSION['mensagem_erro'] = "Parâmetros inválidos.";
    header("Location: /campeonato_esportivo/routes/time/dashboard_time.php");
    exit();
} else {
    $_SESSION['mensagem_erro'] = "Método inválido.";
    header("Location: /campeonato_esportivo/routes/time/dashboard_time.php");
    exit();
}
