<?php
require_once 'config/database.php';
require_once 'app/models/Estatistica.php';

$estatisticaModel = new Estatistica($conn);

// Teste 1: Inserir estatísticas completas
$estatistica1 = $estatisticaModel->registrar(1, 1, 2, 1, 30, 5, 2, 1, 0, 90, 1);
echo $estatistica1 ? "Estatística completa inserida com sucesso!<br>" : "Erro ao inserir estatística completa.<br>";

// Teste 2: Inserir estatísticas sem valores (NULL)
$estatistica2 = $estatisticaModel->registrar(1, 2, null, null, null, null, null, null, null, null, null);
echo $estatistica2 ? "Estatística com valores NULL inserida com sucesso!<br>" : "Erro ao inserir estatística com valores NULL.<br>";

// Verificar estatísticas da partida
$resultado = $conn->query("SELECT * FROM estatisticas_partida WHERE partida_id = 1");
echo "<pre>"; print_r($resultado->fetch_all(MYSQLI_ASSOC)); echo "</pre>";
?>
