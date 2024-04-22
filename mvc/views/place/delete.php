<?php ?>
<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF-8">
		<title>Edición del places - <?= APP_NAME?></title>
		
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
		 <?=(TEMPLATE)::getHeader('Lista de places') ?>
		 <?=(TEMPLATE)::getMenu() ?>
		 <?=(TEMPLATE)::getFlashes() ?>
	<main>
		 <h1><?= APP_NAME ?></h1>
		 <h2>Borrar el place</h2>
		 
		 <form method="post" action="/Anuncio/destroy">
		 	<p>Confirmar el borrado del anuncio <b><?=$place->titulo ?></b>.</p>
		 	
		 	<!-- input oculto que contiene el ID del anuncio a borrar -->
		 	<input type="hidden" name="id" value="<?= $place->id ?>">
		 	<input type="submit" class="button" name="borrar" value="Borrar">		 
		 </form>	 
		
		 <div class="centrado">
		 	<a class="button" onclick="history.back()">Atrás</a>
		 	<a class="button" href="/Place/list">Lista de anuncios</a>
		 	<a class="button" href="/Place/show/<?= $place->id ?>">Detalles</a>
		 	<a class="button" href="/Place/edit/<?= $place->id ?>">Edición</a>		 	
		 </div>
		 <?= (TEMPLATE)::getFooter() ?>
	</main>	 
	</body>


