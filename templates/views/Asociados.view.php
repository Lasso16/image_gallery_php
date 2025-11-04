<?php
require_once __DIR__ . '/../inicio.part.php';
require_once __DIR__ . '/../navegacion.part.php'; ?>

<div class="hero hero-inner">
    <div class="container text-center">
        <h1 class="mb-0">Alta de Partners</h1>
        <p class="text-white">Registra aquí un nuevo partner para la sección “Our Main Partners”.</p>
    </div>
</div>

<div id="asociados" class="container mt-5">
    <div class="col-xs-12 col-sm-8 col-sm-push-2">
        <h2>Registrar nuevo asociado</h2>
        <hr>

        <!-- Mensajes -->
        <?php if ($_SERVER['REQUEST_METHOD'] === 'POST') : ?>
            <div class="alert alert-<?= empty($errores) ? 'success' : 'danger' ?>" role="alert">
                <?php if (empty($errores)): ?>
                    <p><?= $mensaje ?></p>
                <?php else: ?>
                    <ul>
                        <?php foreach ($errores as $error): ?>
                            <li><?= $error ?></li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <!-- Formulario -->
        <form class="form-horizontal" action="<?= $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label class="label-control">Nombre del asociado</label>
                <input type="text" name="nombre" class="form-control" value="<?= $nombre ?>">
            </div>

            <div class="form-group">
                <label class="label-control">Logo</label>
                <input type="file" name="logo" class="form-control-file">
            </div>

            <div class="form-group">
                <label class="label-control">Descripción</label>
                <textarea name="descripcion" class="form-control"><?= $descripcion ?></textarea>
            </div>
            <!-- CAPTCHA -->
            <label class="label-control">Introduce el captcha <img style="border: 1px solid #D3D0D0 "
                    src="/../../src/utils/captcha.php" id='captcha'></label>
            <input class="form-control" type="text" name="captcha">
            <button class="pull-right btn btn-lg sr-button">Registrar</button>
        </form>
    </div>
</div>

<?php require_once __DIR__ . '/../fin.part.php'; ?>