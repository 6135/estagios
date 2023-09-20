<?php

namespace App\Http\Controllers\Auth;

use App\Http\Middleware\LogAccess;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\PasswordChangeRequest;
use App\Http\Requests\PasswordResetRequest;
use App\Http\Requests\RegisterCompanyRequest;
use App\Mail\ConfirmationMail;
use App\Mail\PasswordResetMail;
use App\Models\Docente;
use App\Models\Mensagem;
use App\Models\NaoAluno;
use App\Models\PapelUtilizador;
use App\Models\Recetor;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Adldap\Laravel\Facades\Adldap;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

//models
use App\Models\AccessLog;
use App\Models\Utilizador;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

/**
 * @suppress php1413
 * @suppress php0416
 */
class Authentication extends Controller
{


    /**
     * Login page
     */
    public function loginView()
    {
        return view('auth.login');
    }
    /**
     * Handles app authentication, split into two fazes, first checks if user is in the database, if not, checks if user is in LDAP, if so, creates user in database and authenticates.
     * @param string $email 
     * @param string $password unhashed password
     */
    public function loginPost(LoginRequest $request): string|bool
    {
        $validatedRequest = $request->validated();
        $email = $validatedRequest['email'];
        $password = $validatedRequest['password'];
        /**
         * when user authenticates the data saved in the session is the active role, all the roles, the user object.
         */
        $al = new AccessLog(
            [
                'ipaddr' => $request->ip(),
                'status' => 'OK',
                'acao' => 'LOGIN',
                'detalhes' => 'User is trying to login with username: ' . $email . ' and ip: ' . $request->ip(),
                'data' => Carbon::now(),
            ]
        );
        //check if user exists 
        if (Utilizador::where(Utilizador::EMAIL, $email)->exists())
            $al->utilizador_email = $email;

        $al->save();


        /**
         * Check if user is from DEI, if so, remove @dei.uc.pt and set ldap to 1
         * @var int $ldap
         */
        $ldap = 0;
        if (strpos($email, 'dei.uc.pt') !== false) {
            $ldap = 1;
            $email = explode('@', $email)[0];
        }

        switch ($ldap) {
            case 1:
                $result = $this->ldapLogin($email, $password, $al);
                break;
            default:
                # Check if user with email exists
                $result = $this->dbLogin($email, $password, $al);
                break;
        }
        if ($result['success'] && $result['user']) {
            //start session

            session_start();
            $user = $result['user'];

            session([
                'login' => $user->email,
                'roles' => $user->papeis,
                'user' => $user,
                'activeRole' => $user->papeis[0]->tipo
            ]);
            $al->successfulLogin($user);

            //if user is a student and has not filled out his details first (name, number, etc) no Aluno object will exists, so redirect to a page where student can fill those details
            if ($user->papeis[0]->tipo == PapelUtilizador::Aluno && $user->aluno == null) {
                return json_encode([
                    'success' => true,
                    'message' => $result['message'],
                    'redirect' => route('aluno.dados.editar.get')
                ]);
            }

            return json_encode([
                'success' => true,
                'message' => $result['message'],
                'redirect' => route('home')
            ]);
        } else
            return json_encode([
                'success' => false,
                'message' => $result['message'],
                'redirect' => false
            ]);
    }

    /**
     * 
     */
    public static function verifyLdapValidity($username)
    {
        Adldap::connect();
        $adldapAttempt = Adldap::search()->where('uid', '=', $username)->get();
        //        Log::debug('Verify Validity: '.$adldapAttempt." ".count($adldapAttempt));
        return count($adldapAttempt) == 1;

    }

    /**
     *  Function to switch active role of use which is stored in the sessions profile field. Function uses GET and redirects to the dashboard
     * @param Request $request
     * @param $role
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|string
     */
    public function switchRole(Request $request, $role = "")
    {
        /**
         * check if user has the request role, if so, set active role to that role
         */
        $user = session('user');
        if ($user->papeis()->where(PapelUtilizador::TIPO, $role)->exists()) {
            session(['activeRole' => $role]);
            //echo json_encode(['success' => true, 'message' => __('auth.role.switch.success')]);
            return redirect()->route('home');
        }
        return json_encode(['success' => false, 'message' => __('auth.role.switch.error')]);
    }

    /**
     * Function to assign a role to a user by their ID, can only be ran by users with admin role. Admins can't remove eachother. Recieves parameter with # value of role to give.
     * This is a POST or GET function
     * @param Request $request
     * @param $role
     * @return string|\Symfony\Component\HttpFoundation\Response|void|null|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|bool
     */
    public function assignRole(Request $request, $role = 0, $id = 0)
    {

    }

