<?php ?>
<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF-8">
		<title>Lista de photo - <?= APP_NAME?></title>
		
		<!-- META -->
		<meta name="viewport" content="width=device-widh, initial-scale=1.0">
		<meta name="description" content="Lista de anuncios en <?= APP_NAME ?>">
		<meta name="author" content="Robert Sallent">
		
		<!-- FAVICON -->
		<link rel="shortcut icon" href="/favicon.ico" type="image/png">
		
		
		<!-- CSS -->
		<?= (TEMPLATE)::getCss() ?>	
	</head>
	<body>
		 <?= (TEMPLATE)::getLogin() ?>
		 <?= (TEMPLATE)::getHeader('Photos') ?>
		 <?= (TEMPLATE)::getMenu() ?>
		 <?= (TEMPLATE)::getBreadCrumbs([
		     "Photo"=>'/Photo/list',
		     "List"=>null
		 ]) ?>
		 <?= (TEMPLATE)::getFlashes() ?>
	<main>
		 <h1><?= APP_NAME ?></h1>
		 <h2>Lista completa de photo</h2>
		 <!-- FILTRO DE BUSQUEDA -->
		 <?php if ($filtro) {
		     //el metodo RemoveFilterForm necesita conocer el filtro
		     //y la ruta a la que se envía el formulario
		     echo (TEMPLATE)::removeFilterForm($filtro, '/Photo/list')
		     ;
		 }else{
		     echo(TEMPLATE)::filterForm(
		         //ruta a la que se enviá el formulario
		         '/Photo/list',
		         //Lista de campos para "buscar en"
		         ['Name'=>'name','Description'=>'description'],
		         //lista de campos para "ordenar por"
		         ['Name'=>'name','Description'=>'description'],
		         //Valor por defecto para buscar "en"
		         'Description',
		         //Valor por defecto para ordenar "en"
		         'Name'
		         );
		 }?>
		 <?php if ($photos) {?>
		 <div class="derecha">
		 <?= $paginator->stats() ?>
		 <?php }?>
		 </div>
		 <table>
		 	<tr>
		 		<th>Cover</th><th>Name</th><th>Type</th><th>Location</th><th>Description</th><th>Operaciones</th>
		 	</tr>
		 	<?php foreach ($places as $place){?>
		 		<tr>
		 			<td class="centrado">
		 				<img src="<?= AD_IMAGE_FOLDER.'/'.($place->file ?? DEFAULT_AD_IMAGE) ?>"
		 					class="cover-mini" alt="Foto de <?= $place->name ?>">
		 			</td>		
		 			<td><?= $place->name?></td>
		 			<td><?= $place->type?></td>
		 			<td><?= $place->location?></td>
		 			<td><?= $place->description?></td>
		 			<td>
		 				<a href='/Place/show/<?=$place->id ?>'>Ver</a> -
		 				<a href='/Place/edit/<?=$place->id ?>'>Actualizar</a> -
		 				<a href='/Place/delete/<?=$place->id ?>'>Borrar</a> -		
		 			</td>
		 		</tr>
		 		<?php }?>		
		 </table>
		 <?= $paginator->ellipsisLinks() ?>
		 
		 	<div class="centrado">
		 	<a class="button" onclick="history.back()">Atrás</a>
		 	</div>
		 <?= (TEMPLATE)::getFooter() ?>
	</main>	 
	</body>
