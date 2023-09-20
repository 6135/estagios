<?php
use App\Models\AccessLog;
use App\Models\Pais;
use Illuminate\Support\Carbon;
use Io238\ISOCountries\Models\Country;
use PhpParser\Lexer\TokenEmulator\NullsafeTokenEmulator;






// /*
// |--------------------------------------------------------------------------
// | Web Routes
// |--------------------------------------------------------------------------
// |
// | Here is where you can register web routes for your application. These
// | routes are loaded by the RouteServiceProvider within a group which
// | contains the "web" middleware group. Now create something great!
// |
// */

Route::get('/all', function () {
    dd(Countries::getList(App::currentLocale(), 'php'));
});

Route::get('/one', function () {
    dd(Countries::getOne('PT', 'pt'));
});

Route::get('/ct/{locale?}', function ($locale = null) {
    if ($locale == null) {
        $locale = App::currentLocale();
    }
    //getCountriesName
    $countries = Pais::all();
    $parsed_countries = [];
    foreach ($countries as $country) {
        $parsed_countries[] =
            [
                'name' => Countries::getOne($country->codigo_iso, $locale),
                'code' => $country->codigo_iso,
                'phone_ext' => $country->codigo_tel,
                'other' => Country::find($country->codigo_iso)->name
            ];


        // $country->save();
    }
    dd(array_slice($parsed_countries, 0, 20));
});

Route::get('/ci/{country_iso?}', function ($country_iso = null) {
    if ($country_iso == null) {
        $country_iso = 'PT';
    }
    //getCountriesName
    $countries = Pais::find($country_iso);
    dd($countries->toJSON());
});

// use Adldap\Laravel\Facades\Adldap;

// use App\Http\Controllers\Auth\Authentication;
// use App\Http\Controllers\HomeController;
// use App\Http\Controllers\EmpresaController;
// use App\Mail\TestMail;
// use App\Role;
// use App\Scopes\ColaboradorInternoScope;
// use Illuminate\Http\Request;

// $empraSet = Role::Empresa . ',' . Role::EmpresaColaborador . ',' . Role::EmpresaMembro . ',' . Role::EmpresaRepresentanteLegal;
// $empresaLowPermSet = Role::EmpresaColaborador . ',' . Role::EmpresaColaborador;
// $empresaHighPermSet = Role::Empresa . ',' . Role::EmpresaRepresentanteLegal;
// $ldapSet = Role::Ldap . ',' . Role::Docente . ',' . Role::Aluno;
// $internalSet = Role::Ldap . ',' . Role::Docente . ',' . Role::Aluno . ',' . Role::Admin;
// /*Route::get('/', function () {
// return view('welcome');
// });*/


// /*
// Home controllers 
// */
// Route::get('/', [HomeController::class, 'index'])->name('home'); // Dashboard
// Route::get('cursos', [HomeController::class, 'cursos'])->name('cursos');
// //get information and calendar specific to each course
// Route::get('curso/{curso}', [HomeController::class, 'curso'])->name('curso');
// // Route::get('testEvents', [HomeController::class,'testEvents'])->name('testEvents');

// Route::get('login/{token?}', 'HomeController@loginpage')->name('login');
// Route::get('/thelogin', 'HomeController@login')->name('thelogin');
// Route::get('/login/recover', [HomeController::class, 'loginrecover'])->name('loginrecover');
// Route::post('/login/recover', [HomeController::class, 'loginrecover'])->name('loginrecover');
// Route::get('logout', 'HomeController@endSession')->name('logout');

// //Switch active role route
// Route::get('switchrole/{role?}', 'Auth\Authentication@switchRole')->name('switchrole')->middleware('checklogin');
// // Route::post('switchrole/{role?}', 'Auth\Authentication@switchRole')->name('switchrole')->middleware('checklogin');
// //Assign role to user routes
// Route::get('assignrole/{role?}/{id}', 'Auth\Authentication@assignRole')->name('assignroleGET')->middleware('checklogin')->middleware('checkpermision:' . Role::Admin);
// // Route::post('assignrole', 'Auth\Authentication@assignRole')->name('assignrolePOST')->middleware('checklogin');

