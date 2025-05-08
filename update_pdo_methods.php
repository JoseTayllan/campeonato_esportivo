<?php
/**
 * Script to update MySQLi methods to PDO methods throughout the codebase
 * 
 * This script recursively scans PHP files and updates:
 * - fetch_assoc() to fetch(PDO::FETCH_ASSOC)
 * - fetch_all(MYSQLI_ASSOC) to fetchAll(PDO::FETCH_ASSOC)
 * - bind_param() to bindValue()
 * - get_result() calls are handled
 */

$rootDir = __DIR__;
$counter = [
    'files_scanned' => 0,
    'files_modified' => 0,
    'fetch_assoc_replacements' => 0,
    'fetch_all_replacements' => 0,
    'bind_param_replacements' => 0,
    'get_result_replacements' => 0
];

// Skip these directories
$skipDirs = [
    'vendor',
    'node_modules',
    '.git',
];

// Process directories recursively
processDirectory($rootDir, $counter);

// Print summary
echo "PDO Migration Summary:\n";
echo "Files scanned: {$counter['files_scanned']}\n";
echo "Files modified: {$counter['files_modified']}\n";
echo "fetch_assoc() replacements: {$counter['fetch_assoc_replacements']}\n";
echo "fetch_all(MYSQLI_ASSOC) replacements: {$counter['fetch_all_replacements']}\n";
echo "bind_param() replacements: {$counter['bind_param_replacements']}\n";
echo "get_result() replacements: {$counter['get_result_replacements']}\n";
echo "Migration completed!\n";

/**
 * Process a directory recursively
 */
function processDirectory($dir, &$counter) {
    global $skipDirs;
    
    $files = scandir($dir);
    
    foreach ($files as $file) {
        if ($file === '.' || $file === '..' || in_array($file, $skipDirs)) {
            continue;
        }
        
        $path = $dir . '/' . $file;
        
        if (is_dir($path)) {
            processDirectory($path, $counter);
        } elseif (pathinfo($path, PATHINFO_EXTENSION) === 'php') {
            processFile($path, $counter);
        }
    }
}

/**
 * Process a PHP file
 */
function processFile($filePath, &$counter) {
    $counter['files_scanned']++;
    $fileContent = file_get_contents($filePath);
    $originalContent = $fileContent;
    
    // Common MySQL to PDO replacements
    
    // 1. Replace ->fetch(PDO::FETCH_ASSOC) with ->fetch(PDO::FETCH_ASSOC)
    $fileContent = preg_replace(
        '/->fetch_assoc\(\)/',
        '->fetch(PDO::FETCH_ASSOC)',
        $fileContent,
        -1,
        $fetchAssocCount
    );
    $counter['fetch_assoc_replacements'] += $fetchAssocCount;
    
    // 2. Replace ->fetchAll(PDO::FETCH_ASSOC) with ->fetchAll(PDO::FETCH_ASSOC)
    $fileContent = preg_replace(
        '/->fetch_all\(\s*MYSQLI_ASSOC\s*\)/',
        '->fetchAll(PDO::FETCH_ASSOC)',
        $fileContent,
        -1,
        $fetchAllCount
    );
    $counter['fetch_all_replacements'] += $fetchAllCount;
    
    // 3. For get_result() chains, need to modify more carefully
    $fileContent = preg_replace_callback(
        '/->get_result\(\)->fetch(_assoc|_all\(MYSQLI_ASSOC\))/i',
        function($matches) use (&$counter) {
            $counter['get_result_replacements']++;
            if ($matches[1] === '_assoc') {
                return '->fetch(PDO::FETCH_ASSOC)';
            } else {
                return '->fetchAll(PDO::FETCH_ASSOC)';
            }
        },
        $fileContent
    );
    
    // 4. For simple get_result() calls - often followed by assignment - handle with care
    // This is complex and might need manual adjustment in some cases
    
    // 5. Handle bind_param with common patterns
    $fileContent = preg_replace_callback(
        '/->bind_param\(\s*"([isdbs]*)"\s*,\s*(.+)\)/i',
        function($matches) use (&$counter) {
            $counter['bind_param_replacements']++;
            $types = str_split($matches[1]);
            $params = explode(',', $matches[2]);
            
            $result = [];
            foreach ($types as $index => $type) {
                $param = trim($params[$index]);
                $pdoType = 'PDO::PARAM_STR'; // Default
                
                switch ($type) {
                    case 'i':
                        $pdoType = 'PDO::PARAM_INT';
                        break;
                    case 'b':
                        $pdoType = 'PDO::PARAM_LOB';
                        break;
                }
                
                $result[] = "->bindValue(" . ($index + 1) . ", $param, $pdoType)";
            }
            
            return implode(";\n    \$stmt", $result);
        },
        $fileContent
    );
    
    // Only write file if changes were made
    if ($fileContent !== $originalContent) {
        file_put_contents($filePath, $fileContent);
        $counter['files_modified']++;
        echo "Updated: $filePath\n";
    }
}
?> 