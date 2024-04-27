<?php ?>
<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF-8">
		<title>Edición del photo - <?= APP_NAME?></title>
		
		<!-- META -->
		<meta name="viewport" content="width=device-widh, initial-scale=1.0">
		<meta name="description" content="Edición del anuncio en <?= APP_NAME ?>">
		<meta name="author" content="Robert Sallent">
		
		<!-- FAVICON -->
		<link rel="shortcut icon" href="/favicon.ico" type="image/png">
		
		<!-- CSS -->
		<?= (TEMPLATE)::getCss() ?>	
	</head>
	<body>
		 <?=(TEMPLATE)::getLogin() ?>
		 <?=(TEMPLATE)::getHeader('Lista de photo') ?>
		 <?=(TEMPLATE)::getMenu() ?>
		 <?=(TEMPLATE)::getFlashes() ?>
	<main>
		 <h1><?= APP_NAME ?></h1>
		 <h2>Borrar foto</h2>
		 
		 <form method="post" action="/Photo/destroy">
		 	<p>Confirmar el borrado de la foto <b><?=$photo->name ?></b>.</p>
		 	
		 	<!-- input oculto que contiene el ID de la foto a borrar -->
		 	<input type="hidden" name="id" value="<?= $photo->id ?>">
		 	<input type="submit" class="button" name="borrar" value="Borrar">		 
		 </form>	 
		
		 <div class="centrado">
		 	<a class="button" onclick="history.back()">Atrás</a>
		 	<a class="button" href="/Place/list">Lugares</a>
		 	<a class="button" href="/Photo/show/<?= $photo->id ?>">Detalles</a>
		 	<a class="button" href="/Photo/edit/<?= $photo->id ?>">Edición</a>		 	
		 </div>
		 <?= (TEMPLATE)::getFooter() ?>
	</main>	 
	</body>


