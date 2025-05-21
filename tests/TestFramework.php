<?php
/**
 * TestFramework para os testes do ChampCore
 * 
 * Esta classe fornece a base para os testes automatizados,
 * permitindo o registro e execução de testes de forma organizada.
 */
class TestFramework
{
    private $conn;
    private $tests = [];
    private $results = [];
    
    /**
     * Construtor
     * @param PDO $conn Conexão com o banco de dados de teste
     */
    public function __construct($conn)
    {
        $this->conn = $conn;
    }
    
    /**
     * Registra um teste para execução posterior
     * @param string $name Nome do teste
     * @param callable $callback Função que executa o teste
     */
    public function registerTest($name, $callback)
    {
        $this->tests[$name] = $callback;
    }
    
    /**
     * Executa todos os testes registrados
     * @return array Resultados dos testes
     */
    public function runTests()
    {
        foreach ($this->tests as $name => $callback) {
            try {
                $result = call_user_func($callback);
                $this->results[$name] = [
                    'success' => true,
                    'message' => $result ?: "Test '$name' passed"
                ];
            } catch (Exception $e) {
                $this->results[$name] = [
                    'success' => false,
                    'message' => $e->getMessage()
                ];
            }
        }
        return $this->results;
    }
    
    /**
     * Obtém a conexão com o banco de dados
     * @return PDO Conexão com o banco de dados
     */
    public function getConnection()
    {
        return $this->conn;
    }
    
    /**
     * Verifica se dois valores são iguais
     * @param mixed $expected Valor esperado
     * @param mixed $actual Valor real
     * @param string $message Mensagem em caso de falha
     * @throws Exception Se os valores não forem iguais
     */
    public function assertEquals($expected, $actual, $message = null)
    {
        if ($expected !== $actual) {
            throw new Exception($message ?: "Esperado '$expected', obtido '$actual'");
        }
        return true;
    }
    
    /**
     * Verifica se uma condição é verdadeira
     * @param mixed $condition Condição a verificar
     * @param string $message Mensagem em caso de falha
     * @throws Exception Se a condição for falsa
     */
    public function assertTrue($condition, $message = null)
    {
        if (!$condition) {
            throw new Exception($message ?: "A condição avaliou como falsa");
        }
        return true;
    }
    
    /**
     * Verifica se uma condição é falsa
     * @param mixed $condition Condição a verificar
     * @param string $message Mensagem em caso de falha
     * @throws Exception Se a condição for verdadeira
     */
    public function assertFalse($condition, $message = null)
    {
        if ($condition) {
            throw new Exception($message ?: "A condição avaliou como verdadeira");
        }
        return true;
    }
    
    /**
     * Verifica se um valor não é nulo
     * @param mixed $value Valor a verificar
     * @param string $message Mensagem em caso de falha
     * @throws Exception Se o valor for nulo
     */
    public function assertNotNull($value, $message = null)
    {
        if ($value === null) {
            throw new Exception($message ?: "O valor é nulo");
        }
        return true;
    }
} 