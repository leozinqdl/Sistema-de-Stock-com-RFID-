<?php
$_SESSION["http_host_uri"] = $_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"];
?><!doctype html>
<html>
    <head>
        <meta http-equiv="pragma" content="no-cache" />
        <meta charset="utf-8">
        <meta content="width=device-width, initial-scale=1" name="viewport">
        <title>Barracões</title>
        <link rel="SHORTCUT ICON" type="image/x-icon" href="<?=URL_BASE?>/public/img/layout/header_icon.png" />
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet"> 
        <!-- START SCRIPTS FAZENDA MANDAGUARI  -->
        <script src="<?=URL_BASE?>/public/js/jquery-1.9.1.js" type="text/jscript"></script>
        <script src="<?=URL_BASE?>/public/js/CtrlMandaguari.js" type="text/jscript"></script>
        <script src="<?=URL_BASE?>/public/js/modernizr.js" type="text/jscript"></script>
        <script src="<?=URL_BASE?>/public/js/functions.js"></script>
        <script src="<?=URL_BASE?>/public/js/mask.js"></script>
        <script src="<?=URL_BASE?>/public/js/jquery.canvasjs.min.js"></script>
        <script src="<?=URL_BASE?>/public/js/jquery.fancybox.js"></script> <!-- visualizador de fotos-->
        <!-- END SCRIPTS FAZENDA MANDAGUARI  -->
        
        <!-- START LINKS FAZENDA MANDAGUARI  -->
        <link href="<?=URL_BASE?>/public/css/css.css" rel="stylesheet" type="text/css" charset="utf-8" />
        <link href="<?=URL_BASE?>/public/css/jquery.fancybox.min.css" rel="stylesheet"> <!-- visualizador de fotos..)-->
        <link href="<?=URL_BASE?>/public/js/slick/slick.css" rel="stylesheet"> <!-- visualizador de fotos..)-->
        <link href="<?=URL_BASE?>/public/js/slick/slick-theme.css" rel="stylesheet"> <!-- visualizador de fotos..)-->
        <!-- END LINKS FAZENDA MANDAGUARI  -->

    </head>
	
	<body>
    <!-- START ICONS  -->
    <div id="header">
        <i onclick="history.back()"  class="material-icons back-header">arrow_back</i>
    	<a  href="<?=URL_BASE?>/index">
    		<img height="36" width="36" class="logo_header" src="<?=URL_BASE?>/public/img/layout/iconStock.png"><span>Barracões</span>
    	</a>
		<!-- <div class="header_menu">
			<a title="Sair" href="javascript: ajaxJquery('<?=URL_BASE?>/login/logoff', 'span_header_ajax');"
				class="sidenav-trigger header_itens_menu">
				<img width="35" src="<?=URL_BASE?>/public/img/layout/menu/logout.png" />
			</a>
    	</div> -->
    </div>
    <!-- END ICONS  -->
<span id="span_header_ajax"></span>