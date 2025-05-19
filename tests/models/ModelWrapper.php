<?php
/**
 * Model Wrapper para Testes
 * 
 * Esta classe fornece uma camada de compatibilidade entre PDO (usado nos testes)
 * e mysqli (usado na produção). Isso permite que as classes do sistema funcionem
 * corretamente no ambiente de testes sem modificações.
 */
class ModelWrapper {
    private $pdo;
    
    /**
     * Construtor
     * @param PDO $pdo Conexão PDO para o banco de dados de teste
     */
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
    
    /**
     * Executa uma consulta SQL
     * @param string $sql Consulta SQL a ser executada
     * @return ModelResultWrapper Resultado da consulta
     */
    public function query($sql) {
        try {
            $stmt = $this->pdo->query($sql);
            return new ModelResultWrapper($stmt);
        } catch (PDOException $e) {
            echo "Erro na consulta: " . $e->getMessage() . "\n";
            return false;
        }
    }
    
    /**
     * Prepara uma consulta SQL parametrizada
     * @param string $sql Consulta SQL a ser preparada
     * @return ModelStatementWrapper Statement preparado
     */
    public function prepare($sql) {
        try {
            $stmt = $this->pdo->prepare($sql);
            return new ModelStatementWrapper($stmt, $this);
        } catch (PDOException $e) {
            echo "Erro ao preparar consulta: " . $e->getMessage() . "\n";
            return false;
        }
    }
    
    /**
     * Escapa uma string para uso seguro em consultas SQL
     * @param string $string String a ser escapada
     * @return string String escapada
     */
    public function real_escape_string($string) {
        return str_replace("'", "''", $string);
    }
    
    /**
     * Inicia uma transação
     * @return bool Sucesso ou falha
     */
    public function begin_transaction() {
        return $this->pdo->beginTransaction();
    }
    
    /**
     * Confirma uma transação
     * @return bool Sucesso ou falha
     */
    public function commit() {
        return $this->pdo->commit();
    }
    
    /**
     * Desfaz uma transação
     * @return bool Sucesso ou falha
     */
    public function rollback() {
        return $this->pdo->rollBack();
    }
    
    /**
     * Obtém o ID da última inserção
     * @return int ID da última inserção
     */
    public function __get($name) {
        if ($name === 'insert_id') {
            return $this->pdo->lastInsertId();
        }
        return null;
    }
}

/**
 * Wrapper para os resultados de consultas
 */
class ModelResultWrapper {
    private $stmt;
    private $results;
    
    /**
     * Construtor
     * @param PDOStatement $stmt Statement PDO
     */
    public function __construct($stmt) {
        $this->stmt = $stmt;
        $this->results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    /**
     * Obtém todas as linhas do resultado
     * @return array Linhas do resultado
     */
    public function fetch_all() {
        return $this->results;
    }
    
    /**
     * Obtém a próxima linha do resultado
     * @return array|null Linha do resultado ou null se não houver mais linhas
     */
    public function fetch_assoc() {
        $row = array_shift($this->results);
        if ($row === null) {
            return null;
        }
        return $row;
    }
    
    /**
     * Obtém a quantidade de linhas no resultado
     * @return int Quantidade de linhas
     */
    public function num_rows() {
        return count($this->results);
    }
}

/**
 * Wrapper para statements preparados
 */
class ModelStatementWrapper {
    private $stmt;
    private $parent;
    
    /**
     * Construtor
     * @param PDOStatement $stmt Statement PDO
     * @param ModelWrapper $parent Referência ao wrapper principal
     */
    public function __construct($stmt, $parent) {
        $this->stmt = $stmt;
        $this->parent = $parent;
    }
    
    /**
     * Vincula parâmetros ao statement
     * @param string $types Tipos dos parâmetros (não usado no PDO, apenas por compatibilidade)
     * @param mixed ...$params Parâmetros a serem vinculados
     * @return bool Sucesso ou falha
     */
    public function bind_param($types, ...$params) {
        try {
            for ($i = 0; $i < count($params); $i++) {
                $this->stmt->bindValue($i + 1, $params[$i]);
            }
            return true;
        } catch (PDOException $e) {
            echo "Erro ao vincular parâmetros: " . $e->getMessage() . "\n";
            return false;
        }
    }
    
    /**
     * Executa o statement preparado
     * @return bool Sucesso ou falha
     */
    public function execute() {
        try {
            return $this->stmt->execute();
        } catch (PDOException $e) {
            echo "Erro ao executar statement: " . $e->getMessage() . "\n";
            return false;
        }
    }
    
    /**
     * Obtém o resultado da execução
     * @return ModelResultWrapper Resultado da execução
     */
    public function get_result() {
        return new ModelResultWrapper($this->stmt);
    }
}
?> 