<?php
/**
 * Archivo ordenacion.php que contiene 3 métodos de ordenación de números
 * de arrays, y pide al usuario seleccionar la longitud que desea y el 
 * método con el que desea ordenar dichos arrays.
 */

// ---------- MÉTODOS DE ORDENACIÓN ----------

/**
 * Método de ordenación de la burbuja
 * 
 * Ordena los números del array comprobando los números contiguos y
 * cambiando el orden si el siguiente es menor.
 * 
 * @param array $arrayNumeros Contiene el array a ordenar
 * 
 * @return array
 */
function ordenarBurbuja($arrayNumeros)
{
    $longitud = count($arrayNumeros);
    for ($i=0; $i<$longitud; $i++) {
        for ($j=0; $j<$longitud; $j++) {
            if ($arrayNumeros[$i]< $arrayNumeros[$j]) {
                $temp = $arrayNumeros[$i];
                $arrayNumeros[$i]=$arrayNumeros[$j];
                $arrayNumeros[$j]=$temp;
            }
        }
    }
    return $arrayNumeros;
}

/**
 * Método de ordenación por sustitución progresiva
 * 
 * Ordena los números del array buscando el número más pequeño y colocándolo
 * en la primera posición, tantas veces como números pequeños encuentre.
 * 
 * @param array $arrayNumeros Contiene el array a ordenar
 * 
 * @return array
 */
function ordenarSustitucionProgresiva($arrayNumeros)
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

/**
 * Método de ordenación por Heap Sort
 * 
 * Ordena los números del array de manera que coloca todos los números simulando
 * un montículo, y después va extraendo los números para dejar el array ordenado
 * 
 * @param array $arrayNumeros Contiene el array a ordenar
 * 
 * @return array
 */
function ordenacionHeapSort($arrayNumeros) {
    $longitud = count($arrayNumeros);

    for ($i = $longitud - 1; $i >= 0; $i--) {
        for ($j = 1; $j <= $i; $j++) {
            $numero = $arrayNumeros[$j];
            $k = $j / 2;
            while ($k > 0 && $arrayNumeros[$k] < $numero) {
                $arrayNumeros[$j] = $arrayNumeros[$k];
                $j = $k;
                $k = $k / 2;
            }
            $arrayNumeros[$j] = $numero;
        }
        $temp = $arrayNumeros[0];
        $arrayNumeros[0] = $arrayNumeros[$i];
        $arrayNumeros[$i] = $temp;
    }

    return $arrayNumeros;
}

/**
 * Método para crear un array de forma aleatoria
 * 
 * Genera un array aleatorio dependiendo de la longitud, e introduce
 * valores aleatorios desde 1 a la longitud deseada
 * 
 * @param integer $longitud Integer con la longitud del array a generar
 * 
 * @return array
 */
function crear($longitud)
{
    $arrayBandera = []; // Array vacio que se usará para generar uno aleatorio
    for($i = 0; $i < $longitud; $i++){
        $arrayBandera[$i] = rand(1, $longitud); // Introducimos un número aleatorio
    }
    return $arrayBandera;
}

// ---------- Printado de formulario y resultados ----------

echo '<h1>Ordenación de Arrays</h1>';
echo '<form action="" method="post">'; // Inicio Formulario
echo 'Introduce la longitud del array: ';
echo '<br>';
echo '<input type="number" name="numero" value=2 min=2>  ';
echo '<input type="checkbox" name="json">';
echo ' Incluir un array desde un archivo JSON';
echo '<br>';
echo '<br>';
echo 'Selecciona un método: ';
echo '<br>';
echo '<select name="metodo">';
echo '<option value="burbuja">Método de la burbuja</option>';
echo '<option value="sustitucion">Método de sustitución progresiva</option>';
echo '<option value="heap">Método heap sort</option>';
echo '<option value="todos">Todos</option>';
echo '</select>';
echo ' <button type="submit" name="enviar">Enviar</button>';
echo '</form>'; // Fin Formulario
if(isset($_POST['enviar']) && $_POST['numero'] > 1){
    $length = $_POST['numero'];
    $array = crear($length);
    $array2 = crear($length);
    $array3 = crear($length);
    $metodo = $_POST['metodo'];
    if($metodo == 'burbuja'){
        echo '<br>';
        echo '<br>';
        echo 'Generado array aleatorio: [';
        echo implode(',', $array);
        echo ']';
        echo '<br>';
        echo 'Números ordenados por burbuja: ';
        echo implode(',', ordenarBurbuja($array));
    } else if($metodo == 'sustitucion'){
        echo '<br>';    
        echo '<br>';
        echo 'Generado array aleatorio: [';
        echo implode(',', $array2);
        echo ']';
        echo '<br>';
        echo 'Números ordenados por sustutución progresiva: ';
        echo implode(',', ordenarSustitucionProgresiva($array2));
    } else if($metodo == 'heap') {
        echo '<br>';    
        echo '<br>';
        echo 'Generado array aleatorio: [';
        echo implode(',', $array3);
        echo ']';
        echo '<br>';
        echo 'Números ordenados por <i>\'Heap Sort\'</i>: ';
        echo implode(',', ordenacionHeapSort($array3));
    } else {
        echo '<br>';
        echo '<br>';
        echo 'Generado array aleatorio: [';
        echo implode(',', $array);
        echo ']';
        echo '<br>';
        echo 'Números ordenados por burbuja: ';
        echo implode(',', ordenarBurbuja($array));
        echo '<br>';    
        echo '<br>';
        echo 'Generado array aleatorio: [';
        echo implode(',', $array2);
        echo ']';
        echo '<br>';
        echo 'Números ordenados por sustutución progresiva: ';
        echo implode(',', ordenarSustitucionProgresiva($array2));
        echo '<br>';    
        echo '<br>';
        echo 'Generado array aleatorio: [';
        echo implode(',', $array3);
        echo ']';
        echo '<br>';
        echo 'Números ordenados por <i>\'Heap Sort\'</i>: ';
        echo implode(',', ordenacionHeapSort($array3));
    }
} else if (isset($_POST['numero']) && $_POST['numero'] < 2){
    echo 'Introduce un número mayor o igual que 2.';
}

// ---------- SI SE SELECCIONA LA OPCIÓN DE JSON ----------

if(isset($_POST['json'])) {
    $stringJson = file_get_contents('array.json');
    $json = json_decode($stringJson);
    $arrayJson = $json->array;
    echo '<br>';
    echo '<br>';
    echo 'Array en JSON: ';
    echo ' [';
    echo implode(',', $arrayJson);
    echo ']';
    echo '<br>';
    echo 'Números ordenados: ';
    echo implode(',', ordenacionHeapSort($arrayJson ));
}