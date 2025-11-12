<div class="hero hero-inner">
  <div class="container text-center">
    <h1 class="mb-0">Detalle de imagen</h1>
    <p class="text-white">Información detallada de la imagen seleccionada</p>
  </div>
</div>

<div id="imagen-detalle" class="container mt-5">
  <div class="row justify-content-center">
    <div class="col-xs-12 col-sm-8 col-md-6 text-center">
      <?php if (isset($imagen)) : ?>
        <h2><?= htmlspecialchars($imagen->getDescripcion()) ?></h2>
        <p><strong>Ruta generada:</strong> <?= $imagen->getUrlGalerias() ?></p>

        <img 
          src="<?= $imagen->getUrlGalerias() ?>" 
          alt="<?= htmlspecialchars($imagen->getDescripcion()) ?>" 
          class="img-fluid rounded shadow"
          style="max-width: 500px; border: 2px solid #ccc;">
        <hr>
        <p><strong>Visualizaciones:</strong> <?= $imagen->getNumVisualizaciones() ?></p>
        <p><strong>Likes:</strong> <?= $imagen->getNumLikes() ?></p>
        <p><strong>Descargas:</strong> <?= $imagen->getNumDownloads() ?></p>
        <p><strong>Categoría:</strong> <?= $imagen->getCategoria()->getNombre() ?></p>
        <a href="/galeria" class="btn btn-secondary mt-3">← Volver a la galería</a>
      <?php else : ?>
        <div class="alert alert-danger">
          No se ha encontrado la imagen solicitada.
        </div>
      <?php endif; ?>
    </div>
  </div>
</div>
