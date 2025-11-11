<?php use dwes\app\utils\Utils; ?>
<div class="last-box row">
        <div class="col-xs-12 col-sm-4 col-sm-push-4 last-block">
        <div class="partner-box text-center">
          <p>
          <i class="fa fa-map-marker fa-2x sr-icons"></i> 
          <span class="text-muted">35 North Drive, Adroukpape, PY 88105, Agoe Telessou</span>
          </p>
          <h4>Our Main Partners</h4>
          <hr>
          <div class="text-muted text-left">
          <?php 
                $asociados = Utils::extraeElementosAleatorios($asociadosIndex, 3);
                foreach($asociados as $a) : ?>
            <ul class="list-inline">                
              <li><img src="<?= $a->getUrl()?>" alt="logo"></li>
              <li><?= $a?></li>
            </ul>
            <?php endforeach;?>
            
          </div>
        </div>
        </div>
      </div>