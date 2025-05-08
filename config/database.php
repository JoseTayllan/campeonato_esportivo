<?php
// Define MySQLi constants for compatibility
if (!defined('MYSQLI_ASSOC')) define('MYSQLI_ASSOC', 1);
if (!defined('MYSQLI_NUM')) define('MYSQLI_NUM', 2);
if (!defined('MYSQLI_BOTH')) define('MYSQLI_BOTH', 3);

// Define SQLite database path - relative to the project root
$db_path = __DIR__ . '/../db/championship.sqlite';

// Create PDO connection
try {
    // Check if the directory exists, if not create it
    $db_dir = dirname($db_path);
    if (!file_exists($db_dir)) {
        mkdir($db_dir, 0755, true);
    }
    
    // Create PDO connection
    $conn = new PDO("sqlite:" . $db_path);
    
    // Set error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Enable foreign keys (SQLite has them disabled by default)
    $conn->exec("PRAGMA foreign_keys = ON");
    
    // Set default fetch mode to associative array
    $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    
    // Enable the SQLite WAL (Write-Ahead Logging) journal mode
    // This helps with concurrency and is more resilient to corruption
    $conn->exec("PRAGMA journal_mode = WAL");
    
    // Set a reasonable busy timeout (milliseconds)
    $conn->exec("PRAGMA busy_timeout = 5000");
    
} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// For backward compatibility with code that uses mysqli
class SQLiteMysqlCompat {
    private $pdo;
    
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
    
    public function query($sql) {
        // Convert MySQL-specific queries to SQLite
        $sql = $this->convertMysqlToSqlite($sql);
        
        try {
            $stmt = $this->pdo->query($sql);
            return new SQLiteResult($stmt);
        } catch (PDOException $e) {
            error_log("SQLite query error: " . $e->getMessage() . " in query: " . $sql);
            return false;
        }
    }
    
    public function prepare($sql) {
        // Convert MySQL-specific SQL to SQLite
        $sql = $this->convertMysqlToSqlite($sql);
        
        try {
            $stmt = $this->pdo->prepare($sql);
            return new SQLitePreparedStatement($stmt, $this->pdo);
        } catch (PDOException $e) {
            error_log("SQLite prepare error: " . $e->getMessage() . " in query: " . $sql);
            return false;
        }
    }
    
    public function real_escape_string($string) {
        // No direct equivalent in PDO, using a simple escaping method
        return SQLite3::escapeString($string);
    }
    
    public function insert_id() {
        return $this->pdo->lastInsertId();
    }
    
    public function affected_rows() {
        // This information is available from the statement, not connection
        // Will need to be handled differently
        return 0; // Default to 0
    }
    
    public function error() {
        $error = $this->pdo->errorInfo();
        return $error[2];
    }
    
    private function convertMysqlToSqlite($sql) {
        // Replace some MySQL specific syntax with SQLite equivalents
        $replacements = [
            // AUTO_INCREMENT replacement
            '/AUTO_INCREMENT/i' => 'AUTOINCREMENT',
            
            // ENGINE definition removal
            '/ENGINE\s*=\s*\w+/i' => '',
            
            // CHARSET and COLLATE removal
            '/CHARACTER SET \w+/i' => '',
            '/COLLATE \w+/i' => '',
            
            // Replace MySQL date functions
            '/NOW\(\)/i' => "datetime('now', 'localtime')",
            '/CURDATE\(\)/i' => "date('now', 'localtime')",
            '/CURRENT_TIMESTAMP/i' => "datetime('now', 'localtime')",
            
            // Replace LIMIT with offset syntax if needed
            '/LIMIT\s+(\d+)\s*,\s*(\d+)/i' => 'LIMIT $2 OFFSET $1'
        ];
        
        return preg_replace(array_keys($replacements), array_values($replacements), $sql);
    }
}

class SQLitePreparedStatement {
    private $stmt;
    private $pdo;
    
    public function __construct($stmt, $pdo) {
        $this->stmt = $stmt;
        $this->pdo = $pdo;
    }
    
    public function bind_param($types, ...$params) {
        // In PDO, we bind parameters differently
        $paramCount = count($params);
        for ($i = 0; $i < $paramCount; $i++) {
            $type = $types[$i] ?? 's'; // Default to string if not specified
            $paramType = PDO::PARAM_STR; // Default to string
            
            switch ($type) {
                case 'i':
                    $paramType = PDO::PARAM_INT;
                    break;
                case 'd':
                    $paramType = PDO::PARAM_STR; // Use string for float/double
                    break;
                case 'b':
                    $paramType = PDO::PARAM_LOB;
                    break;
            }
            
            // PDO parameters are 1-indexed
            $this->stmt->bindValue($i + 1, $params[$i], $paramType);
        }
        
        return true;
    }
    
