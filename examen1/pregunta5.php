<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <?php
        // Creamos un array de longitud X y con valores desde 1 a X
        function crear($longitud)
        {
            $arrayBandera = []; // Array vacio que se usará para generar uno aleatorio
            for($i = 0; $i < $longitud; $i++){
                $arrayBandera[$i] = rand(1, $longitud); // Introducimos un número aleatorio
            }
            return $arrayBandera;
        }

        // Método de ordenación de la burbuja
        function ordenarBurbuja($arrayNumeros)
        {
            $longitud = count($arrayNumeros);
            for ($i=0; $i<$longitud; $i++) {
                for ($j=$i+1; $j<$longitud; $j++) {
                    if($arrayNumeros[$j] < $arrayNumeros[$i]){
                        $num = $arrayNumeros[$i];
                        $arrayNumeros[$i] = $arrayNumeros[$j];
                        $arrayNumeros[$j] = $num;
                    }
                }
            }
            return $arrayNumeros;
        }
        // Creamos un array y copiamos el contenido a otro, ordenandolo posteriormente con sort
        $array = crear(10);
        $arrayCopia = $array;
        sort($arrayCopia);
        
        ?>
        <h4>Array desordenado: [<?php echo implode(',', $array) ?>] </h4>
        <h4>Array ordenado (burbuja): [<?php echo implode(',', ordenarBurbuja($array)) ?>]</h4>
        <h4>Array ordenado (sort[php]): [<?php echo implode(',', $arrayCopia) ?>]</h4>

        <?php
            // Función para tratar los mensajes de error de los asserts
            function assert_failure(){
                echo 'Ha fallado el assert';
            }
            // Función para comprobar los asserts
            function test_assert($array1, $array2){
                assert($array1 == $array2);
            }
            test_assert(ordenarBurbuja($array), $arrayCopia);
            // Aquí podemos ver como el assert da True y no devuelve error, en caso de dar error
            // devolvería un aviso

            // opciones que le establecemos al assert
            assert_options(ASSERT_ACTIVE, 1);
            assert_options(ASSERT_WARNING, 0);
            assert_options(ASSERT_QUIET_EVAL, 1);
            assert_options(ASSERT_CALLBACK, 'assert_failure');

            // Documentación sacada de:
            // http://php.net/manual/es/function.assert-options.php
        ?>

</body>
</html>