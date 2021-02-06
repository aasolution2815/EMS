<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\EmsModel;

class AuthenticationController extends Controller
{
    /**
     * Display a Login Screen
     *
     * @return \Illuminate\Http\Response It Returan Response As A View Page
     */
    public function LoginScreen()
    {
        return view('index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * This is For The Authentication Of The User
     *
     * @param  \Illuminate\Http\Request  $request it Contatin Username ANd Password
     * @return \Illuminate\Http\Response It Will Return Wethere Username exit Or
     *  Not And CHeck For Valid Password
     */
    public function CheckLogin(Request $request)
    {
        $model = new EmsModel();
        $user_name = $request->username;
        $user_Password = $request->userPassword;
        $response = $model->Authtentication($user_name,$user_Password);
        return $response;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
