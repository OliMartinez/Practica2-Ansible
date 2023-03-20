<?php
$connect = mysqli_connect('localhost','root','1234','residencias');

if(isset($_GET['id'])) {
    $id = $_GET['id'];

    $query = "SELECT archivo_binario,nombre,tamanokb,tipo FROM documentos WHERE iddoc='$id'";
    $resultado = mysqli_query($connect,$query);
    if (mysqli_num_rows($resultado) == 1) {
        $row = mysqli_fetch_array($resultado);
        $datos=$row['archivo_binario'];
        $tipo=$row['tipo'];
        $nombre=$row['nombre'];
        $peso=$row['tamañokb'];
    }

    header("Content-type: $tipo");
    header("Content-length: $peso"); 
    header("Content-Disposition: inline; filename=$nombre"); 
 
   echo $datos;

}
?>
