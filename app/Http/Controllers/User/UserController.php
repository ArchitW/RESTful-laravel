<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use App\User;

class UserController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $users = User::all();

        return $this->showAll($users);
       // 200 everything is Okay
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $rules = [
            'name' => 'required',
            'email' => 'required|email|unique:users', // unique to users table
            'password' => 'required|min:6|confirmed',
        ];
       // Validate request against rules
        $this->validate($request, $rules);
        // if validation fails , show errors

        //everything is okay
        $data =  $request->all();

        $data['password'] = bcrypt($request->password);
        $data['verified'] = User::UNVERIFIED_USER;
        $data['verified_token'] = User::genegateVerificationCode();
        $data['admin'] = User::REGULAR_USER; // set all users to normal user initially

        //Create User
        $user = User::create($data);

        //return response
        return $this->showOne($user, 201);
        // 201 : created


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::findOrFail($id);
        // throw error : user not found
        return $this->showOne($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $rules = [
          'email' => 'email|unique:users,email,'. $user->id,
          'password' => 'min:6|confirmed',
          'admin' => 'in:'.User::ADMIN_USER . ',' . User::REGULAR_USER,

        ];

        if ($request->has('name')){
            $user->name = $request->name;
        }

        // if request has email , check if email if different from stored email , yes: generate verification code
        if ($request->has('email') && $user->email != $request->email){
            $user->verified = User::UNVERIFIED_USER;
            $user->verified_token = User::genegateVerificationCode();
            $user->email = $request->email;
        }

        if($request->has('password')){
            $user->password = bcrypt($request->password);
        }

        //only verified users can be admin
        if($request->has('admin')){

            if(!$user->isVerified()){
                return $this->errorResponse( 'Only Verified Users can modify the admin field',  409);

            }
            $user->admin = $request->admin;
        }

        // check if something has changed in user record
        if(!$user->isDirty()){
            return $this->errorResponse('you need to specify a different value to update', 422);

        }

        // save user
        $user->save();
        return $this->showOne($user);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        $user->delete();
        return response()->json(['data' => $user], 200);
    }
}
