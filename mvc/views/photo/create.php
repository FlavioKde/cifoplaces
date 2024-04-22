<?php ?>
<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF-8">
		<title>Lista de photo - <?= APP_NAME?></title>
		
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
		 <?=(TEMPLATE)::getHeader('Creación de photo') ?>
		 <?=(TEMPLATE)::getMenu() ?>
		 <?=(TEMPLATE)::getBreadCrumbs([
		     "Photo"=>'/Photo/list',
		     "New Photo"=>null
		 ]) ?>
		 <?=(TEMPLATE)::getFlashes() ?>
	<main>
		 <h1><?= APP_NAME ?></h1>
		 
		 <div class="flex-container">
		 <section class="flex1">
		 
		 
		 <h2>Nuevo photo</h2>
		 
		 <form method="post" action="/Photo/store" enctype="multipart/form-data">
		 	<input type="hidden" name="iduser" value="<?= Login::user()->id ?>">
		 	<input type="hidden" name="idplace" value="<?= $place->id ?>">
		 	<label>Name</label>
		 	<input type="text" name="name" value="<?= old('name') ?>">
		 	<br>
		 	<label>Description</label>
		 	<input type="text" name="description" value="<?= old('description') ?>">
		 	<br>
		 	<label>Date</label>
		 	<input type="date" name="date" value="<?= old('date') ?>">
		 	<br>
		 	<label>Time</label>
		 	<input type="time" name="time" value="<?= old('time') ?>">
		 	<br>
		 	<label>Photo</label>
		 	<input type="file" name="cover" accept="image/*" id="file-with-preview">
		 	<br>
		 	<input type="submit" class="button" name="guardar" value="Guardar">		 
		 </form>
		 </section>
		 <figure class= "flex1 centrado">
		 	<img src="<?= AD_IMAGE_FOLDER.'/'.($photo->cover ?? DEFAULT_AD_IMAGE) ?>" id="preview-image"
		 		class="cover" alt="Foto de <?= $photo->name ?>">
		 	<figcaption>Previsualización de la imagen</figcaption>	
		 </figure>	
		 </div> 
		
		 <div class="centrado">
		 	<a class="button" onclick="history.back()">Atrás</a>
		 	<a class="button" href="/Photo/list">Lista de photo</a>		 	
		 </div>
		 <?= (TEMPLATE)::getFooter() ?>
	</main>	 
	</body>
