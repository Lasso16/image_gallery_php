
<div class="container">
        <div class="col-xs-12 col-sm-8 col-sm-push-2">
            <h2>Editar imgen:</h2>
            <hr>


<form clas="form-horizontal" action="/galeria/update/<?= $imagen->getId() ?>" method="post" enctype="multipart/form-data">
  <div class="form-group">
    <div class="col-xs-12">
      <label class="label-control">Imagen</label>
      <input class="form-control-file" type="file" name="imagen">
    </div>
  </div>
  <div class="form-group">
    <div class="col-xs-12">
      <label class="label-control">Categoria</label>
      <select class="form-control" name="categoria">
        <?php foreach ($categorias as $categoria) : ?>
          <option value="<?= $categoria->getId() ?>"
            <?= ($imagen->getCategoria() == $categoria->getId()) ? 'selected' : '' ?>><?= $categoria->getNombre() ?></option>
        <?php endforeach; ?>
      </select>
    </div>
  </div>
  <label class="label-control">Titulo</label>
  <input type="text" class="form-control" id="titulo" name="titulo" value="<?= $imagen->getTitulo() ?> ">
  <label class="label-control">Descripción</label>
  <textarea class="form-control" name="descripcion" ><?= $imagen->getDescripcion() ?></textarea>
  <button class="pull-right btn btn-lg sr-button">ENVIAR</button>

</form>
</div></div>