    /**
     * Function to try ldap login, if successfull, retrieves user from database, if not, creates it.
     * @param string $email 
     * @param string $password 
     * @param AccessLog $al
     */
    public function ldapLogin(string $email, string $password, AccessLog $al): array
    {
        $adldapStudent = Adldap::auth()->attempt('uid=' . $email . ',ou=student,ou=people,dc=dei,dc=uc,dc=pt', $password);
        $adldapDocente = Adldap::auth()->attempt('uid=' . $email . ',ou=eden,ou=people,dc=dei,dc=uc,dc=pt', $password);
        /**
         * If user is student or docente, check if user exists in database, if not, create it.
         * If user exists, check if user is active, if not, return error.
         * If user is active, perform login.
         * If user is not student or docente, return error.
         */
        if ($adldapStudent || $adldapDocente) {
            $ldapUser = Adldap::search()->select('cn', 'gecos', 'uid')->where('uid', '=', $email)->first();
            $user = Utilizador::where('email', $email)->first();
            /**
             * If user does not exist, create it.
             */
            if (!$user) {
                $user = Utilizador::userFromLdap($email, $ldapUser);
                //if docente, attach docente role, if student, attach student role

            } else /* If user is not active */if (!$user->ativo) {
                $al->failedLogin('User is not active', $email);
                return ['success' => false, 'message' => __('auth.failed'), 'user' => $user];
            } /* If user is active, the proceed with login, add roles acordingly */

            if ($adldapDocente && !$user->hasRole(PapelUtilizador::Docente)) {
                $user->papeis()->attach(PapelUtilizador::where(PapelUtilizador::TIPO, PapelUtilizador::Docente)->first());
                //create nao aluno object 
                $na = new NaoAluno();
                $user->nao_aluno()->save($na);
                $na->docente()->save(new Docente());
            } else if ($adldapStudent && !$user->hasRole(PapelUtilizador::Aluno)) {
                $user->papeis()->attach(PapelUtilizador::where(PapelUtilizador::TIPO, PapelUtilizador::Aluno)->first());
            }
            return ['success' => true, 'message' => __('auth.success'), 'user' => $user];
        } else {
            $al->failedLogin('Wrong credentials', $email);
            return ['success' => false, 'message' => __('auth.failed'), 'user' => null];
        }
    }

    /**
     * 
     */
    public function dbLogin(string $email, string $password, AccessLog $al): array
    {

        //hash to sha1 for legacy users
        $password_legacy = sha1($password);

        $user = Utilizador::active()->where('email', $email)->first();
        $result = [];
        if ($user) {

            /**
             * Check if password is correct using laravel's Hash::check function or legacy sha1 hash 
             * @see https://laravel.com/docs/10.x/hashing
             * 
             */

            if (Hash::check($password, $user->password_hash) || $password_legacy == $user->password_hash) {
                $result = ['success' => true, 'message' => __('auth.success'), 'user' => $user];

            } else if ($user->confirmacao == false) {
                $al->failedLogin('User is not confirmed');
                $result = ['success' => false, 'message' => __('auth.toconfirm'), 'user' => null];
            } else {

                $al->failedLogin('Wrong password');
                $result = ['success' => false, 'message' => __('auth.failed'), 'user' => null];
            }
        } else {
            if ($user && $user->confirmacao == false) {
                $al->failedLogin('User is not confirmed');
                $result = ['success' => false, 'message' => __('auth.toconfirm'), 'user' => null];
            } else {
                $al->failedLogin('User does not exist or is not active');
                $result = ['success' => false, 'message' => __('auth.failed'), 'user' => null];
            }

        }
        return $result;
    }

    /**
     * Function to logout user, destroys session and redirects to login page
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function logout(Request $request)
    {
        $request->session()->invalidate();
        $request->session()->regenerate();
        // $request->session()->flush();
        return redirect('/');
    }
    
    //static logout function
    public static function logoutStatic(Request $request)
    {
        $request->session()->invalidate();
        $request->session()->regenerate();
        // $request->session()->flush();
        return redirect('/');
    }

    /**
     * Register page
     */
    public function register()
    {
        return view('auth.register');
    }

