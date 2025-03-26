<?php
require_once 'config/database.php';
require_once 'app/models/Substituicao.php';

$substituicaoModel = new Substituicao($conn);

// Teste 1: Inserir uma substituição completa
$substituicao1 = $substituicaoModel->registrarSubstituicao(1, 1, 3, 60);
echo $substituicao1 ? "Substituição completa registrada com sucesso!<br>" : "Erro ao registrar substituição completa.<br>";

// Teste 2: Tentar inserir substituição sem jogador saindo/entrando (NULL)
$substituicao2 = $substituicaoModel->registrarSubstituicao(1, null, null, null);
echo $substituicao2 ? "Substituição vazia registrada sem erro!<br>" : "Erro ao registrar substituição vazia.<br>";

// Verificar substituições
$resultado = $conn->query("SELECT * FROM substituicoes WHERE partida_id = 1");
echo "<pre>"; print_r($resultado->fetch_all(MYSQLI_ASSOC)); echo "</pre>";
?>
