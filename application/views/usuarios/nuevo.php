		<section id="">
			<p class="titulo">Nuevo Usuario</p>
			<form id="form1" name="form1" method="post" action="<?php echo base_url(); ?>usuariosc/validate" enctype="multipart/form-data">
			<ul id="newdato">
				<li>
					<input type="text" id="usernam" name="usernam" value="" placeholder="UserName" maxlength="50" />
				</li>
				<li>
					<input type="text" id="usuario" name="usuario" value="" placeholder="Nombre" maxlength="100" />
				</li>
				<li>
					<input type="text" id="apellidos" name="apellidos" value="" placeholder="Apellidos" maxlength="100" />
				</li>
				<li>
					<input type="password" id="password" name="password" value="" placeholder="Escribe tu Password" maxlength="50" />
				</li>
				<li>
					<input type="password" id="password2" name="password2" value="" placeholder="Repite tu Password" maxlength="50" />
				</li>
				<li><div class="submitea"></div></li>
			</ul>
			</form>
		</section>
