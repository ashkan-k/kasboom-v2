<?php

namespace App\Models;

use Illuminate\Support\Facades\Http;
use SoapClient;
use SoapFault;
use GuzzleHttp\Client;


class Sms
{
    public static function send_vam_followup($mobile, $name, $followup)
    {
        return self::send_by_pattern($mobile, "rvpj1jnnn8", ["name" => $name, "followup_code" => $followup]);
    }

    public static function send_by_pattern($mobile, $pattern_code, $input_data)
    {


        try {
            $client = new \SoapClient("http://188.0.240.110/class/sms/wsdlservice/server.php?wsdl");
            $user = config('app.sms_username');
            $pass = config('app.sms_userpass');
            $fromNum = config('app.sms_fromnum');
            $smsStatus = $client->sendPatternSms($fromNum, [$mobile], $user, $pass, $pattern_code, $input_data);
            $smsStatus = explode(',', $smsStatus);
            if (count($smsStatus) > 1)
                return false;
            else
                return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    public static function send($mobile, $text) {


        $url = "http://sms.rajat.ir/send_line.php";
        $client = new Client();
        $response = $client->request('POST', $url, [
            'verify' => false,
            'form_params' => [
                'to' => $mobile,
                'from' => 5000298645,
                'fori' => 2,
                'username' => 15835,
                'password' => 1583500,
                'text' => $text,
            ]
        ]);
        $status = $response->getStatusCode();
        if ($status == 200)
            return true;
        else
            return false;

//
//        $response = Http::get('http://sms.parsgreen.ir/UrlService/sendSMS.ashx', [
//            'to' => $mobile,
//            'text' => $text,
//            'signature' => env('SIGNATURE'),
//        ]);
//
//        $body = $response->body();
//        $pieces = explode(";", $body);
//
//        if (isset($pieces[1]) && (int)$pieces[1] === 0) return true;
//        return false;
    }

    public static function sendAll($mobiles, $text)
    {
        mb_internal_encoding("utf-8");
//        $parameters['signature'] = env('SIGNATURE');
//        $parameters['from'] = '';
//        $parameters['to'] = $mobile;
//        $parameters['text'] = mb_convert_encoding($text, "UTF-8");
//        $parameters['isFlash'] = false;
//        $parameters['udh'] = "";

        $url = "http://sms.rajat.ir/send_line.php";
        $client = new Client();
        $text= mb_convert_encoding($text, "UTF-8");
//        $text = $text."\n\n". "لغو ۱۱ ";
        foreach ($mobiles as $mobile) {
            $response = $client->request('POST', $url, [
                'verify' => false,
                'form_params' => [
                    'to' => $mobile,
                    'from' => 5000298645,
                    'fori' => 2,
                    'username' => 15835,
                    'password' => 1583500,
                    'text' => $text,
                ]
            ]);
            $status = $response->getStatusCode();
        }
        if ($status == 200)
            return true;
        else
            return false;


//
//        try {
//            $con = new SoapClient('http://sms.parsgreen.ir/Api/SendSMS.asmx?WSDL');
//            $responseSTD = (array)$con->SendGroupSmsSimple($parameters);
//            return $responseSTD['SendGroupSmsSimpleResult'];
//        } catch (SoapFault $ex) {
//            return $ex->faultstring;
//        }
    }

}
