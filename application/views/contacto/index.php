<div id="main_part_inner">
    <div id="main_part_inner_in">
        <h1>Contacto</h1>
    </div>
</div>
<?php if ($validForm==1) { ?>
<div id="content_inner"></div>
<?php } else { ?>
<p class="textit"><?=$msgForm;?></p>
<?php } ?>
<hr class="cleanit">
<footer id="footer"></footer>
<script type="text/babel" src="<?= base_url();?>public/js/mainMenu.js"></script>
<script type="text/babel" src="<?= base_url();?>public/js/contacto.js"></script>
<script type="text/babel" src="<?= base_url();?>public/js/mainFooter.js"></script>