<!DOCTYPE html>
<html>
	<head>
		<?php $this->load->view('meta');?>
	</head>
	<body>

<!--
		<?php $this->load->view('menu');?>

		<section class="hero is-dark" style="background-color: #0b2556;">
			<div class="hero-body has-text-centered">
				<div class="container">
					<h1 class="title">
						<?php echo $proyecto->nomb_proy;?>
					</h1>
					<h2 class="subtitle">
						<?php echo $proyecto->nomb_esq_finan;?>
						<?php //echo $proyecto->nomb_proy;?>
					</h2>
				</div>
			</div>
		</section>

-->

            <a class="bd-prev-next-bis-previous" href="javascript:window.history.back();">
              ← ir a la página anterior
            </a>


		<div class="tile is-ancestor">

			<div class="tile is-3 is-vertical is-parent">
				<div class="tile is-child box" style="box-shadow: none !important;">
					<aside class="menu">
						<p class="menu-label">
							Contenido
						</p>

						<ul class="menu-list">
							<li>
							<a href="#resumen">Resumen</a>
									
							</li>
							<li>
								<a href="#palabras_clave">Palabras clave</a>
									
								
							</li>
							<li>
							<a href="#problema_central">Problema central</a>
									
							</li>
							<li>
								<a href="#hipotesis_planteada">Hipótesis planteada</a>
									
							</li>
							<li>
								<a href="#resultados_esperados">Resultados esperados</a>
								
							</li>
							<li>
							<a href="#impactos_esperados">Impactos esperados</a>
									
							</li>
						</ul>

						<p class="menu-label">
							Área de investigación
						</p>
						<ul class="menu-list">
							<li>
								<ul>
									<li>
										<?php echo $proyecto->nomb_areapri;?>
										<ul>
											<li>
												<?php echo $proyecto->area_investigacion;?>
												<ul>
													<li>
														<?php echo $proyecto->linea_investigacion;?>
													</li>
												</ul>
											</li>
										</ul>
									</li>
								</ul>

							</li>
						</ul>

<!--
						<p class="menu-label">
							OCDE
						</p>
						<ul class="menu-list">
							<li>
								<ul>
									<li>
										Ciencias naturales
									</li>
								</ul>

							</li>
						</ul>-->




						<p class="menu-label">
							Financiamiento
						</p>
						<ul class="menu-list">
							<li>
								<a>
									S/ <?php echo $financiamiento;?> 
								</a>
							</li>
						</ul>

						<p class="menu-label">
							Duración
						</p>
						<ul class="menu-list">
							<li>
								<a>
									Duración: <?php echo $proyecto->durac_proy;?> (mes/meses)
								</a>
								<a>
									Inicio: <?php echo $proyecto->fech_ini_proy;?>
								</a>
								<a>
									Fin:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo date("Y-m-d",strtotime($proyecto->fech_ini_proy."+ ".$proyecto->durac_proy." month"));?>
								</a>
							</li>
						</ul>



					</aside>
				</div>
			</div>


			<div class="tile is-parent is-6">
				<div class="tile is-child box " style="box-shadow: none !important;">

					<article class="media">

						<div class="media-content">
							<div class="content">

								<div class="is-size-7">
									<?php echo $proyecto->nomb_esq_finan;?>
								</div>

								<strong>
									<?php echo $proyecto->nomb_proy;?>
								</strong>
								<div class="">
									<small class="is-italic">
										<?php echo ucwords(strtolower($proyecto->integrantes));?>
										
									</small>
								</div>

								<span class="tag is-white">
									<a style="color: currentColor;   cursor: not-allowed;   opacity: 0.5;   text-decoration: none;">
										Descargar en pdf
									</a>
								</span>
								<span class="tag is-white">
									<a style="color: currentColor;   cursor: not-allowed;   opacity: 0.5;   text-decoration: none;">
										Exportar cita
									</a>
								</span>


								<h3>
									Objetivo
								</h3>


								<div class="message-body">

									<?php echo $proyecto->obj_general_proy;?>
								</div>

								<h3>
								<a name="resumen"></a>
									Resumen:
								</h3>
								
								<p class=" has-text-justified">
								<?php echo $proyecto->resumen_ejecutivo;?>
								</p>
								<h3>
								<a name="palabras_clave"></a>
									Palabras clave
								</h3>
								<p class=" has-text-justified">
									<?php echo $proyecto->claves_proy;?>
								</p>


								<h3>
								<a name="problema_central"></a>
									Problema central
								</h3>
								<p class=" has-text-justified">
									<?php echo $proyecto->just_proy;?>
								</p>

								<h3>
									Hipótesis planteada
									<a name="hipotesis_planteada"></a>
								</h3>
								<p class=" has-text-justified">
									<?php echo $proyecto->hipo_proy;?>
								</p>

								<h3>
									<a name="resultados_esperados"></a>
									Resultados esperados
								</h3>
								<p class=" has-text-justified">
									<?php echo nl2br($proyecto->resul_espe_proy);?>
								</p>

								<h3>
								<a name="impactos_esperados"></a>
									Impactos esperados
								</h3>
								<p class=" has-text-justified">
									<?php echo nl2br($proyecto->impacto_proy);?>
								</p>
							</div>
						</div>
					</article>

				</div>
			</div>



			<div class="tile is-3 is-vertical is-parent">

				<div class="tile is-child box" style="box-shadow: none !important;">
					<aside class="menu">

						<p class="menu-label">
							Estado
						</p>
						<ul class="menu-list">
							<li>
								<div class="notification is-danger">
									<?php echo $proyecto->estado_proyecto;?>
								</div>
							</li>

						</ul>

						<p class="menu-label">
							Subvencionado
						</p>

						<ul class="menu-list">
							<li>
								<?php echo $proyecto->principal;?><br>(<?php echo $proyecto->tiposubven;?>)
							</li>
						</ul>


						<p class="menu-label">
							Coordinador general
						</p>

						<ul class="menu-list">
							<li>
							 <?php echo $proyecto->coordinador_nombres;?>
							</li>
						</ul>

						<p class="menu-label">
							Integrantes
						</p>

						<ul class="menu-list">
						<?php 
						//$integrantes = explode(';',$proyecto->integrantes);
						
						foreach($integrantes as $integrante):
						?>
							<li>
								<a>
									<?php echo ucwords(strtolower($integrante->full_name_per));?> <br>
									<i><?php echo ucfirst(strtolower($integrante->cargo_equipo));?></i>
								</a>
							</li>
							
						<?php endforeach; ?>
							
						</ul>
					</aside>
				</div>
			</div>


		</div>

		<?php $this->load->view('footer');?>

	</body>

</html>