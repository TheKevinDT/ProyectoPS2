<?php
// Datos de conexión a la base de datos
$servername = "127.0.0.1";
$username = "root";
$password = "kevin2001";
$dbname = "tiendasabordigital";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
} else {
    echo "Conexión exitosa.";
}

// Obtener datos del formulario
$nombre = $_POST['nombre'];
$descripcion = $_POST['descripcion'];
$precio = $_POST['precio'];
$stock = $_POST['stock'];
$categoria = $_POST['categoria'];
$imagen = $_FILES['imagen'];

// Ruta de almacenamiento de imágenes
$ruta_almacenamiento = __DIR__ . '/../img_productos/'; 
$nombre_imagen = basename($imagen['name']);
$ruta_imagen = $ruta_almacenamiento . $nombre_imagen;

// Verifica si la carpeta de almacenamiento existe y tiene permisos de escritura
if (!is_dir($ruta_almacenamiento)) {
    mkdir($ruta_almacenamiento, 0777, true);
}

if (move_uploaded_file($imagen['tmp_name'], $ruta_imagen)) {
    // Preparar la consulta SQL
    $sql = "INSERT INTO productos (P_nombre, P_descripcion, P_precio, P_stock, id_categoria, P_imagen)
            VALUES (?, ?, ?, ?, ?, ?)";
    
    $stmt = $conn->prepare($sql);
    
    if ($stmt) {
        $stmt->bind_param("ssdiss", $nombre, $descripcion, $precio, $stock, $categoria, $ruta_imagen);
        
        // Ejecutar la consulta
        if ($stmt->execute()) {
            echo "Producto agregado exitosamente.";
        } else {
            echo "Error al ejecutar la consulta: " . $stmt->error;
        }
        
        $stmt->close();
    } else {
        echo "Error al preparar la consulta: " . $conn->error;
    }
} else {
    echo "Error al subir la imagen.";
}

$conn->close();

header("Refresh: 2; URL=/SaborDigital-WEB/html/addproductos.html");
echo "Serás redirigido en 2 segundos...";
?>
