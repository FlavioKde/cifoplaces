<?php ?>
<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF-8">
		<title>Edición de fotos - <?= APP_NAME?></title>
		
		<!-- META -->
		<meta name="viewport" content="width=device-widh, initial-scale=1.0">
		<meta name="description" content="Edición de fotos en <?= APP_NAME ?>">
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
		 <?=(TEMPLATE)::getHeader('Edición de fotos') ?>
		 <?=(TEMPLATE)::getMenu() ?>
		 <?=(TEMPLATE)::getFlashes() ?>
	<main>
		 <h1><?= APP_NAME ?></h1>
		 
		 <div class="flex-container">
		 
		 <section class="flex1">
		 <h2>Edición de fotos <?= $photo->name ?></h2>
		 
		 <form method="post" action="/Photo/update" class="flex1"
		 		enctype="multipart/form-data">
		 	<!-- input oculto que contiene el ID de la foto a actualizar -->
		 	
		 	<input type="hidden" name="id" value="<?= $photo->id ?>">
		 	
		 	<label>Nombre</label>
		 	<input type="text" name="name" value="<?= $photo->name ?>">
		 	<br>
		 	<label>Descripción</label>
		 	<input type="text" name="description" value="<?= $photo->description ?>">
		 	<br>
		 	<label>Dia</label>
		 	<input type="date" name="date" value="<?= $photo->date ?>">
		 	<br>
		 	<label>Hora</label>
		 	<input type="time" name="time" value="<?= $photo->time ?>">
		 	<br>
		 	<label>Foto</label>
		 	<input type="file" name="file" accept="image/*" id="file-with-preview">
		 	<br>
		 	<input type="checkbox" name="eliminarfoto">
		 	<label>Eliminar foto</label>
		 	<br>
		 	<input type="submit" class="button" name="actualizar" value="Actualizar">		 
		 </form>
		 </section>
		 <figure class= "flex1 centrado">
		 	<img src="<?= PI_IMAGE_FOLDER.'/'.($photo->file ?? DEFAULT_PICTURE_IMAGE) ?>"
		 		class="cover" id="preview-image" alt="Foto de <?= $photo->name ?>">
		 		<figcaption>Foto de <?="$photo->name" ?></figcaption>
		 </figure>	 
		 </div>
		 <div class="centrado">
		 	<a class="button" onclick="history.back()">Atrás</a>
		 	<?php if ($photo->id === $place->id) {?>
		 	<a class="button" href="/Place/show/<?=$place->id ?>">Fotos de lugares</a>
		 	<?php }?>
		 	<?php if (Login::user()->id == $photo->id){?>
		 	<a class="button" href="/Photo/show/<?= $photo->id ?>">Detalles</a>
		 	<?php }?>
		 	<?php if (Login::user()->id == $photo->id){?>
		 	<a class="button" href="/Photo/delete/<?= $photo->id ?>">Borrado</a>
		 	<?php }?>		 	
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

