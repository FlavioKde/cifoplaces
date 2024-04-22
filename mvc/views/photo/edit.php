<?php ?>
<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF-8">
		<title>Edición de photo - <?= APP_NAME?></title>
		
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
		 <?=(TEMPLATE)::getHeader('Edit Photo') ?>
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
		 	<label>Titulo:</label>
		 	<input type="text" name="titulo" value="<?= $place->titulo ?>">
		 	<br>
		 	<label>Descripción:</label>
		 	<input type="text" name="descripcion" value="<?= $place->descripcion ?>">
		 	<br>
		 	<label>Precio:</label>
		 	<input type="text" name="precio" value="<?= $place->precio ?>">
		 	<br>
		 	<label>Foto</label>
		 	<input type="file" name="foto" accept="image/*" id="file-with-preview">
		 	<br>
		 	<input type="checkbox" name="eliminarfoto">
		 	<label>Eliminar foto</label>
		 	<br>
		 	<input type="submit" class="button" name="actualizar" value="Actualizar">		 
		 </form>
		 </section>
		 <figure class= "flex1 centrado">
		 	<img src="<?= AD_IMAGE_FOLDER.'/'.($place->foto ?? DEFAULT_AD_IMAGE) ?>"
		 		class="cover" id="preview-image" alt="Foto de <?= $place->titulo ?>">
		 		<figcaption>Foto de <?="$place->name" ?></figcaption>
		 </figure>	 
		 </div>
		 <div class="centrado">
		 	<a class="button" onclick="history.back()">Atrás</a>
		 	<a class="button" href="/Photo/list">Lista de anuncios</a>
		 	<a class="button" href="/Photo/show/<?= $photo->id ?>">Detalles</a>
		 	<a class="button" href="/Photo/delete/<?= $photo->id ?>">Borrado</a>		 	
		 </div>
		 
		 
		 
		 <script>
		 		function confirmar(id){
		 			if(confirm('Seguro que deseas eliminar?'))
		 				location.href = '/Ejemplar/destroy/'+id
									}				 	
		 </script>
		 
		 
				
		 <?= (TEMPLATE)::getFooter() ?>
	</main>	 
	</body>

