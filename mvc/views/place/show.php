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
		<link rel="shortcut icon" href="/favicon.ico" tyoe="image/png"> 
		
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
		 <h2><?= "Detalles de los places $place->name" ?></h2>
		 
		 <div class="centrado">
		 	<a class="button" href="/Photo/create<?= $photo->id ?>">New Photo</a>
		 </div>
		 
		 <p><b>Nombre:</b>                   <?=$place->name?></p>
		 <p><b>Type:</b>              <?=$place->type?></p>
		 <p><b>location:</b>				     <?=$place->location?></p>
		 <p><b>decription:</b>                   	 <?=$place->description ?></p>
		 
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
	
		
		 <?= (TEMPLATE)::getFooter() ?>
	</main>	 
	</body>
