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
include_once dirname(__FILE__) . '/../../../../config/config.inc.php';

$checkout = Configuration::get('PAGSEGURO_CHECKOUT');

include_once dirname(__FILE__) . '/../../pagseguro.php';
include_once dirname(__FILE__) . '/../../backward_compatibility/backward.php';
include_once dirname(__FILE__) . '/../../features/validation/pagsegurovalidateorderprestashop.php';

$pag_seguro = new PagSeguro();
$validate = new PagSeguroValidateOrderPrestashop($pag_seguro);

try {
    $validate->validate();
    if ($checkout) {
        die($validate->request());
    }
    Tools::redirectLink($validate->request());
} catch (Exception $exc) {
	
    canceledOrderForErro($pag_seguro);
    var_dump($checkout); die;
    if ($checkout)    
        throw new Exception($exc->getMessage(), 1);
    else
        displayErroPage();
} 
    
function displayErroPage()
{
    $showView = new BWDisplay();
    $showView->setTemplate(_PS_MODULE_DIR_.'pagseguro/views/templates/front/error.tpl');
    $showView->run();
}

function canceledOrderForErro($pag_seguro)
{
    $currentOrder = (int) ($pag_seguro->currentOrder);

    $history = new OrderHistory();
    $history->id_order = $currentOrder;
    $history->changeIdOrderState(6, $currentOrder);
    $history->save();
}
