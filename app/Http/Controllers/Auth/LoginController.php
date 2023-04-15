<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\InforUser;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
// use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    // login new user
    public function loginUserNew(Request $request)
    {
        // $credentials = $request->only('email', 'password');
        $email = $request->input('email');
        $password = $request->input('password');

        if (Auth::attempt(['email' => $email, 'password' => $password, 'role_id' => 1])) {
            return redirect()->route('dashboard.index');
        }
        if (Auth::attempt(['email' => $email, 'password' => $password, 'role_id' => 0])) {
            return redirect()->route('index');
        }
        if (Auth::attempt(['email' => $email, 'password' => $password, 'role_id' => 2])) {
            return redirect()->route('dashboard.index');
        }

        return redirect()->route('login');
    }

    public function redireactToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
        // return $provider;
    }

    public function handleProviderCallback($provider)
    {
        try {
            $user = Socialite::driver($provider)->user();
        } catch (\Exception $e) {
            return redirect('/index');
        }
        // only allow people with @company.com to login
        // if (explode("@", $user->email)[1] !== 'gmail.com'|| 'vku.udn.vn' ) {
        //     return redirect()->to('/');
        //     // ->with('error', 'Please use email ending "gmail".')
        // }
        // check if they're an existing user
        $existingUser = User::where('email', $user->email)->first();

        if ($existingUser) {
            // log them in
            $user = Auth::user();
            // User::where('email', '=', Auth::user()->email)
            //     ->update([
            //         'active_status' => 0,
            //     ]);
            Auth::login($existingUser, true);
        } else {
            // create a new user
            $newUser                  = new User;
            $newUser->name            = $user->getName();
            $newUser->email           = $user->getEmail();
            $newUser->provider        = $provider;
            $newUser->provider_id     = $user->getId();
            $newUser->avatar          = $user->getAvatar();
            $newUser->avatar_original = $user->avatar_original;
            $newUser->active_status = 0;
            $newUser->save();
            // $newUser = User::create([
            //     'name' => $user->getName(),
            //     'email' => $user->getEmail(),
            //     'provider' => $provider,
            //     'provider_id' => $user->getId(),
            //     'avatar' => $user->getAvatar(),
            //     'avatar_original' => $user->avatar_original,
            // ]);

            InforUser::create([
                'id_user' => $newUser->id
            ]);

            Auth::login($newUser, true);
            // dd("save done");
        }

        return redirect()->to('/index');
    }
}
