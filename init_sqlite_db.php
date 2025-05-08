<?php
/**
 * SQLite Database Initialization Script
 * Run this script to create and initialize the SQLite database
 */

echo "Initializing SQLite database...\n";

// Define paths
$db_path = __DIR__ . '/db/championship.sqlite';
$schema_path = __DIR__ . '/db/schema.sqlite.sql';

// Check if schema file exists
if (!file_exists($schema_path)) {
    die("Error: Schema file not found at $schema_path\n");
}

// Check if the directory exists, if not create it
$db_dir = dirname($db_path);
if (!file_exists($db_dir)) {
    echo "Creating database directory...\n";
    if (!mkdir($db_dir, 0755, true)) {
        die("Error: Failed to create database directory\n");
    }
}

// Remove existing database if it exists
if (file_exists($db_path)) {
    echo "Removing existing database...\n";
    unlink($db_path);
}

// Create PDO connection
try {
    echo "Creating new database...\n";
    $pdo = new PDO("sqlite:$db_path");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Enable foreign keys
    $pdo->exec("PRAGMA foreign_keys = ON");
    
    // Read and execute schema file
    echo "Executing schema...\n";
    $schema = file_get_contents($schema_path);
    
    // Split statements by semicolon
    $statements = array_filter(array_map('trim', explode(';', $schema)), 'strlen');
    
    // Execute each statement
    foreach ($statements as $statement) {
        $pdo->exec($statement);
    }
    
    echo "Setting up WAL mode...\n";
    $pdo->exec("PRAGMA journal_mode = WAL");
    
    echo "Database initialization complete!\n";
    echo "SQLite database created at: $db_path\n";
    
} catch (PDOException $e) {
    die("Database initialization failed: " . $e->getMessage() . "\n");
}

// Insert sample data if needed
$insert_sample_data = false; // Change to true to insert sample data

if ($insert_sample_data) {
    try {
        echo "Inserting sample data...\n";
        
        // Sample usuarios (users)
        $pdo->exec("INSERT INTO usuarios (nome, email, senha, tipo) 
                   VALUES ('Admin', 'admin@example.com', '" . password_hash('admin123', PASSWORD_DEFAULT) . "', 'Administrador')");
        
        $pdo->exec("INSERT INTO usuarios (nome, email, senha, tipo) 
                   VALUES ('Organizador', 'organizador@example.com', '" . password_hash('organizador123', PASSWORD_DEFAULT) . "', 'Organizador')");
        
        // Sample times (teams)
        $pdo->exec("INSERT INTO times (nome, cidade, estadio) VALUES ('Time A', 'Cidade A', 'Estádio A')");
        $pdo->exec("INSERT INTO times (nome, cidade, estadio) VALUES ('Time B', 'Cidade B', 'Estádio B')");
        
        // Sample campeonato (championship)
        $pdo->exec("INSERT INTO campeonatos (nome, descricao, temporada, formato, criado_por) 
                   VALUES ('Campeonato 2024', 'Campeonato de Futebol', 2024, 'Pontos Corridos', 1)");
        
        echo "Sample data inserted successfully!\n";
    } catch (PDOException $e) {
        echo "Warning: Failed to insert sample data: " . $e->getMessage() . "\n";
    }
}

echo "\nDatabase initialization complete!\n";
echo "You can now use the SQLite database in your application.\n";
?> 