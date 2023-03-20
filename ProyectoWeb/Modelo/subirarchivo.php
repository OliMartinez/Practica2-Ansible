<?php

$connect = mysqli_connect('localhost','root','1234','residencias');

    if(isset($_POST['subir'])){
        $fecha= date("Y-m-d");
        $NoControl = $_POST['Ncontrol'];

        //datos del arhivo
        $nombre_archivo = $_FILES['archivo']['name'];
        $tipo_archivo = $_FILES['archivo']['type'];
        $tamaño_archivo = $_FILES['archivo']['size'];
        $binario_nombre_temporal=$_FILES['archivo']['tmp_name'];
        $binario_contenido = addslashes(fread(fopen($binario_nombre_temporal, "rb"), filesize($binario_nombre_temporal)));

        $insert = "INSERT INTO documentos (nusuario,archivo_binario,nombre,tamanokb,tipo,fecha) 
        VALUES ('$NoControl','$binario_contenido','$nombre_archivo','$tamaño_archivo','$tipo_archivo','$fecha')";

        $result = mysqli_query($connect, $insert);
        if($result){
            echo '<script language="javascript">alert("Documento enviado");</script>';
        }
        else{
            echo '<script language="javascript">alert("Error al enviar documento");</script>';
            die("Query Failed");
        }
    }
?>