// Route::get('/dashboard', 'HomeController@dashboard')->name('CompanyDashboard')->middleware('checklogin');

// Route::get('/notloggedin/', function () {
//     return view('notloggedin');
// });

// Route::get('/indevelopment', 'HomeController@indevelopment')->name('indevelopment');
// Route::get('/message/checkmail', 'HomeController@messagecheckmail');

// Route::get('empresa/detalhes/{id}', 'HomeController@showViewEmpresasdetalhes')->middleware('checklogin')
//     ->middleware('checkpermision:' . $empraSet);
// Route::get('/dadosempresa', 'HomeController@showViewDadosEmpresa')->name('CompanyData')->middleware('checklogin')
//     ->middleware('checkpermision:' . $empresaHighPermSet);
// Route::get('/dadosempresa/save', 'HomeController@dadosEmpresaSave')->middleware('checklogin')
//     ->middleware('checkpermision:' . $empresaHighPermSet);
// Route::post('/dadosempresa/save', 'HomeController@dadosEmpresaSave')->middleware('checklogin')
//     ->middleware('checkpermision:' . $empresaHighPermSet);

// /* End home controller */

// /*
// Estagio controllers
// */
// Route::get('estagios/lista', 'EstagioController@showViewLista')->name('IntershipList')->middleware('checklogin');

// Route::get('estagios/lista/json', 'EstagioController@tabledataEstagios')->name('estagiosJSON')->middleware('checklogin');
// //------------------------------candidate routes --------------------------------
// Route::get('estagios/candidatos/lista/json/{id?}', 'EstagioController@verDetalheCandidatos')->name('estagiosCandidatesJSON')->middleware('checklogin');
// Route::get('estagios/candidatos/lista/{id?}', 'EstagioController@verDetalheCandidatosTable')->name('estagiosCandidates')->middleware('checklogin');
// Route::get('estagios/candidatos/gerir/{idEstagio?}/{idCandidato?}/{apply?}', 'EstagioController@gerirCandidato')->name('gerirCandidato')->middleware('checklogin');
// //--------------------------------------------------------------------------------

// Route::get('estagios/propostas/lista', 'EstagioController@propostasLista')->middleware('checklogin');
// Route::get('estagios/propostas/lista/json', 'EstagioController@propostasTabledata');
// Route::get('estagios/propostas/edita/{id}', 'EstagioController@propostasEdita')->middleware('checklogin');
// Route::get('estagios/propostas/detalhes/{idEstagio}', 'EstagioController@propostasDetalhes')->name('verDetalhes')->middleware('checklogin');

// //--------------------------------------------------Gui--------------------------------------------------\\
// Route::get('estagios/propostas/nova/{id?}', 'EstagioController@propostasNova')->name('newProposta')->middleware('checklogin');
// Route::post('estagios/propostas/submit', 'EstagioController@sumbitEstagio')->middleware('checklogin');

// Route::get('estagios/propostas/editar/{id?}', 'EstagioController@propostasNova')->name('editarProposta')->middleware('checklogin');

// Route::get('estagios/propostas/{id}', 'EstagioController@verPropostaEstagio')->middleware('checklogin');

// Route::get('estagios/comparar/{id}/{idcomparador?}', 'EstagioController@compararVersoes')->name('compararVersoes')->middleware('checklogin');
// Route::get('estagios/lista/versoes/json/{id?}', 'EstagioController@compararVersoesData')->name('versionData');
// //--------------------------------------------------/Gui--------------------------------------------------\\

// /* End Estagio controllers */

// /*
// Empresa controllers
// */


// Route::get('listaempresas', 'EmpresaController@tabledata');

// Route::post('empresa/novocolaborador', 'EmpresaController@empresaNovoColaborador')->middleware('checklogin');
// Route::get('empresa/novocolaborador', 'EmpresaController@empresaNovoColaborador')->middleware('checklogin');

// Route::post('empresa/novocolaboradorexterno', 'EmpresaController@empresaNovoColaboradorExterno')->middleware('checklogin');
// Route::get('empresa/novocolaboradorexterno', 'EmpresaController@empresaNovoColaboradorExterno')->name('novoColabExterno')->middleware('checklogin');

