<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8" />
    <title>Mi Sitio | Admin</title>
    <script src="https://unpkg.com/react@15/dist/react.min.js"></script>
    <script src="https://unpkg.com/react-dom@15/dist/react-dom.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/babel-core/5.8.23/browser.min.js"></script>
    <link rel="stylesheet" type="text/css" href="<?= base_url();?>public/css/admin.css">
    <?php 
    if (isset($extraHeaders)) {
    	echo $extraHeaders;
    }
    ?>
  </head>
  <body>
