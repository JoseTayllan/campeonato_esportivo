<?php
require_once 'config/database.php';
require_once 'app/models/Avaliacao.php';

$avaliacaoModel = new Avaliacao($conn);

// Teste 1: Inserir uma avaliação completa
$avaliacao1 = $avaliacaoModel->criar(1, 2, 8, 7, 9, 6, 7.5, "Ótima performance!");
echo $avaliacao1 ? "Avaliação completa registrada com sucesso!<br>" : "Erro ao registrar avaliação completa.<br>";

// Teste 2: Inserir uma avaliação sem notas (NULL)
$avaliacao2 = $avaliacaoModel->criar(2, 3, null, null, null, null, null, null);
echo $avaliacao2 ? "Avaliação com valores NULL registrada com sucesso!<br>" : "Erro ao registrar avaliação com valores NULL.<br>";

// Verificar avaliações
$resultado = $conn->query("SELECT * FROM avaliacoes");
echo "<pre>"; print_r($resultado->fetch_all(MYSQLI_ASSOC)); echo "</pre>";
?>
