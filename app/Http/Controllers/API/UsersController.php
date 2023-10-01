<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Profile;
use App\Models\Points;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Exports\UsersExport;
use Maatwebsite\Excel\Facades\Excel;
use Craftsys\Msg91\Facade\Msg91;
use DB;

class UsersController extends Controller
{
    private ApiResponse $apiResponse;

    public function __construct(ApiResponse $apiResponse)
    {
        $this->apiResponse = $apiResponse;
    }

    
    public function adminprofile(Request $request): Response|Application|ResponseFactory
    {
        if (Auth::check()){
            $data =  User::where('id',Auth::user()->id)->first();
            return $this->apiResponse->adminSendResponse(200, 'admin details fetched successfully',  $data);
        }else {
            return $this->apiResponse->adminSendResponse(401, 'User unauthorized', null);
        }
    }
    



    public function adminprofileupdate(Request $request): Response|Application|ResponseFactory
    {

        if (Auth::check()){
            $validator = Validator::make($request->all(), [
                'id' => 'required|numeric',
                'name'   => 'required|string',
                'email'  =>  'required|email',
                'mobile_no'  => 'required|numeric|digits:10',
            ]);

            if ($validator->fails()) {
                return $this->apiResponse->adminSendResponse(400, 'Parameters missing or invalid.', $validator->errors());
            }
            

            $update1 = User::where('id',$request->id)->update([
                'name' => $request->name,
                'email' => $request->email,
                'mobile_no' => $request->mobile_no,
            ]);

             if($request->file('file') != '' && $request->file('file') != null){
                        $file = $request->file('file');
                        $picname = time().'.'.$file->extension();
                        $file->move(public_path('uploads/profile'),$picname);
                        $request['profile_img'] = 'profile/'.$picname;
                        unset($request['file']);
                        }else{
                            unset($request['file']);
             }
            $update2 = Profile::where('user_id',$request->id)->update([
                'profile_img' => $request->profile_img,
                'name' => $request->name,
            ]);
            if($update1 && $update2){
                return $this->apiResponse->adminSendResponse(200, 'Profile data Updated', null);
            }else {
                return $this->apiResponse->adminSendResponse(404, 'Something wne wrong while updating some data',  NULL);
            }
        }else {
            return $this->apiResponse->adminSendResponse(401, 'User unauthorized', null);
        }
    }


    public function adminpasswordupdate(Request $request): Response|Application|ResponseFactory
    {

        if (Auth::check()){
            $validator = Validator::make($request->all(), [
                'id' => 'required|numeric',
                'password'   => 'required|string',
                'newpassword'  =>  'required|string',
                'conformpassword'  => 'required|string',
            ]);

            if ($validator->fails()) {
                return $this->apiResponse->adminSendResponse(400, 'Parameters missing or invalid.', $validator->errors());
            }

            $user = User::where('id',$request->id)->first();

            if($user->demot != $request->password){
                return $this->apiResponse->adminSendResponse(404, 'Not match with old password', NULL);
            }
            
            if($request->newpassword === $request->conformpassword){
               
            $update = User::where('id',$request->id)->update([
                'demot' => $request->newpassword,
                'password' => bcrypt($request->newpassword),
            ]);

            if($update){
                return $this->apiResponse->adminSendResponse(200, 'Password Updated', null);
            }else {
                return $this->apiResponse->adminSendResponse(404, 'Something wne wrong while updating Password',  NULL);
            }
            }else {
                return $this->apiResponse->adminSendResponse(404, 'Conform Password Does not match',  NULL);
            }
        }else {
            return $this->apiResponse->adminSendResponse(401, 'User unauthorized', null);
        }
    }
}
