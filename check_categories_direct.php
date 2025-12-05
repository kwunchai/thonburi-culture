<?php

// Simple script to check database categories
$host = 'localhost';
$dbname = 'thonburi_culture';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "Database connection successful!\n";
    echo "=================================\n";
    
    // Query categories
    $stmt = $pdo->query("SELECT id, name, slug FROM cultural_categories ORDER BY id");
    $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "Total categories: " . count($categories) . "\n\n";
    
    foreach ($categories as $category) {
        $slug = $category['slug'] ?? 'NULL';
        echo "ID: {$category['id']} | Name: {$category['name']} | Slug: {$slug}\n";
    }
    
    echo "\n=================================\n";
    
    // Check categories without slugs
    $stmt = $pdo->query("SELECT COUNT(*) as count FROM cultural_categories WHERE slug IS NULL OR slug = ''");
    $nullCount = $stmt->fetch(PDO::FETCH_ASSOC)['count'];
    
    echo "Categories without slug: {$nullCount}\n";
    
    if ($nullCount > 0) {
        echo "\nCategories missing slugs:\n";
        $stmt = $pdo->query("SELECT id, name FROM cultural_categories WHERE slug IS NULL OR slug = ''");
        $missing = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        foreach ($missing as $cat) {
            echo "- ID: {$cat['id']}, Name: {$cat['name']}\n";
        }
    } else {
        echo "All categories have slugs!\n";
    }
    
} catch (PDOException $e) {
    echo "Database connection failed: " . $e->getMessage() . "\n";
}