// Route::post('empresa/colaboradorUpdateCV', 'EmpresaController@colaboradorUpdateCV')->middleware('checklogin');
// Route::get('empresa/colaboradorUpdateCV', 'EmpresaController@colaboradorUpdateCV')->middleware('checklogin');

// Route::get('empresa/novorepresentantelegal/', 'EmpresaController@novorepresentantelegal')->middleware('checklogin');
// Route::post('empresa/novorepresentantelegal/', 'EmpresaController@novorepresentantelegal')->middleware('checklogin');

// Route::post('empresa/getCV', 'EmpresaController@getColaboradorCV')->middleware('checklogin');
// Route::post('empresa/colaboradorcv', [EmpresaController::class, 'colaboradorcv'])->middleware('checklogin');

// Route::get('/empresa/registopublico', 'EmpresaController@registoPublico')->name('RegistoEmpresa'); //1St step
// Route::get('/empresa/registopublico-fase2/{id}', 'EmpresaController@registoPublicoFase2');
// Route::get('/empresa/registopublico-fase2-save', 'EmpresaController@registoPublicoFase2Save');
// Route::post('/empresa/registopublico-fase2-save', 'EmpresaController@registoPublicoFase2Save');
// Route::post('/empresa/registopublico-fase22-save', 'EmpresaController@registoPublicoFase22Save');

// Route::post('/empresa/novoregisto', 'EmpresaController@novoregisto'); //2nd step
// Route::get('/empresa/novoregisto', 'EmpresaController@novoregisto'); //2nd step

// //COLABORADORES DE EMPRESAS

// Route::get('/colaborador/definirpassword/{id}', 'EmpresaController@colaboradorSetNewPassView'); //VIEW
// Route::post('/colaborador/setpass', 'EmpresaController@colaboradorSetNewPassService'); //SERVICE
// Route::post('/colaborador/activacao', 'EmpresaController@colaboradorActivacaoService')->middleware('checklogin'); //SERVICE
// Route::post('/colaborador/recuperapassword', 'EmpresaController@colaboradorRecuperacaoPasswordService')->middleware('checklogin'); //SERVICE

// //REPRESENTANTES LEGAIS DE EMPRESAS

// Route::get('/representante/definirpassword/{id}', 'EmpresaController@representanteSetNewPassView'); //VIEW
// Route::post('/representante/setpass', 'EmpresaController@representanteSetNewPassService'); //SERVICE
// Route::post('/representante/activacao', 'EmpresaController@representanteActivacaoService')->middleware('checklogin'); //SERVICE
// Route::post('/representante/recuperapassword', 'EmpresaController@representanteRecuperacaoPasswordService')->middleware('checklogin'); //SERVICE
// Route::get('/representante/recuperapassword', 'EmpresaController@representanteRecuperacaoPasswordService')->middleware('checklogin'); //SERVICE

// //EMPRESAS
// Route::get('/empresa/definirpassword/{id}', 'EmpresaController@empresaSetNewPassView'); //VIEW
// Route::post('/empresa/setpass', 'EmpresaController@empresaSetNewPassService'); //SERVICE

// /* End Empresa controllers */

// /*
// Docente controllers
// */
// Route::get('docentes/lista', 'DocenteController@lista')->middleware('checklogin');
// Route::get('docentes/lista/json', 'DocenteController@tabledata');
// Route::get('docentes/edita/{id}', 'DocenteController@showForm')->middleware('checklogin');
// // Route::post('docentes/update/{id}', 'DocenteController@update')->name('docentes.update');

// // Route::get('docentes/select2List', 'DocenteController@select2List')->middleware('CheckSession');
// // Route::post('docentes/select2List', 'DocenteController@select2List')->middleware('CheckSession');
// /* End Docente controllers */

