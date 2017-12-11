<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Editar un producto</title>
    <style>
        fieldset{
            width:600px;
        }
    </style>
</head>
<body>
    <?php
        /**
         * Establecemos conexión con la base de datos y obtenemos el
         * producto seleccionado
         */
        try{
            mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT); // Lanza las excepciones de msqli
            $con = new mysqli('localhost', 'root', '', 'dwes'); // Establecemos conexion con la base de datos
            
            $con->query("SET NAMES 'utf8'"); // Establecer UTF-8 para las queries
            if(isset($_POST['codigo'])){
                // Obtenemos el producto seleccionado
                $producto = $con->query('SELECT * FROM producto WHERE cod = "' . $_POST['codigo'] . '"')->fetch_object();
            }
    ?>
        <fieldset>
        <legend><?php echo $producto->nombre_corto; ?></legend>
        <!-- Inicio formulario -->
        <form action="actualizar.php" method="POST">
            <p>
                <input type="hidden" name="codigo" value="<?php echo $producto->cod; ?>" >
                <input type="text" value="<?php echo $producto->cod; ?>" disabled style="width: 120px;">
                <input type="text" name="nombre-corto" value="<?php echo $producto->nombre_corto; ?>" style="width: 209px;">
                <input type="number" step=".01" name="pvp" value="<?php echo $producto->PVP; ?>" style="width: 100px;">
            </p>
            <p>
                <input type="text" name="nombre" value="<?php echo $producto->nombre; ?>">
            </p>
            <p>
                <textarea name="descripcion" cols="55" rows="15"><?php echo $producto->descripcion; ?></textarea>
            </p>
            <button name="actualizar" action="submit">Actualizar</button>
            <button name="cancelar" action="submit">Cancelar</button>
        </form>
        <!-- Fin formulario -->
        </fieldset>
    <?php
        }catch (Exception $e){
            /**
             * Tratamos las excepciones 
             */
            if($e->getCode() == 2002){
                echo 'Error: No se ha podido establecer conexión con la base de datos.';
            } else{
                echo 'Error inesperado, por favor vuelve a intentarlo más tarde.    ';
            }
        }
    ?>
</body>
</html>