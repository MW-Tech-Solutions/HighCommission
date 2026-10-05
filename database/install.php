<?php
/**
 * Nigeria High Commission Nairobi - Automated Database Installer
 * Connects to MySQL (defaulting to port 3308 for local XAMPP setup),
 * initializes schema DDL and seeds synthetic demo data.
 */

$host = '127.0.0.1';
$port = '3308'; // Default MySQL port detected on host
$username = 'root';
$password = '';
$dbname = 'kenya_high_commission';

echo "=== NIGERIA HIGH COMMISSION NAIROBI - DATABASE INSTALLER ===\n";

try {
    // 1. Connect without DB name to create DB if needed
    $pdo = new PDO("mysql:host={$host};port={$port}", $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
    
    echo "[1/4] Connected to MySQL server on {$host}:{$port}\n";

    // 2. Load and execute schema.sql
    $schemaSql = file_get_contents(__DIR__ . '/schema.sql');
    if (!$schemaSql) {
        throw new Exception("Could not read schema.sql");
    }
    
    $pdo->exec($schemaSql);
    echo "[2/4] Database '{$dbname}' and tables created successfully.\n";

    // Re-connect directly to the new database
    $pdo = new PDO("mysql:host={$host};port={$port};dbname={$dbname};charset=utf8mb4", $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);

    // 3. Load and execute seed.sql
    $seedSql = file_get_contents(__DIR__ . '/seed.sql');
    if (!$seedSql) {
        throw new Exception("Could not read seed.sql");
    }

    // Split queries by semicolon to execute clean batch
    $queries = explode(';', $seedSql);
    foreach ($queries as $query) {
        $trimmed = trim($query);
        if (!empty($trimmed)) {
            $pdo->exec($trimmed);
        }
    }
    echo "[3/4] Seed data inserted successfully.\n";

    // 4. Update seed user passwords with actual password_hash() for "Password123!"
    $hashedPassword = password_hash('Password123!', PASSWORD_BCRYPT);
    $stmt = $pdo->prepare("UPDATE users SET password_hash = :hash");
    $stmt->execute([':hash' => $hashedPassword]);
    echo "[4/4] Seed user passwords updated with BCrypt hash for 'Password123!'.\n\n";

    echo "SUCCESS: Database setup complete!\n";
    echo "Default accounts created:\n";
    echo " - Officer: officer@nigeriankenya.or.ke / Password123!\n";
    echo " - Editor:  editor@nigeriankenya.or.ke / Password123!\n";
    echo " - Admin:   admin@nigeriankenya.or.ke / Password123!\n";
    echo " - Citizen: tunde.demo@example.com / Password123!\n";
    echo " - Citizen: amina.demo@example.com / Password123!\n";

} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
    exit(1);
}
