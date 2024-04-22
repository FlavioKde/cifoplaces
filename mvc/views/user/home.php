<?php ?>
<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF-8">
		<title>Detalles del anuncio en - <?= APP_NAME?></title>
		<!-- META -->
		<meta name="viewport" content="width=device-widh, initial-scale=1.0">
		<meta name="description" content="Home de usuario <?= APP_NAME ?> ">
		<meta name="author" content="Robert Sallent">
		
		<!-- FAVICON -->
		<link rel="shortcut icon" href="favicon.ico" type="image/png">
		
		<!-- CSS -->
		<?= (TEMPLATE)::getCss() ?>	
	</head>
	<body>
		 <?=(TEMPLATE)::getLogin() ?>
		 <?=(TEMPLATE)::getHeader('Home de Usuario') ?>
		 <?=(TEMPLATE)::getMenu() ?>
		 <?=(TEMPLATE)::getFlashes() ?>
	<main>
		 <h1><?= APP_NAME ?></h1>
		 
		 <div class="flex-container">
		 <section class="flex2">
		 <h2><?=" Home de $user->displayname"?></h2>
		 
		 <p><b>Nombre:</b>                        <?=$user->displayname?></p>
		 <p><b>Email:</b>                         <?=$user->email?></p>
		 <p><b>Teléfono:</b>                      <?=$user->phone?></p>
		 <p><b>Fecha de alta:</b>                 <?=$user->create_at?></p>
		 <p><b>Última modificación:</b>           <?=$user->updated_at ?? '--'?></p>
		 <p><b>Bloqueado:</b>					  <?=$user->blocked_at?></p>
		 						
		 
		 </section>
		 <!-- Esta parte solamente si creamos la carpeta para las fotos de perfil -->
		 <figure class="flex1 centrado">
		 	<img src="<?=  USER_IMAGE_FOLDER.'/'.($user->picture ?? DEFAULT_USER_IMAGE) ?>"
		 		class="cover" alt="Imagen de perfil de <?=$user->displayname ?> ?>">
		 		<figcaption>Imagen de perfil de <?="$user->displayname" ?> </figcaption>
		 </figure>
		 </div>
		 <section>
		 <h2>Anuncios de <?= $user->displayname ?></h2>
		 
		 <?php 
		 
		 if (!$places){
		     echo "<p>No tiene anuncios propios este usuario.</p>";
		 }else ?>
		 
		 <table>
		 	<tr>
		 		<th>Foto</th><th>Título</th><th>Descripción</th><th>Precio</th><th>Operaciones</th>
		 	</tr>
		 	<?php foreach ($places as $place){?>
		 	
		 		<tr>
		 			<td class="centrado">
		 				<img src="<?= AD_IMAGE_FOLDER.'/'.($place->foto ?? DEFAULT_AD_IMAGE) ?>"
		 					class="cover-mini" alt="Foto de <?= $place->name ?>">
		 			</td>		
		 			<td><?= $place->titulo?></td>
		 			<td><?= $place->descripcion?></td>
		 			<td><?= $place->precio?></td>
		 			<td>
		 				<a href='/Place/show/<?=$place->id ?>'>Ver</a> -
		 				<a href='/Place/edit/<?=$place->id ?>'>Actualizar</a> -
		 				<a href='/Place/delete/<?=$place->id ?>'>Borrar</a> -		
		 			</td>
		 		</tr>
		 		<?php }?>		
		 </table>
		
		 </section>
		 <div class="centrado">
		 	<a class="button" onclick="history.back()">Atrás</a>
		 	<a class="button" href="/Place/list">Lista de places</a>
		 	
		 </div>
		 
		
		 <?= (TEMPLATE)::getFooter() ?>
	</main>	 
	</body>

