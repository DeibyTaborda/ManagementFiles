<?php
class FilesUpload {
    public function upload($files, $destination) {
        // Creamos un array para ir capturando los errores que se puedan presentar
        $uploadedFiles = [];

        // Creamos una lista de los tipos de archivos permitidos
        $allowedFiles = [
            "image/jpeg",
            "image/jpg",
            "video/mp4",
            "application/pdf",
            "application/msword",
            "application/vnd.openxmlformats-officedocument.wordprocessingml.document",
        ];

        //recorremos cada archivo vereficando que no haya errores en ninguno de ellos
        foreach($files['name'] as $key=>$filename) {
            if ($files['error'][$key] !== UPLOAD_ERR_OK) {
                $uploadedFiles[] = "Error en subir el archivo: $filename";
                continue;
            }

            $fileMimeType = mime_content_type($files['tmp_name'][$key]);

            if (!in_array($fileMimeType, $allowedFiles)) {
                $uploadedFiles[] = 'El tipo de archivo no es permitido';
                continue;
            }

            // Si la ruta que se especificó no se encuentra se intenta crear
            if (!is_dir($destination)) {
                if (!mkdir($destination, 0777, true)) {
                    $uploadedFiles [] = "No se puedo crear el directorio de destino";
                    continue;
                }
            }

            // Obtener la extensión del archivo
            $fileExtension = pathinfo($filename, PATHINFO_EXTENSION);

            // Renombramos el archivo (por ejemplo, agregando un prefijo único)
            $newFilename = uniqid('image_') . '.' . $fileExtension;

            // Establecemos la ruta del archivo de destino
            $filePath = $destination . DIRECTORY_SEPARATOR . $newFilename;

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

    function getFiles($directoryPath) {
        $errors = [];

        // Verificamos que la ruta exista
        if (!is_dir($directoryPath)) {
            return $errors[] = 'El directorio no existe';
        }

        // Obtenemos todos los archivos de la ruta específicada
        $scanned = scandir($directoryPath);

        foreach($scanned as $item) {
            // Ignorar '.' y '..'
            if ($item == '.' || $item == '..') {
                continue;
            }

            $path = $directoryPath . '/' . $item;

            $files[] = $path;
        }

        return $files;
    }

    function getFile($path) {
        if (file_exists($path)) {
            $fileContents = $path;
        } else {
            $fileContents = 'El archivo no existe';
        }

        return $fileContents;
    }
}