// /*
// Admin controllers
// */
// Route::get('listausers', 'AdminController@tabledata')->middleware('checklogin')->middleware('checkpermision:' . Role::Admin);
// Route::get('user/setadmin/{id}', 'AdminController@setadmin')->middleware('checklogin')->middleware('checkpermision:' . Role::Admin);
// Route::get('estagios/json', 'AdminController@tabledataEstagios')->middleware('checklogin')->middleware('checkpermision:' . Role::Admin);
// Route::get('estagios/{idperiodo}/json/', 'AdminController@tabledataEstagios')->middleware('checklogin')->middleware('checkpermision:' . Role::Admin);
// /* End Admin controllers */

// /*
// Aluno controllers
// */
// //--------------------------------------------------ALUNOS--------------------------------------------------
// Route::get('/aluno/dados', 'AlunoController@dados')->name('alunoDados')->middleware('checklogin')->middleware('checkpermision:' . $internalSet);
// Route::post('/aluno/dados/edita/{studentID?}', 'AlunoController@editDados')->name('alunoDadosEditaP')->middleware('checklogin')->middleware('checkpermision:' . $internalSet);
// Route::get('/aluno/propostas/{curso?}', 'AlunoController@tableDataPropostasEstagio')->name('alunoPropostas')->middleware('checklogin');
// Route::post('/aluno/selectestagios/', 'AlunoController@propostasEstagioPicked')->middleware('checklogin');
// Route::get('/aluno/reorder/', 'AlunoController@reorderProposals')->middleware('checklogin');
// // Route::get('/aluno/dados/edita/{studentID?}', 'AlunoController@editDados')->name('alunoDadosEditaG');


// /* End Aluno controllers */

// /* 
// Temporary Routes
// */

// /* End Temporary Routes */

// /* 
// RESTful Routes 
// */
// Route::get('/queries/areas/{name}', 'EstagioController@getOpcaoTematica');
// //dump user roles in json
// Route::get('roles/json', 'Auth\Authentication@dumpRolesJson')->middleware('checklogin');
// /* End RESTful Routes */

// /*
// Standalone Routes (Closures, development, etc)
// */
// Route::post('/nova/reuniao', 'MiscController@newMeeting')->name('novaReuniao')->middleware('checklogin')->middleware('checkpermision:' . $internalSet);

// Route::get('/token', function () {
//     return csrf_token();
// });

// //Route with closure that gets all estagios that are from companies (company id is > 1) and return them with associatedEmails(). Print as table
// // Route::get('estagios/empresas/emails', function () {
// //     $estagios = \App\Estagio::where('empresa_idempresa', '>', 1)->get();
// //     //filter out those estagios with no alunos
// //     $estagios = $estagios->filter(function ($estagio) {
// //         return $estagio->alunos->count() > 0;
// //     }
// //     );
// //     $estagios->each(function ($estagio) {
// //         $estagio->emails = $estagio->associatedEmails();
// //     }
// //     );
// //     // $estagios = $estagios->select('idestagio','tituloestagio');
// //     //map each estagio in estagios to a new array with only the idestagio and tituloestagio and emails
// //     $estagios = $estagios->map(function ($estagio) {
// //         return [
// //             'idestagio' => $estagio->idestagio,
// //             'tituloestagio' => $estagio->tituloestagio,
// //             'emails' => $estagio->emails
// //         ];
// //     }
// //     );
// //     return view('metronicv815.layout.partials.simpleEmailTable', compact('estagios'));
// // })->middleware('checklogin');

// //ROute with closure for stuff
// // Route::get('estagios/dei/emails', function () {
// //     $estagios = \App\Estagio::where('empresa_idempresa', 1)->get();
// //     //filter out those estagios with no alunos
// //     $estagios = $estagios->filter(function ($estagio) {
// //         return $estagio->alunos->count() > 0;
// //     }
// //     );
// //     $estagios->each(function ($estagio) {
// //         $estagio->emails = $estagio->associatedEmails();
// //     }
// //     );
// //     // $estagios = $estagios->select('idestagio','tituloestagio');
// //     //map each estagio in estagios to a new array with only the idestagio and tituloestagio and emails excluding the first email, without slice()
// //     $estagios = $estagios->map(function ($estagio) {
// //         return [
// //             'idestagio' => $estagio->idestagio,
// //             'tituloestagio' => $estagio->tituloestagio,
// //             'emails' => array_slice($estagio->emails, 1)
// //         ];
// //     }
// //     );
// //     //flatten the array of emails
// //     // $estagios = $estagios->flatten(1);

