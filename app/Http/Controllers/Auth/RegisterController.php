<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function register(Request $request)
    {
        $data = $request->all();
        $validator = $this->validator($data);

        if ($request->hasFile('photo') && $request->file('photo')->isValid()) {
            $data['photo'] = $request->file('photo')->store('/public/users/photos');
        }

        $data['password'] = bcrypt($request->password);

        if ($validator->fails()) {
            return response('Não foi possível cadastrar', 400);
        }

        $user = User::create($data);

        Auth::login($user);

        return $user;
    }

    public function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'max:255'],
            'email' => ['required', 'max:255', 'email', 'unique:users'],
            'nickname' => ['required', 'max:255', 'unique:users'],
            'password' => ['required', 'max:255'],
        ]);
    }
}
