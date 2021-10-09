<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Traits\ImageUpload;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    use ResponseTrait;
    use ImageUpload;
    public function update(Request $request){
        $user = Auth::user();
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'min:5', 'max:255'],
            'email' => ['required', 'email', 'unique:users,id,' . Auth::id()],
           ]
        );
        if($validator->fails()){
            return $this->returnError($validator->errors()->toJson(), 400);
        }

        $user->name= $request->name;
        $user->email= $request->email;
        if ($request->has('current_password')) {

            if ( Hash::check($request->current_password, $user->password) ) {
                $password_validator = Validator::make($request->all(), [
                        'new_password' => ['required','string', 'min:5', 'max:255', 'confirmed'],
                    ]
                );
                if($password_validator->fails()){
                    return $this->returnError('new password confimation does not match', 400);
                }
                if (Hash::check($request->new_password, $user->password) ) {
                    return $this->returnError('new password cannot be old one', 400);
                } else {
                    $user->password = Hash::make($request->new_password);
                }

            } else {
                return $this->returnError('current password is wrong', 400);
            }
        }

            if($request->has('image')){
                $img_validator=Validator::make($request->all(),[
                    'image' => ['required', 'file', 'mimes:png,jpeg,svg,jpg', 'max:4069']
                ]);

                if($img_validator->fails()){
                    return $this->returnError('only allowed jpg,jpeg,svg,png', 400);
                }
                $user->image=$this->uploadImage($request['image'],"profile",40);
            }
        $user->save();
        return $this->returnSuccess('profile data have been updated successfully', 201);
    }
}