// //     return view('metronicv815.layout.partials.simpleEmailTable', compact('estagios'));
// // })->middleware('checklogin');


// // Route with string to auth as docente via only the name
// /**
//  * @suppress PHP0416
//  */
// Route::get('auth/docente/{name}/{token?}', function ($name, $token = null) {

//     if ($token && $token == 'f8yhUpMbnH') {
//         $profile = Role::Docente;
//         $user = Authentication::userFromLDAP($name);
//         $docente = \App\Docente::query()->firstOrNew(
//             ['logindocente' => $name]
//         );
//         session()->put('id', $user[0]->id);
//         session()->put('roles', $user[0]->roles);


//         $ual = new \App\UserAccessLog();
//         $ual->username = $name;
//         $ual->ipAddress = "";
//         $ual->save();


//         if ($profile) {
//             session()->put('nome', ($user[1][0]->gecos)[0]);
//             session()->put('login', $name);
//             session()->put('profile', $profile);
//         }

//         return redirect()->route('CompanyDashboard');
//     } else
//         abort(404);
// })->middleware('checklogin');

// // Route with string to auth as colaborador of empresa via only the name
// Route::get('auth/colaborador/{name}/{token?}', function ($name, $token = null) {

//     if ($token && $token == 'f8yhUpMbnH') {
//         $profile = Role::EmpresaColaborador;
//         $colaborador = \App\EmpresaColaborador::allColab()->firstOrNew(
//             ['email' => $name]
//         );
//         session()->put('id', $colaborador->id);

//         $ual = new \App\UserAccessLog();
//         $ual->username = $name;
//         $ual->ipAddress = "";
//         $ual->save();

//         if ($profile) {
//             session()->put('id', $colaborador->empresaObj->idempresa);
//             session()->put('nome', ($colaborador->nome)[0]);
//             session()->put('login', $name);
//             session()->put('profile', $profile);
//         }

//         return redirect()->route('CompanyDashboard');
//     }
// })->middleware('checklogin');

// //create users and assign them roles from docente and aluno gotten from ldap
// Route::get('create/users/{token?}', function ($token = null) { //create/users/f8yhUpMbnH
//     // dd(env('DB_USERNAME'));
//     if ($token && $token = 'f8yhUpMbnH') {
//         if (count(Role::all()) == 0) {
//             //create if they dont already exist in database
//             Role::firstOrCreate(['name' => 'Admin'], ['permission' => 1]);
//             Role::firstOrCreate(['name' => 'Empresa'], ['permission' => 2]);
//             Role::firstOrCreate(['name' => 'Undefined'], ['permission' => 0]);
//             Role::firstOrCreate(['name' => 'EmpresaMembro'], ['permission' => 3]);
//             Role::firstOrCreate(['name' => 'EmpresaColaborador'], ['permission' => 5]);
//             Role::firstOrCreate(['name' => 'EmpresaRepresentanteLegal'], ['permission' => 6]);
//             Role::firstOrCreate(['name' => 'Aluno'], ['permission' => 7]);
//             Role::firstOrCreate(['name' => 'Docente'], ['permission' => 8]);
//             Role::firstOrCreate(['name' => 'Ldap'], ['permission' => 4]);
//         }
//         // Authentication::catchAllDocentes();
//         // Authentication::catchAllAlunos();
//         Authentication::assignRoles();
//         return "Done";
//     } else
//         abort(403);
// });

// //attach roles to users that don't the proper role yet. If they already have the role, do nothing
// // Route::get('attach/roles', function () {
// //     $users = \App\User::all();
// //     $users->each(function ($user) {
// //         if ($user->docente()->count() > 0 && !$user->hasRoleByName("Docente")) {
// //             $user->assignRoleByName("Docente");
// //         }
// //         if ($user->aluno()->count() > 0 && !$user->hasRoleByName("Aluno")) {
// //             $user->assignRoleByName("Aluno");
// //         }
// //     }
// //     );
// //     return 'done';
// // });

