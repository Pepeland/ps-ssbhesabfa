<?php

/**
 * 2007-2019 PrestaShop
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
 *  @copyright 2007-2019 PrestaShop SA
 *  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
 *  International Registered Trademark & Property of PrestaShop SA
 */
//include(dirname(__FILE__) . '/../../../config/config.inc.php');
//include(dirname(__FILE__) . '/../../../init.php');

class hesabfaAPI
{
    //
    public function api_request($data = array(), $method)
    {
        if (!isset($method))
            return false;

        $data = array_merge(array(
            'apiKey' => Configuration::get('SSBHESABFA_ACCOUNT_API'),
            'userId' => Configuration::get('SSBHESABFA_ACCOUNT_USERNAME'),
            'password' => Configuration::get('SSBHESABFA_ACCOUNT_PASSWORD')
        ), $data);

        $data_string = json_encode($data);

        $url = 'https://api.hesabfa.com/v1/' . $method;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Accept: application/json'
        ));

        $result = curl_exec($ch);
        curl_close($ch);

        if ($result == null) {
            return 'No response from Hesabfa';
        } else {
            $result = json_decode($result);

            if (!isset($result->Success)) {
                switch ($result->ErrorCode) {
                    case '100':
                        return 'InternalServerError';
                        break;
                    case '101':
                        return 'TooManyRequests';
                        break;
                    case '103':
                        return 'MissingData';
                        break;
                    case '104':
                        return 'MissingParameter' . '. ErrorMessage: ' . $result->ErrorMessage;
                        break;
                    case '105':
                        return 'ApiDisabled';
                        break;
                    case '106':
                        return 'UserIsNotOwner';
                        break;
                    case '107':
                        return 'BusinessNotFound';
                        break;
                    case '108':
                        return 'BusinessExpired';
                        break;
                    case '110':
                        return 'IdMustBeZero';
                        break;
                    case '111':
                        return 'IdMustNotBeZero';
                        break;
                    case '112':
                        return 'ObjectNotFound' . '. ErrorMessage: ' . $result->ErrorMessage;
                        break;
                    case '113':
                        return 'MissingApiKey';
                        break;
                    case '114':
                        return 'ParameterIsOutOfRange' . '. ErrorMessage: ' . $result->ErrorMessage;
                        break;
                    case '190':
                        return 'ApplicationError' . '. ErrorMessage: ' . $result->ErrorMessage;
                        break;
                }
            } else {
                return $result;
            }
        }
        return false;
    }

    //Contact functions
    public function contactGet($code) {
        $method = 'contact/get';
        $data = array(
            'code' => $code,
        );

        return $this->api_request($data, $method);
    }

    public function contactGetById($idList) {
        $method = 'contact/getById';
        $data = array(
            'idList' => $idList,
        );

        return $this->api_request($data, $method);
    }

    public function contactGetContacts($queryInfo) {
        $method = 'contact/getcontacts';
        $data = array(
            'queryInfo' => $queryInfo,
        );

        return $this->api_request($data, $method);
    }

    public function contactSave($contact) {
        $method = 'contact/save';
        $data = array(
            'contact' => $contact,
        );

        return $this->api_request($data, $method);
    }

    public function contactBatchSave($contacts) {
        $method = 'contact/batchsave';
        $data = array(
            'contacts' => $contacts,
        );

        return $this->api_request($data, $method);
    }

    public function contactDelete($code) {
        $method = 'contact/delete';
        $data = array(
            'code' => $code,
        );

        return $this->api_request($data, $method);
    }

    //Items functions
    public function itemGet($code) {
        $method = 'item/get';
        $data = array(
            'code' => $code,
        );

        return $this->api_request($data, $method);
    }

    public function itemGetByBarcode($barcode) {
        $method = 'item/getByBarcode';
        $data = array(
            'barcode' => $barcode,
        );

        return $this->api_request($data, $method);
    }

    public function itemGetById($idList) {
        $method = 'item/getById';
        $data = array(
            'idList' => $idList,
        );

        return $this->api_request($data, $method);
    }

    public function itemGetItems($queryInfo) {
        $method = 'item/getitems';
        $data = array(
            'queryInfo' => $queryInfo,
        );

        return $this->api_request($data, $method);
    }

    public function itemSave($item) {
        $method = 'item/save';
        $data = array(
            'item' => $item,
        );

        return $this->api_request($data, $method);
    }

    public function itemBatchSave($items) {
        $method = 'item/batchsave';
        $data = array(
            'items' => $items,
        );

        return $this->api_request($data, $method);
    }

    public function itemDelete($code) {
        $method = 'item/delete';
        $data = array(
            'code' => $code,
        );

        return $this->api_request($data, $method);
    }

    //Invoice functions
    public function invoiceGet($number, $type) {
        $method = 'invoice/get';
        $data = array(
            'number' => $number,
            'type' => $type,
        );

        return $this->api_request($data, $method);
    }

    public function invoiceGetById($id) {
        $method = 'invoice/get';
        $data = array(
            'id' => $id,
        );

        return $this->api_request($data, $method);
    }

    public function invoiceGetInvoices($queryinfo, $type) {
        $method = 'invoice/getinvoices';
        $data = array(
            'code' => $queryinfo,
            'type' => $type,
        );

        return $this->api_request($data, $method);
    }

    public function invoiceSave($invoice) {
        $method = 'invoice/save';
        $data = array(
            'invoice' => $invoice,
        );

        return $this->api_request($data, $method);
    }

    public function invoiceDelete($number, $type) {
        $method = 'invoice/delete';
        $data = array(
            'code' => $number,
            'type' => $type,
        );

        return $this->api_request($data, $method);
    }

    public function invoiceSavePayment($number, $bankCode, $date, $amount, $transactionNumber = null, $description = null) {
        $method = 'invoice/savepayment';
        $data = array(
            'number' => $number,
            'bankCode' => $bankCode,
            'date' => $date,
            'amount' => $amount,
            'transactionNumber' => $transactionNumber,
            'description' => $description,
        );

        return $this->api_request($data, $method);
    }

    public function invoiceGetOnlineInvoiceURL($number, $type) {
        $method = 'invoice/getonlineinvoiceurl';
        $data = array(
            'number' => $number,
            'type' => $type,
        );

        return $this->api_request($data, $method);
    }

    //Settings functions
    public function settingSetChangeHook($url, $hookPassword) {
        $method = 'invoice/getonlineinvoiceurl';
        $data = array(
            'url' => $url,
            'hookPassword' => $hookPassword,
        );

        return $this->api_request($data, $method);
    }

    public function settingGetChanges($start) {
        $method = 'setting/GetChanges';
        $data = array(
            'start' => $start,
        );

        return $this->api_request($data, $method);
    }
}