<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;

class Notify
{
    public static function getAll()
    {
        $user = auth()->user();
        $notify = [];

        if ($user->read_status_memo === 1 and $user->status_memo !== '') {
            $notify[] = ['name' => 'user', 'message' => $user->status_memo];
        }

        $row = DB::table('markaz_database1')->where('id_user', $user->id)->first();
        if (!empty($row) and $row->read_status_memo === 1) {
            $message = 'در انتظار بررسی مرکز خدمات حوزه های علمیه استان ';
            if ($row->modir_accept === 'wait' or $row->modir_accept === 'ok')
                $message = $row->status;
            else if ($row->modir_accept === 'nok')
                $message = $row->message_deaccept;
            else if ($row->modir_accept === 'faild')
                $message = $row->message_faild;
            $notify[] = ['name' => 'db1', 'message' => $message];
        }

        $row = DB::table('markaz_database2')->where('id_user', $user->id)->first();
        if (!empty($row) and $row->read_status_memo === 1) {
            $message = 'در انتظار بررسی مرکز خدمات حوزه های علمیه استان ';
            if ($row->modir_accept === 'wait' or $row->modir_accept === 'ok')
                $message = $row->status;
            else if ($row->modir_accept === 'nok')
                $message = $row->message_deaccept;
            else if ($row->modir_accept === 'faild')
                $message = $row->message_faild;
            $notify[] = ['name' => 'db2', 'message' => $message];
        }

        $row = DB::table('markaz_database3')->where('id_user', $user->id)->first();
        if (!empty($row) and $row->read_status_memo === 1) {
            $message = 'در انتظار بررسی مرکز خدمات حوزه های علمیه استان ';
            if ($row->modir_accept === 'wait' or $row->modir_accept === 'ok')
                $message = $row->status;
            else if ($row->modir_accept === 'nok')
                $message = $row->message_deaccept;
            else if ($row->modir_accept === 'faild')
                $message = $row->message_faild;
            $notify[] = ['name' => 'db3', 'message' => $message];
        }

        $row = DB::table('markaz_database4')->where('id_user', $user->id)->first();
        if (!empty($row) and $row->read_status_memo === 1) {
            $message = 'در انتظار بررسی مرکز خدمات حوزه های علمیه استان ';
            if ($row->modir_accept === 'wait' or $row->modir_accept === 'ok')
                $message = $row->status;
            else if ($row->modir_accept === 'nok')
                $message = $row->message_deaccept;
            else if ($row->modir_accept === 'faild')
                $message = $row->message_faild;
            $notify[] = ['name' => 'db4', 'message' => $message];
        }

        return $notify;
    }
}