// // //if user has role docente and student, remove student role
// // Route::get('remove/student/role', function () {
// //     $users = \App\User::all();
// //     $users->each(function ($user) {
// //         if ($user->hasRoleByName("Docente") && $user->hasRoleByName("Aluno")) {
// //             $user->removeRoleByName("Aluno");
// //         }
// //     }
// //     );
// //     return 'done';
// // });

// // //create a user for EmpresaColaborador and assign it the role
// // Route::get('attach/colaborador/role', function () {
// //     $colaboradores = \App\EmpresaColaborador::allColab();
// //     $colaboradores->each(function ($colaborador) {
// //         //Check if it already exists in users with Name and email
// //         $user = \App\User::query()->firstOrNew(
// //             ['email' => $colaborador->email]
// //         );

// //         //assign the password, accountConfirmation and accountConfirmed
// //         $user->name = $colaborador->nome;
// //         $user->accountConfirmHash = $colaborador->accountConfirmHash;
// //         $user->accountConfirmation = $colaborador->accountConfirmation;
// //         $user->password = $colaborador->password;
// //         $user->accountConfirmed = $colaborador->accountConfirmed;
// //         $user->save();
// //         // dd($user,$colaborador);
// //         if(!$user->hasRoleByName("EmpresaColaborador"))
// //             $user->assignRoleByName("EmpresaColaborador");

// //     }
// //     );
// //     return 'done';
// // });

// // //create a user for EmpresaRepresentante and assign it the role
// // Route::get('attach/representante/role', function () {
// //     $representantes = \App\EmpresaRepresentante::all();
// //     $representantes->each(function ($representante) {
// //         //Check if it already exists in users with Name and email{
// //         $user = \App\User::query()->firstOrNew(
// //             ['email' => $representante->email]
// //         );
// //         //assign the password, accountConfirmation and accountConfirmed
// //         $user->name = $representante->nome;
// //         $user->password = $representante->password;
// //         $user->accountConfirmHash = $representante->accountConfirmHash;
// //         $user->accountConfirmation = $representante->accountConfirmation;
// //         $user->accountConfirmed = $representante->accountConfirmed;
// //         $user->save();
// //         if(!$user->hasRoleByName("EmpresaRepresentante"))
// //             $user->assignRoleByName("EmpresaRepresentante");

// //     }
// //     );
// //     return 'done';
// // });


// // //create a user from Empresa (which represents company) and assign it the role "Empresa"
// // Route::get('attach/empresa/role', function () {
// //     $empresas = \App\Empresa::all();
// //     $empresaUsers = [];
// //     $empresas->each(function ($empresa) use (&$empresaUsers) {

// //         $user = \App\User::query()->firstOrNew(
// //             ['email' => $empresa->emailempresa]
// //         );

// //         if(!$user->exists) {
// //             //assign the password, accountConfirmation and accountConfirmed
// //             $user->name = $empresa->responsavelempresa;
// //             $user->password = $empresa->password;
// //             $user->accountConfirmHash = $empresa->accountConfirmHash;
// //             $user->accountConfirmation = $empresa->accountConfirmation;
// //             $user->accountConfirmed = $empresa->accountConfirmed;
// //             $user->name = mb_convert_encoding($user->name, 'ISO-8859-1', "UTF-8");
// //             $user->save();
// //         }
// //         $user->assignRoleByName("Empresa");
// //     }
// //     );
// //     return 'done';
// // });

// /**
//  * @suppress PHP1413
//  */
// Route::get('/students/validate', function (Request $request) {
//     $email = $request['inputEmailAluno'];
//     if (session()->get('login')) {
//         Adldap::connect();
//         $query = Adldap::search()->where('mail', $email)->get();
//         if (count($query) != 1) {
//             return json_encode(
//                 array(
//                     'valid' => false,
//                 )
//             );
//         } else
//             return json_encode(
//                 array(
//                     'valid' => true,
//                 )
//             );
//     }
//     return json_encode(
//         array(
//             'valid' => false,
//         )
//     );

