<?php
session_start();
session_unset();      // limpa variáveis de sessão
session_destroy();    // destrói a sessão
header("Location: ../public/views/login/login.php"); // redireciona para tela de login
exit();