    /** 
     * Function to register a compa
     * @param Request $request
     * 
     */
    public function registerPost(RegisterCompanyRequest $request)
    {
        $validated = $request->validated();
        $email = $validated['email'];
        $al = AccessLog::create([
            AccessLog::IPADDR => $request->ip(),
            AccessLog::STATUS => 'Pending',
            AccessLog::ACAO => 'Register new user',
            AccessLog::DETALHES => 'User ' . $email . ' is trying to register, data: ' . json_encode($request->except(['password', 'password_confirmation'])),
            AccessLog::DATA => Carbon::now()
        ]);

        //check if user already exists
        $user = Utilizador::where('email', $email)->first();
        if ($user) {
            return json_encode(['success' => false, 'message' => __('auth.register.notunique')]);
        }

        $user = new Utilizador();
        $user->email = $email;
        $user->password_hash = Hash::make($request->password);
        /**
         * Generate confirmation hash, encodes confirmation type with hash::make to indicate that this is a company
         * @see https://laravel.com/docs/8.x/helpers#method-str-random
         * @see https://laravel.com/docs/8.x/helpers#method-hash
         * base64_encode makes it browser friendly. 
         */
        $user->confirmacao_hash = base64_encode(Str::random(256) . ':::' . Hash::make('Empresa'));
        $user->nome = "Placeholder";
        $user->nome_curto = "Placeholder";
        $user->save();
        $nao_aluno = new NaoAluno();
        $nao_aluno->utilizador_email = $email;
        $nao_aluno->save();

        //send email to user with confirmation link
        self::sendConfirmationEmail($user);

        //new log from $al
        AccessLog::create([
            AccessLog::IPADDR => $al->ipaddr,
            AccessLog::STATUS => 'Success',
            AccessLog::ACAO => $al->acao,
            AccessLog::DETALHES => 'User ' . $request->email . ' registered successfully',
            AccessLog::DATA => Carbon::now()
        ]);

        return json_encode(['success' => true, 'message' => __('auth.register.success')]);

    }

    public function validateEmail(Request $request)
    {
        $email = $request->input('email');
        $query = Utilizador::where(Utilizador::EMAIL, $email)->get();
        if (count($query) == 1) {
            return response()->json(
                array(
                    'success' => false,
                )
            );
        }
        return response()->json(
            array(
                'success' => true,
            )
        );
    }

    /**
     * Function to send confirmation email to user
     * @param Utilizador $user 
     */
    public static function sendConfirmationEmail(Utilizador $user)
    {
        $message = new Mensagem();
        $message->assunto = __('static.emails.account.confirmation.subject');
        $message->mensagem = __('static.emails.account.confirmation.body')." Link: ". route('confirm.email', $user->confirmacao_hash);
        $message->enviada = Carbon::now();
        $message->save();
        $url = route('confirm.email', $user->confirmacao_hash);

        $recetor = new Recetor();
        $recetor->mensagem_id = $message->id;
        $recetor->utilizador_email = $user->email;


        Mail::to($user->email)->queue(new ConfirmationMail($url));
    }

    /**
     * 
     * Function to confirm email, recieves hash as parameter
     * @param Request $request
     * @param string $hash
     * @return mixed 
     * 
     */
    public function confirmEmail(Request $request, string $hash)
    {
        
        //TODO: Ask for more details about company
        self::logoutStatic($request);
        $user = Utilizador::where(Utilizador::CONFIRMACAO_HASH, $hash)->first();
        // dd($hash);
        
        $hash = base64_decode($hash);
        if ($user && !$user->confirmacao) {
            $explodeHash = explode(':::', $hash);
            if(Hash::check('Empresa',$explodeHash[1])){
                return view('auth.company_data', ['user' => $user]);
            }
            if(Hash::check('Gestor',$explodeHash[1])){
                return view('auth.gestor_data', ['user' => $user]);
            }
            if(Hash::check('RepLegal',$explodeHash[1])){
                return view('auth.rep_data', ['user' => $user]);
            }
            if(Hash::check('Colab',$explodeHash[1])){
                return view('auth.colab_data', ['user' => $user]);
            }
        }
        return ['success' => false];

    }

    /**
     * 
     * Function to get details, recieves hash as parameter
     * @param Request $request
     * @param string $hash
     * @return mixed 
     * 
     */
    public function detailsEmail(Request $request, string $hash)
    {
        
        self::logoutStatic($request);
        $user = Utilizador::where(Utilizador::DADOS_ADICIONAIS_HASH, $hash)->first();
        // dd($hash);
        
        if ($user && $user->confirmacao) {
            $hash = base64_decode($hash);
            $explodeHash = explode(':::', $hash);
            $types = json_decode($explodeHash[1]);
            //json decode
            $dataToAdd = [];
            foreach($types as $key => $value){
                $dataToAdd[$value] = true;
    
            }
            return view('auth.details', ['user' => $user, 'dataToAdd' => $dataToAdd]);
        }
        return ['success' => false];

    }
    /**
     * Decodes details hash and returns array of types of details to add
     * @param string $hash
     * @return array
     * 
     */
    public static function decodeDetailsHash(string $hash) : array{
        $hash = base64_decode($hash);
        $explodeHash = explode(':::', $hash);
        $types = json_decode($explodeHash[1]);
        return $types;
    }

