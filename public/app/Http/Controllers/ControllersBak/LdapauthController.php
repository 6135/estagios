<?php

namespace App\Http\Controllers;

use App\User;
use App\UserAccessLog;
//use Illuminate\Http\Request;
use Request;
use Adldap\Laravel\Facades\Adldap;

class LdapauthController extends Controller
{
    public function main() {
    }

    public function login(Request $request)
    {
        $connection = Adldap::connect();

        $username = isset($_REQUEST['username']) ? $_REQUEST['username'] : '';
        $password = isset($_REQUEST['password']) ? $_REQUEST['password'] : '';

        $adldapAttempt = Adldap::auth()->attempt('uid=' . $username . ',ou=eden,ou=people,dc=dei,dc=uc,dc=pt', $password);

        if($adldapAttempt) {
            if (!User::where('email', $username)->first()) {
                $user = new User();
                $user->email = $username;
                $user->name = '';
                $user->password = '';
                $user->save();
            }
        }

        $ual = new UserAccessLog();
        $ual->username = $username;
        $ual->ipAddress = Request::ip();

        session()->put('login', '');
        session()->put('profile', '');

        if($adldapAttempt) {
            $ual->status = 'OK';
            $ual->details = 'LdapauthController: Login com sucesso';

            session()->put('login', $username);
            session()->put('profile', 'ldapuser');
        }

        $ual->save();

        echo json_encode(array('success' => $adldapAttempt, 'message' => 'Verifique o Username e Password'));
    }
}
