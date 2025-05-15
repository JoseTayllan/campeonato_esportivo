<?php
session_start();
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../app/controllers/ChampionshipController.php';
require_once __DIR__ . '/../../app/controllers/FaseController.php';
require_once __DIR__ . '/../../app/controllers/RodadaController.php';

$metodo = $_SERVER['REQUEST_METHOD'];

if ($metodo === 'POST') {
    // Dados do campeonato
    $nome = $_POST['nome'] ?? '';
    $descricao = $_POST['descricao'] ?? '';
    $temporada = $_POST['temporada'] ?? '';
    $formato = $_POST['formato'] ?? '';
    $times = $_POST['times'] ?? [];

    // Upload do QR Code
    $qrCodePath = null;
    if (isset($_FILES['qr_code']) && $_FILES['qr_code']['error'] === UPLOAD_ERR_OK) {
        $ext = pathinfo($_FILES['qr_code']['name'], PATHINFO_EXTENSION);
        $novoNome = 'qr_code_' . uniqid() . '.' . $ext;
        $destino = 'public/img/qrcodes/' . $novoNome;

        if (!is_dir(__DIR__ . '/../../public/img/qrcodes')) {
            mkdir(__DIR__ . '/../../public/img/qrcodes', 0777, true);
        }

        if (move_uploaded_file($_FILES['qr_code']['tmp_name'], __DIR__ . '/../../' . $destino)) {
            $qrCodePath = $destino;
        }
    }

    // Verificação mínima
    if (empty($nome) || empty($temporada) || empty($formato)) {
        $_SESSION['mensagem_erro'] = "Campos obrigatórios do campeonato estão faltando.";
        header('Location: ../../public/views/cadastro/cadastro_campeonato.php');
        exit;
    }

    // Criar campeonato
    $championshipController = new ChampionshipController($conn);
    $criado_por = $_SESSION['usuario_id'] ?? null;
    $response = json_decode($championshipController->criarCampeonato(
        $nome, $descricao, $temporada, $formato, $criado_por, $times, $qrCodePath
    ), true);

    if (!isset($response['erro'])) {
        $campeonato_id = $conn->insert_id;

        // Criar fase
        $faseController = new FaseController($conn);
        $fase_id = $faseController->criarFase($campeonato_id, $_POST['fase_nome'] ?? '', $_POST['fase_ordem'] ?? 1);

        if ($fase_id) {
            // Criar rodadas
            $rodadaController = new RodadaController($conn);
            $numeros = $_POST['rodada_numero'] ?? [];
            $tipos = $_POST['rodada_tipo'] ?? [];
            $descricoes = $_POST['rodada_desc'] ?? [];

            for ($i = 0; $i < count($numeros); $i++) {
                $numero = isset($numeros[$i]) ? intval($numeros[$i]) : 0;
                $tipo = isset($tipos[$i]) ? trim($tipos[$i]) : '';
                $descricao = isset($descricoes[$i]) ? trim($descricoes[$i]) : '';

                if ($fase_id && $numero > 0 && !empty($tipo)) {
                    $rodadaController->criarRodada($fase_id, $numero, $tipo, $descricao);
                }
            }

            $_SESSION['mensagem_sucesso'] = "Campeonato, fase e rodadas criadas com sucesso!";
        } else {
            $_SESSION['mensagem_erro'] = "Campeonato criado, mas erro ao criar a fase.";
        }
    } else {
        $_SESSION['mensagem_erro'] = "Erro ao criar campeonato.";
    }

    header('Location: ../../public/views/cadastro/cadastro_campeonato.php');
    exit;
} else {
    http_response_code(405);
    echo "Método não permitido.";
}
