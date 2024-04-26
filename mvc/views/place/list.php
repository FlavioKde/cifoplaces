<?php ?>
<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF-8">
		<title>Lista de lugares - <?= APP_NAME?></title>
		
		<!-- META -->
		<meta name="viewport" content="width=device-widh, initial-scale=1.0">
		<meta name="description" content="Lista de anuncios en <?= APP_NAME ?>">
		<meta name="author" content="Robert Sallent">
		
		<script>
		
		//revisar no esta del todo correcto
			function confirmar(id){
				if(confirm('Seguro que queres borrar el lugar?'))
					location.href = '/Place/list/
		
		
		</script>
		
		<!-- FAVICON -->
		<link rel="shortcut icon" href="/favicon.ico" type="image/png">
		
		
		<!-- CSS -->
		<?= (TEMPLATE)::getCss() ?>	
	</head>
	<body>
		 <?= (TEMPLATE)::getLogin() ?>
		 <?= (TEMPLATE)::getHeader('Lugares') ?>
		 <?= (TEMPLATE)::getMenu() ?>
		 <?= (TEMPLATE)::getBreadCrumbs([
		     "Lugares"=>'/Place/list',
		     "Lista"=>null
		 ]) ?>
		 <?= (TEMPLATE)::getFlashes() ?>
	<main>
		 <h1><?= APP_NAME ?></h1>
		 <h2>Lista completa de lugares</h2>
		 <!-- FILTRO DE BUSQUEDA -->
		 <?php if ($filtro) {
		     //el metodo RemoveFilterForm necesita conocer el filtro
		     //y la ruta a la que se envía el formulario
		     echo (TEMPLATE)::removeFilterForm($filtro, '/Place/list')
		     ;
		 }else{
		     echo(TEMPLATE)::filterForm(
		         //ruta a la que se enviá el formulario
		         '/Place/list',
		         //Lista de campos para "buscar en"
		         ['Nombre'=>'name', 'Tipo'=>'type', 'Lugar'=>'location','Descripción'=>'description'],
		         //lista de campos para "ordenar por"
		         ['Nombre'=>'name', 'Tipo'=>'type', 'Lugar'=>'location','Descripción'=>'description'],
		         //Valor por defecto para buscar "en"
		         'Description',
		         //Valor por defecto para ordenar "en"
		         'Name'
		         );
		 }?>
		 <?php if ($places) {?>
		 <div class="derecha">
		 <?= $paginator->stats() ?>
		 
		 </div>
		 <table>
		 	<tr>
		 		<th>Foto</th><th>Nombre</th><th>Tipo</th><th>Lugar</th><th>Descripción</th><th>Operaciones</th>
		 	</tr>
		 	<?php foreach ($places as $place) {?>
		 		<tr>
		 			<td class="centrado">
		 				<a href='/Place/show/<?=$place->id ?>'><img src="<?= AD_IMAGE_FOLDER.'/'.($place->cover ?? DEFAULT_AD_IMAGE) ?>"
		 					class="cover-mini" alt="Foto de <?= $place->name ?>"></a>
		 			</td>		
		 			<td><?= $place->name?></td>
		 			<td><?= $place->type?></td>
		 			<td><?= $place->location?></td>
		 			<td><?= $place->description?></td>
		 			<td>
		 			
		 			
		 				<a class="button" href='/Place/show/<?=$place->id ?>'>Ver</a> -
		 				<?php if(Login::user()->id == $place->iduser) {?>
		 				<a class="button" href='/Place/edit/<?=$place->id ?>'>Actualizar</a> -
		 				<?php }?>
		 				<?php if(Login::user()->id == $place->iduser) {?>
		 				<a class="button" href='/Place/delete/<?=$place->id ?>'>Borrar</a> 	
		 				<?php }?>	
		 			</td>
		 		</tr>
		 		<?php }?>		
		 </table>
		
		 <?= $paginator->ellipsisLinks() ?>
		
		 <?php }else{ ?>
		 <p>No hay interacciones con el lugar seleccionado.</p>
		 <?php }?>
		 	<div class="centrado">
		 	<a class="button" onclick="history.back()">Atrás</a>
		 	</div>
		 <?= (TEMPLATE)::getFooter() ?>
	</main>	 
	</body>
