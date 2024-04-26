<?php ?>
<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF-8">
		<title>Detalles de places en - <?= APP_NAME?></title>
		<!-- META -->
		<meta name="viewport" content="width=device-widh, initial-scale=1.0">
		<meta name="description" content="Nuevo usuario <?= APP_NAME ?> ">
		<meta name="author" content="Robert Sallent">
		
		<!-- FAVICON -->
		<link rel="shortcut icon" href="favicon.ico" type="image/png">
		
		<!-- JS -->
		<script src="/js/preview.js"></script>
		
		<!-- CSS -->
		<?= (TEMPLATE)::getCss() ?>	
		
		<script>
			window.addEventListener('load', function(){
				inputEmail.addEventListener('change', function(){
				fetch("/User/registered/"+this.value, {
				"method":"GET"
				})
				.then(function(respuesta){
					return respuesta.json();
				})
				.then(function(json){
					if(json.status == 'OK')
					comprobacion.innerHTML = json.registered?
										'El usuario ya existe.': '';
					else
						comprobacion.innerHTML = 'No se pudo comprobar.';
				});
				})
				})								
		</script>	
	</head>
	<body>
		 <?=(TEMPLATE)::getLogin() ?>
		 <?=(TEMPLATE)::getHeader('Nuevo Usuario') ?>
		 <?=(TEMPLATE)::getMenu() ?>
		 <?=(TEMPLATE)::getBreadCrumbs([
		     "User"=>'index',
		     "User"=>null
		 ]) ?>
		 <?=(TEMPLATE)::getFlashes() ?>
	<main>
		 <h1><?= APP_NAME ?></h1>
		<section>
		 <h2>Nuevo Usuario</h2>
		 <div class="flex-container">
		 	<form method="post" action="/User/store"
		 		enctype="multipart/form-data" class="flex2" >		   
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
		 	<input type="submit" class="button" name="guardar" value="Guardar">
		 	</form>
		
    		 <figure class="flex1 centrado">
    		 	<img src="<?=  USER_IMAGE_FOLDER.'/'.DEFAULT_USER_IMAGE ?>" id="preview-image"
    		 		class="cover" alt="Previsualización de la imagen de perfil">
    		 		<figcaption>Previzualización de la imagen de perfil</figcaption>
    		 </figure>
		 	</div>
		 	</section>
		 
    		 <div class="centrado">
    		 	<a class="button" onclick="history.back()">Atrás</a>
    		 </div>
		 
		
		 <?= (TEMPLATE)::getFooter() ?>
	</main>	 
	</body>


