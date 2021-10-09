<?php
namespace App\Traits;
use Illuminate\Http\JsonResponse;use PHPUnit\Util\Type;

trait ResponseTrait{
    public function returnError($msg,$StatusCode):JsonResponse
    {
        return response()->json([
                'status' => false,
                'msg' => $msg,
                ],$StatusCode,['Content-Type' =>'application/json;charset-UTF-8']);
    }

      public function returnSuccess($msg,$StatusCode):JsonResponse
    {
        return response()->json([
                'status' => false,
                'msg' => $msg,
                ],$StatusCode,['Content-Type' =>'application/json;charset-UTF-8']);
    }



  public function returnData($msg,$value,$statusCode):JsonResponse
    {
        return response()->json([
                'status' => false,
                'msg' => $msg,
                'data' => $value
                ],$statusCode,['Content-Type' =>'application/json;charset-UTF-8']);
    }







}

















?>