    public function execute($params = null) {
        if ($params !== null) {
            // If params are provided, bind them automatically
            foreach ($params as $key => $value) {
                $paramType = is_int($value) ? PDO::PARAM_INT : PDO::PARAM_STR;
                
                // Check if the key is numeric or named
                if (is_int($key)) {
                    // 1-indexed
                    $this->stmt->bindValue($key + 1, $value, $paramType);
                } else {
                    // Named parameter
                    $this->stmt->bindValue($key, $value, $paramType);
                }
            }
        }
        
        return $this->stmt->execute();
    }
    
    public function get_result() {
        // For mysqli compatibility - return self so methods can be chained
        $this->stmt->execute();
        return $this;
    }
    
    public function fetch_all($mode = null) {
        // Convert mysqli constants to PDO constants
        $fetchMode = $this->convertFetchMode($mode);
        
        return $this->stmt->fetchAll($fetchMode);
    }
    
    public function fetch_assoc() {
        return $this->stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public function fetch_row() {
        return $this->stmt->fetch(PDO::FETCH_NUM);
    }
    
    public function fetch($mode = null) {
        $fetchMode = $this->convertFetchMode($mode);
        return $this->stmt->fetch($fetchMode);
    }
    
    private function convertFetchMode($mode) {
        // Convert from mysqli constants to PDO constants
        if (!defined('MYSQLI_ASSOC')) define('MYSQLI_ASSOC', 1);
        if (!defined('MYSQLI_NUM')) define('MYSQLI_NUM', 2);
        if (!defined('MYSQLI_BOTH')) define('MYSQLI_BOTH', 3);
        
        switch ($mode) {
            case MYSQLI_ASSOC:
                return PDO::FETCH_ASSOC;
            case MYSQLI_NUM:
                return PDO::FETCH_NUM;
            case MYSQLI_BOTH:
                return PDO::FETCH_BOTH;
            default:
                return PDO::FETCH_ASSOC; // Default to ASSOC
        }
    }
    
    public function close() {
        $this->stmt = null;
    }
    
    public function num_rows() {
        // PDO doesn't have an equivalent, this is just an approximation
        $data = $this->stmt->fetchAll();
        $count = count($data);
        
        // Reset the cursor for future fetches
        $this->stmt->execute();
        
        return $count;
    }
}

class SQLiteResult {
    private $stmt;
    private $results = [];
    private $position = 0;
    
    public function __construct($stmt) {
        $this->stmt = $stmt;
        $this->results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function fetch_assoc() {
        if ($this->position < count($this->results)) {
            return $this->results[$this->position++];
        }
        return false;
    }
    
    public function fetch_array($type = null) {
        if ($this->position < count($this->results)) {
            $row = $this->results[$this->position++];
            if (!defined('MYSQLI_NUM')) define('MYSQLI_NUM', 2);
            if ($type === MYSQLI_NUM) {
                return array_values($row);
            } else {
                return $row;
            }
        }
        return false;
    }
    
    public function fetch_all($mode = null) {
        // Convert mysqli constants to PDO constants
        if (!defined('MYSQLI_ASSOC')) define('MYSQLI_ASSOC', 1);
        if (!defined('MYSQLI_NUM')) define('MYSQLI_NUM', 2);
        if (!defined('MYSQLI_BOTH')) define('MYSQLI_BOTH', 3);
        
        switch ($mode) {
            case MYSQLI_NUM:
                return array_map('array_values', $this->results);
            case MYSQLI_BOTH:
                $result = [];
                foreach ($this->results as $row) {
                    $newRow = array_values($row);
                    foreach ($row as $key => $value) {
                        $newRow[$key] = $value;
                    }
                    $result[] = $newRow;
                }
                return $result;
            case MYSQLI_ASSOC:
            default:
                return $this->results;
        }
    }
    
    public function num_rows() {
        return count($this->results);
    }
    
    public function free() {
        $this->stmt = null;
        $this->results = [];
    }
}

// For backward compatibility, wrap PDO connection with compatibility layer
$mysqli_compat = new SQLiteMysqlCompat($conn);

// Make connection available
return $conn;
?>