    /**
     * Resend confirmation email. Recieves email as parameter
     * @param Request $request
     */
    public function resendConfirmationEmail(Request $request)
    {
        $user = Utilizador::where('email', $request->email)->first();
        if ($user) {
            $this->sendConfirmationEmail($user);
            echo json_encode(['success' => true, 'message' => __('auth.register.resend.success')]);
            return __('auth.register.resend.success');
        } else {
            echo json_encode(['success' => false, 'message' => __('auth.register.resend.error')]);
            return __('auth.register.resend.error');
        }
    }

    /**
     * Reset password request function, exclude ldap users
     */
    public function requestPasswordReset(Request $request)
    {
        //create a password request hash
        AccessLog::create([
            AccessLog::IPADDR => $request->ip(),
            AccessLog::STATUS => 'Pending',
            AccessLog::ACAO => 'Request password reset',
            AccessLog::DETALHES => 'User ' . $request->email . ' is trying to reset password'
        ]);

        $hash = Str::random(512);
        $user = Utilizador::where('email', $request->email)->first();
        if (is_null($user->password_hash) && is_null($user->confirmacao_hash)) {
            //user is ldap user
            echo json_encode(['success' => false, 'message' => __('auth.reset.error')]);
            return __('auth.reset.error');
        }
        if ($user) {
            $user->password_reset_hash = $hash;
            $user->save();
            $this->sendPasswordResetEmail($user);
            echo json_encode(['success' => true, 'message' => __('auth.reset.success')]);
            return __('auth.reset.success');
        } else {
            echo json_encode(['success' => false, 'message' => __('auth.reset.error')]);
            return __('auth.reset.error');
        }
    }

    /**
     * Function to send password reset email
     * @param Utilizador $user 
     */
    private function sendPasswordResetEmail(Utilizador $user)
    {
        $url = url('/reset/' . $user->password_reset_hash);
        $data = [
            'content' => __('auth.reset.email.content'),
            'nome' => $user->nome,
            'action' => $url,
        ];
        Mail::to($user->email)->send(new PasswordResetMail($data));
    }

    /**
     * Function to reset password
     * @param Request $request 
     */
    public function resetPassword(PasswordResetRequest $request)
    {
        $user = Utilizador::where('password_reset_hash', $request->token)->first();
        if ($user) {
            $user->password_hash = Hash::make($request->password);
            $user->password_reset_hash = null;
            $user->save();
            echo json_encode(['success' => true, 'message' => __('auth.reset.success')]);
            return __('auth.reset.success');
        } else {
            echo json_encode(['success' => false, 'message' => __('auth.reset.error')]);
            return __('auth.reset.error');
        }
    }

    /**
     * Change password
     */
    public function changePassword(PasswordChangeRequest $request)
    {
        AccessLog::create([
            AccessLog::IPADDR => $request->ip(),
            AccessLog::STATUS => 'Pending',
            AccessLog::ACAO => 'Change password',
            AccessLog::DETALHES => 'User ' . $request->email . ' is trying to change password'
        ]);

        if (session()->has('user')) {
            $user = Utilizador::find(session()->get('user')->id);
            if ($user && Hash::check($request->old_password, $user->password_hash)) {
                $user->password_hash = Hash::make($request->password);
                $user->save();
                echo json_encode(['success' => true, 'message' => __('auth.change.success')]);
                return __('auth.change.success');
            } else {
                echo json_encode(['success' => false, 'message' => __('auth.change.error')]);
                return __('auth.change.error');
            }
        } else {
            return redirect('/');
        }
    }

