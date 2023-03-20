<?php
$alumn_selects= "No hay alumnos seleccionados";
?>
<html lang="es">
  <head>		
		 <meta http-equiv="Content-type" content="text/html; charset=utf-8">
     <meta name="viewport" content="width=device-width, user-scalable=yes, 
     initial-scale=1.0, maximum-scale=3.0, minimum-scale=1.0">
     <link rel="stylesheet" href="Vista/Estilos/normalize.css">
     <link rel="stylesheet" href="../Vista/Estilos/normalize.css">
     <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <link href="../Vista/Estilos/styles.css" rel="stylesheet">
    <link href="Vista/Estilos/styles.css" rel="stylesheet">
    <title>Agregar Alumnos</title>
  </head>

  <body>
    
    <header class="header">
        <img  class="w-100" src="https://siia.itleon.edu.mx/Imagenes/ITL_Banner_SIIA.png">
    </header>

    <div class="menu">
      <nav class="navegador">
        <a href="#">Inicio</a>
        <a href="#">Situacion Académica</a>
        <a href="#">Avisos</a>
        <a href="../Vista/ApartadoProfesor.php">Residencias Profesionales</a>
        <a href="#">Configuración</a>
        <a href="../Controladores/logout.php">Salir</a>
      </nav>
    </div>

    <main>
      <div class="contenedor tabla">
        <a href="../Vista/chatProfesor.php" class="boton chat">Chat</a>
          <div class="tabla__caption">
            <caption>Selecciona uno o más alumnos</caption>
          </div>
          <table class="contenedor_tabla">
            <thead>
              <tr class="titulos_columna">
                <th class="columna celda_alumnos" scope="col">Nombre</th>
                <th class="columna celda_alumnos" scope="col">Carrera</th>
                <th class="columna celda_alumnos" scope="col">Semestre</th>
                <th class="columna celda_alumnos" scope="col"># Control</th>
              <?php
              $conection = mysqli_connect('localhost','root','1234','residencias');
              $sql = "SELECT * from alumnos as a where a.ncontrol not in (select an.ncontrol from asignación as an where an.ntrabajador='".$userForm."')";
              $result = mysqli_query($conection,$sql);
              while($mostrar=mysqli_fetch_array($result)){
                ?>
              <tr height = 20 class="fila">
                 <td class="celda_alumnos">
                 <form action="../Vista/ApartadoProfesor.php" method = "POST" enctype="multipart/form-data"><!--ルシファー-->
                <input type="hidden" name="namerevisor" value="<?php echo $userForm?>">
                <input type="hidden" name="namealumn" value="<?php echo $mostrar['nombre']?>">
                <input type="submit" name="elegiralumn" value="<?php echo $mostrar['nombre']?>">
                </td>
              </form>
                <td class="celda_alumnos"><?php echo $mostrar['carrera']?></td>
                <td class="celda_alumnos"><?php echo $mostrar['semestre']?></td>
                <td class="celda_alumnos"><?php echo $mostrar['ncontrol']?></td>
              </tr>
              <?php
              }
              ?>
            </thead>
          </table>
          <div class="agregar_alumno">
              <form action="../Vista/ApartadoProfesor.php" method = "POST" enctype="multipart/form-data">
              <input type="button" value="Agregar" class="input">
              <input type="hidden" name="namerevisor" value="<?php echo $_POST["namerevisor"]?>">
              <input type="submit" name="Regresar" class="input" value="¡Listo!">
            </div>
          </form>
        </table>
        
        <div>
          <h1>Alumnos Seleccionados</h1>
                       <?php/*
                  if(isset($_POST['elegiralumn']) or isset($_GET['id'])){
                    if(isset($_POST['elegiralumn'])){$alumno = $_POST['namealumn'];}
                      echo $mostrar;
                  }
              */?>
          <label class="Fechas"><?php echo $alumn_selects ?></label>
        </div>
        
    </main>
          </body>
      
          </html>
