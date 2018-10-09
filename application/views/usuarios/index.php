		<section id="biograph">
			<p class="titulo">Usuarios
				<a href="<?php echo base_url(); ?>usuariosc/nuevo" id="videonuevo">
					<img src="<?php echo base_url(); ?>imgs/icono-myspace.png" border="0" width="56" />
				</a>
			</p>
			<table id="listtabla" cellspacing="1" cellpadding="1" border="1" width="100%">
			<thead>
				<th>ID</th>
				<th>USERNAME</th>
				<th>NOMBRE</th>
				<th>STATUS</th>
				<th>OPN</th>
			</thead>
			<?php 
			$longit = 80;
		if($query->num_rows()>0): 
			foreach($query->result() as $row): 
				$nombre = $this->encrypt->decode($row->nombre) . " " . $this->encrypt->decode($row->apellidos);
				echo '<tr>
				<td>' . $row->idusuarios . '</td>
				<td>' . $row->username . '</td>
				<td>' . substr($nombre,0,$longit) . '</td>
				<td>' . statustxt($row->status) . '</td>
				<td>
					<a href="'.base_url().'usuariosc/borra/' . $row->idusuarios . '">
						<img src="' . base_url() . 'imgs/thumb_Icon_x_sm.png" border="0" width="20" />
					</a>
				</td>
			</tr>
			';
			endforeach;
		endif;
			?>
			</table>
			<?php
			if($npages>1){
			?>
			<article class="paginator">
				<ul>
					<?php 
						if($page>1){
							$pg = $page-1;
							echo '<li><a href="'.base_url().'usuariosc/index/'.$pg.'">&laquo;</a></li>';
						}
						for($a=1;$a<=$npages;$a++){
							echo '<li><a href="'.base_url().'usuariosc/index/'.$a.'">'.$a.'</a></li>';
						}
						if($page<$npages){
							$pg = $page+1;
							echo '<li><a href="'.base_url().'usuariosc/index/'.$pg.'">&raquo;</a></li>';
						}
					?>
				</ul>
			</article>
			<?php
			}
			?>
		</section>