// });
// /**
//  * @suppress PHP1413
//  */
// Route::get('/students/validate/{inputEmailAluno}', function (Request $request, $inputEmailAluno) {
//     $email = $inputEmailAluno;
//     if (session()->get('login')) {
//         Adldap::connect();
//         $query = Adldap::search()->where('mail', $email)->get();
//         if (count($query) != 1) {
//             return json_encode(
//                 array(
//                     'valid' => false,
//                 )
//             );
//         } else
//             return json_encode(
//                 array(
//                     'valid' => true,
//                 )
//             );
//     }
//     return json_encode(
//         array(
//             'valid' => false,
//         )
//     );

// });
// /**
//  * @suppress PHP1413
//  */
// Route::get('/students/details/{inputEmailAluno}', function (Request $request, $inputEmailAluno) {
//     $email = $inputEmailAluno;
//     if (session()->get('login')) {
//         Adldap::connect();
//         $query = Adldap::search()->where('mail', $email)->get();
//         if (count($query) != 1) {
//             return json_encode(
//                 array(
//                     'valid' => false,
//                     'details' => null,
//                 )
//             );
//         } else
//             return json_encode(
//                 array(
//                     'valid' => true,
//                     'details' => $query->first(),
//                 )
//             );
//     }
//     return json_encode(
//         array(
//             'valid' => false,
//             'details' => null,
//         )
//     );

// })->middleware('checklogin')->middleware('checkpermision:' . Role::Admin . ',' . Role::Docente);
// /* End Standalone Routes */
// /** 
//  * Test routes
//  */
// // load html pages for testing
// Route::get('html', function () {
//     return view('html.index');
// });
// Route::get('html/cursos', function () {
//     return view('html.cursos');
// });


// // Test permission middleware
// Route::get('test/permission', function () {
//     return 'You have permission to access this page';
// })->middleware('checkpermision:' . Role::Admin . ',' . Role::Docente)->middleware('indevelopment');

// //send test email to email from link
// Route::get('test/email/{email}', function ($email) {
//     // dd($email);
//     Mail::queue(new TestMail());
//     return 'done';
// });

// /* End Test Routes */




// // Route::get('estagios/propostas/setperfil/{idestagio}/{idaluno}/{idestado}', 'EstagioController@setPropostaAlunoPerfil')->middleware('checklogin');
// // Route::post('estagios/propostas/setperfil/{idestagio}/{idaluno}/{idestado}', 'EstagioController@setPropostaAlunoPerfil')->middleware('checklogin');

// //Proposta de estágio, envio de dados para guardar em BD:
// // Route::post('estagios/propostas/savedata', 'EstagioController@saveData')->middleware('CheckSession:save');

// // Route::post('estagio/proposta/detalhe/{id}', 'EstagioController@detalhe');
// // Route::get('estagio/proposta/detalhe/{id}', 'EstagioController@detalhe');

// //Muda estado do estagio para submetido, não permite mais alterações
// // Route::get('estagios/setsubmited', 'EstagioController@setsubmited')->middleware('checklogin');
// // Route::post('estagios/setsubmited', 'EstagioController@setsubmited')->middleware('checklogin');



// // Route::get('empresa/orientadores/select2list', 'EmpresaController@orientadoresEmpresaSelect2List');
// // Route::post('empresa/orientadores/select2list', 'EmpresaController@orientadoresEmpresaSelect2List');
// // Route::get('empresa/orientadores/select2listdetail/{id}', 'EmpresaController@orientadoresEmpresaSelect2ListDetail');
// // Route::post('empresa/orientadores/select2listdetail/{id}', 'EmpresaController@orientadoresEmpresaSelect2ListDetail');

// // Route::post('empresa/representantes/select2list/{id}', 'EmpresaController@representantesEmpresaSelect2List');
// // Route::get('empresa/representantes/select2list/{id}', 'EmpresaController@representantesEmpresaSelect2List');

// // Route::post('empresa/representantes/select2list', 'EmpresaController@representantesEmpresaSelect2ListNoId');
// // Route::get('empresa/representantes/select2list', 'EmpresaController@representantesEmpresaSelect2ListNoId');

