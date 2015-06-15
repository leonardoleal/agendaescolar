<script type="text/javascript">
    $(document).ready(function(){
        Administry.setup();
        $('.content-box-closed').last().removeClass('content-box-closed');
        formResposta.init();
    });

    var formResposta = {
        form: null,

        init: function() {
            this.form = $('#formResposta');
            this.form.parent().css('display', 'none');

            var pathname = window.location.href;
            var pathnames = pathname.split('#');

            if(pathnames[1] == 'responder') {
                this.showForm();
            }
            $('span').parent('a[href*=#responder]').click(this.showForm);
        },

        showForm: function() {
            $('#formResposta').parent().toggle('slow');
        }
    };
</script>

<!-- Page title -->
<div id="pagetitle">
    <div class="wrapper">
        <h1>Mensagens</h1>
    </div>
</div>
<!-- End of Page title -->

<!-- Page content -->
<div id="page">
    <!-- Wrapper -->
    <div class="wrapper">
        <!-- Left column/section -->
        <section class="column width8 first">
            <h3><?php echo($data['mensagens'][0]->assunto); ?></h3>

            <?php if (Sessao::hasMensagem()) {?>
                <div class="box box-warning"><?php echo(Sessao::getMensagem()); ?></div>
            <?php } ?>

            <a href="#responder">
                <span class="label label-blue float-right">Responder</span>
            </a>
            <a href="mensagem/listar">
                <span class="label-left label-blue float-right voltar">Voltar</span>
            </a>

            <?php foreach ($data['mensagens'] as $mensagem) { ?>
            <div class="column width8">
                <div class="content-box corners content-box-closed">
                    <header>
                        <h3><?php echo($mensagem->idAutor); ?></h3>
                        <span><?php echo(Data::getDataExtenso($mensagem->dataEnvio)); ?></span>
                    </header>
                    <section>
                        <p><?php echo($mensagem->mensagem); ?></p>
                    </section>
                </div>
            </div>
            <?php } ?>

            <a href="#responder">
                <span class="label label-blue float-right">Responder</span>
            </a>
            <a href="mensagem/listar">
                <span class="label-left label-blue float-right voltar">Voltar</span>
            </a>

            <div class="column width8" style="display: none">
                <form id="formResposta" method="post" action="mensagem/enviar">
                    <fieldset>
                        <p>
                            <label for="idDestinatario">Para:</label>
                            <select id="idDestinatario" name="idDestinatario">
                                <?php foreach ($data['responsaveis'] as $responsavel) { ?>
                                   <option value="<?php echo($responsavel->idResponsavel); ?>">
                                       <?php echo($responsavel->nome); ?>
                                   </option>
                                <?php } ?>
                            </select>

                            <input type="hidden" id="idPrecedente" name="idPrecedente" value="<?php echo($data['mensagens'][0]->idMensagem); ?>">
                            <input type="hidden" id="assunto" name="assunto" value="<?php echo($data['mensagens'][0]->assunto); ?>">
                        </p>
                        <p>
                            <label for="mensagem">Mensagem:</label><br/>
                            <textarea id="mensagem" class="required full" name="mensagem" required="required"></textarea>

                        </p>
                        <input type="submit" class="btn btn-green big float-right" value="Enviar"/>
                        <input type="reset" class="btn big float-right" value="Cancelar"/>
                    </fieldset>
                </form>
            </div>

        </section>
        <!-- End of Left column/section -->
    </div>
</div>