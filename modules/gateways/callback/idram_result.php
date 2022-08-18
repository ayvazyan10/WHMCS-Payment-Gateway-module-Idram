<?php

require_once __DIR__ . '/../../../init.php';

App::load_function('gateway');
App::load_function('invoice');

$gatewayModuleName = "idram"; # Enter your gateway module name here replacing template

// // Fetch gateway configuration parameters.
$gatewayParams = getGatewayVariables($gatewayModuleName);

// logTransaction($gatewayParams['name'], $_POST, 'Check params');

// Die if module is not active.
if (!$gatewayParams['type']) {
    die('Module Not Activated');
}

if (isset($_REQUEST['EDP_PRECHECK'])
    && isset($_REQUEST['EDP_BILL_NO'])
    && isset($_REQUEST['EDP_REC_ACCOUNT'])
    && isset($_REQUEST['EDP_AMOUNT'])) {
    if ($_REQUEST['EDP_PRECHECK'] == "YES"
        && $_REQUEST['EDP_REC_ACCOUNT'] == $gatewayParams['merchant_id']) {
        // check if [invoiceid] exists and throw OK
        echo "OK";
    }
}


if (isset($_REQUEST['EDP_PAYER_ACCOUNT'])
    && isset($_REQUEST['EDP_BILL_NO'])
    && isset($_REQUEST['EDP_REC_ACCOUNT'])
    && isset($_REQUEST['EDP_AMOUNT'])
    && isset($_REQUEST['EDP_TRANS_ID'])
    && isset($_REQUEST['EDP_CHECKSUM'])) {
    $hashishme =
        $gatewayParams['merchant_id'] . ":" .
        $_REQUEST['EDP_AMOUNT'] . ":" .
        $gatewayParams['secret_word'] . ":" .
        $_REQUEST['EDP_BILL_NO'] . ":" .
        $_REQUEST['EDP_PAYER_ACCOUNT'] . ":" .
        $_REQUEST['EDP_TRANS_ID'] . ":" .
        $_REQUEST['EDP_TRANS_DATE'];
    if (strtoupper($_REQUEST['EDP_CHECKSUM']) != strtoupper(md5($hashishme))) {
        // if checksum is not equal to secret key throw exception, in this way just FAIL
        echo "FAIL";
    } else {
        // checksum is equal
        echo "OK";
    }
}
