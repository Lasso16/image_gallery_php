<?php

use dwes\app\utils\Utils; ?>

<nav class="navbar navbar-fixed-top navbar-default">
  <div class="container">

    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#menu">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>

      <a class="navbar-brand page-scroll" href="#page-top">
        <span>[PHOTO]</span>
      </a>
    </div>

    <div class="collapse navbar-collapse navbar-right" id="menu">
      <ul class="nav navbar-nav">

        <!-- HOME -->
        <li class="lien <?= Utils::esOpcionMenuActiva('/') || Utils::esOpcionMenuActiva('/index.php') ? 'active' : '' ?>">
          <a href="/"><i class="fa fa-home sr-icons"></i> Home</a>
        </li>

        <!-- ABOUT -->
        <li class="lien <?= Utils::esOpcionMenuActiva('/about') ? 'active' : '' ?>">
          <a href="/about"><i class="fa fa-bookmark sr-icons"></i> About</a>
        </li>

        <!-- BLOG -->
        <li class="lien <?= Utils::esOpcionMenuActiva('/blog') ? 'active' : '' ?>">
          <a href="/blog"><i class="fa fa-file-text sr-icons"></i> Blog</a>
        </li>

        <!-- CONTACT -->
        <li class="lien <?= Utils::esOpcionMenuActiva('/contact') ? 'active' : '' ?>">
          <a href="/contact"><i class="fa fa-phone-square sr-icons"></i> Contact</a>
        </li>

        <?php if (is_null($app['user'])) : ?>

          <!-- LOGIN -->
          <li class="lien <?= Utils::esOpcionMenuActiva('/login') ? 'active' : '' ?>">
            <a href="/login"><i class="fa fa-user-secret sr-icons"></i> Login</a>
          </li>

          <!-- REGISTRO -->
          <li class="lien <?= Utils::esOpcionMenuActiva('/registro') ? 'active' : '' ?>">
            <a href="/registro"><i class="fa fa-sign-in sr-icons"></i> Registro</a>
          </li>

        <?php else : ?>

          <!-- GALERÍA -->
          <li class="lien <?= Utils::esOpcionMenuActiva('/galeria') ? 'active' : '' ?>">
            <a href="/galeria"><i class="fa fa-picture-o sr-icons"></i> Galería</a>
          </li>

          <!-- ASOCIADOS -->
          <li class="lien <?= Utils::esOpcionMenuActiva('/asociados') ? 'active' : '' ?>">
            <a href="/asociados"><i class="fa fa-users sr-icons"></i> Asociados</a>
          </li>

          <!-- EXPOSICIONES -->
          <li class="lien <?= Utils::esOpcionMenuActiva('/exposiciones') ? 'active' : '' ?>">
            <a href="/exposiciones"><i class="fa fa-university sr-icons"></i> Exposiciones</a>
          </li>

          <?php if (!$app['user']->esAdmin()) : ?>

            <!-- MI CUENTA -->
            <li class="lien <?= Utils::esOpcionMenuActiva('/miCuenta') ? 'active' : '' ?>">
              <a href="/miCuenta"><i class="fa fa-user sr-icons"></i> <?= $app['user']->getUsername() ?></a>
            </li>
            <!-- NUEVA EXPOSICIÓN -->
            <li class="lien <?= Utils::esOpcionMenuActiva('/exposiciones/nueva') ? 'active' : '' ?>">
              <a href="/exposiciones/nueva"><i class="fa fa-plus sr-icons"></i> Nueva Exposición</a>
            </li>
            

          <?php else: ?>

            <!-- GESTIÓN DE USUARIOS-->
            <li class="lien <?= Utils::esOpcionMenuActiva('/gestionUsuarios') ? 'active' : '' ?>">
              <a href="/gestionUsuarios"><i class="fa fa-cogs sr-icons"></i> Gestión de usuarios</a>
            </li>

          <?php endif; ?>

          <!-- LOGOUT -->
          <li class="lien <?= Utils::esOpcionMenuActiva('/logout') ? 'active' : '' ?>">
            <a href="/logout"><i class="fa fa-sign-out sr-icons"></i> Logout</a>
          </li>

        <?php endif; ?>

      </ul>
    </div>

  </div>
</nav>