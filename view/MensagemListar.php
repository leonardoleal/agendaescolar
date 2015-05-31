	<script type="text/javascript">
		$(document).ready(function(){
			/* setup navigation, content boxes, etc... */
			Administry.setup();
		});
	</script>

	<!-- Page title -->
	<div id="pagetitle">
		<div class="wrapper">
			<h1>Mensagens</h1>
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
					<div class="clear">&nbsp;</div>

					<a href="#">
						<span class="label label-blue float-right">Nova Mensagem</span>
					</a>
					<a href="#"><span class="icon icon-trash">&nbsp;</span></a>
					<div class="dataTables_paginate paging_two_button" id="example_paginate">
						<div class="paginate_disabled_previous" title="Previous" id="example_previous"></div>
						<div class="paginate_enabled_next" title="Next" id="example_next"></div>
					</div>
					<div class="float-right">Exibindo 1 a 4 de  <?php echo($data['totalRegistros']); ?>  registros</div>
					<table class="display stylized" id="mensagens">
						<thead>
							<tr>
								<th>De</th>
								<th>Assunto</th>
								<th>Turma</th>
								<th>Data</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($data['mensagens'] as $mensagem) { ?>
							<tr class="gradeX">
								<td><?php echo($mensagem->getIdAutor()); ?></td>
								<td><?php echo($mensagem->getAssunto()); ?></td>
								<td><?php echo('Turma'); ?></td>
								<td><?php echo(Data::getDataExtenso($mensagem->getDataEnvio())); ?></td>
							</tr>
							<?php } ?>
						</tbody>
						<tfoot>
							<tr>
								<th colspan="5">&nbsp;</th>
							</tr>
						</tfoot>
					</table>

					<a href="#"><span class="icon icon-trash">&nbsp;</span></a>
					<a href="#">
						<span class="label label-blue float-right">Nova Mensagem</span>
					</a>
					<div class="dataTables_paginate paging_two_button" id="example_paginate">
						<div class="paginate_disabled_previous" title="Previous" id="example_previous"></div>
						<div class="paginate_enabled_next" title="Next" id="example_next"></div>
					</div>
					<div class="float-right">Exibindo 1 a 4 de <?php echo($data['totalRegistros']); ?> registros</div>

					<div class="clear">&nbsp;</div>
					<div class="clear">&nbsp;</div>
				</section>
				<!-- End of Left column/section -->
		</div>
		<!-- End of Wrapper -->
	</div>
	<!-- End of Page content -->