<!DOCTYPE html>
<!--
Alumno: Marc Hernandez Cabot
-->
<html>
<head>
    <meta charset="UTF-8">
    <title>Agenda</title>
</head>
<body>

<h1>Agenda de contactos</h1>

<?php

################ FUNCIONES ################

/**
 * Actualiza el array agenda
 *
 * Recibe un nombre y un teléfono y los añade a la agenda si todavía no constaban. Si el nombre ya constaba en la agenda
 * con otro teléfono se sustituye el valor del teléfono. Si se introduce un nombre pero se deja el campo del teléfono
 * vacío se elimina el contacto y se imprime un mensaje advirtiéndolo. Finalmente, si se introduce solo un teléfono no
 * se actualiza la agenda y se imprime un mensaje advirtiéndolo.
 *
 * @param $nombre
 * @param $telefono
 */
function actualizar_agenda($nombre, $telefono)
{
    // Se accede a la agenda del ambito global.
    global $agenda;

    // Si se han introducido un nombre y un teléfono --> se añade a la agenda o se actualiza.
    if (!empty($telefono) && !empty($nombre)) {
        $agenda[trim($nombre)] = $telefono;
     // Si se ha introducido un nombre pero no se ha introducido un teléfono --> si el contacto existe se borra de
     // la agenda y se lanza un mensaje advirtiendo que se ha eliminado, si no existe el contacto se lanza una aviso de
     // que para guardar un contacto es necesario introducir un numero de telefono.
    } elseif (!empty($nombre) && empty($telefono)) {
        if (isset($agenda[$nombre])) {
            unset($agenda[$nombre]);
            echo "Nota: Se ha eliminado de la agenda el contacto '$nombre'.";
        } else {
            echo "Nota: Debes introducir un teléfono si el contacto todavía no esta en la agenda.";
        }

    // Si se ha introducido un teléfono pero no se ha introducido un nombre --> se lanza un mensaje advirtiendo que no
    // se ha guardado.
    } elseif (empty($nombre) && !empty($telefono)) {
        echo "Atención: ¡Has introducido un número de teléfono pero no has introducido ningún nombre! Introduce un
         nombre si quieres añadir un contacto a la agenda.";

    // Si no se ha introducido un teléfono ni se ha introducido un nombre y la agenda no esta vacia --> se lanza un
    // mensaje advirtiendo de que no se ha aregado nigun contacto a la agenda.
    } elseif (empty($nombre) && empty($telefono) && count($agenda) > 0) {
        echo "Nota: No has introducido ningún nombre ni ningún número de teléfono, por lo que no se ha añadido ningún 
        contacto a la agenda.";
    };
}

;


/**
 * Genera hidden inputs para guardar los contactos
 *
 * Imprime un input con de tipo "hidden" por cada par nombre-télefono que encontramos en la agenda para conseguir
 * persistencia de datos utilizando sólo html. La clave se utiliza para escribir el "name" y el valor para escribir el
 * "value".
 *
 * @param $agenda
 */
function agregar_inputs_ocultos($agenda)
{
    // Recorre la agenda y genera un input
    foreach ($agenda as $nombre => $telefono) {
        echo "<input name='agenda[$nombre]' value='$telefono' type='hidden'/>";
    }
}

;

/**
 * Imprime los contactos
 *
 * Por cada contacto en la agenda imprime una linea en html con su nombre y su teléfono.
 *
 * @param $agenda
 */
function mostrar_contactos($agenda)
{
    // Se recorre la agenda uno a uno y se imprime  los elementos de la agenda
    foreach ($agenda as $nombre => $telefono) {
        echo "<i>Nombre:</i> " . $nombre . ". <i>Teléfono: </i>" . $telefono . ".<br/>";
    }
}

;


################ PROGRAMA PRINCIPAL ################

// Obtenemos la agenda anterior
$agenda = isset($_POST['agenda']) ? $_POST['agenda'] : array();

// Obtenemos el nombre y el telefono nuevo
$nombre = isset($_POST['nombre']) ? $_POST['nombre'] : null;
$telefono = isset($_POST['telefono']) ? $_POST['telefono'] : null;

// Actualizamos la agenda
actualizar_agenda($nombre, $telefono);

?>

<h2>Añadir contactos</h2>
<strong>Instrucciones</strong>
<ol>
    <li>Añade un contacto introduciendo su nombre y su teléfono y pulsando el botón "Añadir contacto".</li>
    <li>Puedes editar un contacto introduciendo su nombre y un nuevo teléfono y pulsando el botón "Añadir contacto".
    </li>
    <li>Si quieres eliminar un contacto introduce su nombre, deja el campo de teléfono vacío y pulsa el botón "Añadir
        contacto".
    </li>
</ol>

<strong>Formulario</strong><br/><br/>
<form method="post">
    <label for="nombre">Nombre</label>
    <input name="nombre" id="nombre" type="text" value=""/><br/><br/>

    <label for="telefono">Teléfono</label>
    <input name="telefono" id="telefono" value="" type="tel"/><br/><br/>

    <input type="submit" value="Añadir contacto"/>

    <?php agregar_inputs_ocultos($agenda); ?>
</form>

<h2>Contactos</h2>

<?php mostrar_contactos($agenda); ?>

</body>
</html>