<!DOCTYPE html>
<html lang="en">
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
     * Nos conectamos en la base de datos y eliminamos los acentos
     */
    $dwes = new mysqli('localhost', 'root', null, 'dwes');
    $acento = $dwes->query("SET NAMES 'utf8'");

    $error = $dwes -> connect_errno;
    if($error != null){
        echo "<p>Error $error conectando a la base de datos: $dwes -> connect_errno</p>";
        exit();
    }   
     /**
      * si le dan a actualizar actualizado los atributos seleccionados si no se produce los cambios manda un error
      */
     if(isset($_POST['actualizar'])){

        $idProducto = $_POST['idProducto'];
        $nombreCorto = $_POST['nombreCorto'];
        $nombre = $_POST['nombre'];
        $descripcion = $_POST['descripcion'];
        $pvp = $_POST['pvp'];
        $actualizar = $_POST['actualizar'];
        $resultadoProducto = $dwes->query("UPDATE producto SET nombre_corto = '". $nombreCorto ."' ,  nombre = '". $nombre ."' ,  descripcion = '". $descripcion ."' , PVP = '". $pvp ."'  WHERE  cod = '". $idProducto."'"); 
        if($resultadoProducto == 0){
            echo "<div class='list-group'> <p class='list-group-item list-group-item-action list-group-item-danger'>ERROR no se han actualizado los datos</p></div>";
        }else{
           echo "<div class='list-group'> <p class='list-group-item list-group-item-action list-group-item-success'>Los datos se han actualizado correctamente</p></div>";
        }
     }
     
     
    
    ?>

    <form action="index.php" method="post">
    
    <button type="submit" class="btn btn-primary">Aceptar</button>
    
    </form>
    
</body>
</html>