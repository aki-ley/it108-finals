<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str; 
use Illuminate\Http\Request;

class GoogleAuthController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback(Request $request)
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            // Check if the user already exists
            $user = User::where('google_id', $googleUser->getId())->first();

            if (!$user) {
                // Create a new user with default 'user' type
                $user = User::create([
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'google_id' => $googleUser->getId(),
                    'avatar' => $googleUser->getAvatar(),
                    'usertype' => 'user', // Assign default usertype
                    'password' => bcrypt(Str::random(16)), // Generate a random password
                ]);
            }

            // Log the user in
            Auth::login($user, true);

            // Redirect based on user type
            return redirect('/redirect');
        } catch (\Exception $e) {
            return redirect()->route('login')->with('error', 'Unable to login using Google.');
        }
    }
}
