<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

abstract class Controller
{
    public function getResponseItems($error, $data, $message, $type)
    {
        $responseItems = [
            'error' => $error,
            'data' => $data,
            'message' => $message,
            'type' => $type
        ];
        return $responseItems;
    }

    public function getErrorResponse($message)
    {
        return   $this->getResponseItems('true', '', $message, 'error');
    }

    public function getSuccessResponse($message,$data='')
    {
        return   $this->getResponseItems('false', $data, $message, 'success');
    }

    public function getAccessDenied()
    {
        return   $this->getResponseItems('true', '', 'شما مجوز این عملیات را ندارید', 'error');
    }

    public function getUserId()
    {
        return Auth::id();
    }

    public function getChamberId()
    {

        try {
            return  Chamber::where("id_user", Auth::user()->id)->first()->id;
        }catch (Exception $error){
            return $this->getErrorResponse('حجره شما یافت نشد');
        }
    }

    public function getChamberCode()
    {
        try {
            return Chamber::where("id_user", Auth::user()->id)->first()->code;
        } catch (Exception $error) {
            return $this->getErrorResponse('غرفه شما یافت نشد');
        }
    }



    public function convertDate($request)
    {
        if(isset($request['start_date']))
            $request['start_date'] = jalaliToMiladi($request['start_date']);
        if(isset($request['end_date']))
            $request['end_date'] = jalaliToMiladi($request['end_date']);
        return $request;
    }


    public function ajax_response($errorr,$dataa,$messagee,$typee){
        $response = [
            'error' => $errorr,
            'data' =>$dataa,
            'message' => $messagee,
            'type' => $typee
        ];

        return response()->json($response);
    }
}
