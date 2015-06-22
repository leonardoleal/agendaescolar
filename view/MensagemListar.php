	<script type="text/javascript">
        var ajaxLoaderImg = '<img src="static/img/nyro/ajaxLoader.gif" align="center">';

		$(document).ready(function(){
			Administry.setup();

            checkBoxesMensagem.init();

            /* datatable */
            $('#mensagens').dataTable({
                "columns": [
                    { "orderable": false },
                    null,
                    null,
                    { "orderable": false }
                ],
                "pagingType": "simple",
                "language": {
                    "info": "Exibindo _START_ a _END_ de _TOTAL_ registros",
                    "infoEmpty": "Exibindo 0 de _TOTAL_ registros",
                    "infoFiltered": "(filtered from _MAX_ total entries)",
                    "emptyTable": "Não há registros para exibir",
                    "search": "Procurar:",
                    "lengthMenu": 'Exibindo <select>'+
                        '<option value="10" selected="selected">10</option>'+
                        '<option value="20">20</option>'+
                        '<option value="40">40</option>'+
                        '<option value="50">50</option>'+
                        '</select> mensagems',
                    "loadingRecords": "Carregando...",
                    "processing":     "Processando...",
                    "zeroRecords":    "Nenhum registro encontrado"
                }
            });
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

        checkBoxesMensagem = {
            $chkBoxes: null,

            init: function() {
                $chkBoxes = $('#marcarTodos');
                this.bind();
            },

            bind: function() {
                $chkBoxes.on('click', this.checkAll);
            },

            checkAll: function() {
                if($chkBoxes.is(':checked')) {
                    $('table input:checkbox').prop('checked', 'checked');;
                } else {
                    $('table input:checkbox').removeAttr('checked');
                }
            }
        }
	</script>

	<!-- Page title -->
	<div id="pagetitle">
		<div class="wrapper">
			<h1>Mensagens</h1>
			<!-- Quick search box -->
<!--			<form action="" method="get"><input class="" type="text" id="q" name="q" /></form>-->
		</div>
	</div>
	<!-- End of Page title -->

	<!-- Page content -->
	<div id="page">
		<!-- Wrapper -->
		<div class="wrapper">
				<!-- Left column/section -->
				<section class="column width8 first">
                    <?php if (Sessao::hasMensagem()) {?>
                        <div class="box box-warning"><?php echo(Sessao::getMensagem()); ?></div>
                    <?php } ?>
					<div class="clear">&nbsp;</div>


                    <a href="mensagem/nova">
                        <span class="label label-blue float-right">Nova Mensagem</span>
                    </a>
                    <form action="mensagem/excluir" method="post" style="width: 100%">
                        <input type="submit" class="icon icon-trash">

                        <table class="display stylized" id="mensagens">
                            <thead>
                                <tr>
                                    <th class="sorting_disabled"><input type="checkbox" id="marcarTodos" name="marcarTodos"></th>
                                    <th>Para</th>
                                    <th>Assunto</th>
                                    <th>Data</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($data['mensagens'] as $mensagem) { ?>
                                <tr class="gradeX linhaMensagem">
                                    <td><input type="checkbox" name="idMensagem[]" value="<?php echo($mensagem->idMensagem); ?>"></td>
                                    <td>
                                        <?php
                                            foreach($mensagem->destinatarios as $destinatario) {
                                                echo($destinatario .', ');
                                            }
                                        ?>
                                    </td>
                                    <td>
                                        <a href="mensagem/detalhes/<?php echo($mensagem->idMensagem); ?>"  title="Abrir Mensagem">
                                            <b><?php echo($mensagem->assunto); ?></b>
                                            <?php echo(!$mensagem->totalRespostas ? '' : '('. ($mensagem->totalRespostas + 1) .')'); ?>
                                        </a>
                                    </td>
                                    <td><?php echo(Data::getDataExtenso($mensagem->dataEnvio)); ?></td>
                                </tr>
                                <?php } ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td>&nbsp;</th>
                                    <td>&nbsp;</th>
                                    <td>&nbsp;</th>
                                    <td>&nbsp;</th>
                                </tr>
                            </tfoot>
                        </table>

                        <input type="submit" class="icon icon-trash">
                    </form>
                    <a href="mensagem/nova">
                        <span class="label label-blue float-right">Nova Mensagem</span>
                    </a>

					<div class="clear">&nbsp;</div>
					<div class="clear">&nbsp;</div>
				</section>
				<!-- End of Left column/section -->
		</div>
		<!-- End of Wrapper -->
	</div>
	<!-- End of Page content -->