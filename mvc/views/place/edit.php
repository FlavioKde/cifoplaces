<?php ?>
<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF-8">
		<title>Edición de places - <?= APP_NAME?></title>
		
		<!-- META -->
		<meta name="viewport" content="width=device-widh, initial-scale=1.0">
		<meta name="description" content="Edición de anuncios en <?= APP_NAME ?>">
		<meta name="author" content="Robert Sallent">
		
		<!-- JS -->
		<script src="/js/preview.js"></script>
		
		<!-- FAVICON -->
		<link rel="shortcut icon" href="/favicon.ico" type="image/png">
		
		<!-- CSS -->
		<?= (TEMPLATE)::getCss() ?>	
	</head>
	<body>
		 <?=(TEMPLATE)::getLogin() ?>
		 <?=(TEMPLATE)::getHeader('Edit Place') ?>
		 <?=(TEMPLATE)::getMenu() ?>
		 <?=(TEMPLATE)::getFlashes() ?>
	<main>
		 <h1><?= APP_NAME ?></h1>
		 
		 <div class="flex-container">
		 
		 <section class="flex1">
		 <h2>Edición del anuncio <?= $place->name ?></h2>
		 
		 <form method="post" action="/Place/update" class="flex1"
		 		enctype="multipart/form-data">
		 	<!-- input oculto que contiene el ID del anuncio a actualizar -->
		 	<input type="hidden" name="id" value="<?= $place->id ?>">
		 	<label>Name:</label>
		 	<input type="text" name="name" value="<?= $place->name ?>">
		 	<br>
		 	<label>Type:</label>
		 	<input type="text" name="type" value="<?= $place->type ?>">
		 	<br>
		 	<label>Location:</label>
		 	<input type="text" name="location" value="<?= $place->location ?>">
		 	<br>
		 	<label>Description:</label>
		 	<textarea name="description"><?= $place->description ?></textarea>
		 	<br>
		 	<label>Cover</label>
		 	<input type="file" name="cover" accept="image/*" id="file-with-preview">
		 	<br>
		 	<input type="checkbox" name="eliminarcover">
		 	<label>Eliminar foto</label>
		 	<br>
		 	<input type="submit" class="button" name="actualizar" value="Actualizar">		 
		 </form>
		 </section>
		 <figure class= "flex1 centrado">
		 	<img src="<?= AD_IMAGE_FOLDER.'/'.($place->cover ?? DEFAULT_AD_IMAGE) ?>"
		 		class="cover" id="preview-image" alt="Foto de <?= $place->name ?>">
		 		<figcaption>Foto de <?="$place->name" ?></figcaption>
		 </figure>	 
		 </div>
		 <div class="centrado">
		 	<a class="button" onclick="history.back()">Atrás</a>
		 	<a class="button" href="/Place/list">Lista de anuncios</a>
		 	<a class="button" href="/Place/show/<?= $place->id ?>">Detalles</a>
		 	<a class="button" href="/Place/delete/<?= $place->id ?>">Borrado</a>		 	
		 </div>
		 <section>
		 
		 
		 <script>
		 		function confirmar(id){
		 			if(confirm('Seguro que deseas eliminar?'))
		 				location.href = '/Ejemplar/destroy/'+id
									}				 	
		 </script>
		 
		 
				
		 <?= (TEMPLATE)::getFooter() ?>
	</main>	 
	</body>

