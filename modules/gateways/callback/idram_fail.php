<?php

require_once __DIR__ . '/../../../init.php';

App::load_function('gateway');
App::load_function('invoice');

$gatewaymodule = "idram"; # Enter your gateway module name here replacing template

$gatewayParams = getGatewayVariables($gatewaymodule);

logTransaction($gatewayParams['name'], $_POST, 'Check params');

// Die if module is not active.
if (!$gatewayParams['type']) {
    die('Module Not Activated');
}

# Get Returned Variables
$id = $_REQUEST['EDP_BILL_NO'];

$invoice_id = checkCbInvoiceID($id, $gatewayParams['name']);

$trans_id = filter_input(INPUT_POST, 'intid');

if (isset($id)) {
    # Unsuccessful
    logTransaction($gatewayParams["name"], $_POST, "Unsuccessful");
    header('Location: ' . $gatewayParams['systemurl'] . 'viewinvoice.php?id=' . $id . '&paymentfailed=true');
    die();
}
