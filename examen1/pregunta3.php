<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Pregunta 3</title>
</head>
<body>
    <h3>¿Qué sucede cuando intentas usar transacciones en mysql con tablas que usan<br>
    el engine=MyISAM cuando el driver es mysqli?</h3>
    <p>A diferencia de cuando usamos el engine <i>InnoDB</i>, MyISAM no soporta <br>
    restricciones de claves foráneas o transacciones, esenciales para mantener <br>
    la integridad referencial de los datos. Además, toda la tabla se bloquea <br>
    cuando uno inserta o actualiza un registro, lo que provoca un efecto <br>
    adverso en el rendimiento de la aplicación, cuando esta crece.</p>
    <h3>Y, ¿qué pasa cuando usamos PDO?</h3>
    <p>A diferencia de mysqli, con <i>PDO</i> podemos ejecutar un lote en una <br>
    misma transacción, lo que soluciona el problema del bloqueo de la tabla en <br>
    cada consulta. Además, se le especifica el inicio de la transacción y se pueden <br>
    realizar tantas ejecuciones como se desee, ejecutándolas con un <i> Commit </i>. <br> <br>
    En caso de haber algún error, permite realizar un <i>Rollback</i> sin guardar <br>
    las consultas anteriores, a diferencia de msqli, en el qual por cada consulta se <br>
    ejecuta de manera definitiva.</p>
</body>
</html>