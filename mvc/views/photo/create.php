<?php ?>
<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF-8">
		<title>Create de photo - <?= APP_NAME?></title>
		
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
		 <?=(TEMPLATE)::getHeader('Nueva foto') ?>
		 <?=(TEMPLATE)::getMenu() ?>
		 <?=(TEMPLATE)::getBreadCrumbs([
		     "Foto"=>'/Photo/list',
		     "Nueva foto"=>null
		 ]) ?>
		 <?=(TEMPLATE)::getFlashes() ?>
	<main>
		 <h1><?= APP_NAME ?></h1>
		 
		 <div class="flex-container">
		 <section class="flex1">
		 
		 
		 <h2>Nuevo foto</h2>
		 
		 <form method="post" action="/Photo/store" enctype="multipart/form-data">
		 	<input type="hidden" name="iduser" value="<?= Login::user()->id ?>">
		 	<input type="hidden" name="idplace" value="<?= $place->id ?>">
		 	
		 	<label>Nombre</label>
		 	<input type="text" name="name" value="<?= old('name') ?>">
		 	<br>
		 	<label>Descripción</label>
		 	<input type="text" name="description" value="<?= old('description') ?>">
		 	<br>
		 	<label>Fecha</label>
		 	<input type="date" name="date" value="<?= old('date') ?>">
		 	<br>
		 	
		 	<label>Foto</label>
		 	<input type="file" name="file" accept="image/*" id="file-with-preview">
		 	<br>
		 	<input type="submit" class="button" name="guardar" value="Guardar">		 
		 </form>
		 </section>
		 <figure class= "flex1 centrado">
		 	<img src="<?= PI_IMAGE_FOLDER.'/'.($photo->file ?? DEFAULT_PICTURE_IMAGE) ?>" id="preview-image"
		 		class="cover" alt="Foto de <?= $photo->name ?>">
		 		
		 	<figcaption>Previsualización de la imagen</figcaption>	
		 </figure>	
		 </div> 
		
		 <div class="centrado">
		 	<a class="button" onclick="history.back()">Atrás</a>
		 	<a class="button" href="/Photo/list">Fotos</a>		 	
		 </div>
		 <?= (TEMPLATE)::getFooter() ?>
	</main>	 
	</body>
