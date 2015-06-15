	<script type="text/javascript">
	$(document).ready(function(){
		/* setup navigation, content boxes, etc... */
		Administry.setup();
	});
	</script>
    <script src="static/js/simplecalendar.js" type="text/javascript"></script>
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
                            <div class="calendar hidden-print">
                                <header>
                                    <h2 class="month"></h2>
                                    <a class="btn-prev fontawesome-angle-left" href="#"></a>
                                    <a class="btn-next fontawesome-angle-right" href="#"></a>
                                </header>
                                <table>
                                    <thead class="event-days">
                                    <tr></tr>
                                    </thead>
                                    <tbody class="event-calendar">
                                    <tr class="1"></tr>
                                    <tr class="2"></tr>
                                    <tr class="3"></tr>
                                    <tr class="4"></tr>
                                    <tr class="5"></tr>
                                    </tbody>
                                </table>
                            </div>
						</div>

						<div class="column width4">
                            <hr/>
                            <div class="day-event" date-month="6" date-day="15" data-number="1">
                                <h2 class="title">Lorem ipsum 1</h2>
                                <p class="date">2014-12-4</p>
                                <p>Lorem Ipsum är en utfyllnadstext från tryck- och förlagsindustrin. Lorem ipsum har varit standard ända sedan 1500-talet, när en okänd boksättare tog att antal bokstäver och blandade dem för att göra ett provexemplar av en bok.</p>
                            </div>
                            <div class="day-event" date-month="6" date-day="13" data-number="1">
                                <h2 class="title">Lorem ipsum 2</h2>
                                <p class="date">2014-12-13</p>
                                <p>Lorem Ipsum är en utfyllnadstext från tryck- och förlagsindustrin. Lorem ipsum har varit standard ända sedan 1500-talet, när en okänd boksättare tog att antal bokstäver och blandade dem för att göra ett provexemplar av en bok.</p>
                            </div>
                            <div class="day-event" date-month="6" date-day="13" data-number="2">
                                <h2 class="title">Lorem ipsum 2</h2>
                                <p class="date">2014-12-13</p>
                                <p>Lorem Ipsum är en utfyllnadstext från tryck- och förlagsindustrin. Lorem ipsum har varit standard ända sedan 1500-talet, när en okänd boksättare tog att antal bokstäver och blandade dem för att göra ett provexemplar av en bok.</p>
                            </div>
                            <div class="day-event" date-month="6" date-day="13" data-number="2">
                                <h2 class="title">Lorem ipsum 2</h2>
                                <p class="date">2014-12-13</p>
                                <p>Lorem Ipsum är en utfyllnadstext från tryck- och förlagsindustrin. Lorem ipsum har varit standard ända sedan 1500-talet, när en okänd boksättare tog att antal bokstäver och blandade dem för att göra ett provexemplar av en bok.</p>
                            </div>
                            <div class="day-event" date-month="6" date-day="13" data-number="2">
                                <h2 class="title">Lorem ipsum 2</h2>
                                <p class="date">2014-12-13</p>
                                <p>Lorem Ipsum är en utfyllnadstext från tryck- och förlagsindustrin. Lorem ipsum har varit standard ända sedan 1500-talet, när en okänd boksättare tog att antal bokstäver och blandade dem för att göra ett provexemplar av en bok.</p>
                            </div>
                            <div class="day-event" date-month="6" date-day="14" data-number="1">
                                <h2 class="title">Lorem ipsum 3</h2>
                                <p class="date">2014-12-14</p>
                                <p>Lorem Ipsum är en utfyllnadstext från tryck- och förlagsindustrin. Lorem ipsum har varit standard ända sedan 1500-talet, när en okänd boksättare tog att antal bokstäver och blandade dem för att göra ett provexemplar av en bok.</p>
                            </div>
                            <div class="day-event" date-month="7" date-day="16" data-number="1">
                                <h2 class="title">Lorem ipsum 4</h2>
                                <p class="date">2014-12-16</p>
                                <p>Lorem Ipsum är en utfyllnadstext från tryck- och förlagsindustrin. Lorem ipsum har varit standard ända sedan 1500-talet, när en okänd boksättare tog att antal bokstäver och blandade dem för att göra ett provexemplar av en bok.</p>
                            </div>
                            <div class="day-event" date-month="7" date-day="24" data-number="1">
                                <h2 class="title">Lorem ipsum 5</h2>
                                <p class="date">2014-12-24</p>
                                <p>Lorem Ipsum är en utfyllnadstext från tryck- och förlagsindustrin. Lorem ipsum har varit standard ända sedan 1500-talet, när en okänd boksättare tog att antal bokstäver och blandade dem för att göra ett provexemplar av en bok.</p>
                            </div>
                            <div class="day-event" date-month="5" date-day="31" data-number="1">
                                <h2 class="title">Lorem ipsum 6</h2>
                                <p class="date">2014-12-31</p>
                                <p>Lorem Ipsum är en utfyllnadstext från tryck- och förlagsindustrin. Lorem ipsum har varit standard ända sedan 1500-talet, när en okänd boksättare tog att antal bokstäver och blandade dem för att göra ett provexemplar av en bok.</p>
                            </div>
                            <div class="day-event" date-month="5" date-day="22" data-number="1">
                                <h2 class="title">Lorem ipsum 6</h2>
                                <p class="date">2014-12-31</p>
                                <p>Lorem Ipsum är en utfyllnadstext från tryck- och förlagsindustrin. Lorem ipsum har varit standard ända sedan 1500-talet, när en okänd boksättare tog att antal bokstäver och blandade dem för att göra ett provexemplar av en bok.</p>
                            </div>
						</div>
					</div>

					<div class="clear">&nbsp;</div>
				</section>
				<!-- End of Left column/section -->
		</div>
		<!-- End of Wrapper -->
	</div>
	<!-- End of Page content -->