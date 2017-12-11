<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Tabla de datos</title>
        <style>
            h1 {
                width: 800px;
                text-align:center;
            }
            table{
                text-align: center;
                width: 800px;
                border: 1px solid;
                background-color:blue;
                color: white;
                border: 1px solid black;
                border-collapse: collapse;
            }
            th{
                border-bottom: 1px solid black;
            }
            td {
                border-left: 1px solid black;
                border-right: 1px solid black;
            }
        </style>
    </head>
    <body>
        <h1>TABLA DE DATOS</h1>    
        
        <?php 
            $array = [null, 0, true, false, "0", "", "foo", array()];
        ?>
        <table>
            <thead>
                <th>Contenido de $var</th>
                <th>isset($var)</th>
                <th>empty($var)</th>
                <th>(bool) $var</th>
            </thead>
            <tbody>
            <?php
                foreach($array as $var){
                    if($var === null){
                        $texto = 'null';
                    }else if(is_array($var)){
                        $texto = 'Array';
                    }else if($var === true){
                        $texto = 'true';
                    }else if($var === false){
                        $texto = 'false';
                    }else if($var === '') {
                        $texto = "' '";
                    }else{
                        $texto = $var;
                    }

                    echo "<tr>";
                    echo '<td>' . '$var = ' . $texto . '</td>';
                    echo "<td>";
                    echo (isset($var)) ? 'true' : 'false' ;
                    echo "</td>"; 
                    echo "<td>";
                    echo (empty($var)) ? 'true' : 'false' ;
                    echo "</td>"; 
                    echo "<td>";
                    echo ((bool) $var) ? 'true' : 'false' ;
                    echo "</td>"; 
                    echo "<tr>";
                }

                echo "<tr>";
                echo "<td>" . 'unset($var)' . "</td>";
                echo "<td>";
                echo 'false';
                echo "</td>"; 
                echo "<td>";
                echo 'true';
                echo "</td>"; 
                echo "<td>";
                echo 'false';
                echo "</td>"; 
                echo "<tr>";
            ?>
            </tbody>
        </table>
    </body>
</html>