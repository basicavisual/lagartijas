# Lagartijas documentation

Lagartijas es un custom wordpress que showcasea el trabajo artístico de varios productores.

Este readme es un changelog de los cambios hechos al wordpress con propósitos documentales.

### Tamaños de fotos para sección Proyectos

**Problema**: La featured image del tipo de post Obras tiene tamaños irregulares.  
**Solución**: Este es la función responsable de los tamaños de las fotos. Se encuentra en functions.php y fue escrita por la desarrolladora original. La función está escrita correctamente, pero los tamaños no se veían reflejados. El código no presenta errores. La razón de que no se vieran aplicados es simplemente porque la función se escribió después de que se subieran las fotos y ésta no es retroactiva, pues procesa las fotos sólo durante el tiempo de upload. La solución fue simplemente subir las 3 fotos afectadas (en el mismo barco, noviembre y pia)

```
	// Habilitamos soporte a Thumbnails
	if ( function_exists( 'add_theme_support' ) ) {
	  add_theme_support( 'post-thumbnails' );
	  set_post_thumbnail_size( 150, 150, true );
	  add_image_size( 'disque-isotope', 450, 337, true );
	}
```

### Selector de años y despliegue de datos en la sección Tiempos

**Problema**: El selector en esta sección representaba un rango de unos 9 años, sin embargo algunas obras más antiguas no aparecían.  
**Solución**: Refactorear el código del contador (bonus: tena estilos default del navegador, puse estilos acorde al resto de la página).
El código actual hace una lista de todos los años en los que ha habido presentaciones y con ello construye el selector. Se hace uso de una función ya existente para ello.


Código original

```
$anio = (isset($_GET['anio'])) ? (string)trim($_GET['anio']) : date("Y");
<?php $contador_anios = (int)date("Y"); ?>
<?php for ($i = -5; $i < 6; $i++) { ?>
<option value="<?php echo ($contador_anios+$i); ?>"<?=(($contador_anios+$i)==$anio) ? ' selected' : '';?>><?php echo ($contador_anios+$i); ?></option>
<?php } ?>
```

Código refactoreado
```
$fechas_array = [];

foreach ($obras as $obra) {
	$presentaciones = get_field ( "presentaciones", $obra->ID );
		foreach ($presentaciones as $presentacion)
			{
				$inicio = $presentacion['fecha_inicio'];
				$time = strtotime($inicio);
				array_push($fechas_array, date('Y', $time));
			}
}
$fechas_array = array_unique($fechas_array);
rsort($fechas_array);

<?php foreach ($fechas_array as $per_year) { ?>
<option value="<?php echo $per_year?>"<?=($per_year == $anio) ? ' selected' : ''; ?>><?php echo $per_year?></option>
<?php } ?>
```

Para el despliegue inverso de tiempos en dicha sección, decidí aprovechar el código y simplemente invertir el orden de los años.
