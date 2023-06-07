<?php

namespace App\Http\Controllers\V1;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\Controller;
use Exception;

class GoogleController extends Controller
{

  public function login()
  {
    return Socialite::driver('google')->redirect();
  }

  public function callback()
  {
    try {
       $google = Socialite::driver('google')->user();
       $user = User::where('email', $user->getEmail())->first();
       if(!$user){
          $data = ['name' => $google->getName(), 'email' => $google->getEmail(), 'password' => Hash::make($google->getName().'@'.$google->getId())];
          $user = User::updateOrCreate(['google_id' => $google->getId()],[...$data]);
       }else{
          User::where('email',  $google->getEmail())->update(['google_id' => $google->getId()]);
          $user = User::where('email', $google->getEmail())->first();
       }

       return response()->json([
          'success' => true,
          'response' => [
             'user' => ['id' => $user->id, 'name' => $user->fullname(), 'email' => $user->email, 'token' => auth()->login($user)]
          ],
          'message' => 'Login successful',
       ], 200);
    } catch (Exception $error) {
      throw $th;
    }
  }
}



