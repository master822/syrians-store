<?php
echo "PHP is working!<br>";
echo "Current directory: " . getcwd() . "<br>";
echo "PHP version: " . phpversion() . "<br>";

// Test file permissions
$files = ['storage', 'bootstrap/cache', '.env'];
foreach ($files as $file) {
    echo "$file: " . (file_exists($file) ? 'EXISTS' : 'MISSING') . "<br>";
}
?>