    /**
     * static Function to check if user is logged in
     */
    public static function check(): bool
    {
        if (session()->has('user')) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Static function to check if user is admin
     */
    public static function checkAdmin(): bool
    {
        if (session()->has('user')) {
            $user = Utilizador::find(session()->get('user')->id);
            if ($user->hasRole(PapelUtilizador::Admin)) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * Static function to check if user is docente
     */
    public static function checkDocente(): bool
    {
        if (session()->has('user')) {
            $user = Utilizador::find(session()->get('user')->id);
            if ($user->hasRole(PapelUtilizador::Docente)) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * Static function to check if user is aluno
     */
    public static function checkAluno(): bool
    {
        if (session()->has('user')) {
            $user = Utilizador::find(session()->get('user')->id);
            if ($user->hasRole(PapelUtilizador::Aluno)) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * Static function to check if user is Gestor
     */
    public static function checkGestor(): bool
    {
        if (session()->has('user')) {
            $user = Utilizador::find(session()->get('user')->id);
            if ($user->hasRole(PapelUtilizador::Gestor)) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * Static function to check if user is GestorPlataforma
     */
    public static function checkGestorPlataforma(): bool
    {
        if (session()->has('user')) {
            $user = Utilizador::find(session()->get('user')->id);
            if ($user->hasRole(PapelUtilizador::GestorPlataforma)) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * Static function to check if user is EmpresaColab
     */
    public static function checkEmpresaColab(): bool
    {
        if (session()->has('user')) {
            $user = Utilizador::find(session()->get('user')->id);
            if ($user->hasRole(PapelUtilizador::EmpresaColab)) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * Static function to check if user is EmpresaRepLegal
     */
    public static function checkEmpresaRepLegal(): bool
    {
        if (session()->has('user')) {
            $user = Utilizador::find(session()->get('user')->id);
            if ($user->hasRole(PapelUtilizador::EmpresaRepLegal)) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * Static function to check if user is Coordenador
     */
    public static function checkCoordenador(): bool
    {
        if (session()->has('user')) {
            $user = Utilizador::find(session()->get('user')->id);
            if ($user->hasRole(PapelUtilizador::Coordenador)) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * Same as the above functions but checks for active role instead
     */
    public static function checkActiveAdmin(): bool
    {
        if (session()->has('user')) {
            $user = Utilizador::find(session()->get('user')->id);
            $activeRole = session()->get('activeRole');
            if ($activeRole && $activeRole == PapelUtilizador::Admin && $user->hasRole(PapelUtilizador::Admin)) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public static function checkActiveDocente(): bool
    {
        if (session()->has('user')) {
            $user = Utilizador::find(session()->get('user')->id);
            $activeRole = session()->get('activeRole');
            if ($activeRole && $activeRole == PapelUtilizador::Docente && $user->hasRole(PapelUtilizador::Docente)) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public static function checkActiveAluno(): bool
    {
        if (session()->has('user')) {
            $user = Utilizador::find(session()->get('user')->id);
            $activeRole = session()->get('activeRole');
            if ($activeRole && $activeRole == PapelUtilizador::Aluno && $user->hasRole(PapelUtilizador::Aluno)) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public static function checkActiveGestor(): bool
    {
        if (session()->has('user')) {
            $user = Utilizador::find(session()->get('user')->id);
            $activeRole = session()->get('activeRole');
            if ($activeRole && $activeRole == PapelUtilizador::Gestor && $user->hasRole(PapelUtilizador::Gestor)) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public static function checkActiveGestorPlataforma(): bool
    {
        if (session()->has('user')) {
            $user = Utilizador::find(session()->get('user')->id);
            $activeRole = session()->get('activeRole');
            if ($activeRole && $activeRole == PapelUtilizador::GestorPlataforma && $user->hasRole(PapelUtilizador::GestorPlataforma)) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public static function checkActiveEmpresaColab(): bool
    {
        if (session()->has('user')) {
            $user = Utilizador::find(session()->get('user')->id);
            $activeRole = session()->get('activeRole');
            if ($activeRole && $activeRole == PapelUtilizador::EmpresaColab && $user->hasRole(PapelUtilizador::EmpresaColab)) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public static function checkActiveEmpresaRepLegal(): bool
    {
        if (session()->has('user')) {
            $user = Utilizador::find(session()->get('user')->id);
            $activeRole = session()->get('activeRole');
            if ($activeRole && $activeRole == PapelUtilizador::EmpresaRepLegal && $user->hasRole(PapelUtilizador::EmpresaRepLegal)) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public static function checkActiveCoordenador(): bool
    {
        if (session()->has('user')) {
            $user = Utilizador::find(session()->get('user')->id);
            $activeRole = session()->get('activeRole');
            if ($activeRole && $activeRole == PapelUtilizador::Coordenador && $user->hasRole(PapelUtilizador::Coordenador)) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public static function getUser(): Utilizador|null
    {
        if (self::check()) {
            return Utilizador::find(session()->get('user')->email);
        } else {
            return null;
        }
    }

    /**
     * @param string $type - The type of hash to generate, must be of values "Empresa", "RepLegal", "Colab", "Gestor"
     */
    public static function generateHash(string $type): string
    {
        return base64_encode(Str::random(256) . ':::' . Hash::make($type));
        
    }

    public static function decodeHashType(string $hash): string
    {
        return explode(':::', base64_decode($hash))[1];
    }
}