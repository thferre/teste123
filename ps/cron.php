<?php

/*
*
* PrestaBR - https://prestabr.com.br
*
*/

include_once(dirname(__FILE__).'/../../config/config.inc.php');
include_once(dirname(__FILE__).'/../../init.php');
require_once(dirname(__FILE__).'/newsletter.php');

$hash = Tools::getValue('hash');
$news = new Newsletter();

if(isset($hash) && $hash == '' || $hash != 'lenr33kdnsiodbg2424e0f2ni0rgn20i23') 
{
	echo "Ocorreu um erro, tente novamente";
}else{
	$news->CronNews();
	echo "Executado com Sucesso! ;-)";
}
