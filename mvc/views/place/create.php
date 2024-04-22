<?php ?>
<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF-8">
		<title>create place  - <?= APP_NAME?></title>
		
		<!-- META -->
		<meta name="viewport" content="width=device-widh, initial-scale=1.0">
		<meta name="description" content="Creación de anuncio en <?= APP_NAME ?>">
		<meta name="author" content="Robert Sallent">
		
		<!-- FAVICON -->
		<link rel="shortcut icon" href="/favicon.ico" type="image/png">
		
		<!-- JS -->
		<script src="/js/preview.js"></script>
		<!-- CSS -->
		<?= (TEMPLATE)::getCss() ?>	
	</head>
	<body>
		 <?=(TEMPLATE)::getLogin() ?>
		 <?=(TEMPLATE)::getHeader('Creación de anuncios') ?>
		 <?=(TEMPLATE)::getMenu() ?>
		 <?=(TEMPLATE)::getBreadCrumbs([
		     "Place"=>'/Place/list',
		     "New Place"=>null
		 ]) ?>
		 <?=(TEMPLATE)::getFlashes() ?>
	<main>
		 <h1><?= APP_NAME ?></h1>
		 
		 <div class="flex-container">
		 <section class="flex1">
		 
		 
		 <h2>create pleace</h2>
		 
		 <form method="post" action="/Place/store" enctype="multipart/form-data">
		 	<input type="hidden" name="iduser" value="<?= Login::user()->id ?>">
		 	<label>Name</label>
		 	<input type="text" name="name" value="<?= old('name') ?>">
		 	<br>
		 	<label>Type</label>
		 	<input type="text" name="type" value="<?= old('type') ?>">
		 	<br>
		 	<label>Location</label>
		 	<input type="text" name="location" value="<?= old('location') ?>">
		 	<br>
		 	<label>Description</label>
		 	<input type="text" name="location" value="<?= old('description') ?>">
		 	<br>
		 	<label>Cover</label>
		 	<input type="file" name="cover" accept="image/*" id="file-with-preview">
		 	<br>
		 	<input type="submit" class="button" name="guardar" value="Guardar">		 
		 </form>
		 </section>
		 <figure class= "flex1 centrado">
		 	<img src="<?= AD_IMAGE_FOLDER.'/'.($place->cover ?? DEFAULT_AD_IMAGE) ?>" id="preview-image"
		 		class="cover" alt="Foto de <?= $place->name ?>">
		 	<figcaption>Previsualización de la imagen</figcaption>	
		 </figure>	
		 </div> 
		
		 <div class="centrado">
		 	<a class="button" onclick="history.back()">Atrás</a>
		 	<a class="button" href="/Place/list">Lista de Anuncios</a>		 	
		 </div>
		 <?= (TEMPLATE)::getFooter() ?>
	</main>	 
	</body>
