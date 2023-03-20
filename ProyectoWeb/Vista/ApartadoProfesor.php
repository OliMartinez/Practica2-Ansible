<?php
$alumno= "Selecciona a un Alumno";
$doc= "Aquí aparecerá el nombre del documento del alumno";
$califs= "Aquí apareceran las calificaciones sobre el Documento";
$calfinal="No hay";
$dates= "Aquí apareceran las fechas importantes sobre el Documento";
$idd=null;
$coments="No hay comentarios";
?>  
<html lang="es">

  <head>
		 <meta http-equiv="Content-type" content="text/html; charset=utf-8">
     <meta name="viewport" content="width=device-width, user-scalable=yes, 
     initial-scale=1.0, maximum-scale=3.0, minimum-scale=1.0">
     <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"  rel="stylesheet" ><!--ルシファー-->
     <link href="Vista/Estilos/normalize.css" rel="stylesheet" >
     <link href="../Vista/Estilos/normalize.css" rel="stylesheet" >
     <link href="Vista/Estilos/styles.css" rel="stylesheet" >
     <link href="../Vista/Estilos/styles.css" rel="stylesheet" >
     
     <title>Residencias Profesionales</title>
  </head>

  <body>
    
    <header>
        <img class="w-100" src="https://siia.itleon.edu.mx/Imagenes/ITL_Banner_SIIA.png"> 
    </header>
    <div class="menu">
      <nav class="navegador">
          <a href="">Inicio</a>
          <a href="">Situacion Académica</a>
          <a href="">Avisos</a>
          <a href="Vista/ApartadoProfesor.php">Residencias Profesionales</a>
          <a href="">Configuración</a>
          <a href="Controladores/logout.php">Salir</a>
      </nav>
    </div>

    <main>
      <div class="contenedor tabla">
        <div class="tabla__caption">
          <caption>Lista de Alumnos Asignados</caption>
        </div>
          <table class="tabla__profesores">
          <thead>
            <tr class="Encabezados">
              <th class="celdas_profesores" scope="col">Nombre</th>
              <th class="celdas_profesores" scope="col">Estado de Residencia</th>
              <th class="celdas_profesores" scope="col">Último Documento subido</th>
              <th class="celdas_profesores" scope="col">Carrera</th>
              <th class="celdas_profesores" scope="col">Semestre</th>
              <th class="celdas_profesores" scope="col">Número de Control</th>
            </tr>
            <?php
              $conection = mysqli_connect('localhost','root','1234','residencias');
              if(isset($_POST["elegiralumn"]) or isset($_POST["Regresar"])){
                $userForm = $_POST["namerevisor"]; 
              }
              if(isset($_GET['id'])){
                $pos = strpos($_GET['id'], ":");
                $userForm = substr($_GET['id'], $pos+1, strlen($_GET['id'])) ; 
                $idd = (int)substr($_GET['id'], 0, $pos); 
                $sql = "SELECT a.nombre from alumnos as a inner join asignación as an on a.ncontrol=an.ncontrol inner join revisión as r on an.ntrabajador=r.ntrabajador
                where r.iddoc=".$idd." and r.ntrabajador='".$userForm."'";
                $result = mysqli_query($conection,$sql);
                while($mostrar=mysqli_fetch_array($result)){
                  $alumno = $mostrar['nombre'];
                }
              }
              $sql = "SELECT a.*, d.iddoc, d.nombredoc, r.aprobación from alumnos as a inner join 
              documentos as d on a.ncontrol = d.nusuario inner join revisión as r
              on d.iddoc = r.iddoc inner join asignación as an on a.ncontrol = an.ncontrol where '".$userForm."'=an.ntrabajador and r.ntrabajador='".$userForm."'";
              $result = mysqli_query($conection,$sql);
              while($mostrar=mysqli_fetch_array($result)){
            ?>
            <tr>
              <td class="celdas_profesores">
              <form action="Vista/ApartadoProfesor.php" method = "POST" enctype="multipart/form-data"><!--ルシファー-->
                <input type="hidden" name="namerevisor" value="<?php echo $userForm?>">
                <input type="hidden" name="namealumn" value="<?php echo $mostrar['nombre']?>">
                <input type="submit" name="elegiralumn" value="<?php echo $mostrar['nombre']?>">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="quitar">
                <path d="M12 0c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm4.151 17.943l-4.143-4.102-4.117 4.159-1.833-1.833 4.104-4.157-4.162-4.119 1.833-1.833 4.155 4.102 4.106-4.16 1.849 1.849-4.1 4.141 4.157 4.104-1.849 1.849z"/></svg></td>
              </form>
              <td class="celdas_profesores"><?php echo $mostrar['aprobación']?></td>
              <td class="celdas_profesores" class="Subrayado"><a href="Modelo/verDoc.php?id=<?php echo $mostrar['iddoc']?>"><?php echo "<u>",$mostrar['nombredoc'],"</u>"?></a></td>
              <td class="celdas_profesores"><?php echo $mostrar['carrera']?></td>
              <td class="celdas_profesores"><?php echo $mostrar['semestre']?></td>
              <td class="celdas_profesores"><?php echo $mostrar['ncontrol']?></td>
            </tr>
            <?php
              }
            ?>
          </thead>
        </table> 
        <form action="Vista/AgregarAlumnos.php" method = "POST" enctype="multipart/form-data">
          <input type="hidden" name="namerevisor" value="<?php echo $userForm?>">
          <input type="submit" value="Agregar más" class="ag">
        </form>

        <a href="Vista/chatProfesor.php"><input type="button" value="Chat" class="chat_prof"></a>

          <div class="flex">
            <div class="flex_p">
              <div class="flex_historial">
                <h3>Historial</h3>
                <div class="content_historial">
                  <?php 
                    if(isset($_POST['elegiralumn']) or isset($_GET['id'])){
                      if(isset($_POST['elegiralumn'])){$alumno = $_POST['namealumn'];}
                      $sql="SELECT d.* from documentos as d inner join alumnos as a where a.nombre = '".$alumno."'";
                      $result = mysqli_query($conection,$sql);
                      while($mostrar=mysqli_fetch_array($result)){
                        echo "<br><a href=\"Vista/ApartadoProfesor.php?id=",$mostrar['iddoc'],":",$userForm,"\"","><u>",$mostrar['nombredoc'],"</u></a><br>Tamaño: ",
                          $mostrar['tamanokb']," kb</br>Fecha de subida: ",$mostrar['fecha'];
                      }
                      $sql2 ="SELECT d.nombredoc from documentos as d inner join revisión as r on d.iddoc=r.iddoc inner join 
                      asignación as a on r.ntrabajador = a.ntrabajador inner join alumnos as al on a.ncontrol=al.ncontrol where al.nombre = '".$alumno."'";
                      $idd = mysqli_query($conection,$sql2);
                    }                 
                  ?>
                </div>
              </div>
            </div>

            <div class="flex_p">
              <h3 class=""><?php echo $alumno;?></h3>
              <h3>Asignar Nuevo Documento a Entregar</h3>
              <h3>Fecha:</h3>
              <input type="date" name="fecha">
              <p>Descripción</p>
              <textarea name="descripcion" rows="3" cols="40" class="Describir" placeholder="Escribe una descripción..."></textarea>
              <input type="file" name="subir archivo" value="Subir Archivo">
              <input type="submit" value="Asignar" class="BotonAsignar" onclick="">
              <br>
              <?php 
                if(isset($_POST['elegiralumn']) or isset($_GET['id'])){
                  if(isset($_POST['elegiralumn'])){$idd = 1;}
                  else{$idd= (int)substr($_GET['id'], 0, $pos);}
                  $sql ="SELECT d.nombredoc from documentos as d where d.iddoc = '".$idd."'"; 
                  $result = mysqli_query($conection,$sql);
                  while($mostrar=mysqli_fetch_array($result)){
                    $doc=$mostrar['nombredoc'];
                  }
                }
              ?>
              <a href="Modelo/verDoc.php?id=<?php echo $idd?>"><?php echo $doc?></a>
              <?php
                  if(isset($_POST['elegiralumn']) or isset($_GET['id'])){
                    if(isset($_POST['elegiralumn'])){$idd = 1;}
                    $sql="SELECT r.nombre, rn.aprobación from revisores as r inner join revisión as rn 
                    on r.ntrabajador = rn.ntrabajador where rn.iddoc ='".$idd."'";
                    $result = mysqli_query($conection,$sql);
                    if($idd!=null){$califs = null;}
                    while($mostrar=mysqli_fetch_array($result)){             
                    $califs .= "<br>".$mostrar['nombre']. ": ".$mostrar['aprobación'];
                    }
                    $califs .= "<br>Calificación Final: ".$calfinal;
                  }
              ?><!--ルシファー*-->
              <label class="Calificaciones_prof"><?php echo $califs ?></label>
              <?php
                if(isset($_POST['elegiralumn']) or isset($_GET['id'])){
                  if(isset($_POST['elegiralumn'])){$idd = 1;}
                  $sql ="SELECT r.fecha_lim, d.fecha from revisión as r inner join
                  documentos as d on r.iddoc = d.iddoc where d.iddoc ='".$idd."'"; 
                  $result = mysqli_query($conection,$sql);
                  while($mostrar = mysqli_fetch_array($result)){
                    $dates = "<br>Fecha asignada: ".$mostrar['fecha_lim']."<br>Fecha de subida: ".$mostrar['fecha'];
                    $dates .= "<br>";
                  }
                  $sql ="SELECT r.fecha_revis, rs.nombre from revisión as r inner join revisores as rs on 
                  r.ntrabajador=rs.ntrabajador where r.iddoc ='".$idd."'";
                  $result = mysqli_query($conection,$sql);
                  while($mostrar=mysqli_fetch_array($result)){ 
                    if($mostrar['fecha_revis']==NULL){            
                      $dates .= "<br>".$mostrar['nombre']." no ha revisado";               
                    }
                    else{
                      $dates .= "<br>".$mostrar['nombre']." revisó el día ".$mostrar['fecha_revis'];                 
                    }
                  }
                  /*$sql ="SELECT r.fecha_revis, rs.nombre from revisión as r inner join revisores as rs on 
                  r.ntrabajador=rs.ntrabajador where r.iddoc ='".$idd."' and r.ntrabajador==".$userForm."";
                  $result = mysqli_query($conection,$sql);
                  while($mostrar=mysqli_fetch_array($result)){ 
                    if($mostrar['fecha_revis']==NULL){            
                      $dates .= "<br>No has revisado";               
                    }
                    else{
                      $dates .= "Revisaste el día ".$mostrar['fecha_revis'];                 
                    }
                  }*/
                }
              ?>
              <label class="Fechas"><?php echo $dates ?></label>
              <input type="button" value="Volver a Calificar" class="VolverCalificar" onclick="VolvCalif()">
            </div>

            <div class="RevsyComs flex_p">
              <h3>Revisores en Común</h3>
              <div class="Revisores">
              <?php
                  if(isset($_POST['elegiralumn']) or isset($_GET['id'])){
                    if(isset($_POST['elegiralumn'])){$alumno = $_POST['namealumn'];}
                    $sql = "SELECT r.nombre from revisores as r inner join asignación as a on r.ntrabajador = a.ntrabajador 
                    inner join alumnos as al on a.ncontrol = al.ncontrol where '".$userForm."'!=a.ntrabajador and al.nombre='".$alumno."'";
                    $result = mysqli_query($conection,$sql);
                    while($mostrar=mysqli_fetch_array($result)){
                      echo "<svg width=","8", " height=","8", " viewBox=","0 0 8 8","><circle cx=","4"," cy=","4"," r=","4"," fill=","#3ADF00",">
                      </circle></svg><b>", $mostrar['nombre'],"</b><br>";
                    }
                  }
                  else{echo "<br></br><br></br>";}
              ?>
              </div>
               <form method="post" enctype="multipart/form-data">
                 <p align=center class="TitleComentarios">Comentarios</p>        
                   <?php 
                    if(isset($_POST['elegiralumn']) or isset($_GET['id'])){
                      if(isset($_POST['elegiralumn'])){$idd = 1;}
                      $sql ="SELECT c.comentario from comentarios as c inner join revisión as rn on c.ComID = rn.ComID
                      and rn.iddoc =".$idd."";
                      $result = mysqli_query($conection,$sql);
                      if($result!=null){
                        $coments="";
                        while($mostrar=mysqli_fetch_array($result)){
                         $coments.= $mostrar['comentario']."<br>";
                        }
                      }
                    }
                 ?>
                  <p class="Comentarios"><?php echo $coments ?></p>
                  <textarea name="comentarios" rows="5" class="Comentar" placeholder="Escribe un comentario..."></textarea>
                  <input type="file" name="subir archivo" value="Subir Archivo" class="sub_f" id="subir_archivo">
                  <input type="submit" name="enviarcom" value="Enviar Comentario" class="sub_f">
              </form>
              </div>
            </div>
          </div>
    </main>
    </body>     
    </html>
