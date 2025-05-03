<?php
session_start();
$restrito_para = ['Administrador'];
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../app/controllers/UserController.php';

include __DIR__ . '/../../public/views/usuarios/cadastro_organizador.php';
