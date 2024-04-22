<?php ?>
<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF-8">
		<title>Detalles de los photo - <?= APP_NAME?></title>
		<!-- META -->
		<meta name="viewport" content="width=device-widh, initial-scale=1.0">
		<meta name="description" content="Detalles de los photo en  <?= APP_NAME ?> ">
		<meta name="author" content="Robert Sallent">
		
		<!-- FAVICON -->
		<link rel="shortcut icon" href="/favicon.ico" tyoe="image/png"> 
		
		<!-- CSS -->
		<?= (TEMPLATE)::getCss() ?>	
	</head>
	<body>
		 <?=(TEMPLATE)::getLogin() ?>
		 <?=(TEMPLATE)::getHeader('Detalles de los photo') ?>
		 <?=(TEMPLATE)::getMenu() ?>
		 <?=(TEMPLATE)::getFlashes() ?>
	<main>
		 <h1><?= APP_NAME ?></h1>
		 <div class="flex-container">
		 
		 <section class="flex1">
		 <h2><?= "Detalles de los places $photo->name" ?></h2>
		 
		 <p><b>Nombre:</b>                   <?=$photo->name?></p>
		 <p><b>Descripción:</b>              <?=$photo->descripcion?></p>
		 <p><b>Dia:</b>				    	 <?=$photo->date?></p>
		 <p><b>Hora:</b>                   	 <?=$photo->time ?></p>
		 
		 </section>
		 <figure class= "flex1 centrado">
		 	<img src="<?= AD_IMAGE_FOLDER.'/'.($photo->foto ?? DEFAULT_AD_IMAGE) ?>"
		 		class="cover" alt="Foto de <?= $photo->name ?>">
		 		<figcaption>Foto de <?="$photo->name" ?></figcaption>
		 </figure>
		 </div>			 
		 <div class="centrado">
		 	<a class="button" onclick="history.back()">Atrás</a>
		 	<a class="button" href="/Photo/list">Lista de places</a>
		 	<a class="button" href="/Photo/edit/<?= $place->id ?>">Edición</a>
		 	<a class="button" href="/Photo/delete<?= $place->id ?>">Borrado</a>
		 </div>
	
		
		 <?= (TEMPLATE)::getFooter() ?>
	</main>	 
	</body>
