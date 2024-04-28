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
		 <?=(TEMPLATE)::getHeader('Borrar lugar') ?>
		 <?=(TEMPLATE)::getMenu() ?>
		 <?=(TEMPLATE)::getFlashes() ?>
	<main>
		 <h1><?= APP_NAME ?></h1>
		 <h2>Borrar</h2>
		 <script>
		 		function confirmar(id){
		 			if(confirm('Seguro que deseas eliminar?'))
		 				location.href = '/Place/destroy/'+id
									}				 	
		 </script>
		 
		 <form method="post" action="/Place/destroy">
		 	<p>Confirmar el borrado del lugar <b><?=$place->name ?></b>.</p>
		 	
		 	<!-- input oculto que contiene el ID del anuncio a borrar -->
		 	<input type="hidden" name="id" value="<?= $place->id ?>">
		 		
		 	<input type="submit" class="button" name="borrar" value="borrar" onclick="confirmar(<?= $place->id?>)">	 
		 </form>	 
		 
		 <div class="centrado">
		 	<a class="button" onclick="history.back()">Atrás</a>
		 	<a class="button" href="/Place/list">Lugares</a>
		 	<a class="button" href="/Place/show/<?= $place->id ?>">Detalles</a>
		 	<a class="button" href="/Place/edit/<?= $place->id ?>">Edición</a>		 	
		 </div>
		 <?= (TEMPLATE)::getFooter() ?>
	</main>	 
	</body>