// // Route::post('empresa/colaboradores/select2list/{id}', 'EmpresaController@colaboradoresEmpresaSelect2List');
// // Route::get('empresa/colaboradores/select2list/{id}', 'EmpresaController@colaboradoresEmpresaSelect2List');

// //Auth::routes();


// //Route::get('/logout', 'HomeController@logout')->name('logout');



// // TESTING


// //QUERIES
// // Route::get('/queries/files', 'QueriesController@index');
// // Route::get('/queries/dashboard', 'QueriesController@dashboard')->middleware('checklogin');
// // Route::get('/queries/lastinserted', 'QueriesController@lastinserted');
// // Route::get('/queries/rpu', 'QueriesController@relatoriosProgressoUltimos');

// // Route::get('/queries/rpua', 'QueriesController@relatoriosProgressoUltimosComAnexo');
// // Route::post('/queries/rpua', 'QueriesController@relatoriosProgressoUltimosComAnexo');

// // Route::get('/queries/ur', 'QueriesController@ultimasReunioes');
// // Route::post('/queries/ur', 'QueriesController@ultimasReunioes');

// // Route::get('/queries/nre', 'QueriesController@numeroReunioesPorEstagio');
// // Route::post('/queries/nre', 'QueriesController@numeroReunioesPorEstagio');

// // Route::get('/queries/common', 'QueriesController@common');

// // Route::get('/queries/info', 'QueriesController@dashboardInfo');
// //Route::get('/queries/nreunioesmes', 'QueriesController@quantidadeReunioesUltimosMeses');
// // Route::get('/queries/rpdownload/{id}', 'QueriesController@downloadRelatorioProgresso');

// //AUX

// //PROFILE::EMPRESAS


// // //--------------------------------------------------SUPERADMIN--------------------------------------------------
// // Route::group(["middleware" => ['\App\Http\Middleware\SecureSuperUserMiddleware', '\App\Http\Middleware\CheckLogin']], function () {
// //     Route::get('/su/listaempresasnovas', 'SuperAdminController@listaEmpresasNovas');
// //     Route::get('/su/stats', 'SuperAdminController@stats');
// //     Route::get('/su/listaestagiosempresa/{id}', 'SuperAdminController@listaEstagiosEmpresa');
// //     Route::get('/su/listaestagios', 'SuperAdminController@listaEstagiosEmpresa');
// //     Route::get('/su/listaestagios/destaque', 'SuperAdminController@listaEstagiosEmpresaDestaque');
// //     Route::get('/su/logs/access', 'SuperAdminController@logsaccess');
// //     Route::get('/su/json/chartpr', 'SuperAdminController@chartpr');
// //     Route::post('/su/json/chartpr', 'SuperAdminController@chartpr');
// //     Route::get('/su/json/chartprmm', 'SuperAdminController@chartprmm');
// //     Route::post('/su/json/chartprmm', 'SuperAdminController@chartprmm');
// //     Route::get('/su/events/get', 'SuperAdminController@eventsGet');
// //     Route::post('/su/events/get', 'SuperAdminController@eventsGet');
// //     Route::get('/su/candidatos', 'SuperAdminController@listaAlunosCandidatos');
// //     Route::get('/su/candidatos-dados-ajax', 'SuperAdminController@listaAlunosCandidatosDadosAjax');
// //     Route::post('/su/candidatos-dados-ajax', 'SuperAdminController@listaAlunosCandidatosDadosAjax');
// //     Route::get('/su/candidatos/detalhe', 'SuperAdminController@listaAlunosCandidatoDetalhe');
// //     Route::post('/su/candidatos/detalhe', 'SuperAdminController@listaAlunosCandidatoDetalhe');


// //     Route::get('/su/listaestagiosd/{tipo?}', 'SuperAdminController@listaEstagiosEmpresaDetalhe');
// // });

// // //--------------------------------------------------CONSULTAS--------------------------------------------------
// // Route::group(["middleware" => ['\App\Http\Middleware\RestrictToDEINetworks:funcionariosOuComLogin']], function () {
// //     Route::get('/queries/empresascomestagiosano/{ano}', 'QueriesController@empresasComEstagioNoAno');
// // });
