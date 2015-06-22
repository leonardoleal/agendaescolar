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
            <h3>Nova Mensagem</h3>

            <?php if (Sessao::hasMensagem()) {?>
                <div class="box box-warning"><?php echo(Sessao::getMensagem()); ?></div>
            <?php } ?>

            <div class="column width8">
                <form id="formNovaMensagem" method="post" action="mensagem/enviar">
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
                        </p>
                        <p>
                            <label for="dataEvento">Data do Evento:</label>
                            <input type="datetime-local" id="dataEvento" name="dataEvento">
                            <small>* caso for um evento preencha este campo</small>
                        </p>
                        <p>
                            <label for="assunto">Assunto:</label>
                            <input type="text" id="assunto" name="assunto" value="" required="required">
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