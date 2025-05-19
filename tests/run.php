<?php
/**
 * ChampCore - Framework de Testes
 * 
 * Este script executa testes automatizados em um ambiente isolado,
 * garantindo que os dados de produção não sejam afetados.
 */

// Definir constante para ambiente de teste
define('TESTING', true);

// Evita que o código de produção carregue a configuração de produção
$_SERVER['SCRIPT_FILENAME'] = __FILE__;

// Carregar a configuração do banco de dados de teste
require_once __DIR__ . '/../config/database.test.php';

// Carregar o wrapper de modelo para compatibilidade
require_once __DIR__ . '/models/ModelWrapper.php';

// Carregar o framework de testes
require_once __DIR__ . '/TestFramework.php';

// Carregar as classes de teste disponíveis
require_once __DIR__ . '/CampeonatoTest.php';
require_once __DIR__ . '/FilterTest.php';

// Importar classes do sistema
// A constante TESTING já definida garante que a configuração de produção não será carregada
require_once __DIR__ . '/../app/Models/Campeonato.php';
require_once __DIR__ . '/../app/controllers/ChampionshipController.php';
require_once __DIR__ . '/../app/controllers/IndexPublicoController.php';

// Banner de início
echo "\n";
echo "=======================================================\n";
echo "  ChampCore - Framework de Testes\n";
echo "=======================================================\n";
echo "Iniciando testes em ambiente isolado...\n\n";

// Definir testes disponíveis
$availableTests = [
    'campeonato' => 'CampeonatoTest',
    'filtro' => 'FilterTest'
];

// Determinar quais testes executar
$testToRun = isset($argv[1]) && array_key_exists($argv[1], $availableTests) 
    ? $argv[1] 
    : null;

echo "Testes disponíveis:\n";
foreach ($availableTests as $key => $test) {
    echo "- $key: " . $test . "\n";
}
echo "\n";

/**
 * Função para executar um teste específico
 */
function runTest($testClass) {
    // Estabelecer conexão com o banco de dados de teste
    try {
        $testDbConn = getTestDatabaseConnection();
        echo "✓ Conectado ao banco de dados de teste com sucesso\n";
        
        // Criar wrapper para compatibilidade com as classes do sistema
        $conn = new ModelWrapper($testDbConn);
    } catch (Exception $e) {
        die("❌ Erro ao conectar ao banco de dados de teste: " . $e->getMessage() . "\n");
    }
    
    // Inicializar o banco de dados de teste (criar tabelas)
    if (!resetTestDatabase($testDbConn)) {
        die("❌ Falha ao inicializar o banco de dados de teste\n");
    }
    
    // Inicializar e executar o teste
    $test = new $testClass($testDbConn);
    $results = $test->run();
    
    // Limpar dados após a execução
    if (method_exists($test, 'tearDown')) {
        $test->tearDown();
    }
    
    return $results;
}

// Executar todos os testes ou o teste específico
if ($testToRun === null) {
    echo "Executando todos os testes...\n\n";
    
    $totalTests = 0;
    $passedTests = 0;
    
    foreach ($availableTests as $key => $testClass) {
        echo ">> Iniciando teste: $key\n";
        
        // Reinicializar o banco de dados para cada teste
        echo "   Preparando ambiente de teste isolado...\n";
        $results = runTest($testClass);
        
        foreach ($results as $name => $result) {
            $totalTests++;
            if ($result['success']) {
                $passedTests++;
                echo "  ✓ " . $result['message'] . "\n";
            } else {
                echo "  ❌ FALHA: " . $result['message'] . "\n";
            }
        }
        
        echo "\n";
    }
    
    // Resumo final
    echo "=======================================================\n";
    echo "Resumo dos testes: $passedTests/$totalTests testes passaram\n";
    if ($passedTests == $totalTests) {
        echo "✅ TODOS OS TESTES PASSARAM\n";
    } else {
        echo "❌ ALGUNS TESTES FALHARAM\n";
    }
    echo "=======================================================\n";
} else {
    echo "Executando teste: $testToRun\n\n";
    
    $testClass = $availableTests[$testToRun];
    $results = runTest($testClass);
    
    $totalTests = count($results);
    $passedTests = 0;
    
    foreach ($results as $name => $result) {
        if ($result['success']) {
            $passedTests++;
            echo "✓ " . $result['message'] . "\n";
        } else {
            echo "❌ FALHA: " . $result['message'] . "\n";
        }
    }
    
    // Resumo final
    echo "\n=======================================================\n";
    echo "Resumo dos testes: $passedTests/$totalTests testes passaram\n";
    if ($passedTests == $totalTests) {
        echo "✅ TODOS OS TESTES PASSARAM\n";
    } else {
        echo "❌ ALGUNS TESTES FALHARAM\n";
    }
    echo "=======================================================\n";
}
?> 