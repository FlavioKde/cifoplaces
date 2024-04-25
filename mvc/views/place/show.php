<?php ?>
<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF-8">
		<title>Detalles de los lugares - <?= APP_NAME?></title>
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
		 <?=(TEMPLATE)::getHeader('Detalles de los lugares') ?>
		 <?=(TEMPLATE)::getMenu() ?>
		 <?=(TEMPLATE)::getFlashes() ?>
	<main>
		 <h1><?= APP_NAME ?></h1>
		 <div class="derecha">
		 	
		 	
		 	
		 	<a class="button" href="/Place/createComment/<?=$place->id?>">Nuevo comentario</a>
		 	
		 	<a class="button" href="/Photo/create/<?= $place->id ?>">Nueva Foto</a>
		 </div>
		 <br>
		 <div class="flex-container">
		 
		 <section class="flex1">
		 <h2><?= "Detalles de los lugares $place->name" ?></h2>
		 
		 
		 
		 
		 <p><b>Nombre:</b>                   <?=$place->name?></p>
		 <p><b>Tipo:</b>                     <?=$place->type?></p>
		 <p><b>lugar:</b>				     <?=$place->location?></p>
		 <p><b>decripción:</b>               <?=$place->description ?></p>
		 
		 </section>
		 <figure class= "flex1 centrado">
		 	<img src="<?= AD_IMAGE_FOLDER.'/'.($place->cover ?? DEFAULT_AD_IMAGE) ?>"
		 		class="cover" alt="Foto de <?= $place->name ?>">
		 		<figcaption>Foto de <?="$place->name" ?></figcaption>
		 </figure>
		 
		 </div>
		 <br>	
		 
		 					 
		 <div class="centrado">
		 	<a class="button" onclick="history.back()">Atrás</a>
		 	<a class="button" href="/Place/list">Lista de lugares</a>
		 	<?php if(Login::user()->id == $place->id){?>
		 	<a class="button" href="/Place/edit/<?= $place->id ?>">Edición</a>
		 	<?php }?>
		 	<?php if (Login::user()->id == $place->id) {?>
		 	<a class="button" href="/Place/delete<?= $place->id ?>">Borrado</a>
		 	<?php }?>
		 </div>
		 
		 <h2>Fotos de usuarios</h2>
		
		<?php foreach ($photos as $photo){?>
		<div class="flex-container">
		 		<section class="flex4">
		 	
		 			
		 				<img src="<?= PI_IMAGE_FOLDER.'/'.($photo->file ?? DEFAULT_PICTURE_IMAGE) ?>"
		 					class="cover" alt="Foto de <?= $photo->name ?>">
		 			
		 				<a class="button" href='/Photo/show/<?=$photo->id ?>'>Ver</a> -
		 				<?php if (Login::user()->id == $photo->iduser) {?>
		 				<a class="button" href='/Photo/edit/<?=$photo->id ?>'>Actualizar</a> -
		 				<?php }?>
		 				<?php if (Login::user()->id == $photo->iduser) {?>
		 				<a class="button" href='/Photo/delete/<?=$photo->id ?>'>Borrar</a>
		 				<?php }?> 		
		 			
		 		</section>	
		 </div>		
		 		<?php }?>	
		 		
		 	<h2>Comentarios de usuarios</h2>	
		 	
		 <?php 
		 if ($comments) {
		      echo "<p>No hay comentarios de este lugar.</p>";
		 }else{?>
		 
		
		 			<table>
		 				<tr>
		 					<th>Comentario</th><th>usuario</th><th>operaciones</th>
		 					</tr>
		 					<?php foreach ($createComments as $comment){?>
		 					
		 					<tr>	
		 					<td><?= $comment->text ?></td>
		 					<td><?= $comment->iduser ?></td>
		 					<td class="centrado">
		 				<a class="button" href='/Comment/show/<?=$comment->id ?>'>Ver</a> -
		 				<?php if (Login::user()->id == $comment->iduser) {?>
		 				<a class="button" href='/Comment/edit/<?=$comment->id ?>'>Actualizar</a> -
		 				<?php }?>
		 				<?php if (Login::user()->id == $comment->iduser) {?>
		 				<a class="button" href='/Comment/delete/<?=$comment->id ?>'>Borrar</a>
		 				<?php }?>
		 				</td>
		 				</tr>
		 				<?php }?> 		
		 			</table>
		 		
		 			
				<?php }?>
		 <?= (TEMPLATE)::getFooter() ?>
	</main>	 
	</body>
