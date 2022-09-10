<?php
session_start();
if (!empty($_SESSION['active'])) {
    header('location: src/');
} else {
    if (!empty($_POST)) {
        $alert = '';
        if (empty($_POST['usuario']) || empty($_POST['clave'])) {
            $alert = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                        Ingrese usuario y contraseña
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>';
        } else {
            require_once "conexion.php";
            $user = mysqli_real_escape_string($conexion, $_POST['usuario']);
            $clave = md5(mysqli_real_escape_string($conexion, $_POST['clave']));
            $query = mysqli_query($conexion, "SELECT * FROM usuario WHERE usuario = '$user' AND clave = '$clave'");
            mysqli_close($conexion);
            $resultado = mysqli_num_rows($query);
            if ($resultado > 0) {
                $dato = mysqli_fetch_array($query);
                $_SESSION['active'] = true;
                $_SESSION['idUser'] = $dato['idusuario'];
                $_SESSION['nombre'] = $dato['nombre'];
                $_SESSION['user'] = $dato['usuario'];
                header('Location: src/');
            } else {
                $alert = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                        Contraseña incorrecta
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>';
                session_destroy();
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Iniciar Sesión</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="assets/css/material-dashboard.css?v2.0">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel="icon" href="assets/img/icon.png">
    <link rel="stylesheet" href="assets/css/style.css">
    <!-- End layout styles -->
    <link rel="shortcut icon" href="assets/img/favicon.ico" />
</head>

<body class="bg">
    <div class="col-md-4 mx-auto">
        <?php /*echo (isset($alert)) ? $alert : '' ;*/ ?>
							<div class="card">
								<div class="card-header card-header-primary text-center">
                                    <h3 class="card-title">Iniciar Sesión</h3>
									<img class="img-thumbnail" src="assets/img/municipalidad.png" width="500"/>
								</div>
								<div class="card-body">
									<?php echo (isset($alert)) ? $alert : ''; ?>
									<form action="" method="post" class="p-3">
										<div class="form-group">
											<input type="text" class="form-control form-control-lg text-center" id="exampleInputEmail1" placeholder="Ingresar Usuario" name="usuario">
										</div>
										<div class="form-group">
											<input type="password" class="form-control form-control-lg text-center" id="exampleInputPassword1" placeholder="Ingresar contraseña" name="clave">
										</div>
										<div class="mt-3">
											<button class="btn btn-block btn-success btn-lg font-weight-medium auth-form-btn" type="submit">Ingresar</button>
										</div>

									</form>
								</div>
							</div>
    </div>
    <!-- container-scroller -->
    <!-- plugins:js -->
    <script src="assets/js/material-dashboard.js"></script>
    <!-- endinject -->
</body>

</html>