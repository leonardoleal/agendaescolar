	<script type="text/javascript">
        var ajaxLoaderImg = '<img src="static/img/nyro/ajaxLoader.gif" align="center">';

		$(document).ready(function(){
			Administry.setup();

//            linhaMensagem.init();
		});

        var linhaMensagem = {
            $linhas: null,

            init: function() {
                $linha = $('.linhaMensagem');
                $linha.css('cursor', 'pointer');
                this.bind();
            },

            bind: function() {
                $linha.click(this.showDetails);
            },

            showDetails: function() {
                $linhaSelecionada = $(this);

                idMensagem = $linhaSelecionada.find('input').val();

                $section = $($linhaSelecionada.parents('section'));
                $section.html(ajaxLoaderImg);

                $.get( 'mensagem/detalhesMensagem/'+ idMensagem, {}, function(data) {
                    console.log("retorno: ");
                    console.log(data);
                    $section.html(data);
                });
            }
        };
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


                    <a href="mensagem/nova">
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
                                <th><input type="checkbox" name="marcarTodos"></th>
								<th>De</th>
								<th>Assunto</th>
								<th>Turma</th>
								<th>Data</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($data['mensagens'] as $mensagem) { ?>
                            <tr class="gradeX linhaMensagem">
<!--                                    <input type="hidden" value="--><?php //echo($mensagem->idMensagem); ?><!--">-->
                                <td><input type="checkbox" name="idMensagem[]" value="<?php echo($mensagem->idMensagem); ?>"></td>
                                <td><?php echo($mensagem->idAutor); ?></td>
                                <td>
                                    <a href="mensagem/detalhes/<?php echo($mensagem->idMensagem); ?>"  title="Abrir Mensagem">
                                        <b><?php echo($mensagem->assunto); ?></b>
                                        <?php echo(!$mensagem->totalRespostas ? '' : '('. ($mensagem->totalRespostas + 1) .')'); ?>
                                    </a>
                                </td>
                                <td><?php echo('Turma'); ?></td>
                                <td><?php echo(Data::getDataExtenso($mensagem->dataEnvio)); ?></td>
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
                    <a href="mensagem/nova">
                        <span class="label label-blue float-right">Nova Mensagem</span>
                    </a>

					<div class="dataTables_paginate paging_two_button" id="example_paginate">
						<div class="paginate_disabled_previous" title="Previous" id="example_previous"></div>
						<div class="paginate_enabled_next" title="Next" id="example_next"></div>
					</div>
					<div class="float-right">
                        Exibindo <?php echo(sizeof($data['mensagens'])); ?>
                        de <?php echo($data['totalRegistros']); ?> registros
                    </div>

					<div class="clear">&nbsp;</div>
					<div class="clear">&nbsp;</div>
				</section>
				<!-- End of Left column/section -->
		</div>
		<!-- End of Wrapper -->
	</div>
	<!-- End of Page content -->