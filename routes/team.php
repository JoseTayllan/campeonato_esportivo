<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../app/controllers/TeamController.php';

session_start(); // Iniciar sessão para armazenar mensagens

$timeController = new TeamController($conn);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['nome'], $_POST['cidade'], $_POST['estadio'])) {
        $nome = $_POST['nome'];
        $cidade = $_POST['cidade'];
        $estadio = $_POST['estadio'];

        // Variável para armazenar o caminho do escudo
        $escudo = NULL;

        // Verifica se um arquivo foi enviado
        if (isset($_FILES['escudo']) && $_FILES['escudo']['error'] === UPLOAD_ERR_OK) {
            $extensao = pathinfo($_FILES['escudo']['name'], PATHINFO_EXTENSION);
            $novoNome = uniqid("escudo_") . "." . $extensao;
            $caminhoDestino = __DIR__ . "/../public/img/times/" . $novoNome;

            // Move o arquivo para a pasta correta
            if (move_uploaded_file($_FILES['escudo']['tmp_name'], $caminhoDestino)) {
                $escudo = "img/times/" . $novoNome; // Caminho relativo para o banco
            } else {
                $_SESSION['mensagem_erro'] = "Erro ao salvar o escudo.";
                header("Location: ../public/views/cadastro/cadastro_time.php");
                exit();
            }
        }

        // Criar time no banco de dados
        $resultado = $timeController->criarTime($nome, $escudo, $cidade, $estadio);

        if (strpos($resultado, 'sucesso') !== false) {
            $_SESSION['mensagem_sucesso'] = "Time cadastrado com sucesso!";
        } else {
            $_SESSION['mensagem_erro'] = "Erro ao cadastrar time: " . $resultado;
        }
    } else {
        $_SESSION['mensagem_erro'] = "Parâmetros ausentes.";
    }

    header("Location: ../public/views/cadastro/cadastro_time.php");
    exit();
} else {
    $_SESSION['mensagem_erro'] = "Método inválido.";
    header("Location: ../public/views/cadastro/cadastro_time.php");
    exit();
}
?>
