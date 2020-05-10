<?php

namespace App\Http\Controllers\company;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class profileController extends Controller
{
    public function updateCurrentPassword(Request $request){
        //return $request->new_password;
        if($request->new_password != null ){
            $rules=[
                'name' => 'required|min:3',
                'email' => 'required|email',
                'old_password' => 'required',
                'new_password' => 'required',
                'confirm_password', 'required',];
        }
        else{
            $rules=[
                'name' => 'required|min:3',
                'email' => 'required|email',
                'old_password' => 'required',
            ];
        }

            $validator = \Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
                return redirect()->back()->withErrors($validator->errors());
            }


            //esson::create($request->all());
return 0;
            //return $this->respondCreated('Lesson created successfully');
    }

}
