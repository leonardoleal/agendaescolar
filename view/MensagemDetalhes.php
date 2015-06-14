<!--suppress ALL -->

<script type="text/javascript">
    $(document).ready(function(){
        Administry.setup();
        $('.content-box-closed').last().removeClass('content-box-closed');
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
            <h3><?php echo($data['mensagens'][0]->assunto); ?></h3>

            <?php if (Sessao::hasMensagem()) {?>
                <div class="box box-warning"><?php echo(Sessao::getMensagem()); ?></div>
            <?php } ?>

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

            <form id="sampleform" method="post" action="#">
                <fieldset>
                    <legend>

                    </legend><p>
                        <label class="required" for="titulo">TÍTULO:</label>
                        <br/>
                        <input type="text" id="titulo" class="half" value="" name="titulo"/>
                    </p>

                    <p>
                        <label for="wysiwyg">Mensagem:</label><br/>
                        <textarea  id="wysiwyg" class="required full wysiwyg" name="wysiwyg"></textarea>

                    </p>
                    <p>
                        <label for="select1">Tipo de Evento:</label><br/>
                        <select id="select1" class="half" name="select1">
                            <option value="1">Passeio</option>
                            <option value="2">Reunião</option>
                            <option value="3">Evento</option>
                        </select>
                    </p>

                    <p>&nbsp;</p>

                    <p>
                        <label class="required">fORMATO DATA:</label>
                        <br/>
                        <input type="radio" id="dateformat1" class="" value="dmy" name="dateformat"/>
                        <label class="choice" for="dateformat1">dd/mm/yyyy</label>
                        <input type="radio" id="dateformat2" class="" value="mdy" name="dateformat"/>
                        <label class="choice" for="dateformat2">mm/dd/yyyy</label>
                    </p>

                    <p>&nbsp;</p>

                    <p class="box"><input type="submit" class="btn btn-green big" value="Inserir"/> ou <input type="reset" class="btn" value="Limpar"/></p>

                </fieldset>

            </form>
        </section>
        <!-- End of Left column/section -->
    </div>
</div>