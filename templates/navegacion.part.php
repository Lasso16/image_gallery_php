<?php require_once __DIR__ . '/../src/utils/utils.class.php';?>
<nav class="navbar navbar-fixed-top navbar-default">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#menu">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            </button>
            <a  class="navbar-brand page-scroll" href="#page-top">
            <span>[PHOTO]</span>
            </a>
        </div>
        <div class="collapse navbar-collapse navbar-right" id="menu">
            <ul class="nav navbar-nav">
            <?php if (Utils::esOpcionMenuActiva('/index.php') || Utils::esOpcionMenuActiva('/')) 
          echo '<li class="active lien">'; else echo '<li class="lien">'; ?>
          <a href="/templates/index.php"><i class="fa fa-home sr-icons"></i> Home</a></li>

        <?php if (Utils::esOpcionMenuActiva('/about.php')) 
          echo '<li class="active lien">'; else echo '<li class="lien">'; ?>
          <a href="/templates/about.php">About</a></li>

        <?php if (Utils::esOpcionMenuActiva('/blog.php')) 
          echo '<li class="active lien">'; else echo '<li class="lien">'; ?>
          <a href="/templates/blog.php">Blog</a></li>

        <?php if (Utils::esOpcionMenuActiva('/contact.php')) 
          echo '<li class="active lien">'; else echo '<li class="lien">'; ?>
          <a href="/templates/contact.php">Contact</a></li>
          <?php if (Utils::esOpcionMenuActiva('/galeria.php')) 
          echo '<li class="active lien">'; else echo '<li class="lien">'; ?>
          <a href="/templates/galeria.php">Gallery</a></li>
          <?php if (Utils::esOpcionMenuActiva('/Asociados.php')) 
          echo '<li class="active lien">'; else echo '<li class="lien">'; ?>
          <a href="/templates/Asociados.php">Asociados</a></li>
            </ul>
        </div>
    </div>
</nav>