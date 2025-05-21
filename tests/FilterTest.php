<?php
/**
 * Teste para verificar o funcionamento correto dos filtros por modalidade
 * 
 * Este teste verifica se o sistema consegue filtrar corretamente os campeonatos
 * por modalidade esportiva, retornando apenas os campeonatos ativos da
 * modalidade selecionada.
 */
class FilterTest
{
    private $conn;
    private $testFramework;
    private $campeonatoIDs = [];
    
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
     * Cria campeonatos de diferentes modalidades
     */
    private function setupInitialData()
    {
        // Criar campeonatos de teste para várias modalidades
        $modalidades = ['Futebol', 'Queimada', 'Natação', 'Vôlei'];
        
        foreach ($modalidades as $modalidade) {
            // Criar 2 campeonatos ativos para cada modalidade
            for ($i = 1; $i <= 2; $i++) {
                $stmt = $this->conn->prepare("
                    INSERT INTO campeonatos (
                        nome, descricao, modalidade, ativo
                    ) VALUES (?, ?, ?, 1)
                ");
                $nome = "Campeonato de $modalidade $i";
                $descricao = "Descrição do campeonato de $modalidade $i";
                $stmt->execute([$nome, $descricao, $modalidade]);
                $this->campeonatoIDs[] = $this->conn->lastInsertId();
            }
            
            // Criar 1 campeonato inativo para cada modalidade
            $stmt = $this->conn->prepare("
                INSERT INTO campeonatos (
                    nome, descricao, modalidade, ativo
                ) VALUES (?, ?, ?, 0)
            ");
            $nome = "Campeonato de $modalidade Inativo";
            $descricao = "Descrição do campeonato inativo de $modalidade";
            $stmt->execute([$nome, $descricao, $modalidade]);
            $this->campeonatoIDs[] = $this->conn->lastInsertId();
        }
    }
    
    /**
     * Registra todos os testes a serem executados
     */
    private function registerTests()
    {
        // Teste 1: Listar todos os campeonatos ativos
        $this->testFramework->registerTest('listar_todos_ativos', function() {
            $stmt = $this->conn->prepare("
                SELECT * FROM campeonatos WHERE ativo = 1
            ");
            $stmt->execute();
            $campeonatos = $stmt->fetchAll();
            
            // Devem existir 8 campeonatos ativos (2 para cada uma das 4 modalidades)
            $this->testFramework->assertEquals(8, count($campeonatos), 
                "Número incorreto de campeonatos ativos");
            
            return "Todos os campeonatos ativos listados com sucesso: " . count($campeonatos);
        });
        
        // Teste 2: Filtrar campeonatos ativos de Futebol
        $this->testFramework->registerTest('filtrar_futebol', function() {
            $modalidade = 'Futebol';
            $stmt = $this->conn->prepare("
                SELECT * FROM campeonatos 
                WHERE modalidade = ? AND ativo = 1
            ");
            $stmt->execute([$modalidade]);
            $campeonatos = $stmt->fetchAll();
            
            // Devem existir 2 campeonatos ativos de Futebol
            $this->testFramework->assertEquals(2, count($campeonatos), 
                "Número incorreto de campeonatos ativos de $modalidade");
            
            // Verificar se todos os campeonatos retornados são realmente de Futebol
            foreach ($campeonatos as $campeonato) {
                $this->testFramework->assertEquals($modalidade, $campeonato['modalidade'],
                    "Campeonato com modalidade incorreta encontrado");
            }
            
            return "Campeonatos de $modalidade filtrados com sucesso: " . count($campeonatos);
        });
        
        // Teste 3: Filtrar campeonatos ativos de Queimada
        $this->testFramework->registerTest('filtrar_queimada', function() {
            $modalidade = 'Queimada';
            $stmt = $this->conn->prepare("
                SELECT * FROM campeonatos 
                WHERE modalidade = ? AND ativo = 1
            ");
            $stmt->execute([$modalidade]);
            $campeonatos = $stmt->fetchAll();
            
            // Devem existir 2 campeonatos ativos de Queimada
            $this->testFramework->assertEquals(2, count($campeonatos), 
                "Número incorreto de campeonatos ativos de $modalidade");
            
            // Verificar se todos os campeonatos retornados são realmente de Queimada
            foreach ($campeonatos as $campeonato) {
                $this->testFramework->assertEquals($modalidade, $campeonato['modalidade'],
                    "Campeonato com modalidade incorreta encontrado");
            }
            
            return "Campeonatos de $modalidade filtrados com sucesso: " . count($campeonatos);
        });
        
        // Teste 4: Filtrar campeonatos ativos de Natação
        $this->testFramework->registerTest('filtrar_natacao', function() {
            $modalidade = 'Natação';
            $stmt = $this->conn->prepare("
                SELECT * FROM campeonatos 
                WHERE modalidade = ? AND ativo = 1
            ");
            $stmt->execute([$modalidade]);
            $campeonatos = $stmt->fetchAll();
            
            // Devem existir 2 campeonatos ativos de Natação
            $this->testFramework->assertEquals(2, count($campeonatos), 
                "Número incorreto de campeonatos ativos de $modalidade");
            
            // Verificar se todos os campeonatos retornados são realmente de Natação
            foreach ($campeonatos as $campeonato) {
                $this->testFramework->assertEquals($modalidade, $campeonato['modalidade'],
                    "Campeonato com modalidade incorreta encontrado");
            }
            
            return "Campeonatos de $modalidade filtrados com sucesso: " . count($campeonatos);
        });
        
        // Teste 5: Filtrar campeonatos ativos de Vôlei
        $this->testFramework->registerTest('filtrar_volei', function() {
            $modalidade = 'Vôlei';
            $stmt = $this->conn->prepare("
                SELECT * FROM campeonatos 
                WHERE modalidade = ? AND ativo = 1
            ");
            $stmt->execute([$modalidade]);
            $campeonatos = $stmt->fetchAll();
            
            // Devem existir 2 campeonatos ativos de Vôlei
            $this->testFramework->assertEquals(2, count($campeonatos), 
                "Número incorreto de campeonatos ativos de $modalidade");
            
            // Verificar se todos os campeonatos retornados são realmente de Vôlei
            foreach ($campeonatos as $campeonato) {
                $this->testFramework->assertEquals($modalidade, $campeonato['modalidade'],
                    "Campeonato com modalidade incorreta encontrado");
            }
            
            return "Campeonatos de $modalidade filtrados com sucesso: " . count($campeonatos);
        });
        
        // Teste 6: Filtrar campeonatos de uma modalidade inexistente
        $this->testFramework->registerTest('filtrar_modalidade_inexistente', function() {
            $modalidade = 'Basquete'; // Modalidade que não existe no banco
            $stmt = $this->conn->prepare("
                SELECT * FROM campeonatos 
                WHERE modalidade = ? AND ativo = 1
            ");
            $stmt->execute([$modalidade]);
            $campeonatos = $stmt->fetchAll();
            
            // Não deve existir nenhum campeonato dessa modalidade
            $this->testFramework->assertEquals(0, count($campeonatos), 
                "Foram encontrados campeonatos de uma modalidade inexistente");
            
            return "Filtro para modalidade inexistente funcionou corretamente: 0 resultados";
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
            // Remover campeonatos
            if (!empty($this->campeonatoIDs)) {
                foreach ($this->campeonatoIDs as $id) {
                    $stmt = $this->conn->prepare("DELETE FROM campeonatos WHERE id_campeonato = ?");
                    $stmt->execute([$id]);
                }
            }
        } catch (Exception $e) {
            echo "Erro ao limpar dados de teste: " . $e->getMessage() . "\n";
        }
    }
} 