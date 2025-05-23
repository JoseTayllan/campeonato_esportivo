<?php
session_start();
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../app/controllers/ChampionshipController.php';
require_once __DIR__ . '/../../app/controllers/FaseController.php';
require_once __DIR__ . '/../../app/controllers/RodadaController.php';

$metodo = $_SERVER['REQUEST_METHOD'];

if ($metodo === 'POST') {
    $nome       = $_POST['nome'] ?? '';
    $descricao  = $_POST['descricao'] ?? '';
    $premiacao  = $_POST['premiacao'] ?? '';
    $temporada  = $_POST['temporada'] ?? '';
    $formato    = $_POST['formato'] ?? '';
    $modalidade = $_POST['modalidade'] ?? '';
    $times      = $_POST['times'] ?? [];

    $criado_por = isset($_SESSION['usuario_id']) ? intval($_SESSION['usuario_id']) : 0;
    if ($criado_por <= 0) {
        $_SESSION['mensagem_erro'] = "Usuário não autenticado. Faça login novamente.";
        header('Location: ../../public/views/cadastro/cadastro_campeonato.php');
        exit;
    }

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

    // Upload do Banner (Bandeirão)
    $bannerPath = null;
    if (isset($_FILES['banner']) && $_FILES['banner']['error'] === UPLOAD_ERR_OK) {
        $ext = pathinfo($_FILES['banner']['name'], PATHINFO_EXTENSION);
        $novoNome = 'banner_' . uniqid() . '.' . $ext;
        $destino = 'public/img/banners/' . $novoNome;

        if (!is_dir(__DIR__ . '/../../public/img/banners')) {
            mkdir(__DIR__ . '/../../public/img/banners', 0777, true);
        }

        if (move_uploaded_file($_FILES['banner']['tmp_name'], __DIR__ . '/../../' . $destino)) {
            $bannerPath = $destino;
        }
    }

    if (empty($nome) || empty($temporada) || empty($formato)) {
        $_SESSION['mensagem_erro'] = "Campos obrigatórios do campeonato estão faltando.";
        header('Location: ../../public/views/cadastro/cadastro_campeonato.php');
        exit;
    }

    // Cria o campeonato
    $championshipController = new ChampionshipController($conn);
    $response = json_decode($championshipController->criarCampeonato(
        $nome, $descricao, $premiacao, $temporada, $formato, $modalidade, $criado_por, $times, $qrCodePath, $bannerPath
    ), true);

    if (!isset($response['erro'])) {
        $campeonato_id = $conn->insert_id;

        // Cria a fase inicial
        $faseController = new FaseController($conn);
        $fase_id = $faseController->criarFase($campeonato_id, $_POST['fase_nome'] ?? '', $_POST['fase_ordem'] ?? 1);

        if ($fase_id) {
            // Cria as rodadas
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
