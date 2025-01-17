<?php 
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    public function redirect()
    {
      //  dd(config('services.google')); 
        $url = Socialite::driver('google')->redirect()->getTargetUrl();
        dd($url); // Проверяем, корректен ли URL
       // return Socialite::driver('google')->redirect();
    }

    public function callback()
    
    {
        $googleUser = Socialite::driver('google')->user();
        dd($googleUser); // Проверим, что возвращает Google

        $user = User::firstOrCreate([
            'email' => $googleUser->getEmail(),
        ], [
            'name' => $googleUser->getName(),
            'password' => bcrypt(str_random(16)),
            'role' => 'freelancer', // По умолчанию роль "фрилансер"
        ]);

        Auth::login($user);

        return redirect('/freelancer');
    }
}
