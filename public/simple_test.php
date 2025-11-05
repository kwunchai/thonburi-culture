    <?php
// Simple PHP test - no Laravel dependencies

echo "Simple PHP Test Works!<br>";
echo "Server: " . $_SERVER['SERVER_NAME'] . "<br>";
echo "Script: " . $_SERVER['SCRIPT_NAME'] . "<br>";
echo "Request: " . $_SERVER['REQUEST_URI'] . "<br>";

// Test basic database connection
try {
    $pdo = new PDO("mysql:host=127.0.0.1;dbname=thonburi_culture", "root", "");
    echo "Database connection: OK<br>";
    
    // Test simple query
    $stmt = $pdo->query("SELECT COUNT(*) FROM intellectual_properties");
    $count = $stmt->fetchColumn();
    echo "IP Records: $count<br>";
    
} catch (Exception $e) {
    echo "Database error: " . $e->getMessage() . "<br>";
}
?>