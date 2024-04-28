
<?php ?>
<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF-8">
		<title>Creación de comentarios  - <?= APP_NAME?></title>
		
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
		 <?=(TEMPLATE)::getHeader('Creación de comentarios') ?>
		 <?=(TEMPLATE)::getMenu() ?>
		 <?=(TEMPLATE)::getBreadCrumbs([
		     "Comentario"=>'/Comentario/list',
		     "Nuevo comentario"=>null
		 ]) ?>
		 <?=(TEMPLATE)::getFlashes() ?>
	<main>
		 <h1><?= APP_NAME ?></h1>
		 
		 <div class="flex-container">
		 <section class="flex1">
		 
		 
		 <h2>Nuevo comentario</h2>
		 
		 <form method="post" action="/Comment/store" enctype="multipart/form-data">
		 	<input type="hidden" name="iduser" value="<?= Login::user()->id ?>">
		 	<input type="hidden" name="idplace" value="<?= $place->id?>">
		 	<label>Comentario:</label>
		 	<textarea name="text"><?= old('text') ?></textarea>
		 	<br>
		 	<label>Fecha:</label>
		 	<input type="date" name="created_at" value="<?= old('created_at') ?>">
			<br>
		 	<input type="submit" class="button" name="guardar" value="Guardar">		 
		 </form>
		 </section>
		 <figure class= "flex1 centrado">
		 	<img src="<?= AD_IMAGE_FOLDER.'/'.($place->cover ?? DEFAULT_AD_IMAGE) ?>" id="preview-image"
		 		class="cover" alt="Foto de <?= $place->name ?>">
		 	
		 </figure>	
		 </div> 
		
		 <div class="centrado">
		 	<a class="button" onclick="history.back()">Atrás</a>
		 		 	
		 </div>
		 <?= (TEMPLATE)::getFooter() ?>
	</main>	 
	</body>
