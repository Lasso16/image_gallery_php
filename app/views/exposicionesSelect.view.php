<div class="hero hero-inner">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 mx-auto text-center">
                <div class="intro-wrap">
                    <h1 class="mb-0">Añadir imagen a exposición</h1>
                    <p class="text-white">Selecciona una exposición activa para esta imagen.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container mt-4">
    <?php include __DIR__ . '/show-error.part.php'; ?>

    <form action="/exposicion/anadirimagen" method="post">
        <input type="hidden" name="id_imagen" value="<?= $idImagen ?>">

        <div class="form-group">
            <label for="id_exposicion">Exposición activa:</label>
            <select name="id_exposicion" id="id_exposicion" class="form-control">
                <?php foreach ($exposiciones as $expo) : ?>
                    <option value="<?= $expo->getId() ?>">
                        <?= $expo->getNombre() ?> (<?= $expo->getFechaInicio() ?> - <?= $expo->getFechaFin() ?>)
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <br>
        <button type="submit" class="btn btn-primary">
            Añadir imagen a exposición
        </button>
    </form>
</div>
