<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>LogIn</title>
    <link rel="stylesheet" type="text/css" href="../CSS/Login.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>    
<body>

    <div class="wrapper">
        <span class="bg-animate"></span>
        <span class="bg-animate2"></span>

        <div class="form-box login">
            <h2 class="animation" style="--i:0; --j:21;">Login</h2>
            <form action="prueba1.php" method="POST">
                <div class="input-box animation" style="--i:1; --j:22;">
                    <input type="text" required name="Usuario" id="Campo1" class="custom-input">
                    <label for="Campo1">Usuario</label>
                    <i class='bx bxs-user'></i>
                </div>
                <div class="input-box animation" style="--i:2; --j:23;">
                    <input type="password" required name="Contraseña" id="Campo2">
                    <label for="Campo2">Password</label>
                    <i class='bx bxs-lock-alt'></i>
                </div>
                <button type="submit" class="btn animation" style="--i:3; --j:24;">Entrar</button>

                <div class="logreg-link animation" style="--i:4; --j:25;">
                    <p>No tienes cuenta? <a href="#" class="register-link">Registrate</a></p>
                </div>
            </form>
        </div>
        <div class="info-text login">
            <h2 class="animation" style="--i:0; --j:20;">¡Hola de nuevo!</h2>
            <p class="animation" style="--i:1; --j:21;"></p>
        </div>

        <div class="form-box register">
            <h2 class="animation" style="--i:17; --j:0;">Registro</h2>
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                <div class="input-box animation" style="--i:18; --j:1;">
                    <input type="text" required name="Usuario" id="RegUsuario">
                    <label for="RegUsuario">Usuario</label>
                    <i class='bx bxs-user'></i>
                </div>
                <div class="input-box animation" style="--i:19; --j:2;">
                    <input type="text" required name="Apellidos" id="RegApellidos">
                    <label for="RegApellidos">Apellidos</label>
                    <i class='bx bxs-user'></i>
                </div>
                <div class="input-box animation" style="--i:20; --j:3;">
                    <input type="email" required name="Email" id="RegEmail">
                    <label for="RegEmail">Email</label>
                    <i class='bx bxs-envelope'></i>
                </div>
                <div class="input-box animation" style="--i:21; --j:4;">
                    <input type="password" required name="contraseña" id="RegContraseña">
                    <label for="RegContraseña">Password</label>
                    <i  class='bx bxs-lock-alt'></i>
                </div>
                <button type="submit" class="btn animation" style="--i:22; --j:5;">Guardar</button>

                <div class="logreg-link animation" style="--i:23; --j:6;">
                    <p>Ahora inicia tu sesion? <a href="#" class="login-link">login</a></p>
                </div>
            </form>
        </div>
        <div class="info-text register">
            <h2 class="animation" style="--i:17; --j:0;">Regístrate!</h2>
            <p class="animation" style="--i:18; --j:1;">Este proyecto se realiza para conocer el comportamiento del clima en el invernadero de fresas</p>
        </div>
    </div>
    
    <script src="../JS/Login.js"></script>
    <script>
        <?php
        session_start();
        if (isset($_SESSION['login_success'])) {
            echo "
            Swal.fire({
                position: 'top-end',
                icon: 'success',
                title: 'Bienvenido',
                showConfirmButton: false,
                timer: 1500
            });
            ";
            unset($_SESSION['login_success']);
        }
        if (isset($_SESSION['login_error'])) {
            echo "
            Swal.fire({
                position: 'top-center',
                icon: 'error',
                title: 'Usuario o contraseña incorrectos',
                showConfirmButton: false,
                timer: 1500
            });
            ";
            unset($_SESSION['login_error']);
        }
        ?>

        function mostrar(){ 
            Swal.fire({
                position: "top-end",
                icon: "success",
                title: "El registro se ha guardado",
                showConfirmButton: false,
                timer: 1500
            });
        }
    </script>
</body>
</html>

<?php 
if(isset($_POST['Usuario']) && isset($_POST['Apellidos']) && isset($_POST['Email']) && isset($_POST['contraseña'])){
    $con = mysqli_connect("bfhcqaz7dcnefult7yo9-mysql.services.clever-cloud.com", "uhougzfja5rrs8sh", "Ma0TA9vRq0YG3hEd7aZE", "bfhcqaz7dcnefult7yo9"); 

    mysqli_query($con, "INSERT INTO login_registro(Usuario, Apellidos, Email, Contraseña) VALUES ('$_POST[Usuario]','$_POST[Apellidos]','$_POST[Email]','$_POST[contraseña]')");    
}
?>