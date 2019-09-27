<!DOCTYPE html>
<html>

<head>
	<?php $this->load->view('meta'); ?>

	<link rel="stylesheet" href="<?php echo base_url('media/searchable-option-list-master/sol.css') ?>">
	<script src="<?php echo base_url('media/jquery-2.1.4.min.js') ?>">
	</script>
	<link rel="stylesheet" href="<?php echo base_url('media/css/estilos.css') ?>">

	<script>
		var variableJS = "0S2A1430.jpg";
	</script>
	<script>
		var Var_JavaScript = "0S2A1430.jpg"; // declaración de la variable 
	</script>
</head>



<body>

	<!--<?php $this->load->view('menu'); ?>
		<?php $this->load->view('header'); ?>
-->
	<form method="post" action="<?php echo site_url('Welcome/index/1') ?>">

		<div class="tile is-ancestor">

			<div class="tile is-3 is-vertical is-parent">

				<div class="tile is-child box" style="box-shadow: none !important;">


					<aside class="menu">
						<p class="menu-label">
							Búsqueda
						</p>

						<div class="field has-addons has-addons-centered">
							<div class="control">
								<input class="input" name="titulo" value="<?php echo TSession::getValue('ProyUnsa_titulo'); ?>" type="text" placeholder="Nombre o título de proyecto">
							</div>
							<div class="control">
								<input type="submit" value="Buscar" class="button is-info" />

							</div>
						</div>
						<p class="menu-label">
							Año
						</p>
						<div class="select is-fullwidth">
							<select class="estiloselect" style="max-width: 600px; y height: auto;" name="id_anio">
								<option value="0">
									Todos
								</option>
								<?php $anio = TSession::getValue('ProyUnsa_id_anio'); ?>

								<?php
								for ($i = date('Y'); $i >= 2016; $i--) {
									$selected = ($anio == $i) ? 'selected="selected"' : '';
									?>
									<option value="<?php echo $i; ?>" <?php echo $selected; ?>>
										<?php echo $i; ?>
									</option>
								<?php
								}
								?>
							</select>
						</div>









						<script type="text/javascript">
							$(function() {
								// initialize sol
								$('#my-select').searchableOptionList({
									showSelectionBelowList: true,
									maxHeight: '250px',
									texts: {
										noItemsAvailable: 'No hay coincidencias',
										selectAll: 'Todos',
										selectNone: 'Ninguno',
										searchplaceholder: 'Clic aquí para buscar seleccionar la convocatoria'
									}
								});
							});
						</script>

					</aside>

					<hr />
					<input type="submit" class="button is-link is-outlined is-fullwidth" value="Aplicar filtros" />


				</div>


			</div>


			<div class="tile is-parent">
				<div class="tile is-child box " style="box-shadow: none !important;">


					<!-- Main container -->
					<nav class="level">
						<!-- Left side -->
						<div class="level-left">
							<div class="level-item">
								<p class="subtitle is-5">
									<strong>
										<?php echo $param['rows']; ?>
									</strong> resultados
								</p>
							</div>
						</div>

						<!-- Right side -->
						<div class="level-right">
							<div class="select">
								<!--<select onchange="location = this.options[this.selectedIndex].value;">-->
								<select name="order" onchange="this.form.submit()">

									<?php echo  TSession::getValue('ProyUnsa_order'); ?>
									<?php $select = ("description/asc" == TSession::getValue('ProyUnsa_order')) ? 'selected="selected"' : ""; ?>
									<option value="description/asc" <?php echo $select ?>>
										Ordenado por el orden de publicacion (A-Z)
									</option>

									<?php $select = ("description/desc" == TSession::getValue('ProyUnsa_order')) ? 'selected="selected"' : ""; ?>
									<option value="description/desc" <?php echo $select ?>>
										Ordenado por el orden de publicacion (Z-A)
									</option>

									<?php $select = ("title/asc" == TSession::getValue('ProyUnsa_order')) ? 'selected="selected"' : ""; ?>
									<option value="title/asc" <?php echo $select ?>>
										Ordenado por titulo de publicación (A-Z)
									</option>

									<?php $select = ("title/desc" == TSession::getValue('ProyUnsa_order')) ? 'selected="selected"' : ""; ?>
									<option value="title/desc" <?php echo $select ?>>
										Ordenado por titulo de publicación (Z-A)
									</option>
								</select>
							</div>
						</div>
					</nav>

					<hr />


					<script>
						function get_resumen(id) {
							var resultado = "#response_" + id;
							var parametros = {
								"id": id
							};
							var site = "<?php echo site_url('Welcome/cargar_imagenes/'); ?>" + id;
							$.ajax({
								data: parametros, //datos que se envian a traves de ajax
								url: site, //archivo que recibe la peticion
								type: 'post', //método de envio
								dataType: 'json',
								beforeSend: function() {
									$(resultado).html('<progress class="progress is-danger" max="100"></progress>');
								},
								success: function(response) {
									//una vez que el archivo recibe el request lo procesa y lo devuelve
									//$(resultado).html("Procesando, espere por favor...");
								},
								statusCode: {
									500: function(response) {
										$(resultado).html("Error 500");
									},
									200: function(response) {
										//location.reload();
										$(resultado).html("Procesando, espere por favor...");
										$.each(response.data, function(index, elemento) {
											$(resultado).html('<p class=" notification has-text-justified">' + elemento.resumen + ' </p>');
										});
									}
								}
							});
						}
					</script>
					<script>
						function get_imagenes(id) {
							var resultado = "#response_" + id;
							var parametros = {
								"id": id
							};
							var site = "<?php echo site_url('Welcome/cargar_imagenes/'); ?>" + id;
							$(imgpub).html("id");
						}
					</script>

					<?php
					if (isset($proyectos)) {
						foreach ($proyectos as $proyecto) : ?>
							<article class="media">
								<div class="media-content">
									<div class="content">
										<div class="is-size-7">
											<?php echo $proyecto->nomb_esq_finan ?>
										</div>

										<strong>
											<a class="resumen_proyecto" href="<?php echo site_url('view/' . $proyecto->id); ?>">
												<?php echo $proyecto->title ?>
											</a>
										</strong>

										<div class="is-size-7 has-text-weight-light">
											Descripcion: <?php echo $proyecto->description ?>. Convocatoria: <?php echo $proyecto->nomb_conv ?>
										</div>
										<div class="is-capitalized">
											<small class="is-italic">
												<?php echo ucwords(strtolower($proyecto->integrantes)) ?>
											</small>
										</div>

										<span class="tag is-white">

											<a onclick="final(<?php echo $proyecto->id; ?>);">
												Ver fotos
											</a>
										</span>

										<!-- <span class="tag is-white">

											<a href="#popup2">Ver videos</a>
										</span> -->
										<span class="tag is-white">
											<a onclick="alternativo(<?php echo $proyecto->id; ?>);">
												Ver videos
											</a>
										</span>


										<span class="tag is-white">
											<a onclick="get_resumen(<?php echo $proyecto->id; ?>);">
												Ver resumen
											</a>
										</span>
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

										<div id="response_<?php echo $proyecto->id ?>" class="">

										</div>

									</div>
								</div>
							</article>
					<?php
						endforeach;
					}
					?>


					<hr />


					<nav class="pagination" role="navigation" aria-label="pagination">

						<?php
						$total_pages = ceil($param['rows'] / $param['limit']);
						$previous    = ($param['page'] - 1);
						$disabled    = ($param['page'] * 1 == 1) ? 'disabled' : 'href="' . site_url('Welcome/index/') . $previous . '"';
						?>
						<a <?php echo $disabled ?> class="pagination-previous">
							Anterior
						</a>

						<?php
						$next_page = $param['page'] + 1;
						$disabled  = ($next_page > $total_pages) ? 'disabled' : 'href="' . site_url('Welcome/index/') . $next_page . '"'; ?>
						<a <?php echo $disabled ?> class="pagination-next">
							Siguiente
						</a>


						<ul class="pagination-list">
							<li>
								Mostrar
							</li>
							<li>
								<?php $is_current = ($param['limit'] == "25") ? 'is-current' : ''; ?>
								<input type="submit" class="button <?php echo $is_current; ?> pagination-link" value="25" name="limit" />
							</li>
							<li>
								<?php $is_current = ($param['limit'] == "50") ? 'is-current' : ''; ?>
								<input type="submit" class="button <?php echo $is_current; ?> pagination-link" value="50" name="limit" />
							</li>
							<li>
								<?php $is_current = ($param['limit'] == "100") ? 'is-current' : ''; ?>
								<input type="submit" class="button <?php echo $is_current; ?> pagination-link" value="100" name="limit" />
							</li>
							<li>
								por página
							</li>
						</ul>
					</nav>

				</div>
			</div>
		</div>
	</form>

	<!-- POP UP IMAGENES -->
	<div class="overlay" id="overlay">
		<div class="popup" id="popup">
			<a onclick="cerrar()" class="btn-cerrar-popup"><i class="fas fa-times"></i></a>
			<div id="imgpub">


			</div>

			<button class="w3-button w3-black w3-display-left" onclick="plusSlides(-1)">&#10094;</button>
			<button class="w3-button w3-black w3-display-right" onclick="plusSlides(1)">&#10095;</button>
		</div>
	</div>

	<!-- POP UP VIDEOS -->
	<div id="popup2" class="overlay2">

		<div id="popupBody">
			<a id="cerrar" href="#">&times;</a>


			<div class="popupContent">
				<h1></h1>
				<?php TTransaction::open('database');
				$video_media = new ViewMedia(1);
				TTransaction::close();
				?>

				<video width="640" height="480" controls>
					<source src="<?php echo $video_media->path ?>" type="video/mp4">
				</video>
			</div>
		</div>
	</div>


	<script>
		var btnAbrirPopup = document.getElementById('btn-abrir-popup'),
			overlay = document.getElementById('overlay'),
			popup = document.getElementById('popup'),
			btnCerrarPopup = document.getElementById('btn-cerrar-popup');
		btnAbrirPopup.addEventListener('click', function() {
			// overlay.classList.add('active');
			// popup.classList.add('active');
			//get_imagenes(17);
		});
		btnCerrarPopup.addEventListener('click', function(e) {
			e.preventDefault();
			overlay.classList.remove('active');
			popup.classList.remove('active');
		});

		function cerrar() {
			overlay.classList.remove('active');
			popup.classList.remove('active');
			$(imgpub).html('');
		}

		function final(id) {
			
			var resultado = "#response_" + id;
			var parametros = {
				"id": id
			};
			var site = "<?php echo site_url('Welcome/cargar_imagenes/'); ?>" + id;
			var resp = "";
			$.ajax({
				data: parametros, 
				url: site, 
				type: 'post', 
				dataType: 'json',
				beforeSend: function() {
					$(resultado).html('<progress class="progress is-danger" max="100"></progress>');
				},
				success: function(response) {
					//una vez que el archivo recibe el request lo procesa y lo devuelve
					//$(resultado).html("Procesando, espere por favor...");
				},
				statusCode: {
					500: function(response) {
						$(resultado).html("Error 500");
					},
					200: function(response) {
						//location.reload();
						$(resultado).html("Procesando, espere por favor...");
						$.each(response.data, function(index, elemento) {
							resp = resp + '<div class="mySlides fade"><img  src="http://localhost/proyectos_vri/uploads/' + response.data[index].resumen + '"> </div>';
						});
						$(imgpub).html(resp);
						overlay.classList.add('active');
						popup.classList.add('active');
						plusSlides(1);
					}
				}
			});
		}


		function alternativo(id) {
			//$(imgpub).html('adlflkfdfjd');
			var resultado = "#response_" + id;
			var parametros = {
				"id": id
			};
			var site = "<?php echo site_url('Welcome/cargar_videos/'); ?>" + id;
			var resp = "";
			$.ajax({
				data: parametros, //datos que se envian a traves de ajax
				url: site, //archivo que recibe la peticion
				type: 'post', //método de envio
				dataType: 'json',
				
				success: function(response) {
					//una vez que el archivo recibe el request lo procesa y lo devuelve
					//$(resultado).html("Procesando, espere por favor...");
				},
				statusCode: {
					500: function(response) {
						$(resultado).html("Error 500");
					},
					200: function(response) {
						//location.reload();
						
						$.each(response.data, function(index, elemento) {
							resp = resp + '<div class="mySlides fade"><video width="640" height="480" autoplay controls controlsList="nodownload"><source  src="http://localhost/proyectos_vri/uploads/' + response.data[index].video + '" type="video/mp4"> </video></div>';

						});
						$(imgpub).html(resp);
						overlay.classList.add('active');
						popup.classList.add('active');
						plusSlides(1);
					}
				}
			});
		}

		function modalClose() {
			if (location.hash == '#popup2') {
				location.hash = '';
			}
			cerrar();
			
		}
	</script>
	<script>
		// Handle ESC key (key code 27)
		var overlay = document.getElementById('overlay'),
			popup = document.getElementById('popup');
		popup2 = document.getElementById('popup2');
		document.addEventListener('keyup', function(e) {
			if (e.keyCode == 27) {
				overlay.classList.remove('active');
				popup.classList.remove('active');
				if (location.hash == '#popup2') {
					location.hash = '';
				}

				$(imgpub).html('');
			}
		});
		
		var modal2 = document.querySelector('#overlay');
		// Handle click on the modal container
		modal2.addEventListener('click', modalClose, false);
		// Prevent event bubbling if click occurred within modal content body
		modal2.children[0].addEventListener('click', function(e) {
			e.stopPropagation();
			
		}, false);
		var modal3 = document.querySelector('#popup2');
		// Handle click on the modal container
		modal3.addEventListener('click', modalClose, false);
		// Prevent event bubbling if click occurred within modal content body
		modal3.children[0].addEventListener('click', function(e) {
			e.stopPropagation();
		}, false);
		var slideIndex = 1;
		showSlides(slideIndex);

		function plusSlides(n) {
			showSlides(slideIndex += n);
		}

		function currentSlide(n) {
			showSlides(slideIndex = n);
		}

		function showSlides(n) {
			var i;
			var slides = document.getElementsByClassName("mySlides");
			var dots = document.getElementsByClassName("dot");
			if (n > slides.length) {
				slideIndex = 1
			}
			if (n < 1) {
				slideIndex = slides.length
			}
			for (i = 0; i < slides.length; i++) {
				slides[i].style.display = "none";
			}
			for (i = 0; i < dots.length; i++) {
				dots[i].className = dots[i].className.replace(" active", "");
			}
			slides[slideIndex - 1].style.display = "block";
			dots[slideIndex - 1].className += " active";
		}
	</script>
	<?php $this->load->view('footer'); ?>



</body>

</html>