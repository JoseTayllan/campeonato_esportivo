<?php
if (!isset($_SESSION['usuario']) || !isset($_SESSION['usuario']['tipo_assinatura'])) {
    header('Location: /login.php');
    exit;
}

function permite_acesso($tipos_permitidos = []) {
    if (!in_array($_SESSION['usuario']['tipo_assinatura'], $tipos_permitidos)) {
        header('Location: /erro_assinatura.php');
        exit;
    }
}
