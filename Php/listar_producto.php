<?php
header('Content-Type: application/json');

// Datos de conexión a la base de datos
$servername = "127.0.0.1";
$username = "root";
$password = "kevin2001";
$dbname = "tiendasabordigital";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die(json_encode(["error" => "Conexión fallida: " . $conn->connect_error]));
}

// Preparar la consulta SQL
$sql = "SELECT P_nombre, P_descripcion, P_precio, P_stock, id_categoria FROM productos";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $productos = [];

    while($row = $result->fetch_assoc()) {
        $productos[] = $row;
    }

    echo json_encode($productos);
} else {
    echo json_encode([]);
}

$conn->close();
?>
