<?php
include 'bd/bdpdo.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener datos del cuerpo de la solicitud
    $correo = $_POST['correo'];
    $contrasena = $_POST['contrasena'];

    // Validar que los campos no estén vacíos
    if (empty($correo) || empty($contrasena)) {
        echo json_encode(['error' => 'Correo y contraseña son requeridos.'], JSON_UNESCAPED_UNICODE);
        exit;
    }

    // Verificar el correo y la contraseña en la base de datos
    $stmt = $conexion->prepare("SELECT * FROM usuario WHERE correo = ?");
    $stmt->execute([$correo]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($usuario && password_verify($contrasena, $usuario['contrasena'])) {
        echo json_encode(['message' => 'Inicio de sesión exitoso.'], JSON_UNESCAPED_UNICODE);
    } else {
        echo json_encode(['error' => 'Correo o contraseña incorrectos.'], JSON_UNESCAPED_UNICODE);
    }
} else {
    echo json_encode(['error' => 'Método no permitido.'], JSON_UNESCAPED_UNICODE);
}
?>