<?php
include 'bd/bd.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $sentencia = $conexion->prepare("SELECT * FROM usuario WHERE idusuario=?");
        $sentencia->bind_param('i', $id);
        $sentencia->execute();

        $resultado = $sentencia->get_result();

        if ($resultado->num_rows > 0) {
            $fila = $resultado->fetch_assoc();
            echo json_encode(['data' => $fila], JSON_UNESCAPED_UNICODE);
        } else {
            echo json_encode(['error' => 'No se encontro el id.'], JSON_UNESCAPED_UNICODE);
        }

        $sentencia->close();
    } elseif (isset($_GET['t3'])) {
        $correo = $_GET['t3'];
        $sentencia = $conexion->prepare("SELECT * FROM usuario WHERE correo=?");
        $sentencia->bind_param('s', $correo);
        $sentencia->execute();

        $resultado = $sentencia->get_result();

        if ($resultado->num_rows > 0) {
            $fila = $resultado->fetch_assoc();
            echo json_encode(['data' => $fila], JSON_UNESCAPED_UNICODE);
        } else {
            echo json_encode(['error' => 'No se encontro el correo.'], JSON_UNESCAPED_UNICODE);
        }

        $sentencia->close();
    } elseif (isset($_GET['t5'])) {
        $telefono = $_GET['t5'];
        $sentencia = $conexion->prepare("SELECT * FROM usuario WHERE telefono=?");
        $sentencia->bind_param('s', $telefono);
        $sentencia->execute();

        $resultado = $sentencia->get_result();

        if ($resultado->num_rows > 0) {
            $fila = $resultado->fetch_assoc();
            echo json_encode(['data' => $fila], JSON_UNESCAPED_UNICODE);
        } else {
            echo json_encode(['error' => 'No se encontro el telefono.'], JSON_UNESCAPED_UNICODE);
        }

        $sentencia->close();
    } else {
        $resultado = $conexion->query("SELECT * FROM usuario");

        if ($resultado->num_rows > 0) {
            $fila = $resultado->fetch_all(MYSQLI_ASSOC);
            echo json_encode(['data' => $fila], JSON_UNESCAPED_UNICODE);
        } else {
            echo json_encode(['error' => 'No se encontraron resultados.'], JSON_UNESCAPED_UNICODE);
        }
    }

    $conexion->close();
}
//*******************************************************************************************************

//+++++++++++++++++++++++++++++++++++metodo post++++++++++++++++++++++++++++++++++++++++++++++++++++++++

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Verificar si los campos estan presentes
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
        $sentencia = $conexion->prepare("INSERT INTO usuario (identificacion, nombres, correo, contrasena, telefono) VALUES (?, ?, ?, ?, ?)");
        $sentencia->bind_param('sssss', $identificacion, $nombres, $correo, $contrasena, $telefono);

        // Ejecutar la consulta
        if ($sentencia->execute()) {
            echo json_encode(['message' => 'Registro exitoso.'], JSON_UNESCAPED_UNICODE);
        } else {
            echo json_encode(['error' => 'Error no se pudo guardar.'], JSON_UNESCAPED_UNICODE);
        }

        $sentencia->close();
    } else {
        echo json_encode(['error' => 'Se necesitan todos los campos para poder guardar.'], JSON_UNESCAPED_UNICODE);
    }

    $conexion->close();
} 

//*****************************************************************************************************

//+++++++++++++++++++++++++++++++++metodo put+++++++++++++++++++++++++++++++++++++++++++++++++++++++++

if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
    // Parsear el cuerpo de la solicitud JSON
    $data = json_decode(file_get_contents("php://input"), true);

    // Verificar si lla pagina vienen los campos con informacion
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
        $sentencia = $conexion->prepare("UPDATE usuario SET identificacion=?, nombres=?, correo=?, contrasena=?, telefono=? WHERE idusuario=?");
        $sentencia->bind_param('sssssi', $identificacion, $nombres, $correo, $contrasena, $telefono, $idusuario);

        // Ejecutar la consulta
        if ($sentencia->execute()) {
            echo json_encode(['message' => 'Edición exitosa.'], JSON_UNESCAPED_UNICODE);
        } else {
            echo json_encode(['error' => 'Error no se pudo editar usuario.'], JSON_UNESCAPED_UNICODE);
        }

        $sentencia->close();
    } else {
        echo json_encode(['error' => 'Se requieren todos los campo para poder editar.'], JSON_UNESCAPED_UNICODE);
    }

    $conexion->close();
}

//*****************************************************************************************************

//+++++++++++++++++++++++++++++++++metodo delete+++++++++++++++++++++++++++++++++++++++++++++++++++++++++

if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
    // Parsear el cuerpo de la solicitud JSON
    $data = json_decode(file_get_contents("php://input"), true);

    // Verificar si los datos requeridos están presentes en el cuerpo de la solicitud
    if (isset($data['id'])) {
        // Obtener el idusuario desde el cuerpo de la solicitud
        $idusuario = $data['id'];

        // Evitar SQL Injection usando consultas preparadas
        $sentencia = $conexion->prepare("DELETE FROM usuario WHERE idusuario=?");
        $sentencia->bind_param('i', $idusuario);

        // Ejecutar la consulta
        if ($sentencia->execute()) {
            echo json_encode(['message' => 'Eliminación exitosa.'], JSON_UNESCAPED_UNICODE);
        } else {
            echo json_encode(['error' => 'Error al eliminar datos en la base de datos.'], JSON_UNESCAPED_UNICODE);
        }

        $sentencia->close();
    } else {
        echo json_encode(['error' => 'Se requiere el parámetro "idusuario" en el cuerpo de la solicitud DELETE.'], JSON_UNESCAPED_UNICODE);
    }

    $conexion->close();
}
?>