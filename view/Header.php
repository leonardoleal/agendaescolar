<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
<title>...::: Agenda Escolar :::...</title>
<meta name="description" content="Administry - Admin Template by Zoran Juric" />
<meta name="keywords" content="Admin,Template" />
<!-- We need to emulate IE7 only when we are to use excanvas -->
<!--[if IE]>
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<![endif]-->

<base href="http://localhost/SENAC/agendaescolar/">

<!-- Favicons --> 
<link rel="shortcut icon" type="image/png" href="static/img/favicons/favicon.png"/>
<link rel="icon" type="image/png" href="static/img/favicons/favicon.png"/>
<link rel="apple-touch-icon" href="static/img/favicons/apple.png" />

<!-- Main Stylesheet -->
<link rel="stylesheet" href="static/css/style.css" type="text/css" />
<!-- Your Custom Stylesheet --> 
<link rel="stylesheet" href="static/css/custom.css" type="text/css" />

<!--swfobject - needed only if you require <video> tag support for older browsers -->
<script type="text/javascript" src="static/js/swfobject.js"></script>
<!-- jQuery with plugins -->
<script type="text/javascript" src="static/js/jquery-1.4.2.min.js"></script>
<!-- Could be loaded remotely from Google CDN : <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script> -->
<script type="text/javascript" src="static/js/jquery.ui.core.min.js"></script>
<script type="text/javascript" src="static/js/jquery.ui.widget.min.js"></script>
<script type="text/javascript" src="static/js/jquery.ui.tabs.min.js"></script>
<!-- jQuery tooltips -->
<script type="text/javascript" src="static/js/jquery.tipTip.min.js"></script>
<!-- Superfish navigation -->
<script type="text/javascript" src="static/js/jquery.superfish.min.js"></script>
<script type="text/javascript" src="static/js/jquery.supersubs.min.js"></script>
<!-- jQuery form validation -->
<script type="text/javascript" src="static/js/jquery.validate_pack.js"></script>
<!-- jQuery popup box -->
<script type="text/javascript" src="static/js/jquery.nyroModal.pack.js"></script>
<!-- Internet Explorer Fixes --> 
<!--[if IE]>
<link rel="stylesheet" type="text/css" media="all" href="static/css/ie.css"/>
<script src="static/js/html5.js"></script>
<![endif]-->
<!--Upgrade MSIE5.5-7 to be compatible with MSIE8: http://ie7-js.googlecode.com/svn/version/2.1(beta3)/IE8.js -->
<!--[if lt IE 8]>
<script src="static/js/IE8.js"></script>
<![endif]-->
</head>
<body>
	<!-- Header -->
	<header id="top">
		<div class="wrapper">
			<!-- Title/Logo - can use text instead of image -->
			<div id="title"><img src="static/img/logo.png" alt="Administry" /></div>
			<?php if(!HTML::isSelectedPage('login') && HTML::isSelectedPage('')) { ?>
			<!-- Top navigation -->
			<div id="topnav">
				<a href="default#"><img class="avatar" src="static/img/user_32.png" alt="" /></a>
				Logado como <b><?php echo(Sessao::getNome()); ?></b>
				<span>|</span> <a href="default#">Configurações</a>
				<span>|</span> <a href="login/encerrar">Sair</a><br />
			</div>
			<!-- End of Top navigation -->

			<!-- Main navigation -->
			<nav id="menu">
				<ul class="sf-menu">
					<li class="<?php echo( (HTML::isSelectedPage('default') ? 'current' : '') ); ?>"><a href="default">Inicio</a></li>
					<li class="<?php echo( (HTML::isSelectedPage('mensagem') ? 'current' : '') ); ?>">
						<a href="mensagem/listar">Mensagens</a>
						<ul>
							<li>
								<a href="mensagem/listar">Listar Mensagens</a>
							</li>
							<li>
								<a href="mensagem/nova">Nova Mensagem</a>
							</li>
						</ul>
					</li>
				</ul>
			</nav>
			<!-- End of Main navigation -->
			<?php } ?>
		</div>
	</header>