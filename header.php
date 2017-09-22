<?
require_once "model/start.php";
if (!empty(Main::get_cookie("LOG")) && !empty(Main::get_cookie("HPS")))
    $user = new User();
?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <? 
            if (empty(Main::get_cookie("LOG"))) // если в сессии не указано, что пользователь залогинен
            {
                exit('<META HTTP-EQUIV="REFRESH" CONTENT="0; URL=/index.php">');
            }
        ?>
        <title>ППОС ЛГТУ</title>

        <link href="<?=auto_version('/css/styles.css');?>" rel="stylesheet">
        <link rel="stylesheet" href="<?=auto_version('/css/jquery.mCustomScrollbar.css');?>" />
        <link rel="shortcut icon" type="img/x-icon" href="/favicon.ico">
    </head>
    <body style="border:1px;">
        <script type="text/javascript" src="<?=auto_version('/js/jquery-2.2.4.js');?>"></script> 
        <script type="text/javascript" src="<?=auto_version('/js/help.js');?>"></script> 
        <script src="<?=auto_version('/js/jquery.mCustomScrollbar.concat.min.js');?>"></script>
        <script src="<?=auto_version('/js/js-webshim/minified/polyfiller.js');?>"></script>
        <script>
            webshims.setOptions('forms-ext', {types: 'date'});
            webshims.polyfill('forms forms-ext');
            $.webshims.formcfg = {
                en: {
                    dFormat: '-',
                    dateSigns: '-',
                    patterns: {
                        d: "dd-mm-yy"
                    }
                }
            };
        </script>
        <header id="masthead" class="site-header navbar-fixed-top">
            <div class="row" style="max-width:1024px;margin:auto">
            	<div class="logo navbar-brand">
            		<img src="/images/Logo.png" style="height:64px;width:auto" onclick="window.location.href='/index.php'">
            	</div><!-- end logo -->
            	<nav class="site-navigation" role="navigation" style="height:1px;">
            		<ul>
                        <?Main::IncludeThing(
                            "menu",
                            "topmenu", 
                            array(
                                "userLevel" => $user->getLevel(),
                                "requests" => $user->getNumNotes()
                            )
                        )?>
                        <?Main::IncludeThing(
                            "menu",
                            "rtopmenu", 
                            array(
                                "userId" => $user->getId(),
                                "requests" => $user->getNumNotes()
                            )
                        )?>
                	</ul>
                </nav><!-- primary-navigation -->
            </div><!-- end row -->
        </header><!-- end #masthead -->
		<section class="home-service">
			<div class="container">
				<div class="row">
                    <?$lmenu = Main::IncludeThing(
                        "menu",
                        "lMenu", 
                        array(
                            "page" => $_SERVER['PHP_SELF']
                        )
                    );//dump($_SERVER);
                    //$db->ListAllQueries() 
                    //echo __DIR__?>
