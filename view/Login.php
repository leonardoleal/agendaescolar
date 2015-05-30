	<script type="text/javascript">
		$(document).ready(function(){
			/* setup navigation, content boxes, etc... */
			Administry.setup();
			
			// validate signup form on keyup and submit
			var validator = $("#loginform").validate({
				rules: {
					usuario: "required",
					senha: "required"
				},
				messages: {
					usuario: "Digite o nome de usuário",
					senha: "Digite sua senha"
				},
				// the errorPlacement has to take the layout into account
				errorPlacement: function(error, element) {
					error.insertAfter(element.parent().find('label:first'));
				},
				// set new class to error-labels to indicate valid fields
				success: function(label) {
					// set &nbsp; as text for IE
					label.html("&nbsp;").addClass("ok");
				}
			});
		
		});
	</script>

	<div id="page">
		<!-- Wrapper -->
		<div class="wrapper-login">
				<!-- Login form -->
				<section class="full">					
					<h3>Login</h3>

					<?php if (Sessao::hasMensagem()) {?>
					<div class="box box-error"><?php echo(Sessao::getMensagem()); ?></div>
					<?php } ?>

					<form id="loginform" method="post" action="login/validar">

						<p>
							<label class="required" for="usuario">Usuário:</label><br/>
							<input type="text" id="usuario" class="full" value="" name="usuario"/>
						</p>
						
						<p>
							<label class="required" for="senha">Senha:</label><br/>
							<input type="password" id="senha" class="full" value="" name="senha"/>
						</p>
						
						<p>
							<input type="submit" class="btn btn-green big" value="Logar"/> &nbsp; <a href="javascript: //;" onclick="$('#emailform').slideDown(); return false;">Esqueceu a senha?</a> or <a href="#">Need help?</a>
						</p>
						<div class="clear">&nbsp;</div>

					</form>
					
					<form id="emailform" style="display:none" method="post" action="#">
						<div class="box">
							<p id="emailinput">
								<label for="email">Email:</label><br/>
								<input type="text" id="email" class="full" value="" name="email"/>
							</p>
							<p>
								<input type="submit" class="btn" value="Send"/>
							</p>
						</div>
					</form>
					
				</section>
				<!-- End of login form -->
				
		</div>
		<!-- End of Wrapper -->
	</div>
	<!-- End of Page content -->