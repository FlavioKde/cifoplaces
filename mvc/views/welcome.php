<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF-8">
		<title>Portada - <?= APP_NAME ?></title>
		
		<!-- META -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="Cifoplaces">
		<meta name="author" content="Robert Sallent">
		
		<!-- FAVICON -->
		<link rel="shortcut icon" href="/favicon.ico" type="image/png">	
		
		<!-- CSS -->
		<?= (TEMPLATE)::getCss() ?>
	</head>
	<body>
		<?= (TEMPLATE)::getLogin() ?>
		<?= (TEMPLATE)::getHeader('') ?>
		<?= (TEMPLATE)::getMenu() ?>
		<?= (TEMPLATE)::getFlashes() ?>
		
		<main>
			<br>
			<br>
			<br>
			<br>
		    <div class="centrado">
    		<h1><?= APP_NAME ?>
    		</h1>
    		
    		<br>
    		<br>
    		<h2>Registrate para ver <span style="color:turquoise">fotos</span> y </h2>
    		<h2><span style="color:violet">Videos</span> de tus amigos y tuyos tambien</h2>
    		
    		<a class="button" href="/Login">Entrar</a>
    		<a class="button" href="/User/create">Registrarse</a>
    		</div>
		   	<br>
		   	<br>
		   	<br>
		   	<br>
		   	<br>
		   	<br>
		   	<div class="centrado">
		   	<h3>from</h3>
		   	
		   	<img class="cover-mini" src="images/template/logo2.png">
		   	<p>Buhito</p>
		   	</div>
		   
		   	   
   	
		   	   
		</main>
		<?= (TEMPLATE)::getFooter() ?>
	</body>
</html>

