<?php
require_once "../conexion.php";
session_start();
if (isset($_GET['q'])) {
    $datos = array();
    $nombre = $_GET['q'];
    $adquisidor = mysqli_query($conexion, "SELECT * FROM adquisidor WHERE nombre LIKE '%$nombre%'");
    while ($row = mysqli_fetch_assoc($adquisidor)) {
        $data['id'] = $row['idadquisidor'];
        $data['label'] = $row['nombre'];
        $data['direccion'] = $row['direccion'];
        $data['telefono'] = $row['telefono'];
        array_push($datos, $data);
    }
    echo json_encode($datos);
    die();
}else if (isset($_GET['pro'])) {
    $datos = array();
    $nombre = $_GET['pro'];
    $hoy = date('Y-m-d');
    $materiales = mysqli_query($conexion, "SELECT * FROM materiales WHERE codigo LIKE '%" . $nombre . "%' OR descripcion LIKE '%" . $nombre . "%' AND fecha_actual > '$hoy' OR fecha_actual = '0000-00-00'");
    while ($row = mysqli_fetch_assoc($materiales)) {
        $data['id'] = $row['codmateriales'];
        $data['label'] = $row['codigo'] . ' - ' .$row['descripcion'];
        $data['value'] = $row['descripcion'];
        $data['valor'] = $row['valor'];
        $data['existencia'] = $row['existencia'];
        array_push($datos, $data);
    }
    echo json_encode($datos);
    die();
}else if (isset($_GET['detalle'])) {
    $id = $_SESSION['idUser'];
    $datos = array();
    $detalle = mysqli_query($conexion, "SELECT d.*, p.codmateriales, p.descripcion FROM detalle_temp d INNER JOIN materiales p ON d.id_material = p.codmateriales WHERE d.id_usuario = $id");
    while ($row = mysqli_fetch_assoc($detalle)) {
        $data['id'] = $row['id'];
        $data['descripcion'] = $row['descripcion'];
        $data['cantidad'] = $row['cantidad'];
        $data['depreciacion'] = $row['depreciacion'];
        $data['monto_valor'] = $row['monto_valor'];
        $data['sub_total'] = $row['total'];
        array_push($datos, $data);
    }
    echo json_encode($datos);
    die();
} else if (isset($_GET['delete_detalle'])) {
    $id_detalle = $_GET['id'];
    $query = mysqli_query($conexion, "DELETE FROM detalle_temp WHERE id = $id_detalle");
    if ($query) {
        $msg = "ok";
    } else {
        $msg = "Error";
    }
    echo $msg;
    die();
} else if (isset($_GET['procesarCargo'])) {
    $id_adquisidor = $_GET['id'];
    $id_user = $_SESSION['idUser'];
    $consulta = mysqli_query($conexion, "SELECT total, SUM(total) AS total_pagar FROM detalle_temp WHERE id_usuario = $id_user");
    $result = mysqli_fetch_assoc($consulta);
    $total = $result['total_pagar'];
    $insertar = mysqli_query($conexion, "INSERT INTO cargos(id_adquisidor, total, id_usuario) VALUES ($id_adquisidor, '$total', $id_user)");
    if ($insertar) {
        $id_maximo = mysqli_query($conexion, "SELECT MAX(id) AS total FROM cargos");
        $resultId = mysqli_fetch_assoc($id_maximo);
        $ultimoId = $resultId['total'];
        $consultaDetalle = mysqli_query($conexion, "SELECT * FROM detalle_temp WHERE id_usuario = $id_user");
        while ($row = mysqli_fetch_assoc($consultaDetalle)) {
            $id_materiales = $row['id_material'];
            $cantidad = $row['cantidad'];
            $desc = $row['depreciacion'];
            $precio = $row['monto_valor'];
            $total = $row['total'];
            $insertarDet = mysqli_query($conexion, "INSERT INTO detalle_cargo (id_material, id_cargo, cantidad, monto, depreciacion, total) VALUES ($id_materiales, $ultimoId, $cantidad, '$precio', '$desc','$total')");
            $stockActual = mysqli_query($conexion, "SELECT * FROM materiales WHERE codmateriales = $id_materiales");
            $stockNuevo = mysqli_fetch_assoc($stockActual);
            $stockTotal = $stockNuevo['existencia'] - $cantidad;
            $stock = mysqli_query($conexion, "UPDATE materiales SET existencia = $stockTotal WHERE codmateriales = $id_materiales");
        } 
        if ($insertarDet) {
            $eliminar = mysqli_query($conexion, "DELETE FROM detalle_temp WHERE id_usuario = $id_user");
            $msg = array('id_adquisidor' => $id_adquisidor, 'id_cargo' => $ultimoId);
        } 
    }else{
        $msg = array('mensaje' => 'error');
    }
    echo json_encode($msg);
    die();
}else if (isset($_GET['descuento'])) {
    $id = $_GET['id'];
    $desc = $_GET['desc']/100;
    $consulta = mysqli_query($conexion, "SELECT * FROM detalle_temp WHERE id = $id");
    $result = mysqli_fetch_assoc($consulta);
    $total_desc = $desc;
    /* Agarra la cantidad ya descontada */
    /*$total = $result['total'] - $desc;*/
    $sub_total_temp=$result['cantidad']*$result['monto_valor'];
    $total = $sub_total_temp - ($sub_total_temp*$desc);
    $insertar = mysqli_query($conexion, "UPDATE detalle_temp SET depreciacion = $total_desc, total = '$total'  WHERE id = $id");
    if ($insertar) {
        $msg = array('mensaje' => 'descontado');
    }else{
        $msg = array('mensaje' => 'error');
    }
    echo json_encode($msg);
    die();
}else if(isset($_GET['editarAdquisidor'])){
    $idadquisidor = $_GET['id'];
    $sql = mysqli_query($conexion, "SELECT * FROM adquisidor WHERE idadquisidor = $idadquisidor");
    $data = mysqli_fetch_array($sql);
    echo json_encode($data);
    exit;
} else if (isset($_GET['editarUsuario'])) {
    $idusuario = $_GET['id'];
    $sql = mysqli_query($conexion, "SELECT * FROM usuario WHERE idusuario = $idusuario");
    $data = mysqli_fetch_array($sql);
    echo json_encode($data);
    exit;
} else if (isset($_GET['editarMateriales'])) {
    $id = $_GET['id'];
    $sql = mysqli_query($conexion, "SELECT * FROM materiales WHERE codmateriales = $id");
    $data = mysqli_fetch_array($sql);
    echo json_encode($data);
    exit;
} else if (isset($_GET['editarCategoria'])) {
    $id = $_GET['id'];
    $sql = mysqli_query($conexion, "SELECT * FROM categorias WHERE id = $id");
    $data = mysqli_fetch_array($sql);
    echo json_encode($data);
    exit;
} else if (isset($_GET['editarMarca'])) {
    $id = $_GET['id'];
    $sql = mysqli_query($conexion, "SELECT * FROM marca WHERE id = $id");
    $data = mysqli_fetch_array($sql);
    echo json_encode($data);
    exit;
} else if (isset($_GET['editarGer'])) {
    $id = $_GET['id'];
    $sql = mysqli_query($conexion, "SELECT * FROM gerencias WHERE id = $id");
    $data = mysqli_fetch_array($sql);
    echo json_encode($data);
    exit;
}
if (isset($_POST['regDetalle'])) {
    $id = $_POST['id'];
    $cant = $_POST['cant'];
    $precio = $_POST['precio'];
    $id_user = $_SESSION['idUser'];
    $total = $precio * $cant;
    $verificar = mysqli_query($conexion, "SELECT * FROM detalle_temp WHERE id_material = $id AND id_usuario = $id_user");
    $result = mysqli_num_rows($verificar);
    $datos = mysqli_fetch_assoc($verificar);
    if ($result > 0) {
        $cantidad = $datos['cantidad'] + $cant;
        $total_precio = ($cantidad * $total);
        $query = mysqli_query($conexion, "UPDATE detalle_temp SET cantidad = $cantidad, total = '$total_precio' WHERE id_material = $id AND id_usuario = $id_user");
        if ($query) {
            $msg = "actualizado";
        } else {
            $msg = "Error al ingresar";
        }
    }else{
        $query = mysqli_query($conexion, "INSERT INTO detalle_temp(id_usuario, id_material, cantidad ,monto_valor, total) VALUES ($id_user, $id, $cant,'$precio', '$total')");
        if ($query) {
            $msg = "registrado";
        }else{
            $msg = "Error al ingresar";
        }
    }
    echo json_encode($msg);
    die();
}else if (isset($_POST['cambio'])) {
    if (empty($_POST['actual']) || empty($_POST['nueva'])) {
        $msg = 'Los campos estan vacios';
    } else {
        $id = $_SESSION['idUser'];
        $actual = md5($_POST['actual']);
        $nueva = md5($_POST['nueva']);
        $consulta = mysqli_query($conexion, "SELECT * FROM usuario WHERE clave = '$actual' AND idusuario = $id");
        $result = mysqli_num_rows($consulta);
        if ($result == 1) {
            $query = mysqli_query($conexion, "UPDATE usuario SET clave = '$nueva' WHERE idusuario = $id");
            if ($query) {
                $msg = 'ok';
            }else{
                $msg = 'error';
            }
        } else {
            $msg = 'dif';
        }
        
    }
    echo $msg;
    die();
    
}

