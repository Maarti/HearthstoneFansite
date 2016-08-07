<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <link rel="shortcut icon" type="image/x-icon" href="<?=base_url('favicon.ico')?>">
        <link href="<?= base_url('assets/css/foundation.min.css'); ?>" rel="stylesheet" type="text/css">
        <link href="<?= base_url('assets/css/normalize.css'); ?>" rel="stylesheet" type="text/css">
        <link href="<?= base_url('assets/css/style.css'); ?>" rel="stylesheet" type="text/css">
        <link href="<?= base_url('assets/css/heroes.css'); ?>" rel="stylesheet" type="text/css">
        <script src="<?= base_url('assets/js/vendor/modernizr.js'); ?>"></script>
        <?
        if(strpos($url, 'tournament')){?>    
            <script type="text/javascript" src="http://www.aropupu.fi/bracket/site/jquery-1.6.2.min.js"></script>
            <script type="text/javascript" src="http://www.aropupu.fi/bracket/site/jquery.json-2.2.min.js"></script>
            <script type="text/javascript" src="<?= base_url('assets/js/jquery.bracket.min.js'); ?>"></script>            
            <link href="<?= base_url('assets/css/jquery.bracket.min.css'); ?>" rel="stylesheet" type="text/css">
        <?}?>            

        <title><?=lang($page_title)?></title>
    </head>    
    <body>