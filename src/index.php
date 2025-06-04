<?php
// PHP script to connect to MSSQL and query test data
// Database: TestDB, Table: Inventory (id, name, quantity)

// Database connection parameters
$serverName = "demo-db"; // or your server IP
$connectionOptions = array(
    "Database" => "TestDB",
    "Uid" => "sa",
    "PWD" => "Sup3rStrongP@ssw0rd", // Replace with your actual password
    "TrustServerCertificate" => true, // For development/testing
    "Encrypt" => true
);

try {
    // Establish connection
    echo "<h2>Connecting to MSSQL Database...</h2>\n";
    $conn = sqlsrv_connect($serverName, $connectionOptions);
    
    if ($conn === false) {
        throw new Exception("Connection failed: " . print_r(sqlsrv_errors(), true));
    }
    
    echo "<p style='color: green;'>✓ Connected successfully to TestDB!</p>\n";
    
    // Query to select all data from Inventory table
    $sql = "SELECT id, name, quantity FROM Inventory ORDER BY id";
    
    echo "<h3>Querying Inventory table...</h3>\n";
    
    $stmt = sqlsrv_query($conn, $sql);
    
    if ($stmt === false) {
        throw new Exception("Query failed: " . print_r(sqlsrv_errors(), true));
    }
    
    echo "<table border='1' cellpadding='5' cellspacing='0' style='border-collapse: collapse;'>\n";
    echo "<thead style='background-color: #f0f0f0;'>\n";
    echo "<tr><th>ID</th><th>Name</th><th>Quantity</th></tr>\n";
    echo "</thead>\n";
    echo "<tbody>\n";
    
    $rowCount = 0;
    
    // Fetch and display results
    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        $rowCount++;
        echo "<tr>\n";
        echo "<td>" . htmlspecialchars($row['id']) . "</td>\n";
        echo "<td>" . htmlspecialchars($row['name']) . "</td>\n";
        echo "<td>" . htmlspecialchars($row['quantity']) . "</td>\n";
        echo "</tr>\n";
    }
    
    echo "</tbody>\n";
    echo "</table>\n";
    
    if ($rowCount == 0) {
        echo "<p style='color: orange;'>No records found in Inventory table.</p>\n";
    } else {
        echo "<p style='color: blue;'>Total records found: $rowCount</p>\n";
    }
    
    // Additional query - Get total quantity
    $totalSql = "SELECT SUM(quantity) as total_quantity FROM Inventory";
    $totalStmt = sqlsrv_query($conn, $totalSql);
    
    if ($totalStmt !== false) {
        $totalRow = sqlsrv_fetch_array($totalStmt, SQLSRV_FETCH_ASSOC);
        $totalQuantity = $totalRow['total_quantity'] ?? 0;
        echo "<p><strong>Total Quantity in Inventory: $totalQuantity</strong></p>\n";
        sqlsrv_free_stmt($totalStmt);
    }
    
    // Free statement and close connection
    sqlsrv_free_stmt($stmt);
    
} catch (Exception $e) {
    echo "<p style='color: red;'>Error: " . $e->getMessage() . "</p>\n";
} finally {
    // Close connection if it exists
    if (isset($conn) && $conn !== false) {
        sqlsrv_close($conn);
        echo "<p style='color: gray;'>Database connection closed.</p>\n";
    }
}

// Display PHP and driver info for debugging
echo "<hr>\n";
echo "<h4>System Information:</h4>\n";
echo "<p>PHP Version: " . phpversion() . "</p>\n";

if (extension_loaded('sqlsrv')) {
    echo "<p style='color: green;'>✓ SQL Server driver is loaded</p>\n";
} else {
    echo "<p style='color: red;'>✗ SQL Server driver is NOT loaded</p>\n";
    echo "<p>Please install the Microsoft SQL Server PHP driver (sqlsrv)</p>\n";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>MSSQL Test Connection</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        table { margin: 10px 0; }
        th, td { text-align: left; padding: 8px; }
        th { font-weight: bold; }
    </style>
</head>
<body>
    <h1>MSSQL Database Test - Inventory Data</h1>
</body>
</html>
