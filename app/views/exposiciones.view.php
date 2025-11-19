<?php

/** @var array $exposiciones */ ?>
<div class="container" style="margin-top:90px;">
    <h2>Exposiciones</h2>
    <?php if (!empty($mensaje)) : ?>
        <div class="alert alert-success"><?= htmlspecialchars($mensaje) ?></div>
    <?php endif; ?>
    <?php if (!empty($errores)) : ?>
        <div class="alert alert-danger">
            <ul class="list-unstyled">
                <?php foreach ($errores as $err): ?>
                    <li><?= htmlspecialchars($err) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
    <div class="text-right mb-3">
        <a class="btn btn-primary" href="/exposiciones/nueva"><i class="fa fa-plus"></i> Nueva Exposición</a>
    </div>
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Inicio</th>
                <th>Fin</th>
                <th>Activa</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($exposiciones)) : ?>
                <tr>
                    <td colspan="5" class="text-center">No hay exposiciones</td>
                </tr>
            <?php else: ?>
                <?php foreach ($exposiciones as $expo): ?>
                    <tr>
                        <td><?= htmlspecialchars($expo->getNombre()) ?></td>
                        <td><?= htmlspecialchars($expo->getDescripcion()) ?></td>
                        <td><?= htmlspecialchars($expo->getFechaInicio()) ?></td>
                        <td><?= htmlspecialchars($expo->getFechaFin()) ?></td>
                        <td><?= $expo->isActiva() ? '<span class="label label-success">Activa</span>' : '<span class="label label-default">Inactiva</span>' ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>