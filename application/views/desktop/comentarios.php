<?php $bsrl = base_url(); ?>
		<h2><?=$titulo;?></h2>
		<ul class="ulcomm">
		<?php
		if($coments->num_rows()>0):
			foreach($coments->result() as $row): 
				$fecha = explode(" ",$row->fecha);
		?>
		<li>
			<div class="ddetails">
				<?php echo $row->nombre. " [ " . $row->email ." ] " . $fecha[0]; ?>
			</div>
			<div class="dcommen"><?php echo $row->comment; ?></div>
		</li>
		<?php
			endforeach; 
		endif; 
		?>
		</ul>
