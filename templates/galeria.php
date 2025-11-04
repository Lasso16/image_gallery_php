<?php
// 🔹 1. Cargamos la configuración y el sistema base
require_once __DIR__ . '/../core/app.php';

// 🔹 2. Importamos las clases necesarias
require_once __DIR__ . '/../src/utils/File.class.php';
require_once __DIR__ . '/../src/entity/Imagen.class.php';
require_once __DIR__ . '/../repository/ImagenesRepository.php';

$errores = [];
$mensaje = "";
$titulo = "";
$descripcion = "";

// 🔹 3. Si se envía el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $titulo = trim(htmlspecialchars($_POST['titulo']));
        $descripcion = trim(htmlspecialchars($_POST['descripcion']));

        if (empty($titulo)) {
            $errores[] = "El título es obligatorio.";
        }

        // Si no hay errores de validación
        if (empty($errores)) {
            // 4️⃣ Guardar la imagen
            $tiposAceptados = ["image/jpg", "image/jpeg", "image/png", "image/gif"];
            $file = new File('imagen', $tiposAceptados);
            $file->saveUploadFile(Imagen::RUTA_IMAGENES_SUBIDAS);

            // 5️⃣ Crear el objeto Imagen
            $imagen = new Imagen();
            $imagen->setNombre($file->getFileName())
                   ->setDescripcion($descripcion)
                   ->setCategoria(1)
                   ->setNumVisualizaciones(0)
                   ->setNumLikes(0)
                   ->setNumDownloads(0);

            // 6️⃣ Guardar en base de datos usando el repositorio
            $repo = new ImagenRepository();
            $repo->save($imagen);

            $mensaje = "✅ La imagen se ha subido correctamente.";
            $titulo = "";
            $descripcion = "";
        }
    } catch (Exception $e) {
        $errores[] = $e->getMessage();
    }
}

// 🔹 7. Recuperar todas las imágenes
$repo = new ImagenRepository();
$imagenes = $repo->findAll();

// 🔹 8. Incluir la vista
require_once __DIR__ . '/views/galeria.view.php';
