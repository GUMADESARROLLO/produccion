<?php

namespace App\Http\Controllers\Auth;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\DB;

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
    //protected $redirectTo = RouteServiceProvider::HOME;
    public function redirectTo() {

        // rol de usuario
        $role = Auth::User()->activeRole();

        // Redireccionando a pagina segun rol
        switch ($role) {
            case '1':
                return 'home';
            break;
            case '3':
                return 'costos';
            break;
            case '5':
                return 'orden-produccion';
                break;
            default:
                return '/login';
            break;
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
    }

    public function username() {
        return 'username';
    }

    public function login(Request $request) {

        $this->validateLogin($request);//valida los campos del formulario del login

        if ($this->hasTooManyLoginAttempts($request)) {//si se ha hecho varios intentos se bloquea por 1 minuto

            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }


        $user = $request->username;//obtener el username
        $queryResult = DB::table('users')->where('username', $user)->pluck('id');// consulta para obtener el id del usuario a logearse de existir el username

        if (!$queryResult->isEmpty()) {//si queryResult no esta vacio existe el usuario
            if ($this->attemptLogin($request)) {
                $rol = DB::table('usuario_rol')->where('usuario_id', $queryResult)->pluck('rol_id');
                $request->session()->put('rol', $rol);

                return $this->sendLoginResponse($request);
            }
        }
        return $this->sendFailedLoginResponse($request);
    }

    public function showLoginForm()//para no afectar al metodo showLoginForm del trait AuthenticatesUsers, el metodo debe de sobre escribirse en el controlador
    {
        return view('auth.login');// envia variable al MOD
    }
}
