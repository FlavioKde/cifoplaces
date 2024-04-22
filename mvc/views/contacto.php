<?php ?>
<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF-8">
		<title>Contacto CifoPlaces - <?= APP_NAME?></title>
		
		<!-- META -->
		<meta name="viewport" content="width=device-widh, initial-scale=1.0">
		<meta name="description" content="Contacto <?= APP_NAME ?>">
		<meta name="author" content="Robert Sallent">
		
		<!-- FAVICON -->
		<link rel="shortcut icon" href="/favicon.ico" type="image/png">
		
		<!-- CSS -->
		<?= (TEMPLATE)::getCss() ?>	
	</head>
	<body>
		 <?=(TEMPLATE)::getLogin() ?>
		 <?=(TEMPLATE)::getHeader('Contacto') ?>
		 <?=(TEMPLATE)::getMenu() ?>
		 <?=(TEMPLATE)::getFlashes() ?>
	<main>
		 <h1><?= APP_NAME ?></h1>
		 <div class="flex-container">
		 	<section class="flex1">
		 		<h2>Contacto</h2>
		 		
		 		<p>Utiliza el formulario de contacto para enviar un mensaje
		 		al administrador de <?= APP_NAME ?>.</p>
		 		<form method="POST" action="/Contacto/send">
		 			<label>Email</label>
		 			<input type="email" name="email" value="<?=old('email') ?>" required>
		 			<br>
		 			<label>Nombre</label>
		 			<input type="text" name="nombre" value="<?=old('nombre') ?>" required>
		 			<br>
		 			<label>Asunto</label>
		 			<input type="text" name="asunto" value="<?=old('asunto') ?>" required>
		 			<br>
		 			<label>Mensaje</label>
		 			<textarea  name="mensaje" required><?= old('mensaje') ?></textarea>
		 			<br>
		 			<input class="button" type="submit" name="enviar" value="Enviar">
		 		</form>
		 	</section>
		 	<section class="flex1">
		 		<h2>Ubicación y mapa</h2>
		 		<iframe id="mapa" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2985.6401100796065!2d2.0555563413491478!3d41.555388971398564!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x12a4952ef0b8c6e9%3A0xb6f080d2f180b111!2sCIFO%20Valles!5e0!3m2!1ses!2ses!4v1711095620013!5m2!1ses!2ses"
		 		 width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
		 		 
		 		 <h3>Datos</h3>
		 		 <p><b>CIFO Sabadell</b> - Carretera Nacional 150 km.15, 08227 Terrassa<br>
		 		 Télefono:93 736 29 10<br>
		 		 cifo_valles.soc@gencat.cat
		 		 </p>
		 	</section>
		 </div>
		 
		 <div class="centrado">
		 	<a class="button" onclick="history.back()">Atrás</a>		 	
		 </div>
		 <?= (TEMPLATE)::getFooter() ?>
	</main>	 
	</body>

