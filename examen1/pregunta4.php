<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Pregunta 4</title>
    <style>
        fieldset{
            width: 500px;
        }
    </style>
</head>
<body>
    <?php
        define('INTENTOS', 5);
        $intentosTotales = 0;
        $numero = rand(1, 10); // Generamos un número aleatorio
        // Inicializamos banderas a falso
        $elegido = false;
        $bajo = false;
        if(isset($_POST['intentos'])){
            // Si hemos hecho almenos 1 intento, buscamos si es el número elegido
            // y en caso de no serlo, definimos la bandera $bajo para saber si el
            // número es más alto o más bajo que el que debe encontrar
            $intentosTotales = $_POST['intentos'] + 1;
            $numero = $_POST['numero'];
            if($numero == $_POST['elegido']){
                $elegido = true;
            } else if ($_POST['elegido'] < $numero){
                $bajo = true;
            }
        }

        if($elegido){ // Mostramos mensaje si ha encontrado el número
    ?>
        <h1>ENHORABUENA, HAS GANADO!</h1>
        <form action="pregunta4.php" method="get">
        <button type="submit">Jugar de nuevo</button>
    </form>
    <?php
        }else if($intentosTotales < INTENTOS){ // Si ha fallado y lleva menos intentos
    ?>

    <fieldset>
    <legend>Encuentra el número correcto</legend>
        <p>Llevas: <?php echo $intentosTotales ?> intentos.</p>
        <?php 
            // Le indicamos al usuario si el número es más alto o más bajo
            if($intentosTotales > 0 && $bajo){
        ?>
        <p>El número <?php echo $_POST['elegido'] ?> es demasiado bajo</p>
        <?php } else if($intentosTotales > 0){ ?>
        <p>El número <?php echo $_POST['elegido'] ?> es demasiado alto</p>
        <?php } ?>
        <form action="pregunta4.php" method="post">
        
            <input type="hidden" name="intentos" value="<?php echo $intentosTotales ?>"/>
            <input type="hidden" name="numero" value="<?php echo $numero ?>">
            <p>Adivina un número entre 1 y 10, con un máximo de 5 intentos.</p>
            <label for="elegido">Número</label>
            <input type="number" name="elegido" />
            <br><br>
            <button type="submit">Enviar</button>
        </form>
        <form action="pregunta4.php" method="get">
            <button type="submit">Repetir</button>
        </form>
    </fieldset>
    <?php
        } else { // Le mostramos al usuario el mensaje de error
    ?>
    <h1>LO SIENTO, HAS PERDIDO!</h1>
    <form action="pregunta4.php" method="get">
        <button type="submit">Vuelve a intentarlo</button>
    </form>
    <?php
        }
    ?>
</body>
</html>