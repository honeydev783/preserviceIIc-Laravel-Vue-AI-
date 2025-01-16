<?php

$host = 'localhost';
$user = 'lobalpx1_laravel';
$password = 'm5x7~krMkIah';
$database = 'lobalpx1_laravel_crud';

$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die("Connection error: " . $conn->connect_error);
}

$sql = "SELECT id FROM resource_components ORDER BY id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $component_id = 1;
    
    while ($row = $result->fetch_assoc()) {
        $id = $row['id'];
        $update_sql = "UPDATE resource_components SET component_id = $component_id WHERE id = $id";
        if ($conn->query($update_sql) === TRUE) {
            $component_id++;
        } else {
            echo "Error updating record with ID $id: " . $conn->error;
        }
    }
    
    echo "Update completed successfully.";
} else {
    echo "No records found in resource_components table.";
}

$conn->close();
?>
