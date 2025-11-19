<div class="hero hero-inner">
	<div class="container text-center">
		<h1 class="mb-0">Crear exposición</h1>
		<p class="text-white">Rellena los datos para publicar una exposición</p>
	</div>
	<!-- /.container -->
</div>

<div class="container" style="margin-top: 30px;">
	<?php include __DIR__ . '/show-error.part.php'; ?>

	<div class="row">
		<div class="col-xs-12 col-sm-8 col-sm-push-2">
			<h2>Nueva exposición</h2>
			<hr>

			<form class="form-horizontal" action="/exposiciones/nueva" method="post">
				<div class="form-group">
					<div class="col-xs-12">
						<label class="label-control" for="nombre">Nombre</label>
						<input class="form-control" type="text" id="nombre" name="nombre" value="<?= htmlspecialchars($nombre ?? '') ?>" red>
					</div>
				</div>

				<div class="form-group">
					<div class="col-xs-12">
						<label class="label-control" for="descripcion">Descripción</label>
						<textarea class="form-control" id="descripcion" name="descripcion" rows="4" red><?= htmlspecialchars($descripcion ?? '') ?></textarea>
					</div>
				</div>

				<div class="form-group">
					<div class="col-xs-12 col-sm-6">
						<label class="label-control" for="fechaInicio">Fecha inicio</label>
						<input class="form-control" type="date" id="fechaInicio" name="fechaInicio" value="<?= htmlspecialchars($fechaInicio ?? '') ?>" red>
					</div>
					<div class="col-xs-12 col-sm-6">
						<label class="label-control" for="fechaFin">Fecha fin</label>
						<input class="form-control" type="date" id="fechaFin" name="fechaFin" value="<?= htmlspecialchars($fechaFin ?? '') ?>" red>
					</div>
				</div>

				<div class="form-group">
					<div class="col-xs-12">
						<div class="checkbox">
							<label>
								<input type="checkbox" name="activa" value="1" <?= !empty($activa) ? 'checked' : '' ?>> Activa
							</label>
						</div>
					</div>
				</div>

				<div class="form-group">
					<div class="col-xs-12">
						<button type="submit" class="btn btn-primary sr-button">Guardar</button>
						<a href="/" class="btn btn-default">Cancelar</a>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
