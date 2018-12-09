<?php
/**
 * 2007-2013 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author    PrestaShop SA <contact@prestashop.com>
*  @copyright 2007-2014 PrestaShop SA
*  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/
include_once dirname(__FILE__).'/../../../../config/config.inc.php';
include_once dirname(__FILE__).'/../../../../init.php';
include_once dirname(__FILE__).'/../../pagseguro.php';
include_once dirname(__FILE__).'/../../backward_compatibility/backward.php';
include_once dirname(__FILE__).'/../../features/payment/pagseguropaymentorderprestashop.php';

$useSSL = true;

$pagseguro = new PagSeguro();

$showView = new BWDisplay();

$context = Context::getContext();

if (! $context->cookie->isLogged(true)) {
    Tools::redirect('authentication.php?back=order.php');
}

$payment = new PagSeguroPaymentOrderPrestashop();
$payment->setVariablesPaymentExecutionView();

$environment = Configuration::get('PAGSEGURO_ENVIRONMENT');

$context->smarty->assign('environment', $environment);

$url = "modules/pagseguro/standard/front/error.php";
$context->smarty->assign('errurl', $url);

$showView->setTemplate(_PS_MODULE_DIR_.'pagseguro/views/templates/front/payment_execution.tpl');
$showView->run();
