<?php
function redirecionarUsuario($usuario)
{
    if (!$usuario || !isset($usuario['tipo'])) {
        header("Location: ../public/views/login/login.php");
        exit;
    }

    $tipo = strtolower($usuario['tipo']);
    $assinatura = $usuario['tipo_assinatura'] ?? 'completo';

    // Se for plano Time, redireciona direto
    if ($assinatura === 'time') {
        header("Location: ../routes/time/dashboard_time.php");
        exit;
    }

    // ✅ Patrocinador: sempre envia para a dashboard
    if ($tipo === 'patrocinador') {
        header("Location: ../routes/patrocinador/patrocinador_dashboard.php");
        exit;
    }
    // Jogador → pode ser futebol ou ping-pong
    if ($tipo === 'jogador') {
        if (isset($usuario['tipo_assinatura']) && $usuario['tipo_assinatura'] === 'pingpong') {
            header("Location: ../public/index.php?modalidade=pingpong");
        } else {
            header("Location: ../routes/jogador/verificar_perfil.php");
        }
        exit;
    }


    // Demais tipos de usuário
    $rotas = [
        'master'        => '../public/views/master/dashboard_master.php',
        'administrador' => '../routes/admin_visual/dashboard_administrador.php',
        'organizador'   => '../public/views/dashboard/dashboard_organizador.php',
        'treinador'     => '../public/views/dashboard/dashboard_treinador.php',
        'olheiro' => '../routes/avaliacao/visualizar_avaliacoes.php',
        'juiz'          => '/ping-pong/index.php?r=juiz_dashboard',

    ];

    if (isset($rotas[$tipo])) {
        header("Location: " . $rotas[$tipo]);
    } else {
        $_SESSION['mensagem_erro'] = "Tipo de usuário não reconhecido.";
        header("Location: ../public/views/login/login.php");
    }

    exit;
}
