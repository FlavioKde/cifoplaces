<?php ?>
<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF-8">
		<title>Detalles de los places - <?= APP_NAME?></title>
		<!-- META -->
		<meta name="viewport" content="width=device-widh, initial-scale=1.0">
		<meta name="description" content="Detalles de los anuncios en  <?= APP_NAME ?> ">
		<meta name="author" content="Robert Sallent">
		
		<!-- FAVICON -->
		<link rel="shortcut icon" href="/favicon.ico" type="image/png"> 
		
		<!-- CSS -->
		<?= (TEMPLATE)::getCss() ?>	
	</head>
	<body>
		 <?=(TEMPLATE)::getLogin() ?>
		 <?=(TEMPLATE)::getHeader('Detalles de los places') ?>
		 <?=(TEMPLATE)::getMenu() ?>
		 <?=(TEMPLATE)::getFlashes() ?>
	<main>
		 <h1><?= APP_NAME ?></h1>
		 <div class="flex-container">
		 
		 <section class="flex1">
		 <h2><?= "Detalles del comentario" ?></h2>
		 
		 <div class="derecha">
		 	<a class="button" href="/Photo/create/<?= $place->id ?>">New Photo</a>
		 </div>
		 <form method="post">
		 <input type="hidden" name="idplace" value="$place->id">
		 </form>
		 
		 <p><b>Nombre:</b>                   <?=$place->name?></p>
		 <p><b>Type:</b>                     <?=$place->type?></p>
		 <p><b>location:</b>				 <?=$place->location?></p>
		 <p><b>decription:</b>               <?=$place->description ?></p>
		 
		 </section>
		 <figure class= "flex1 centrado">
		 	<img src="<?= AD_IMAGE_FOLDER.'/'.($place->cover ?? DEFAULT_AD_IMAGE) ?>"
		 		class="cover" alt="Foto de <?= $place->name ?>">
		 		<figcaption>Foto de <?="$place->name, a un precio de $place->precio € " ?></figcaption>
		 </figure>
		 </div>	
		 
		 					 
		 <div class="centrado">
		 	<a class="button" onclick="history.back()">Atrás</a>
		 	<a class="button" href="/Place/list">Lista de places</a>
		 	<a class="button" href="/Place/edit/<?= $place->id ?>">Edición</a>
		 	<a class="button" href="/Place/delete<?= $place->id ?>">Borrado</a>
		 </div>
		 
		 <h2>Fotos de usuarios</h2>
		
		<?php foreach ($photos as $photo){?>
		
		 		
		 			<div class="centrado">
		 				<img src="<?= PI_IMAGE_FOLDER.'/'.($photo->file ?? DEFAULT_PICTURE_IMAGE) ?>"
		 					class="cover" alt="Foto de <?= $photo->name ?>">
		 			
		 				<a class="button" href='/Photo/show/<?=$photo->id ?>'>Ver</a> -
		 				<?php if (Login::user()->id == $place->iduser) {?>
		 				<a href='/Photo/edit/<?=$photo->id ?>'>Actualizar</a> -
		 				<?php }?>
		 				<?php if (Login::user()->id == $place->iduser) {?>
		 				<a href='/Photo/delete/<?=$photo->id ?>'>Borrar</a>
		 				<?php }?> 		
		 			</div>
		 		
		 		<?php }?>	
		 		
		 	<h2>Comenatrios de usuarios</h2>		
		
		 <?= (TEMPLATE)::getFooter() ?>
	</main>	 
	</body>
