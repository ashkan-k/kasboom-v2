<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 10/6/2020
 * Time: 4:57 PM
 */

namespace App\lib;
namespace App\lib;
use SoapClient;

class zarinpal
{
    public $MerchantID;
    public function __construct()
    {
        $this->MerchantID="e7d6f566-c2e1-4fbe-9473-7ac3567a3944";
//        $this->MerchantID="7dba871e-3236-11ea-b6c7-000c295eb8fc";
    }
    public function pay($Amount,$Email,$Mobile,$Description,$CallbackURL)
    {
        $client = new SoapClient('https://www.zarinpal.com/pg/services/WebGate/wsdl', ['encoding' => 'UTF-8']);
        $result = $client->PaymentRequest(
            [
                'MerchantID' => $this->MerchantID,
                'Amount' => $Amount,
                'Description' => $Description,
                'Email' => $Email,
                'Mobile' => $Mobile,
                'CallbackURL' => $CallbackURL,
            ]
        );

        if ($result->Status == 100) {
            return $result->Authority;
        } else {
            return false;
        }



    }
}
