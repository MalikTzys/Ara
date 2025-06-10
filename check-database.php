<?php
// File untuk mengecek database - hapus setelah selesai
include 'config/database.php';

echo "<h1>Database Check</h1>";

// Test koneksi
if ($conn) {
    echo "✅ Database connected successfully<br><br>";
} else {
    echo "❌ Database connection failed<br>";
    exit;
}

// Check tables
$tables = ['admin', 'jurusan', 'alumni', 'siswa'];

foreach ($tables as $table) {
    echo "<h3>Table: $table</h3>";
    
    $query = "SELECT COUNT(*) as count FROM $table";
    $result = mysqli_query($conn, $query);
    
    if ($result) {
        $count = mysqli_fetch_assoc($result)['count'];
        echo "Records: $count<br>";
        
        if ($count > 0) {
            $query = "SELECT * FROM $table LIMIT 3";
            $result = mysqli_query($conn, $query);
            echo "<table border='1' style='margin: 10px 0;'>";
            
            // Header
            if ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                foreach (array_keys($row) as $column) {
                    echo "<th>$column</th>";
                }
                echo "</tr>";
                
                // First row
                echo "<tr>";
                foreach ($row as $value) {
                    echo "<td>" . htmlspecialchars($value) . "</td>";
                }
                echo "</tr>";
                
                // Other rows
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    foreach ($row as $value) {
                        echo "<td>" . htmlspecialchars($value) . "</td>";
                    }
                    echo "</tr>";
                }
            }
            echo "</table>";
        }
    } else {
        echo "❌ Error: " . mysqli_error($conn) . "<br>";
    }
    echo "<br>";
}

echo "<h3>Test Queries</h3>";

// Test alumni with jurusan
$query = "SELECT a.nama, j.nama_jurusan FROM alumni a JOIN jurusan j ON a.id_jurusan = j.id_jurusan LIMIT 5";
$result = mysqli_query($conn, $query);

if ($result) {
    echo "Alumni with Jurusan:<br>";
    while ($row = mysqli_fetch_assoc($result)) {
        echo "- " . $row['nama'] . " (" . $row['nama_jurusan'] . ")<br>";
    }
} else {
    echo "❌ Alumni query error: " . mysqli_error($conn) . "<br>";
}
?>
