<?php
//CONSULTAMOS LAS ULTIMAS OBRAS
$args = array(
	'post_type' => 'obra',
	'order' => 'DESC',
	'orderby' => 'date',
	'posts_per_page' => -1,
	'suppress_filters' => 0
);
$obras = get_posts( $args ); $identificador = ''; $fechas = array(); $contador_presentaciones = 0;
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

//Leemos el Año
// esta variable lee el año actual en date("Y") y, en el caso de que el request tenga un parámetro 'anio' lee el año de ese parámetro.
// El propósito de esto es que el selector funcione correctamente, dando el primer año del array o el año presentamente seleccionado.
$anio = (isset($_GET['anio'])) ? (string)trim($_GET['anio']) : $fechas_array[0];
?>

<?php get_header(); ?>
	<section class="espaniol">
		<?php include 'menu_esp.php'; ?>
		<div class="tiempos">
			<div class="titulo">
				<h2>
					<?php
					// echo $fechas; ?>
					<?php _e('TEMPORAL DE OBRAS','lagartijas');?> -
					<select id="selector_tiempos" name="selector_tiempos" rel="<?php echo  icl_get_home_url(); ?>seccion/tiempos/">
						<?php foreach ($fechas_array as $per_year) { ?>
							<option value="<?php echo $per_year?>"<?=($per_year == $anio) ? ' selected' : ''; ?>><?php echo $per_year?></option>
						<?php } ?>
					</select>
				</h2>
			</div>
			<div class="archive_tiempo">
				<?php


					//Checamos el Idioma, y Creamos los Meses según el idioma
					if (ICL_LANGUAGE_CODE == 'es')
					{
						$Mes01Upper = 'DICIEMBRE'; $Mes01Lower = 'Diciembre';
						$Mes02Upper = 'NOVIEMBRE'; $Mes02Lower = 'Noviembre';
						$Mes03Upper = 'OCTUBRE'; $Mes03Lower = 'Octubre';
						$Mes04Upper = 'SEPTIEMBRE'; $Mes04Lower = 'Septiembre';
						$Mes05Upper = 'AGOSTO'; $Mes05Lower = 'Agosto';
						$Mes06Upper = 'JULIO'; $Mes06Lower = 'Julio';
						$Mes07Upper = 'JUNIO'; $Mes07Lower = 'Junio';
						$Mes08Upper = 'MAYO'; $Mes08Lower = 'Mayo';
						$Mes09Upper = 'ABRIL'; $Mes09Lower = 'Abril';
						$Mes10Upper = 'MARZO'; $Mes10Lower = 'Marzo';
						$Mes11Upper = 'FEBRERO'; $Mes11Lower = 'Febrero';
						$Mes12Upper = 'ENERO'; $Mes12Lower = 'Enero';
					}
					else
					{
						$Mes01Upper = 'DECEMBER'; $Mes01Lower = 'December';
						$Mes02Upper = 'NOVEMBER'; $Mes02Lower = 'November';
						$Mes03Upper = 'OCTOBER'; $Mes03Lower = 'October';
						$Mes04Upper = 'SEPTEMBER'; $Mes04Lower = 'September';
						$Mes05Upper = 'AUGUST'; $Mes05Lower = 'August';
						$Mes06Upper = 'JULY'; $Mes06Lower = 'July';
						$Mes07Upper = 'JUNE'; $Mes07Lower = 'June';
						$Mes08Upper = 'MAY'; $Mes08Lower = 'May';
						$Mes09Upper = 'APRIL'; $Mes09Lower = 'April';
						$Mes10Upper = 'MARCH'; $Mes10Lower = 'March';
						$Mes11Upper = 'FEBRUARY'; $Mes11Lower = 'February';
						$Mes12Upper = 'JANUARY'; $Mes12Lower = 'January';
					}

					//Pre construimos la estructura de fechas
					$fechas = array(
						'01' => array(
							'mes' => $Mes01Upper.' '.$anio,
							'presentaciones' => array()
						),
						'02' => array(
							'mes' => $Mes02Upper.' '.$anio,
							'presentaciones' => array()
						),
						'03' => array(
							'mes' => $Mes03Upper.' '.$anio,
							'presentaciones' => array()
						),
						'04' => array(
							'mes' => $Mes04Upper.' '.$anio,
							'presentaciones' => array()
						),
						'05' => array(
							'mes' => $Mes05Upper.' '.$anio,
							'presentaciones' => array()
						),
						'06' => array(
							'mes' => $Mes06Upper.' '.$anio,
							'presentaciones' => array()
						),
						'07' => array(
							'mes' => $Mes07Upper.' '.$anio,
							'presentaciones' => array()
						),
						'08' => array(
							'mes' => $Mes08Upper.' '.$anio,
							'presentaciones' => array()
						),
						'09' => array(
							'mes' => $Mes09Upper.' '.$anio,
							'presentaciones' => array()
						),
						'10' => array(
							'mes' => $Mes10Upper.' '.$anio,
							'presentaciones' => array()
						),
						'11' => array(
							'mes' => $Mes11Upper.' '.$anio,
							'presentaciones' => array()
						),
						'12' => array(
							'mes' => $Mes12Upper.' '.$anio,
							'presentaciones' => array()
						)
					);

					//Verificamos si hay obras
					if (count($obras) > 0)
					{
						//Procesamos las Obras
						foreach ($obras as $obra)
						{
							//Leemos las Presentaciones
							$presentaciones = get_field ( "presentaciones", $obra->ID );

							//Verificamos
							if ($presentaciones)
							{
								//Procesamos las Presentaciones
								foreach ($presentaciones as $presentacion)
								{
									//Leemos la Informacion
									$inicio = $presentacion['fecha_inicio'];
									$termino = $presentacion['fecha_termino'];
									$lugar = $presentacion['lugar'];
									$url = $presentacion['url'];
									$nombre_inicio = ''; $nombre_termino = '';

									//Procesamos la Fecha de Inicio
									$time = strtotime($inicio);
									$newformat = date('Y-m-d',$time);
									$date_inicio = explode('-',$newformat);

									//Verificamos que la obra es en el año mandado por parametro o el año actual
									if ((string)trim($date_inicio[0]) == $anio)
									{
										switch ((int)$date_inicio[1])
										{
											case 1: $nombre_mes = $Mes01Upper.' '.$date_inicio[0]; $nombre_inicio = $Mes01Lower.' '.$date_inicio[2]; break;
											case 2: $nombre_mes = $Mes02Upper.' '.$date_inicio[0]; $nombre_inicio = $Mes02Lower.' '.$date_inicio[2]; break;
											case 3: $nombre_mes = $Mes03Upper.' '.$date_inicio[0]; $nombre_inicio = $Mes03Lower.' '.$date_inicio[2]; break;
											case 4: $nombre_mes = $Mes04Upper.' '.$date_inicio[0]; $nombre_inicio = $Mes04Lower.' '.$date_inicio[2]; break;
											case 5: $nombre_mes = $Mes05Upper.' '.$date_inicio[0]; $nombre_inicio = $Mes05Lower.' '.$date_inicio[2]; break;
											case 6: $nombre_mes = $Mes06Upper.' '.$date_inicio[0]; $nombre_inicio = $Mes06Lower.' '.$date_inicio[2]; break;
											case 7: $nombre_mes = $Mes07Upper.' '.$date_inicio[0]; $nombre_inicio = $Mes07Lower.' '.$date_inicio[2]; break;
											case 8: $nombre_mes = $Mes08Upper.' '.$date_inicio[0]; $nombre_inicio = $Mes08Lower.' '.$date_inicio[2]; break;
											case 9: $nombre_mes = $Mes09Upper.' '.$date_inicio[0]; $nombre_inicio = $Mes09Lower.' '.$date_inicio[2]; break;
											case 10: $nombre_mes = $Mes10Upper.' '.$date_inicio[0]; $nombre_inicio = $Mes10Lower.' '.$date_inicio[2]; break;
											case 11: $nombre_mes = $Mes11Upper.' '.$date_inicio[0]; $nombre_inicio = $Mes11Lower.' '.$date_inicio[2]; break;
											case 12: $nombre_mes = $Mes12Upper.' '.$date_inicio[0]; $nombre_inicio = $Mes12Lower.' '.$date_inicio[2]; break;
											default: $nombre_mes = $Mes01Upper.' '.$date_inicio[0]; $nombre_inicio = $Mes01Lower.' '.$date_inicio[2]; break;
										}

										//Procesamos la Fecha de Término
										$time = strtotime($termino);
										$newformat = date('Y-m-d',$time);
										$date_termino = explode('-',$newformat);

										switch ((int)$date_termino[1])
										{
											case 1:
												if ($date_inicio[1] == $date_termino[1]) { $nombre_termino = $date_termino[2];  }
												else { $nombre_termino = $Mes01Lower.' '.$date_termino[2]; } break;
											case 2:
												if ($date_inicio[1] == $date_termino[1]) { $nombre_termino = $date_termino[2];  }
												else { $nombre_termino = $Mes02Lower.' '.$date_termino[2]; } break;
											case 3:
												if ($date_inicio[1] == $date_termino[1]) { $nombre_termino = $date_termino[2];  }
												else { $nombre_termino = $Mes03Lower.' '.$date_termino[2]; } break;
											case 4:
												if ($date_inicio[1] == $date_termino[1]) { $nombre_termino = $date_termino[2];  }
												else { $nombre_termino = $Mes04Lower.' '.$date_termino[2]; } break;
											case 5:
												if ($date_inicio[1] == $date_termino[1]) { $nombre_termino = $date_termino[2];  }
												else { $nombre_termino = $Mes05Lower.' '.$date_termino[2]; } break;
											case 6:
												if ($date_inicio[1] == $date_termino[1]) { $nombre_termino = $date_termino[2];  }
												else { $nombre_termino = $Mes06Lower.' '.$date_termino[2]; } break;
											case 7:
												if ($date_inicio[1] == $date_termino[1]) { $nombre_termino = $date_termino[2];  }
												else { $nombre_termino = $Mes07Lower.' '.$date_termino[2]; } break;
											case 8:
												if ($date_inicio[1] == $date_termino[1]) { $nombre_termino = $date_termino[2];  }
												else { $nombre_termino = $Mes08Lower.' '.$date_termino[2]; } break;
											case 9:
												if ($date_inicio[1] == $date_termino[1]) { $nombre_termino = $date_termino[2];  }
												else { $nombre_termino = $Mes09Lower.' '.$date_termino[2]; } break;
											case 10:
												if ($date_inicio[1] == $date_termino[1]) { $nombre_termino = $date_termino[2];  }
												else { $nombre_termino = $Mes10Lower.' '.$date_termino[2]; } break;
											case 11:
												if ($date_inicio[1] == $date_termino[1]) { $nombre_termino = $date_termino[2];  }
												else { $nombre_termino = $Mes11Lower.' '.$date_termino[2]; } break;
											case 12:
												if ($date_inicio[1] == $date_termino[1]) { $nombre_termino = $date_termino[2];  }
												else { $nombre_termino = $Mes12Lower.' '.$date_termino[2]; } break;
											default:
												if ($date_inicio[1] == $date_termino[1]) { $nombre_termino = $date_termino[2];  }
												else { $nombre_termino = $Mes01Lower.' '.$date_termino[2]; } break;
										}

										//Verificamos si la fecha de inicio y término son en el mismo mes
										if ($date_inicio[1] == $date_termino[1])
										{
											//Agregamos la entrada al mes creado previamente
											$fechas[$date_inicio[1]]['presentaciones'][] = array(
												'lugar' => $lugar,
												'url' => $url,
												'fecha' => $nombre_inicio . ' - ' . $nombre_termino,
												'idobra' => $obra->ID,
												'obra' => $obra->post_title
											);
										}
										else
										{
											//Agregamos la entrada al mes creado previamente
											$fechas[$date_inicio[1]]['presentaciones'][] = array(
												'lugar' => $lugar,
												'url' => $url,
												'fecha' => $nombre_inicio . ' - ' . $nombre_termino,
												'idobra' => $obra->ID,
												'obra' => $obra->post_title
											);
										}
									}
								}
							} // End If (presentaciones)
						} // End Foreach (obras)
					}

					//Revisamos si hay fechas
					if (count($contador_presentaciones) > 0) { ?>
					<?php foreach ($fechas as $fecha) { ?>
						<?php if (count($fecha['presentaciones']) > 0) { $contador_presentaciones++; ?>
							<?php if ($contador_presentaciones==1) { ?>
							<h3><?php echo $anio; //echo $fecha['mes']; ?></h3>
							<?php } ?>
							<?php foreach ($fecha['presentaciones'] as $presentacion) { ?>
							<div class="tiempo_box">
								<p><?php echo $presentacion['fecha']; ?></p>
								<a class="titulo_lugar" href="<?php echo $presentacion['url']; ?>" target="_blank"><?php echo $presentacion['lugar']; ?></a>
								<a class="titulo_obra" href="<?php echo get_the_permalink($presentacion['idobra']); ?>" target="_self"><?php echo $presentacion['obra']; ?></a>
							</div>
							<?php } // End Foreach(presentaciones) ?>
						<?php } // End If (presentaciones) ?>
					<?php } // End Foreach (fechas) ?>
				<?php } ?>
				<?php if ($contador_presentaciones == 0) { ?>
				<p><?php _e('No hay obras publicadas en este año.','lagartijas');?></p>
				<?php } ?>
			</div>
		</div>
	</section>
<?php get_footer(); ?>
