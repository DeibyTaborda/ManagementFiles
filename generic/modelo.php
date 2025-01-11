<?php
class FilesUpload {
    public function upload($files, $destination) {
        //obtenemos los errores que van ocurriendo
        $uploadedFiles = [];

        //recorremos cada archivo vereficando que no haya errores en ninguno de ellos
        foreach($files['name'] as $key=>$filename) {
            if ($files['error'][$key] !== UPLOAD_ERR_OK) {
                $uploadedFiles[] = "Error en subir el archivo: $filename";
                continue;
            }

            // Si la ruta que se especificó no se encuentra se intenta crear
            if (!is_dir($destination)) {
            if (!mkdir($destination, 0777, true)) {
                $uploadedFiles [] = "No se puedo crear el directorio de destino";
                continue;
            }
        }


            // Establecemos la ruta del archivo de destino
            $filePath = $destination . DIRECTORY_SEPARATOR . basename($filename);

            //Movemos el archivo de la carpeta temporal a la carpeta de destino
            if (move_uploaded_file($files['tmp_name'][$key], $filePath)) {
                $uploadedFiles[] = "Archivo subido exitosamente: $filename";
            } else {
                $uploadedFiles[] = "Error al mover el archivo: $filename";
            }
        }

        //Devolvemos el resultado de la carga de todos los archivos
        return $uploadedFiles;
    }

}