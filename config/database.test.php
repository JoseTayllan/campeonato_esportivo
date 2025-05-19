<?php
/**
 * Configuração de Banco de Dados para Testes
 * 
 * Este arquivo contém as configurações de conexão com o banco de dados
 * específicas para o ambiente de testes. Por padrão, utiliza SQLite em memória
 * para garantir que os testes não afetem dados de produção.
 */

// Evitar que o arquivo de produção seja carregado
if (defined('TESTING')) {
    // Se já existe uma conexão com o banco de dados, feche-a para evitar conflitos
    if (isset($conn) && $conn instanceof mysqli) {
        $conn->close();
        $conn = null;
    }
}

// Por padrão, usamos SQLite em memória para testes
// Isso garante que os testes sejam rápidos e completamente isolados
$TEST_DB_TYPE = 'sqlite';
$TEST_DB_PATH = ':memory:';

// Alternativamente, é possível configurar para usar MySQL
// Descomente e configure as linhas abaixo para usar MySQL em vez de SQLite
/*
$TEST_DB_TYPE = 'mysql';
$TEST_DB_HOST = 'localhost';
$TEST_DB_USER = 'root';
$TEST_DB_PASS = '';
$TEST_DB_NAME = 'champcore_test';
*/

/**
 * Estabelece conexão com o banco de dados de teste
 * 
 * @return PDO Conexão com o banco de dados
 */
function getTestDatabaseConnection() {
    global $TEST_DB_TYPE, $TEST_DB_PATH, $TEST_DB_HOST, $TEST_DB_USER, $TEST_DB_PASS, $TEST_DB_NAME;
    
    try {
        if ($TEST_DB_TYPE === 'sqlite') {
            // SQLite em memória
            $pdo = new PDO('sqlite:' . $TEST_DB_PATH);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pdo;
        } else if ($TEST_DB_TYPE === 'mysql') {
            // MySQL para testes
            $dsn = "mysql:host=$TEST_DB_HOST;dbname=$TEST_DB_NAME;charset=utf8mb4";
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ];
            return new PDO($dsn, $TEST_DB_USER, $TEST_DB_PASS, $options);
        } else {
            throw new Exception("Tipo de banco de dados de teste não suportado: $TEST_DB_TYPE");
        }
    } catch (PDOException $e) {
        die("Erro de conexão com banco de dados de teste: " . $e->getMessage());
    }
}

/**
 * Inicializa/reseta o esquema do banco de dados de teste
 * Cria todas as tabelas necessárias para os testes
 * 
 * @param PDO $pdo Conexão com o banco de dados
 * @return bool Sucesso ou falha na inicialização
 */
function resetTestDatabase($pdo) {
    global $TEST_DB_TYPE;
    
    try {
        // Cria as tabelas principais necessárias para os testes
        
        // Tabela de campeonatos
        $pdo->exec("
            CREATE TABLE IF NOT EXISTS campeonatos (
                id_campeonato INTEGER PRIMARY KEY " . ($TEST_DB_TYPE === 'sqlite' ? 'AUTOINCREMENT' : 'AUTO_INCREMENT') . ",
                nome VARCHAR(255) NOT NULL,
                descricao TEXT,
                data_inicio DATE,
                data_fim DATE,
                codigo VARCHAR(20),
                logo VARCHAR(255),
                ativo TINYINT(1) DEFAULT 1,
                modalidade VARCHAR(50) DEFAULT 'Futebol',
                id_temporada INTEGER DEFAULT NULL,
                tipo VARCHAR(50) DEFAULT 'Pontos Corridos',
                aprovacao_resultado TINYINT(1) DEFAULT 0,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )
        ");
        
        // Tabela de times
        $pdo->exec("
            CREATE TABLE IF NOT EXISTS times (
                id_time INTEGER PRIMARY KEY " . ($TEST_DB_TYPE === 'sqlite' ? 'AUTOINCREMENT' : 'AUTO_INCREMENT') . ",
                nome VARCHAR(255) NOT NULL,
                abreviacao VARCHAR(10),
                escudo VARCHAR(255),
                cor_primaria VARCHAR(7),
                cor_secundaria VARCHAR(7),
                codigo VARCHAR(20),
                ativo TINYINT(1) DEFAULT 1,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )
        ");
        
        // Tabela de associação entre campeonatos e times
        $pdo->exec("
            CREATE TABLE IF NOT EXISTS campeonato_times (
                id INTEGER PRIMARY KEY " . ($TEST_DB_TYPE === 'sqlite' ? 'AUTOINCREMENT' : 'AUTO_INCREMENT') . ",
                id_campeonato INTEGER NOT NULL,
                id_time INTEGER NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                UNIQUE(id_campeonato, id_time)
            )
        ");
        
        // Tabela de partidas
        $pdo->exec("
            CREATE TABLE IF NOT EXISTS partidas (
                id_partida INTEGER PRIMARY KEY " . ($TEST_DB_TYPE === 'sqlite' ? 'AUTOINCREMENT' : 'AUTO_INCREMENT') . ",
                id_campeonato INTEGER NOT NULL,
                id_time_mandante INTEGER,
                id_time_visitante INTEGER,
                placar_mandante INTEGER DEFAULT 0,
                placar_visitante INTEGER DEFAULT 0,
                data_partida DATETIME,
                local VARCHAR(255),
                status VARCHAR(20) DEFAULT 'agendada',
                rodada INTEGER DEFAULT 1,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )
        ");
        
        return true;
    } catch (PDOException $e) {
        echo "Erro ao inicializar banco de dados de teste: " . $e->getMessage() . "\n";
        return false;
    }
}
?> 