<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" content="text/html; charset=utf8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Conexión a base de datos</title>
    <style>
        fieldset{
            width:600px;
        }
        td{
            text-align: center;
            padding: 5px;
        }
        table#t01 {
            width: 550px; 
            background-color: #f1f1c1;
        }

        table#t01 tr:nth-child(even) {
            background-color: #eee;
        }
        table#t01 tr:nth-child(odd) {
            background-color: #fff;
        }
        table#t01 th {
            color: white;
            background-color: black;
        }
    </style>
</head>
<body>
    <?php
        /**
         * Establecemos conexión con la base de datos y obtenemos todas las familias
         * de los productos.
         */
        try{
            mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT); // Lanza las excepciones de msqli
            $con = new mysqli('localhost', 'root', '', 'dwes'); // conectamos con la bbdd

            $con->query("SET NAMES 'utf8'"); // Establecer UTF-8 para las queries

            $familias = $con->query('SELECT * FROM familia'); // Obtenemos las familias
        }catch (Exception $e){
            /**
             * Tratamos las excepciones 
             */
            if($e->getCode() == 2002){ // Error de conexión
                echo 'Error: No se ha podido establecer conexión con la base de datos.';
            } else{
                echo 'Error inesperado, por favor vuelve a intentarlo más tarde.';
            }
        }
    ?>
</body>
    <fieldset>
    <legend>Familia de Productos</legend>
    <form action="listado.php" method="POST">
        <select name="familia">
            <?php
                /**
                 * Recorremos todas las familias para obtener el nombre 
                 * y el código de cada una
                 */
                while ($familia = $familias->fetch_object()) {
                    echo '<option value="' . $familia->cod .'">' . $familia->nombre . '</option>';
                }
            ?>
        </select>
        <button action="submit">Mostrar Productos</button>
    </form>
    </fieldset>
    <?php if(isset($_POST['familia'])){
        /**
         * Obtenemos los productos de la familia seleccionada
         */
        $productos = $con->query('SELECT * FROM producto WHERE familia = "' . $_POST['familia'] . '"');
    ?>
    <fieldset>
    <legend>Resultados</legend>
        <table id='t01'>
            <tr>
                <th width='25%'>COD</th>
                <th width='50%'>Nombre</th>
                <th>PVP</th>
                <th>Acción</th>
            </tr>
            <?php while($producto = $productos->fetch_object()){
                /**
                 * Formateamos cada producto dentro de la tabla
                 */
                echo '<tr><form method="POST" action="editar.php"><input type="hidden" name="codigo" value="' . $producto->cod . '" /><td>' . $producto->cod . '</td><td>'.$producto->nombre_corto .'</td><td>'.$producto->PVP.
                '</td><td><button action="submit">Editar</button></form></tr>';
            } ?>
        </table>
    </fieldset>

    <?php } ?>
</html>