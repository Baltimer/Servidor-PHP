<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Material+Icons">
    <link rel="stylesheet" href="https://unpkg.com/bootstrap-material-design@4.0.0-beta.4/dist/css/bootstrap-material-design.min.css" integrity="sha384-R80DC0KVBO4GSTw+wZ5x2zn2pu4POSErBkf8/fSFhPXHxvHJydT0CSgAP2Yo2r4I" crossorigin="anonymous">
</head>
<body>
<?php 

/**
 * Inicializo la conexion a la base de datos y permito la insercción de acentos
 */
$dwes = new mysqli('localhost', 'root', null, 'dwes');
$acento = $dwes->query("SET NAMES 'utf8'");

/**
 * Compruebo que no haya ningún error en la conexión de la base de datos
 */
$error = $dwes -> connect_errno;

if($error != null){
    echo "<p>Error $error conectando a la base de datos: $dwes -> connect_errno</p>";
    exit();
}

/**
 * Realizo la query para imprimir todas las familias dentro del select
 */
$resultado = $dwes->query('SELECT cod, nombre FROM familia');

?>
<div class="container">
<div class="jumbotron">
<h1 class="display-3">Tarea: Listado de productos de una familia</h1>
</div>

<form action="index.php" method="post">
<div style="display:flex;">
<?php
    /**
     * Rellenamos el select de la tabla familia
     */
    echo "<select name='categoria' class='form-control'>";

    while($row = $resultado->fetch_assoc()) {
        echo "<option  value=".$row["cod"].">" . $row["nombre"] . "</option>";
        }

    echo "</select>";

    ?> 
    
    <div style="display:inline-block;">
    <button type="submit" name="" class="btn btn-primary">Mostrar Productos </button>
    </div>   
    </div>
<?php
    echo "</form>";
        /**
         * Recoge el campo seleccionado de familia y pinta todos sus productos. 
         */
        if(isset($_POST['categoria'])){
            $categoria = $_POST['categoria'];
            $resultadoProducto = $dwes->query('SELECT * FROM producto WHERE  familia = '."'". $_POST['categoria']."'");             
                while($row1 = $resultadoProducto->fetch_assoc()) {
                    echo "<form action ='editar.php'  method='post'>";
                    echo "<input type='text' name='codigoProducto' value='".$row1["cod"]."' hidden>";
                    echo "<p>" . $row1["nombre_corto"] . " - " . $row1["PVP"] ." - EUROS </p>";
                    echo "<button class='btn btn-primary'>Editar</button>";
                    echo "</form>";
                    }
        }

?>
  </div>
</body>
</html>




