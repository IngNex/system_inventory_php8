<?php
require "../conexion.php";
$usuarios = mysqli_query($conexion, "SELECT * FROM usuario");
$total['usuarios'] = mysqli_num_rows($usuarios);
$clientes = mysqli_query($conexion, "SELECT * FROM adquisidor");
$total['adquisidores'] = mysqli_num_rows($clientes);
$productos = mysqli_query($conexion, "SELECT * FROM materiales");
$total['materiales'] = mysqli_num_rows($productos);
$ventas = mysqli_query($conexion, "SELECT * FROM cargos");
/*$ventas = mysqli_query($conexion, "SELECT * FROM cargos WHERE fecha > CURDATE()"); */
$total['cargos'] = mysqli_num_rows($ventas);
session_start();
include_once "includes/header.php";
?>
<!-- Content Row -->
<div class="row">
    <div class="col-lg-3 col-md-6 col-sm-6">
        <div class="card card-stats">
            <div class="card-header card-header-warning card-header-icon">
                <div class="card-icon">
                    <i class="fas fa-user-circle fa-2x"></i>
                </div>
                <a href="usuarios.php" class="card-category text-warning font-weight-bold">
                    Miembros
                </a>
                <h3 class="card-title"><?php echo $total['usuarios']; ?></h3>
            </div>
            <div class="card-footer bg-warning text-white">
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 col-sm-6">
        <div class="card card-stats">
            <div class="card-header card-header-success card-header-icon">
                <div class="card-icon">
                    <i class="fas fa-users fa-2x"></i>
                </div>
                <a href="adquisidor.php" class="card-category text-success font-weight-bold">
                    Adquisidor
                </a>
                <h3 class="card-title"><?php echo $total['adquisidores']; ?></h3>
            </div>
            <div class="card-footer bg-primary text-white">
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6">
        <div class="card card-stats">
            <div class="card-header card-header-danger card-header-icon">
                <div class="card-icon">
                    <i class="fas fa-laptop fa-2x"></i>
                </div>
                <a href="materiales.php" class="card-category text-danger font-weight-bold">
                    Materiales
                </a>
                <h3 class="card-title"><?php echo $total['materiales']; ?></h3>
            </div>
            <div class="card-footer bg-danger">
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6">
        <div class="card card-stats">
            <div class="card-header card-header-info card-header-icon">
                <div class="card-icon">
                    <i class="fas fa fa-file fa-2x"></i>
                </div>
                <a href="lista_cargos.php" class="card-category text-info font-weight-bold">
                    Cargos
                </a>
                <h3 class="card-title"><?php echo $total['cargos']; ?></h3>
            </div>
            <div class="card-footer bg-info text-white">
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header card-header-primary">
                <center>
                    <h3 class="title-2 m-b-40">Materiales más remitidos</h3>
                </center>
            </div>
            <div class="card-body">
                <canvas id="ProductosVendidos"></canvas>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header card-header-primary">
                <center>
                    <h3 class="title-2 m-b-40">Materiales con stock mínimo</h3>
                </center>
            </div>
            <div class="card-body">
                <canvas id="stockMinimo"></canvas>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <h3>Materiales en Stock</h3>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-success table-bordered" id="tbl">
                    <thead class="thead-dark">
                        <tr>
                            <th>#</th>
                            <th>Código</th>
                            <th>Material</th>
                            <th>Categoria</th>
                            <th>Marca</th>
                            <th>Precio</th>
                            <th>Stock</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        include "../conexion.php";
                        $hoy = date('Y-m-d');
                        $query = mysqli_query($conexion, "SELECT m.*, c.id, c.categoria, marc.id, marc.nombre FROM materiales m INNER JOIN categorias c ON m.id_categoria = c.id INNER JOIN marca marc ON m.id_marca = marc.id WHERE m.fecha_actual != '0000-00-00' AND m.fecha_actual < '$hoy'");
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
                                        <form action="eliminar_producto.php?id=<?php echo $data['codmateriales']; ?>" method="post" class="confirmar d-inline">
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