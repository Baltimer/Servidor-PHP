<?php
    // 1333 al ejecutarlo en 17/10/2017
    $funcs = get_defined_functions();
    echo count($funcs['internal']);
?>