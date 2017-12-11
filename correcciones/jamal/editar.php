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
     * Nos conectamos a la base de datos dwes y admitimos los acentos
     */
    $dwes = new mysqli('localhost', 'root', null, 'dwes');
    $acento = $dwes->query("SET NAMES 'utf8'");

    $error = $dwes -> connect_errno;    
    if($error != null){
        echo "<p>Error $error conectando a la base de datos: $dwes -> connect_errno</p>";
        exit();
    }   
    /**
     * Realizamos la query para coger todos los atributos del producto seleccionado y los pintamos en el formulario
     */
    $resultadoProducto = $dwes->query('SELECT * FROM producto WHERE  cod = '."'". $_POST['codigoProducto']."'"); 
    $fila = mysqli_fetch_assoc($resultadoProducto);                
    ?>
    <div class="container" style="margin-top:50px;">
        <div class="form-group">
            <form action="actualizar.php" method="post">
                <input type="hidden" name="idProducto" value="<?php echo $fila['cod']; ?>">
                <label for="exampleInputEmail1">Nombre corto</label>
                <input type="text" class="form-control form-control-lg is-valid" name="nombreCorto" value="<?php echo $fila['nombre_corto']; ?>">
                <label for="exampleInputEmail1">Nombre</label>
                <input type="text" class="form-control form-control-lg is-valid" name="nombre" value="<?php echo $fila['nombre']; ?>">
                <label for="exampleInputEmail1">Descripción</label>
                <textarea style="width: 100%;" name="descripcion" class="form-control text-justify" id="" cols="30" rows="10">
                <?php echo $fila['descripcion']; ?>
                </textarea>
                <label for="exampleInputEmail1">PVP</label>
                <input type="number" class="form-control form-control-lg is-valid" step=".01" name="pvp" value="<?php echo $fila['PVP']; ?>">  
                </input>
                <div style="display:flex;">
                <button name="actualizar" class="btn btn-primary" type="submit">Actualizar</button>
            </form>
            <form action="index.php">
                <button type="submit" class="btn btn-danger">Cancelar</button>
            </form>
        </div>
    </div>
    </div>
    
</body>
</html>