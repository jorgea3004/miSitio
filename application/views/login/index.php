<!doctype html>
<html lang="es">
    <head>
        <meta charset="ISO-8859-1" />
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
        <title>Login</title>
		<link rel="shortcut icon" href="<?php echo base_url();?>imgs/favicon.ico" type="image/x-icon" />
		<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>css/normalize.css">
		<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>css/coments.css">
		<script src="<?php echo base_url();?>js/modernizr.js"></script>
		<script src="<?php echo base_url();?>js/jquery-1.8.3.min.js" type="text/javascript" ></script>
		<script type="text/javascript" >
		<?php if($errsesnf){ ?>
			function valida(){
				var msg = 0; 
				var theForm = document.form1; 
				var str= theForm.password.value; 
				var strTema = "";
				var sname = theForm.usuario.value; 
				if (sname == "") {
					var usr = "Campo Necesario, debes escribir tu usuario.";
					$("<label>"+usr+"</label>").insertAfter("#usuario");
					msg=1;
				 } 
				if (str == "") {
					var usr = "Campo Necesario.";
					$("<label>"+usr+"</label>").insertAfter("#password");
					msg=1;
				 } 
				if (msg==1){
				   return false; 
				 } else {
					$('section article form#form1').submit();
				 } 
			}
				<?php } else { ?>
			function recarga(){
				location.href = "<?php echo base_url();?>login";
			}
				<?php } ?>
		</script>
    </head>
	<body>
		<header><p>Escribe tu usuario</p></header>
		<section>
			<article>
				<?php if($errsesnf){ ?>
				<form id="form1" name="form1" method="post" action="<?php echo base_url(); ?>login/validate" enctype="multipart/form-data">
					<ul>
						<li><input type="text" name="usuario" placeholder="Usuario" id="usuario" /></li>
						<li><input type="password" name="password" placeholder="password" value="" id="password" /></li>
						<li class="submitea" onclick="valida();">SUBMIT</li>
					</ul>
				</form>
				<?php } else { ?>
					<ul>
						<li>Ha excedido el n&uacute;mero de intentos.</li>
						<li>El sistema permanecer&aacute; bloqueado durante 1 hora.</li>
						<li class="submitea" onclick="recarga();">Recargar p&aacute;gina</li>
					</ul>
				<?php } ?>
			</article>
		</section>
	</body>
</html>