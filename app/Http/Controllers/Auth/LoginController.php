<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use OwenIt\Auditing\Models\Audit;

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
    protected $redirectTo = '/home';


    protected function authenticated(Request $request, $user)
    {
        Audit::create([
            'user_id' => $user->id,
            'user_type' => 'App\Models\User',
            'event' => 'login',
            'auditable_type' => get_class($user),
            'auditable_id' => $user->id,
            'old_values' => [],
            'new_values' => ['login_at' => now()],
            'url' => $request->fullUrl(),
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);
        // Example: if you have a 'role' column in your users table
        switch ($user->role) {
            case 'Admin':
                return redirect()->route('dashboard');
            case 'Manager':
                return redirect()->route('dashboard');
            case 'Staff':
                return redirect()->route('dashboard');
            default:
                return redirect('/home');
        }
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }
}
