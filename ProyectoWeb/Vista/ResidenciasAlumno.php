<html lang="es">
    <head>
        <meta http-equiv="Content-type" content="text/html; charset=utf-8"><!--Demons Powered-->
        <meta name="viewport" content="width=device-width, user-scalable=yes, 
        initial-scale=1.0, maximum-scale=3.0, minimum-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" 
        integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
        <link rel="stylesheet" href="../Vista/Estilos/normalize.css">
        <link rel="stylesheet" href="Vista/Estilos/normalize.css">
        <link href="../Vista/Estilos/styles.css" rel="stylesheet">
        <link href="Vista/Estilos/styles.css" rel="stylesheet">
        <title>Residencias Profesionales</title>
    </head>
    <body>
        <header class="header">
                <img class="w-100" src="Vista/img/Cabecera.jpg">
        </header>
        <div class="menu">
            <nav class="navegador">
                <a href="#">Inicio</a>
                <a href="#">Situacion Académica</a>
                <a href="#">Avisos</a>
                <a href="#">Residencias Profesionales</a>
                <a href="#">Configuración</a>
                <a href="Controladores/logout.php">Salir</a>
            </nav>
        </div>
        <?php
$conection = mysqli_connect('localhost','root','1234','residencias');
$NoControl = $_SESSION['user'];
$UltDoc = 0;
/*Traer los revisores del alumno*/

    $sql="SELECT a.ncontrol, a.ntrabajador, r.nombre 
            FROM asignación as a 
            JOIN revisores as r 
            ON a.ntrabajador = r.ntrabajador 
            JOIN alumnos as al 
            ON a.ncontrol = al.ncontrol 
            WHERE a.ncontrol = $NoControl 
            ORDER BY a.ncontrol";

    $estudiantes = mysqli_query($conection,$sql);


/*Traer historial de documentos*/
    $sql="SELECT * FROM documentos WHERE nusuario=$NoControl";

    $documentos = mysqli_query($conection,$sql);

/*Traer calificaciones*/
    $sql="SELECT r.iddoc, rev.nombre, r.aprobación 
            FROM revisión as r 
            JOIN revisores as rev 
            ON r.ntrabajador = rev.ntrabajador 
            WHERE r.iddoc = (SELECT MAX(iddoc) FROM documentos) 
            GROUP BY rev.nombre";

    $calificaciones =  mysqli_query($conection,$sql);

/*Traer el ultimo archivo subido*/
    $sql = "SELECT iddoc, nombredoc,fecha FROM documentos WHERE iddoc = (SELECT MAX(iddoc) FROM documentos) AND nusuario='$NoControl'";

    $doc =  mysqli_query($conection,$sql);

/*Traer las caracteristicas de la última revisión*/ 
    $sql = "SELECT * FROM revisión HAVING fecha_revis = MAX(fecha_revis)";

    $caracteristicas =  mysqli_query($conection,$sql);
?>
        <main>
            <div class="contenedor">
                <div class="asesores">
                    <h3>Asesores asignados</h3>
                    <ul class="asesores__lista">
                        <?php while($mostrar=mysqli_fetch_array($estudiantes)){?>
                        <li>
                            <?php echo "<label class=\"conectado\"></label>"," ",$mostrar['nombre']?>
                        </li>
                        <?php }?>
                    </ul>
                </div>

                <div class="documento">
                    <h3>Subir documento</h3>
                    <form action="" method="GET" class="fecha_limite">
                    Fecha limite:
                    <input type="date" name="fecha" readonly>
                    </form>
                </div>

                <div class="file">
                    <form action="../Modelo/subirarchivo.php" method="POST" enctype="multipart/form-data" class="nuevo_documento">
                        <p class="p-700">Subir nuevo archivo</p>
                        <div class="archivo">
                            <input type="file" name="archivo"> <!--Demonios trabajando-->
                            <input type="hidden" name="Ncontrol" value="<?php echo $NoControl?>">
                        </div>          
                        <input type="submit"  name="subir" value="Subir" class="button">
                        <input type="reset" value="Cancelar" class="button">
                    </form>
                    <p>
                        <?php while($mostrar=mysqli_fetch_array($doc)){?>
                            <a href="../Modelo/verDoc.php?id=<?php echo $mostrar['iddoc']; $UltDoc = $mostrar['iddoc'];?>"><?php echo $mostrar['nombredoc'];?></a><br>
                        <?php }?>
                    </p>
                </div>
                <div class="historial">
                    <h3>Historial</h3>
                    <div class="textarea">
                        <h6><?php while($mostrar=mysqli_fetch_array($documentos)){?>
                            <a href="Modelo/verDoc.php?id=<?php echo  $mostrar['iddoc']?>"><?php echo  $mostrar['nombredoc']?></a><br>
                            <?php echo  $mostrar['fecha']?><br><br>
                        <?php }?>
                        </h6>
                    </div>
                </div>
                <div class="centrar calificaciones">
                    <p>
                        <?php while($mostrar=mysqli_fetch_array($calificaciones)){
                            echo $mostrar['nombre'].' : <span class="negritas">'.$mostrar['aprobación'].'</span><br>';}?>
                        Calificación Final: <span class="negritas">No hay</span><br>
                </p>
                    <?php while($mostrar=mysqli_fetch_array($caracteristicas)){
                    echo '<p>Limite: <span class="negritas">'.$mostrar['fecha_lim'].'</span></p>
                    <p>Subido el: <span class="negritas">';while($mostrar1=mysqli_fetch_array($documentos)){echo $mostrar1['fecha'];}; echo'</span></p>
                    <p>Revisado el <span class="negritas">'.$mostrar['fecha_revis'].'</span></p>';}
                    ?>
                </div>
                <div class="comentarios">
                    <h3>Comentarios:</h3>
                        <textarea name="comentario" id="comentario" cols="30" rows="10" disabled class="comentario"></textarea>           
                </div>
            </div>
        </main>
        <div class="chat">Chat</div>
    </body>
</html>
<!--7 pecados-->