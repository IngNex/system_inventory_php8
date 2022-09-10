<?php
session_start();
include "../conexion.php";
$id_user = $_SESSION['idUser'];
$permiso = "materiales";
$sql = mysqli_query($conexion, "SELECT p.*, d.* FROM permisos p INNER JOIN detalle_permisos d ON p.id = d.id_permiso WHERE d.id_usuario = $id_user AND p.nombre = '$permiso'");
$existe = mysqli_fetch_all($sql);
if (empty($existe) && $id_user != 1) {
    header('Location: permisos.php');
}
if (!empty($_POST)) {
    $alert = "";
    $id = $_POST['id'];
    $codigo = $_POST['codigo'];
    $materiales = $_POST['materiales'];
    $valor = $_POST['valor'];
    $cantidad = $_POST['cantidad'];
    $categoria = $_POST['categoria'];
    $marca = $_POST['marca'];
    $gerencias = $_POST['gerencias'];
    $fecha_actual = '';
    if (!empty($_POST['accion'])) {
        $fecha_actual = $_POST['fecha_actual'];
    }
    if (empty($codigo) || empty($materiales) || empty($categoria) || empty($marca) || empty($gerencias)  || empty($valor) || $valor <  0 || empty($cantidad) || $cantidad <  0) {
        $alert = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                        Todo los campos son obligatorios
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>';
    } else {
        if (empty($id)) {
            $query = mysqli_query($conexion, "SELECT * FROM materiales WHERE codigo = '$codigo'");
            $result = mysqli_fetch_array($query);
            if ($result > 0) {
                $alert = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                        El codigo del Material ya existe
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>';
            } else {
                $query_insert = mysqli_query($conexion, "INSERT INTO materiales(codigo,descripcion,valor,existencia,id_ger,id_marca,id_categoria, fecha_actual) values ('$codigo', '$materiales', '$valor', '$cantidad', $gerencias, $marca, $categoria, '$fecha_actual')");
                if ($query_insert) {
                    $alert = '<div class="alert alert-success alert-dismissible fade show" role="alert">
                        Material registrado
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>';
                } else {
                    $alert = '<div class="alert alert-danger" role="alert">
                    Error al registrar el materiales
                  </div>';
                }
            }
        } else {
            $query_update = mysqli_query($conexion, "UPDATE materiales SET codigo = '$codigo', descripcion = '$materiales', valor= $valor, existencia = $cantidad, fecha_actual = '$fecha_actual' WHERE codmateriales = $id");
            if ($query_update) {
                $alert = '<div class="alert alert-success alert-dismissible fade show" role="alert">
                        Material Modificado
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>';
            } else {
                $alert = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                        Error al modificar
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>';
            }
        }
    }
}
include_once "includes/header.php";
?>
<div class="card shadow-lg">
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                <div class="card shadow-lg">
                    <div class="card-header bg-danger text-white">
                        Materiales de Inventario
                    </div>
                    <div class="card-body">
                        <form action="" method="post" autocomplete="off" id="formulario">
                            <?php echo isset($alert) ? $alert : ''; ?>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="codigo" class=" text-dark font-weight-bold"><i class="fas fa-barcode"></i> Código</label>
                                        <input type="text" placeholder="Ingrese código de barras" name="codigo" id="codigo" class="form-control">
                                        <input type="hidden" id="id" name="id">
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label for="materiales" class=" text-dark font-weight-bold">Material</label>
                                        <input type="text" placeholder="Ingrese nombre del materiales" name="materiales" id="materiales" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="valor" class=" text-dark font-weight-bold">Monto Valorizado</label>
                                        <input type="text" placeholder="Ingrese monto valorizado" class="form-control" name="valor" id="valor">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="cantidad" class=" text-dark font-weight-bold">Cantidad</label>
                                        <input type="number" placeholder="Ingrese cantidad" class="form-control" name="cantidad" id="cantidad">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="categoria">Categoria</label>
                                        <select id="categoria" class="form-control" name="categoria" required>
                                            <?php
                                            $query_tipo = mysqli_query($conexion, "SELECT * FROM categorias");
                                            while ($datos = mysqli_fetch_assoc($query_tipo)) { ?>
                                                <option value="<?php echo $datos['id'] ?>"><?php echo $datos['categoria'] ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="marca">Marca</label>
                                        <select id="marca" class="form-control" name="marca" required>
                                            <?php
                                            $query_pre = mysqli_query($conexion, "SELECT * FROM marca");
                                            while ($datos = mysqli_fetch_assoc($query_pre)) { ?>
                                                <option value="<?php echo $datos['id'] ?>"><?php echo $datos['nombre'] ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="gerencias">Gerencia</label>
                                        <select id="gerencias" class="form-control" name="gerencias" required>
                                            <?php
                                            $query_lab = mysqli_query($conexion, "SELECT * FROM gerencias");
                                            while ($datos = mysqli_fetch_assoc($query_lab)) { ?>
                                                <option value="<?php echo $datos['id'] ?>"><?php echo $datos['gerencias'] ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <input id="accion" class="form-check-input" type="checkbox" name="accion" value="si">
                                        <label for="fecha_actual">Incorporado</label>
                                        <input id="fecha_actual" class="form-control" type="date" name="fecha_actual">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <input type="submit" value="Registrar" class="btn btn-primary" id="btnAccion">
                                    <input type="button" value="Nuevo" onclick="limpiar()" class="btn btn-info" id="btnNuevo">
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table table-striped table-bordered" id="tbl">
                    <thead class="thead-dark">
                        <tr>
                            <th>#</th>
                            <th>Código</th>
                            <th>Material</th>
                            <th>Categoria</th>
                            <th>Marca</th>
                            <th>Valor</th>
                            <th>Stock</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        include "../conexion.php";

                        $query = mysqli_query($conexion, "SELECT m.*, c.id, c.categoria, marc.id, marc.nombre FROM materiales m INNER JOIN categorias c ON m.id_categoria = c.id INNER JOIN marca marc ON m.id_marca = marc.id");
                        $result = mysqli_num_rows($query);
                        if ($result > 0) {
                            while ($data = mysqli_fetch_assoc($query)) { ?>
                                <tr>
                                    <td><?php echo $data['codmateriales']; ?></td>
                                    <td><?php echo $data['codigo']; ?></td>
                                    <td><?php echo $data['descripcion']; ?></td>
                                    <td><?php echo $data['categoria']; ?></td>
                                    <td><?php echo $data['nombre']; ?></td>
                                    <td><?php echo $data['valor']; ?></td>
                                    <td><?php echo $data['existencia']; ?></td>
                                    <td>
                                        <a href="#" onclick="editarMateriales(<?php echo $data['codmateriales']; ?>)" class="btn btn-primary"><i class='fas fa-edit'></i></a>
                                        <form action="eliminar_material.php?id=<?php echo $data['codmateriales']; ?>" method="post" class="confirmar d-inline">
                                            <button class="btn btn-danger" type="submit"><i class='fas fa-trash-alt'></i> </button>
                                        </form>
                                    </td>
                                </tr>
                        <?php }
                        } ?>
                    </tbody>

                </table>
            </div>
        </div>
    </div>
</div>
<?php include_once "includes/footer.php"; ?>