<?php ?>
<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF-8">
		<title>Edición de home- <?= APP_NAME?></title>
		
		<!-- META -->
		<meta name="viewport" content="width=device-widh, initial-scale=1.0">
		<meta name="description" content="Edición de anuncios en <?= APP_NAME ?>">
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
		 <?=(TEMPLATE)::getHeader('Edición de home de usuario') ?>
		 <?=(TEMPLATE)::getMenu() ?>
		 <?=(TEMPLATE)::getFlashes() ?>
	<main>
		 <h1><?= APP_NAME ?></h1>
		 
		 <div class="flex-container">
		 
		 <section class="flex1">
		 <h2>Edición del home de <?= $user->displayname ?></h2>
		 
		 <form method="post" action="/User/update" class="flex1"
		 		enctype="multipart/form-data">
		 	<!-- input oculto que contiene el ID del anuncio a actualizar -->
		 	<input type="hidden" name="id" value="<?= $user->id ?>">
		 	<label>Nombre</label>
		 	<input type="text" name="displayname" value="<?=old('displayname') ?>" required>
		 	<br>
		 	<label>Email</label>
		 	<input type="email" name="email" value="<?=old('email') ?>" required>
		 	<span id="comprobacion" class='info'></span>
		 	<br>
		 	<label>Phone</label>
		 	<input type="text" name="phone" value="<?=old('phone') ?>" required>
		 	<br>
		 	<label>Password</label>
		 	<input type="password" name="password" value="<?=old('password') ?>" required>
		 	<br>
		 	<label>Repetir</label>
		 	<input type="password" name="repeatpassword" value="<?=old('repeatpassword') ?>" required>
		 	<br>
		 	<label>Fecha de alta</label>
		 	<input type="date" name="created_at" value="<?=old('created_at') ?>" required>
		 	<br>
		 	<label>Imagen de perfil</label>
		 	<input type="file" name="picture" accept="image/*" id="file-with-preview">
		 	<br>
		 	<label>Rol</label>
		 	<select name="roles">
		 		<?php foreach (USER_ROLES as $roleName=>$roleValue){?>
		 		<option value="<?= $roleValue ?>"><?= $roleName ?></option>
		 		<?php }?>
		 	</select>
		 	<br>
		 	<input type="submit" class="button" name="actualizar" value="actualizar">
		 	</form>
		 	</section>
			
    		 <figure class="flex1 centrado">
    		 	<img src="<?=  USER_IMAGE_FOLDER.'/'.DEFAULT_USER_IMAGE ?>" id="preview-image"
    		 		class="cover" alt="Previsualización de la imagen de perfil">
    		 		<figcaption>Previzualización de la imagen de perfil</figcaption>
    		 </figure>
		 	</div>
		 	

		
		 <div class="centrado">
		 	<a class="button" onclick="history.back()">Atrás</a>
		 	<a class="button" href="/Place/list">Lugares</a>
		 			 	
		 </div>
		
		 
		 
		 
		 
		 
				
		 <?= (TEMPLATE)::getFooter() ?>
	</main>	 
	</body>

