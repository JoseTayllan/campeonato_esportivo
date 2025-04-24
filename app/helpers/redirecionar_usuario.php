<?php
function redirecionarUsuario($usuario) {
    if (!$usuario || !isset($usuario['tipo'])) {
        header("Location: ../public/views/login/login.php");
        exit;
    }

    $tipo = strtolower($usuario['tipo']);
    $assinatura = $usuario['tipo_assinatura'] ?? 'completo';

    // Se for plano Time, sempre redireciona pro dashboard de time
    if ($assinatura === 'time') {
        header("Location: ../public/views/time/dashboard_time.php");
        exit;
    }

    $rotas = [
        'administrador' => '../public/views/dashboard/dashboard_administrador.php',
        'organizador'   => '../public/views/dashboard/dashboard_organizador.php',
        'treinador'     => '../public/views/dashboard/dashboard_treinador.php',
        'jogador'       => '../public/views/dashboard/dashboard_jogador.php',
        'olheiro'       => '../public/views/avaliacao/visualizar_avaliacoes.php',
        'patrocinador'  => '../routes/patrocinador_dashboard.php',
    ];

    if (isset($rotas[$tipo])) {
        header("Location: " . $rotas[$tipo]);
    } else {
        $_SESSION['mensagem_erro'] = "Tipo de usuário não reconhecido.";
        header("Location: ../public/views/login/login.php");
    }
    exit;
}
