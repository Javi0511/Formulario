<html>
<head>
<title>Procesa una subida de archivos </title>
<meta charset="UTF-8">
</head>
<?php




function test($archivo) {
    $codigosErrorSubida= [
        0 => 'Subida correcta',
        1 => 'El tamaño del archivo excede el admitido por el servidor',  // directiva upload_max_filesize en php.ini
        2 => 'El tamaño del archivo excede el admitido por el cliente',  // directiva MAX_FILE_SIZE en el formulario HTML
        3 => 'El archivo no se pudo subir completamente',
        4 => 'No se seleccionó ningún archivo para ser subido',
        6 => 'No existe un directorio temporal donde subir el archivo',
        7 => 'No se pudo guardar el archivo en disco',  // permisos
        8 => 'Una extensión PHP evito la subida del archivo'  // extensión PHP
    ];
    $mensaje = '';
    if (! isset($_FILES[$archivo]['name'])) {
        $mensaje .= 'ERROR: No se indicó el archivo y/o no se indicó el directorio';
        
    } else {
        
        $directorioSubida = "/home/alummo2019-20/Escritorio/image";
        $nombreFichero   =   $_FILES[$archivo]['name'];
        $tipoFichero     =   $_FILES[$archivo]['type'];
        $tamanioFichero  =   $_FILES[$archivo]['size'];
        
        $errorFichero    =   $_FILES[$archivo]['error'];
        
      
        if ($errorFichero > 0) {
            $mensaje .= "Se a producido el error: $errorFichero:"
            . $codigosErrorSubida[$errorFichero] . ' <br />';
        } else { // subida correcta del temporal
            // si es un directorio y tengo permisos
            if ( !(is_dir($directorioSubida)) && !(is_writable ($directorioSubida))) {
                    //Intento mover el archivo temporal al directorio indicado
                    $mensaje .= 'ERROR: No es un directorio correcto o no se tiene permiso de escritura <br />';
            }
            
            if($tipoFichero != "image/jpeg" && $tipoFichero  != "image/png" && $tipoFichero  != "image/jpg"){
                    $mensaje .= 'El tipo de archivo no es el correcto';
            } 
             
            if ($tamanioFichero > 200000 ){
                $mensaje .= 'El tamaño de archivo no es el correcto';
            }
            if (file_exists($directorioSubida .'/'. $nombreFichero)){
                $mensaje .= 'El archivo ya existe';
            }
        }
    }
    return $mensaje;
}

function moverfichero($archivo){
    $mensaje="";
    $directorioSubida = "/home/alummo2019-20/Escritorio/image";
    $temporalFichero =   $_FILES[$archivo]['tmp_name'];
    if (move_uploaded_file($temporalFichero,  $directorioSubida .'/'. $_FILES[$archivo]['name']) == true) {
        $mensaje .= 'Archivo guardado en: ' . $directorioSubida .'/'. $_FILES[$archivo]['name'] . ' <br />';
    } else {
        $mensaje .= 'ERROR: Archivo no guardado correctamente <br />';
    }
    return $mensaje;
}
    
$suma1 =   $_FILES[archivo1]['size'] + $_FILES[archivo2]['size'];
?>
<body>
 <?php echo " Bienvenido ".$_REQUEST['nombre']."<br>"?>
	<?php

	if($suma1 < 290000){
	    echo " FICHERO 1";
	    echo "<br>";
    	if(test('archivo1') == ''){
    	   
    	      echo moverfichero('archivo1');
    	       echo "<br>";
    	       
    	}else {
    	    echo test('archivo1');
    	    echo "<br>";
    	}
	echo "FICHERO 2";
	echo "<br>";
	
	if(test('archivo2') == ''){
	    echo moverfichero('archivo2');
	    echo "<br>"; 
	}else {
	    echo test('archivo2');
	    echo "<br>";
	}
	}else echo "los archivos pesan demasiado";
	   
    ?>
<br />
	<a href="subirfichero.html">Volver a la página de subida</a>
</body>
</html>