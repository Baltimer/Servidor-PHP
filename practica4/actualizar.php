<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Actualizar</title>
</head>
<body>
    <?php
        /**
         * Comprueba si se ha seleccionado actualizar el producto y, en caso de
         * haber actualizado, introduce 
         */
        if(isset($_POST['actualizar'])){
            try{
                mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT); // Lanza las excepciones de msqli
                $con = new mysqli('localhost', 'root', '', 'dwes'); // Establecemos conexion con la base de datos
                
                $con->query("SET NAMES 'utf8'"); // Establecer UTF-8 para las queries

                // Actualizamos el producto con los datos introducidos por el usuario
                $con->query('UPDATE producto SET nombre_corto = "' . $_POST['nombre-corto'] . '", descripcion="' .
                    $_POST['descripcion'] . '", PVP="' . $_POST['pvp'] . '", nombre="' . 
                    $_POST['nombre'] . '" WHERE cod = "' . $_POST['codigo'] . '"');

            }catch (Exception $e){
                /**
                 * Tratamos las excepciones 
                 */
                if($e->getCode() == 2002){
                    echo 'Error: No se ha podido establecer conexión con la base de datos.';
                } else{
                    echo 'Error inesperado, por favor vuelve a intentarlo más tarde.';
                }
            }
        }
        // Aplicamos la redirección a listado.php
        header('Location: listado.php');
        die();
    ?>
</body>
</html>