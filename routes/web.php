<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;


Route::get('/', function (Request $request) {

    $grantCode=$request->get('code');
    $response = Http::asForm()->withHeaders([
        'Content-Type'=>'application/x-www-form-urlencoded',
        'Authorization'=>'Basic NHJhbmpnNTBwMG5pdHA0ZWFkMWxjYzUzZmc6MTFhbWdiNXNrZml2N3J0MHZndHA0ZzAyNW5kcWo4MTdrbG1jYmIxZXFubWlwbmRqa2w0bA==' 
    ])->post('https://ujjwalsnippet.auth.us-west-2.amazoncognito.com/oauth2/token',[
        'grant_type'=>'authorization_code' ,
        'code'=>$grantCode ,
        'redirect_uri'=>'http://localhost:8000/'
    ]);


    $decodedResponse= json_decode($response);
    $accessToken = $decodedResponse->access_token;
    
    $userInfoResponse = Http::asForm()->withHeaders([
        'Content-Type'=>'application/x-www-form-urlencoded',
        'Authorization'=>'Bearer '.$accessToken 
    ])->get('https://ujjwalsnippet.auth.us-west-2.amazoncognito.com/oauth2/userInfo');

    $data = json_decode($userInfoResponse);

    return view('index1',['data'=>$data]);
});

