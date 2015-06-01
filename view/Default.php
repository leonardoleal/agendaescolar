	<script type="text/javascript">
	$(document).ready(function(){
		/* setup navigation, content boxes, etc... */
		Administry.setup();
	});
	</script>

	<!-- Page title -->
	<div id="pagetitle">
		<div class="wrapper">
			<h1>Visão Geral</h1>
			<!-- Quick search box -->
			<form action="" method="get"><input class="" type="text" id="q" name="q" /></form>
		</div>
	</div>
	<!-- End of Page title -->
	
	<!-- Page content -->
	<div id="page">
		<!-- Wrapper -->
		<div class="wrapper">
				<!-- Left column/section -->
				<section class="column width8 first">
					<div class="colgroup leading">
						<div class="column width4 first">
							<h3>Próximos eventos</h3>

							<?php if(! isset($data['proximosEventos'])) { ?>
									<div class="width4 column">
										<b><?php echo('Não há eventos futuros.'); ?></b>
									</div>

							<?php } else { ?>
								<?php foreach ($data['proximosEventos'] as $eventos) { ?>
										<div class="leading width4 column">
											<b class="big"><?php echo($eventos->getAssunto()); ?></b><br>
											<small>
												<abbr title="<?php echo(Data::getDataExtenso($eventos->getDataEvento())); ?>"><?php echo(Data::getDataExtenso($eventos->getDataEvento())); ?></abbr><br>
												<a href="#">visualizar</a> · <a href="#">cancelar</a>
											</small>
										</div>
								<?php } ?>
							<?php } ?>

						</div>
						<div class="column width4">
							<h5>Último logon</h5>
							<p>
								<?php echo(Data::getDataHoraExtenso(Sessao::getUltimaSessao())); ?>
							</p>
							<h5>Logon Atual</h5>
							<p>
								<?php echo(Data::getDataHoraExtenso(Sessao::getInicioSessao()) .', origem '. $_SERVER['REMOTE_ADDR']); ?>
							</p>
						</div>
					</div>

					<div class="colgroup leading">
						<div class="column width4 first">
							<hr/>
							<table class="no-style full">
								<tbody>
									<tr>
										<td>Calendário aqui</td>
										<td class="ta-right">&nbsp;</td>
										<td class="ta-right">&nbsp;</td>
									</tr>
								</tbody>
							</table>
						</div>

						<div class="column width4">
							<hr/>
							<h4>Nome do evento selecionado</h4>
							<p><b>Descrição</b></p>

							<hr/>
							<h4>Nome do evento selecionado</h4>
							<p><b>Descrição</b></p>

							<hr/>
							<h4>Nome do evento selecionado</h4>
							<p><b>Descrição</b></p>
						</div>
					</div>

					<div class="clear">&nbsp;</div>
				</section>
				<!-- End of Left column/section -->
		</div>
		<!-- End of Wrapper -->
	</div>
	<!-- End of Page content -->