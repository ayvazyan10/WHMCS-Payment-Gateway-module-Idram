<?php

if (!defined("WHMCS")) {
    die("This file cannot be accessed directly");
}

/**
 * Define module related meta data.
 *
 * Values returned here are used to determine module related capabilities and
 * settings.
 *
 * @see https://developers.whmcs.com/payment-gateways/meta-data-params/
 *
 * @return array
 */
function idram_MetaData()
{
    return array(
        'DisplayName' => 'Idram Merchant Gateway Module',
        'APIVersion' => '1.1', // Use API Version 1.1
        'DisableLocalCredtCardInput' => true,
        'TokenisedStorage' => false,
    );
}

/**
 * Define gateway configuration options.
 *
 * The fields you define here determine the configuration options that are
 * presented to administrator users when activating and configuring your
 * payment gateway module for use.
 *
 * Supported field types include:
 * * text
 * * password
 * * yesno
 * * dropdown
 * * radio
 * * textarea
 *
 * Examples of each field type and their possible configuration parameters are
 * provided in the sample function below.
 *
 * @see https://developers.whmcs.com/payment-gateways/configuration/
 *
 * @return array
 */
function idram_config()
{
    return array(
        // the friendly display name for a payment gateway should be
        // defined here for backwards compatibility
        'FriendlyName' => array(
            'Type' => 'System',
            'Value' => 'Idram',
        ),
        'merchant_id' => array(
            'FriendlyName' => 'Merchant ID',
            'Type' => 'text',
            'Size' => '25',
            'Default' => '',
            'Description' => 'Provided by Idram',
        ),
        'secret_word' => array(
            'FriendlyName' => 'Secret Key',
            'Type' => 'text',
            'Size' => '25',
            'Default' => '',
            'Description' => 'Provided by Idram',
        ),
    );
}

/**
 * Payment link.
 *
 * Required by third party payment gateway modules only.
 *
 * Defines the HTML output displayed on an invoice. Typically consists of an
 * HTML form that will take the user to the payment gateway endpoint.
 *
 * @param array $params Payment Gateway Module Parameters
 *
 * @return string
 * @see https://developers.whmcs.com/payment-gateways/third-party-gateway/
 *
 */
function idram_link($params)
{
    $merchant_id = $params['merchant_id'];
    $description = $params['description'];
    $bill_no = $params['invoiceid'];
    $amount = $params['amount'];

    return '<form method="post" action="https://banking.idram.am/Payment/GetPayment">
        <input type="hidden" name="EDP_LANGUAGE" value="EN">
        <input type="hidden" name="EDP_REC_ACCOUNT" value="' . $merchant_id . '">
        <input type="hidden" name="EDP_DESCRIPTION" value="' . $description . '">
        <input type="hidden" name="EDP_AMOUNT" value="' . $amount . '">
        <input type="hidden" name="EDP_BILL_NO" value ="' . $bill_no . '">
        <input type="submit" value="' . $params['langpaynow'] . '">
        </form>';
}