<?php
/**
 * Teste para verificar o funcionamento correto do gerenciamento de campeonatos
 * 
 * Este teste verifica se é possível criar, buscar, listar, atualizar e excluir
 * campeonatos, assim como associar times a campeonatos.
 */
class CampeonatoTest
{
    private $conn;
    private $testFramework;
    private $campeonatoIDs = [];
    private $timeID = null;
    
    /**
     * Construtor - inicializa o teste com uma conexão ao banco de dados de teste
     * @param PDO $conn Conexão com o banco de dados
     */
    public function __construct($conn)
    {
        $this->conn = $conn;
        $this->testFramework = new TestFramework($conn);
        
        // Configurar dados iniciais para o teste
        $this->setupInitialData();
        
        // Registrar testes
        $this->registerTests();
    }
    
    /**
     * Configura dados iniciais para o teste
     */
    private function setupInitialData()
    {
        // Criar um time de teste para usar nos campeonatos
        $stmt = $this->conn->prepare("
            INSERT INTO times (nome, abreviacao, codigo, ativo) 
            VALUES (?, ?, ?, 1)
        ");
        $nome = "Time Teste";
        $abreviacao = "TST";
        $codigo = "TIME" . rand(1000, 9999);
        $stmt->execute([$nome, $abreviacao, $codigo]);
        $this->timeID = $this->conn->lastInsertId();
    }
    
    /**
     * Registra todos os testes a serem executados
     */
    private function registerTests()
    {
        // Teste 1: Criar campeonato de futebol
        $this->testFramework->registerTest('criar_campeonato_futebol', function() {
            $nome = "Campeonato de Futebol Teste";
            $descricao = "Descrição de teste";
            $modalidade = "Futebol";
            
            $stmt = $this->conn->prepare("
                INSERT INTO campeonatos (nome, descricao, modalidade, ativo) 
                VALUES (?, ?, ?, 1)
            ");
            $stmt->execute([$nome, $descricao, $modalidade]);
            $id = $this->conn->lastInsertId();
            $this->campeonatoIDs[] = $id;
            
            // Verificar se foi criado corretamente
            $stmt = $this->conn->prepare("SELECT * FROM campeonatos WHERE id_campeonato = ?");
            $stmt->execute([$id]);
            $campeonato = $stmt->fetch();
            
            $this->testFramework->assertEquals($nome, $campeonato['nome'], "O nome do campeonato não corresponde");
            $this->testFramework->assertEquals($modalidade, $campeonato['modalidade'], "A modalidade do campeonato não corresponde");
            
            return "Campeonato de Futebol criado com sucesso (ID: $id)";
        });
        
        // Teste 2: Criar campeonato de outra modalidade
        $this->testFramework->registerTest('criar_campeonato_volei', function() {
            $nome = "Campeonato de Vôlei Teste";
            $descricao = "Descrição de teste para vôlei";
            $modalidade = "Vôlei";
            
            $stmt = $this->conn->prepare("
                INSERT INTO campeonatos (nome, descricao, modalidade, ativo) 
                VALUES (?, ?, ?, 1)
            ");
            $stmt->execute([$nome, $descricao, $modalidade]);
            $id = $this->conn->lastInsertId();
            $this->campeonatoIDs[] = $id;
            
            // Verificar se foi criado corretamente
            $stmt = $this->conn->prepare("SELECT * FROM campeonatos WHERE id_campeonato = ?");
            $stmt->execute([$id]);
            $campeonato = $stmt->fetch();
            
            $this->testFramework->assertEquals($nome, $campeonato['nome'], "O nome do campeonato não corresponde");
            $this->testFramework->assertEquals($modalidade, $campeonato['modalidade'], "A modalidade do campeonato não corresponde");
            
            return "Campeonato de Vôlei criado com sucesso (ID: $id)";
        });
        
        // Teste 3: Buscar campeonato por ID
        $this->testFramework->registerTest('buscar_campeonato', function() {
            if (empty($this->campeonatoIDs)) {
                throw new Exception("Não há campeonatos para buscar");
            }
            
            $id = $this->campeonatoIDs[0];
            
            $stmt = $this->conn->prepare("SELECT * FROM campeonatos WHERE id_campeonato = ?");
            $stmt->execute([$id]);
            $campeonato = $stmt->fetch();
            
            $this->testFramework->assertTrue(!empty($campeonato), "Campeonato não encontrado");
            
            return "Campeonato encontrado com sucesso (ID: $id)";
        });
        
        // Teste 4: Listar todos os campeonatos
        $this->testFramework->registerTest('listar_campeonatos', function() {
            $stmt = $this->conn->query("SELECT * FROM campeonatos");
            $campeonatos = $stmt->fetchAll();
            
            $this->testFramework->assertTrue(count($campeonatos) >= count($this->campeonatoIDs), 
                "O número de campeonatos encontrados não corresponde ao esperado");
            
            return "Listagem de campeonatos realizada com sucesso (" . count($campeonatos) . " encontrados)";
        });
        
        // Teste 5: Associar time a campeonato
        $this->testFramework->registerTest('associar_time_campeonato', function() {
            if (empty($this->campeonatoIDs) || !$this->timeID) {
                throw new Exception("Não há campeonatos ou times para associar");
            }
            
            $id_campeonato = $this->campeonatoIDs[0];
            
            $stmt = $this->conn->prepare("
                INSERT INTO campeonato_times (id_campeonato, id_time) 
                VALUES (?, ?)
            ");
            $stmt->execute([$id_campeonato, $this->timeID]);
            
            // Verificar se a associação foi criada
            $stmt = $this->conn->prepare("
                SELECT * FROM campeonato_times 
                WHERE id_campeonato = ? AND id_time = ?
            ");
            $stmt->execute([$id_campeonato, $this->timeID]);
            $associacao = $stmt->fetch();
            
            $this->testFramework->assertTrue(!empty($associacao), 
                "A associação entre campeonato e time não foi encontrada");
            
            return "Time associado ao campeonato com sucesso";
        });
        
        // Teste 6: Atualizar campeonato
        $this->testFramework->registerTest('atualizar_campeonato', function() {
            if (empty($this->campeonatoIDs)) {
                throw new Exception("Não há campeonatos para atualizar");
            }
            
            $id = $this->campeonatoIDs[0];
            $novoNome = "Campeonato Atualizado";
            
            $stmt = $this->conn->prepare("
                UPDATE campeonatos 
                SET nome = ? 
                WHERE id_campeonato = ?
            ");
            $stmt->execute([$novoNome, $id]);
            
            // Verificar se foi atualizado
            $stmt = $this->conn->prepare("SELECT nome FROM campeonatos WHERE id_campeonato = ?");
            $stmt->execute([$id]);
            $campeonato = $stmt->fetch();
            
            $this->testFramework->assertEquals($novoNome, $campeonato['nome'], 
                "O nome do campeonato não foi atualizado corretamente");
            
            return "Campeonato atualizado com sucesso";
        });
    }
    
    /**
     * Executa todos os testes registrados
     * @return array Resultados dos testes
     */
    public function run()
    {
        return $this->testFramework->runTests();
    }
    
    /**
     * Limpa os dados criados durante o teste
     */
    public function tearDown()
    {
        try {
            // Remover associações de campeonatos e times
            if (!empty($this->campeonatoIDs)) {
                foreach ($this->campeonatoIDs as $id) {
                    $stmt = $this->conn->prepare("DELETE FROM campeonato_times WHERE id_campeonato = ?");
                    $stmt->execute([$id]);
                }
            }
            
            // Remover campeonatos
            if (!empty($this->campeonatoIDs)) {
                foreach ($this->campeonatoIDs as $id) {
                    $stmt = $this->conn->prepare("DELETE FROM campeonatos WHERE id_campeonato = ?");
                    $stmt->execute([$id]);
                }
            }
            
            // Remover time de teste
            if ($this->timeID) {
                $stmt = $this->conn->prepare("DELETE FROM times WHERE id_time = ?");
                $stmt->execute([$this->timeID]);
            }
        } catch (Exception $e) {
            echo "Erro ao limpar dados de teste: " . $e->getMessage() . "\n";
        }
    }
} 