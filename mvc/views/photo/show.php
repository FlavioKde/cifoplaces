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
		<link rel="shortcut icon" href="/favicon.ico" type="image/png"> 
		
		<!-- CSS -->
		<?= (TEMPLATE)::getCss() ?>	
	</head>
	<body>
		 <?=(TEMPLATE)::getLogin() ?>
		 <?=(TEMPLATE)::getHeader('Detalles de fotos') ?>
		 <?=(TEMPLATE)::getMenu() ?>
		 <?=(TEMPLATE)::getFlashes() ?>
	<main>
		 <h1><?= APP_NAME ?></h1>
		 
		 <div class="derecha">
		 <a class="button" href="/Place/createPhotoComment/<?=$photo->id?>">Nuevo comentario</a>
		 </div>
		 <br>
		 <div class="flex-container">
		 <section class="flex1">
		 <h2><?= "Detalles fotos de $photo->name" ?></h2>
		 
		 <p><b>Nombre:</b>                   <?=$photo->name?></p>
		 <p><b>Descripción:</b>              <?=$photo->description?></p>
		 <p><b>Dia:</b>				    	 <?=$photo->date?></p>
		 <p><b>Hora:</b>                   	 <?=$photo->time ?></p>
		 
		 </section>
		 <figure class= "flex1 centrado">
		 	<img src="<?= PI_IMAGE_FOLDER.'/'.($photo->file ?? DEFAULT_PI_IMAGE) ?>"
		 		class="cover" alt="Foto de <?= $photo->name ?>">
		 		<figcaption>Foto de <?="$photo->name" ?></figcaption>
		 </figure>
		 </div>			 
		 <div class="centrado">
		 	<a class="button" onclick="history.back()">Atrás</a>
		 	
		 	<a class="button" href="/Place/show/<?=$idplace->id ?>">Fotos</a>
		 	
		 	<?php if (Login::user()->id == $photo->id){?>
		 	<a class="button" href="/Photo/edit/<?= $photo->id ?>">Edición</a>
		 	<?php }?>
		 	<?php if (Login::user()->id == $photo->id) {?>
		 	<a class="button" href="/Photo/delete<?= $photo->id ?>">Borrado</a>
		 	<?php }?>
		 </div>
		<h2>Comentarios de usuarios</h2>	
		 
		 <div class="centrado">	
		 <?php 
		 if ($comment) {
		      echo "<p>No hay comentarios de esta foto.</p>";
		 }else{?>
		 </div>
			
		 			<table>
		 				
		 					<?php foreach ($createPhotoComments as $comment){?>
		 					
		 					<tr>	
		 					<td><?= $comment->text ?></td>
		 					<td><?= $comment->iduser ?></td>
		 					<td class="centrado">
		 				<a class="button" href='/Comment/show/<?=$comment->id ?>'>Ver</a> -
		 				
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
