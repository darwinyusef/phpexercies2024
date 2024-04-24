<?php
include 'bd/bdpdo.php';

try {
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $stmt = $conexion->prepare("SELECT * FROM usuario WHERE idusuario = ?");
            $stmt->execute([$id]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($result) {
                echo json_encode(['data' => $result], JSON_UNESCAPED_UNICODE);
            } else {
                echo json_encode(['error' => 'No se encontró un usuario con el ID proporcionado.'], JSON_UNESCAPED_UNICODE);
            }
        } elseif (isset($_GET['t3'])) {
            $correo = $_GET['t3'];
            $stmt = $conexion->prepare("SELECT * FROM usuario WHERE correo = ?");
            $stmt->execute([$correo]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($result) {
                echo json_encode(['data' => $result], JSON_UNESCAPED_UNICODE);
            } else {
                echo json_encode(['error' => 'No se encontró un usuario con el correo proporcionado.'], JSON_UNESCAPED_UNICODE);
            }
        } elseif (isset($_GET['t5'])) {
            $telefono = $_GET['t5'];
            $stmt = $conexion->prepare("SELECT * FROM usuario WHERE telefono = ?");
            $stmt->execute([$telefono]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($result) {
                echo json_encode(['data' => $result], JSON_UNESCAPED_UNICODE);
            } else {
                echo json_encode(['error' => 'No se encontró un usuario con el teléfono proporcionado.'], JSON_UNESCAPED_UNICODE);
            }
        } else {
            $stmt = $conexion->query("SELECT * FROM usuario");
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if ($result) {
                echo json_encode(['data' => $result], JSON_UNESCAPED_UNICODE);
            } else {
                echo json_encode(['error' => 'No se encontro usuarios.'], JSON_UNESCAPED_UNICODE);
            }
        }
    }// cerrar el metodo get
//---------------------------------metodo post--------------
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Verificar si los campos están presentes
        if (
            isset($_POST['t1']) &&
            isset($_POST['t2']) &&
            isset($_POST['t3']) &&
            isset($_POST['t4']) &&
            isset($_POST['t5'])
        ) {
            // Obtener datos desde la solicitud POST
            $identificacion = $_POST['t1'];
            $nombres = $_POST['t2'];
            $correo = $_POST['t3'];
            $contrasena = password_hash($_POST['t4'], PASSWORD_ARGON2I); // Encriptar la contraseña con Argon2
            $telefono = $_POST['t5'];
    
            // Evitar SQL Injection usando consultas preparadas
            $stmt = $conexion->prepare("INSERT INTO usuario (identificacion, nombres, correo, contrasena, telefono) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$identificacion, $nombres, $correo, $contrasena, $telefono]);
    
            // Verificar si la inserción fue exitosa
            if ($stmt->rowCount() > 0) {
                echo json_encode(['message' => 'Registro exitoso.'], JSON_UNESCAPED_UNICODE);
            } else {
                echo json_encode(['error' => 'Error no se pudo guardar.'], JSON_UNESCAPED_UNICODE);
            }
        } else {
            echo json_encode(['error' => 'Se necesitan todos los campos para poder guardar.'], JSON_UNESCAPED_UNICODE);
        }
    } 
   //--------------------------metodo put------------------------- 
   if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
    // Parsear el cuerpo de la solicitud JSON
    $data = json_decode(file_get_contents("php://input"), true);

    // Verificar si los campos están presentes
    if (
        isset($data['id']) &&
        isset($data['t1']) &&
        isset($data['t2']) &&
        isset($data['t3']) &&
        isset($data['t4']) &&
        isset($data['t5'])
    ) {
        // Obtener datos desde el cuerpo de la solicitud
        $idusuario = $data['id'];
        $identificacion = $data['t1'];
        $nombres = $data['t2'];
        $correo = $data['t3'];
        $contrasena = password_hash($data['t4'], PASSWORD_ARGON2I); // Encriptar la nueva contraseña con Argon2
        $telefono = $data['t5'];

        // Evitar SQL Injection usando consultas preparadas
        $stmt = $conexion->prepare("UPDATE usuario SET identificacion=?, nombres=?, correo=?, contrasena=?, telefono=? WHERE idusuario=?");
        $stmt->execute([$identificacion, $nombres, $correo, $contrasena, $telefono, $idusuario]);

        // Verificar si la actualización fue exitosa
        if ($stmt->rowCount() > 0) {
            echo json_encode(['message' => 'Edición exitosa.'], JSON_UNESCAPED_UNICODE);
        } else {
            echo json_encode(['error' => 'Error no se pudo editar usuario.'], JSON_UNESCAPED_UNICODE);
        }
    } else {
        echo json_encode(['error' => 'Se requieren todos los campos para poder editar.'], JSON_UNESCAPED_UNICODE);
    }
} 
//------------------------metodo delete--------------------------------
if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
    // convertir el cuerpo de la solicitud JSON
    $data = json_decode(file_get_contents("php://input"), true);

    // Verificar si los datos requeridos están presentes en el cuerpo de la solicitud
    if (isset($data['id'])) {
        // Obtener el idusuario desde el cuerpo de la solicitud
        $idusuario = $data['id'];

        // Evitar SQL Injection usando consultas preparadas
        $stmt = $conexion->prepare("DELETE FROM usuario WHERE idusuario = ?");
        $stmt->execute([$idusuario]);

        // Verificar si la eliminación fue exitosa
        if ($stmt->rowCount() > 0) {
            echo json_encode(['message' => 'Eliminación exitosa.'], JSON_UNESCAPED_UNICODE);
        } else {
            echo json_encode(['error' => 'Error al eliminar usuario. El usuario no existe.'], JSON_UNESCAPED_UNICODE);
        }
    } else {
        echo json_encode(['error' => 'Se requiere el parámetro "idusuario" en el cuerpo de la solicitud DELETE.'], JSON_UNESCAPED_UNICODE);
    }
} 
   
   $conexion = null; 
} catch (PDOException $e) {
    echo json_encode(['error' => 'Error en la base de datos: ' . $e->getMessage()], JSON_UNESCAPED_UNICODE);
}


?>