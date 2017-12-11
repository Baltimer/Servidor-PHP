<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Práctica formulario</title>
    <style>
        fieldset{
            width: 300px;
        }
        label{
            width:50px;
        }
        td{
            text-align: center;
        }
        table#t01 {
            width: 300px; 
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
        #error{
            background-color: red;
            color: white;
            width: 330px;
            text-align: center;
        }
        #succes{
            background-color: green;
            color: white;
            width: 330px;
            text-align: center;
        }
    </style>
</head>
<body>
<?php
    // Iniciamos la sesion
    session_start([
        'cookie_lifetime' => 86400,
    ]);
    $agenda = isset($_SESSION['agenda']) ? $_SESSION['agenda'] : array();

    $mensaje = ''; // String donde se almacena si ha ido bien la operación
    $error = ''; // String donde se almacena un error

    // Inicializamos el nombre y el teléfono
    $nombre = (isset($_POST['nombre'])) ? trim($_POST['nombre']) : ''; // Eliminamos espacios sobrantes
    $telefono = (isset($_POST['telefono'])) ? trim($_POST['telefono']) : ''; // Eliminamos espacios sobrantes

    // Variables para devolver el nombre o el teléfono en caso de haber un errro
    $nombreContacto = '';
    $numeroTelefono = '';

    /**
     * Comprobamos que se haya enviado un nombre y un telefono, para posteriormente
     * validarlo. Una vez validad, comprobamos que no exista ya ese contado y, si no
     * existe, lo guardamos en la agenda.
     * 
     * Si el contacto existe, se sobrescribe si se ha definido un teléfono, en caso
     * contrario se eliminará dicho contacto de la agenda.
     */
    if(isset($_POST['nombre']) || isset($_POST['telefono'])){
        if(validarNombre($nombre)){ // validamos el nombre
            if(existeContacto($nombre) && $telefono != '') { // Si existe el contacto y hay teléfono
                guardarContacto($nombre, (int)$telefono);
                $mensaje = 'El contacto ' . $nombre . ' se ha actualizado correctament.';
            } else if(existeContacto($nombre) && $telefono == ''){ // Si existe contacto y NO hay teléfono 
                eliminarContacto($nombre);
                $mensaje = 'El contacto ' . $nombre . ' se ha eliminado correctamente.';
            } else if(is_numeric($telefono) && strlen($telefono) == 9){ // Si el teléfono es un número de longitud 9 
                guardarContacto($nombre, (int)$telefono);
                $mensaje = 'El contacto ' . $nombre . ' se ha guardado correctamente.';
            } else { // Si el número NO es correcto
                global $nombreContacto;
                $nombreContacto = $nombre;
                $error = 'Introduce un número correcto.';
            }
        } else { // Si el nombre NO es correcto
            global $numeroTelefono;
            $numeroTelefono = $telefono;
            $error = 'Introduce un nombre correcto';
        }
    }

    /**
     * Valida el nombre y devuelve un booleano
     * 
     * @param string $nombre nombre del contacto
     * 
     * @return boolean
     */
    function validarNombre($nombre){
        if(!is_numeric($nombre) && $nombre != ''){
            return true;
        } else {
            return false;
        }
    }

    /**
     * Añade un contacto de la agenda
     * 
     * @param string $nombre nombre del contacto
     * @param integer $telefono teléfono del contacto
     * 
     * @return void
     */
    function guardarContacto($nombre, $telefono){
        global $agenda;
        $agenda[$nombre] = $telefono;
    }

    /**
     * Elimina un contacto de la agenda
     * 
     * @param string $nombre nombre del contacto
     * 
     * @return void
     */
    function eliminarContacto($nombre){
        global $agenda;
        unset($agenda[$nombre]);
    }

    /**
     * Función que comprueba si hay un contacto con el nombre que
     * le pasamos y devuelve un booleano
     * 
     * @param string $nombre nombre del contacto
     * 
     * @return string
     */
    function existeContacto($nombre){
        global $agenda;
        if(array_key_exists($nombre, $agenda)){
            return true;
        } else {
            return false;
        }
    }
    
?>
    <h2>Formulario con validación en <i>PHP</i></h2>
    <?php 
        // Muestra los mensajes al usuario
        if($mensaje != ''){
            echo '<div id="succes">' . $mensaje . '</div>';
        }
        if($error != ''){
            echo '<div id="error">' . $error . '</div>';
        }
    ?>
    <!-- Inicio formulario -->
    <form method="post">
        <fieldset>
            <legend>Insertar contacto</legend>
            <label for="nombre">Nombre:&nbsp;</label>
            <input type="text" name="nombre" value="<?php echo $nombreContacto ?>">
            <br>
            <br>
            <label for="telefono"> Teléfono: </label>
            <input type="tel" name="telefono" value="<?php echo $numeroTelefono ?>" pattern="[0-9]{9}|(\W&\D&\S)">
            <br>
            <br>
            <button type="submit">Guardar</button>
        </fieldset>
    </form>
    <!-- Fin formulario -->
    <!-- Inicio agenda -->
    <fieldset>
        <legend>Agenda</legend>
        <table id='t01'>
        <tr>
          <th>Nombre</th>
          <th>Telefono</th> 
        </tr>
        <?php 
            // Printamos todos los contactos de la agenda
            foreach($agenda as $nombre => $telefono){
                echo '<tr><td>' . $nombre . '</td><td>' . $telefono . '</td></tr>';
            }
            // Guardamos la agenda en la sesión
            if(count($agenda) > 0) {
                $_SESSION['agenda'] = $agenda;
            }
        ?>
        </table>
    </fieldset>
    <!-- Fin agenda -->
</body>
</html>