<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Http\Services\UploaderService;
use Illuminate\Http\UploadedFile;

class ClientController extends Controller
{
    /**
     * @var IMAGE_PATH
     */
    const IMAGE_PATH = 'clients';
    
    public function __construct(UploaderService $uploaderService)
    {
        $this->uploaderService = $uploaderService;
    }

    public function auth(Request $request){
        $Validated = Validator::make($request->all(), [
            'phone'     => 'required',
        ]);

        if($Validated->fails())
            return response()->json($Validated->messages(), 403);

        $client = Client::where('phone', $request->phone)->first();
        if (isset($client) && $client!=null) {
            $this->updateDeviceToken($client, $request->device_token);
            $this->updateActivationCode($client);
        } else {
            $client = Client::create( array_merge($request->all(), ['activation_code' => random_int(1000, 9999)]) );
        }

        $client_activation_code = $client->activation_code.' : '.'كود التفعيل';
        //sendSms($client->phone, $client->activation_code);
        $token = $client->createToken('API')->accessToken;
        return response(['token' => $token, 'user' => $this->formatUser($client)], 200);
    }

    private function updateDeviceToken($client, $device_token){
        $client->device_token = $device_token;
        $client->save();

        return true;
    }

    private function updateActivationCode($client){
        $client->activation_code = random_int(1000, 9999);
        $client->save();

        return true;
    }

    public function completeAuth(Request $request){
        $client = $request->user();

        $Validated = Validator::make($request->all(), [
            'first_name'      => 'required|min:3',
            'last_name'      => 'required|min:3',
        ]);

        if($Validated->fails())
            return response()->json($Validated->messages(), 403);

        $updated_client = Client::where('id', $client->id)->first();
        $updated_client->fill( array_merge($request->all(), ['status' => 1]) );
        $updated_client->update();
        
        return response()->json(['messaage' => trans('api.update_profile'), 'user' => $this->formatUser($updated_client)], 200);
    }

    public function verifyCode(Request $request){
        $client = $request->user();

        $Validated = Validator::make($request->all(), [
            'code' => 'required',
        ]);

        if($Validated->fails())
            return response()->json($Validated->messages(), 403);
            
        if(true /*$client->activation_code == $request->code*/){
            return response()->json(['message'=> trans('api.verify_code'), 'token' => request()->bearerToken()], 200);
        }else{
            return response()->json(['message'=> trans('api.wrong_activation_code')], 403);

        }
    }

    public function profile(Request $request){
        $user = $this->formatUser($request->user());

        return response()->json(['user' => $user], 200);
    }

    public function updateProfile(Request $request){
        $client = $request->user();

        $Validated = Validator::make($request->all(), [
            'first_name'      => 'required|min:3',
            'last_name'      => 'required|min:3',
            'email'     => 'required|unique:clients,email,'.$client->id,
            'phone'     => 'required|unique:clients,phone,'.$client->id,
        ]);

        if($Validated->fails())
            return response()->json($Validated->messages(), 403);

        $updated_client = Client::where('id', $client->id)->first();
        $updated_client->fill($request->only('first_name', 'last_name', 'email', 'phone'));
        $updated_client->update();
        
        return response()->json(['messaage' => trans('api.update_profile'), 'user' => $this->formatUser($updated_client)], 200);
    }

    public function updateProfileImage(Request $request){
        $client = $request->user();

        $Validated = Validator::make($request->all(), [
            'image'      => 'required|mimes:jpeg,jpg,png',
        ]);

        if($Validated->fails())
            return response()->json($Validated->messages(), 403);

        $updated_client = Client::where('id', $client->id)->first();
        if ($request->image) {
            $updated_client->image = $this->handleFile($request['image']);
        }
        $updated_client->update();

        return response()->json(['messaage' => trans('api.update_profile'), 'user' => $this->formatUser($updated_client)], 200);
    }

    private function formatUser($user){
        $user = [
            "id" => $user->id,
            "first_name" => $user->first_name,
            "last_name" => $user->last_name,
            "phone" => $user->phone,
            "email" => $user->email,
            "image" => isset($user->image) && $user->image!=null ? url($user->image) : null,
            "activation_code" => $user->activation_code,
            "status" => $user->status,
        ];

        return $user;
    }

    public function logout(Request $request)
    {
        $request->user()->token()->revoke();

        return response()->json(['message' => trans('api.logout')], 200);
    }

       /**
     * handle image file that return file path
     * @param File $file
     * @return string
     */
    public function handleFile(UploadedFile $file)
    {
        return $this->uploaderService->upload($file, self::IMAGE_PATH);
    }
}
