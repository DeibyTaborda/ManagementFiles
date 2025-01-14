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

    function getFiles($module, $id, $folder = "") {
        $errors = [];
        $files = [];
    
        // Verificamos que el directorio principal exista
        if (!is_dir($module)) {
            $errors[] = 'El directorio principal no existe';
            return $errors;
        }
    
        // Construimos la ruta con el parámetro folder si es proporcionado
        $path = rtrim($module, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;
    
        if (!empty($folder)) {
            $path .= $folder . DIRECTORY_SEPARATOR;
        }
    
        $path .= $id;
    
        // Verificamos que la ruta construida exista
        if (!is_dir($path)) {
            $errors[] = 'El subdirectorio no existe';
            return $errors;
        }
    
        // Obtener los archivos del subdirectorio
        $scanned = scandir($path);
        if ($scanned === false) {
            $errors[] = 'No se pudieron leer los archivos del directorio';
            return $errors;
        }
    
        // Recorremos los archivos encontrados
        foreach ($scanned as $item) {
            // Ignorar '.' y '..'
            if ($item == '.' || $item == '..') {
                continue;
            }
    
            // Agregar el archivo a la lista de archivos
            $files[] = $path . DIRECTORY_SEPARATOR . $item;
        }
    
        return $files;
    }        


    function getFile($module, $id, $file = "") {
        // Construimos la ruta de manera similar al método anterior
        $path = rtrim($module, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;
    
        // Si hay una carpeta intermedia, la añadimos
        if (!empty($file)) {
            $path .= $file . DIRECTORY_SEPARATOR;
        }
    
        // Añadimos el id al final de la ruta
        $path .= $id;
    
        // Verifica si el archivo existe
        if (file_exists($path)) {
            // Obtiene el contenido del archivo
            $fileContents = file_get_contents($path);
        } else {
            // Si el archivo no existe, retorna un mensaje de error más informativo
            $fileContents = "El archivo '$path' no existe";
        }
    
        return $fileContents;
    }
}    