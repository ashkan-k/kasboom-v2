<?php

namespace App\Http\Controllers;

use App\Models\classroom;
use App\Models\User;
use App\Models\webinar_register;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;

class CertificateController extends Controller
{
  public function getCheckCertificate ()
  {
    return view('checkCertificate');
  }

  public function checkCertificate ()
  {
    $validator = Validator::make(request()->all(), [
      'yearCerificate' => 'required|in:400,401,402',
      'typeCerificate' => 'required|in:م,د,الف,ب',
      'userIdCerificate' => 'required|max:11',
      'idCerificate' => 'required|max:11'
    ]);
    if($validator->fails())
      return response()->json(['message' => 'گواهی نامه یافت نشد .'], 403);

    $yearCerificate = request()->yearCerificate;
    $idCerificate = request()->idCerificate;
    $type = request()->typeCerificate;
    $userId = request()->userIdCerificate;
    if ($type === 'الف' || $type === 'ب') {
      $user = User::find($userId);
      if(!$user) return response()->json(['message' => 'گواهی نامه یافت نشد .'], 403);
    }
    else if($type === 'م' || $type === 'د') {
      $user = User::where('id_teacher', $userId)->first();
      if(!$user) return response()->json(['message' => 'گواهی نامه یافت نشد .'], 403);
    }

    $nameCertificate = "$userId/$idCerificate/$type/$yearCerificate";
    $certificate = '';
    if ($type === 'الف') {
      $certificate = classroom::where('name_certificate', $nameCertificate)->first();
      $url = url("/backend/public/certificate/$user->code/course/$idCerificate");
    }
    else if ($type === 'ب') {
      $certificate = webinar_register::where('name_certificate', $nameCertificate)->first();
      $url = url("/backend/public/certificate/$user->code/webinar/$idCerificate");
    }
    else if ($type === 'م') {
      $certificate = true;
      $slash = DIRECTORY_SEPARATOR;
      $fileName = '_upload_'.$slash.'_users_'.$slash . $user->code . $slash .'certificates' . $slash . 'webinar' . $slash . "$idCerificate.jpg";
      if (!file_exists($fileName)) $certificate = false;

      $url = url($fileName);
    }
    else if ($type === 'د') {
      $certificate = true;
      $slash = DIRECTORY_SEPARATOR;
      $fileName = '_upload_'.$slash.'_users_'.$slash . $user->code . $slash .'certificates' . $slash . 'course' . $slash . "$idCerificate.jpg";
      if (!file_exists($fileName)) $certificate = false;

      $url = url($fileName);
    }

    if(!$certificate) return response()->json(['message' => 'گواهی نامه یافت نشد .'], 403);
    return response()->json(['url' => $url], 200);
  }
}
