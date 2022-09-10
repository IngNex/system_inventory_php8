<?php
session_start();
require("../conexion.php");
$id_user = $_SESSION['idUser'];
$permiso = "nuevo_cargo";
$sql = mysqli_query($conexion, "SELECT p.*, d.* FROM permisos p INNER JOIN detalle_permisos d ON p.id = d.id_permiso WHERE d.id_usuario = $id_user AND p.nombre = '$permiso'");
$existe = mysqli_fetch_all($sql);
if (empty($existe) && $id_user != 1) {
    header('Location: permisos.php');
}
include_once "includes/header.php";
?>
<div class="row">
    <div class="col-lg-12">
        <!--<div class="form-group">
            <h4 class="text-center">Datos del adquisidor</h4>
        </div>-->
        <div class="card">
            <div class="card-header bg-success text-white text-center">
                Buscar Adquisidor
            </div>
            <div class="card-body">
                <form method="post">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <input type="hidden" id="idadquisidor" value="1" name="idadquisidor" required>
                                <label>Nombre</label>
                                <input type="text" name="nom_adquisidor" id="nom_adquisidor" class="form-control" placeholder="Ingrese nombre del adquisidor" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Celular</label>
                                <input type="number" name="tel_adquisidor" id="tel_adquisidor" class="form-control" disabled required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Dirreción</label>
                                <input type="text" name="dir_adquisidor" id="dir_adquisidor" class="form-control" disabled required>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="card">
            <div class="card-header bg-danger text-white text-center">
                Buscar Material
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-5">
                        <div class="form-group">
                            <label for="materiales">Código o Nombre</label>
                            <input id="materiales" class="form-control" type="text" name="materiales" placeholder="Ingresa el código o nombre">
                            <input id="id" type="hidden" name="id">
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="form-group">
                            <label for="cantidad">Cantidad</label>
                            <input id="cantidad" class="form-control" type="text" name="cantidad" placeholder="Cantidad" onkeyup="calcularPrecio(event)">
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="form-group">
                            <label for="valor">Monto Valorizado</label>
                            <input id="valor" class="form-control" type="text" name="valor" placeholder="valorización de material" disabled>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="form-group">
                            <label for="sub_total">Valorización Total</label>
                            <input id="sub_total" class="form-control" type="text" name="sub_total" placeholder="Valorización Total" disabled>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div class="card">
        <div class="table-responsive">
            <table class="table table-hover" id="tblDetalle">
                <thead class="thead-dark">
                    <tr>
                        <th width="100">Id</th>
                        <th >Descripción</th>
                        <th >Cantidad</th>
                        <th width="150">Aplicar Depreciación</th>
                        <th >Depreciación</th>
                        <th>Valorizado</th>
                        <th>Valorización Total</th>
                        <th>Accion</th>
                    </tr>
                </thead>
                <tbody id="detalle_cargo">
                    <!--funciones.js-->
                </tbody>
                <tfoot>
                    <tr class="font-weight-bold">
                        <td>Total Valorizado</td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
        </div>
        </div>
    </div>
    <div class="col-md-6">
        <a href="#" class="btn btn-warning" id="btn_generar"><i class="fas fa-save mr-2"></i>Generar Cargo</a>
    </div>

</div>
<?php include_once "includes/footer.php"; ?>