<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Auth\Authentication;
use App\Http\Requests\StudentFormRequest;
use App\Models\Aluno;
use Illuminate\Http\Request;
use Adldap\Laravel\Facades\Adldap;

class StudentController extends Controller
{   

    public function validateStudentEmail(Request $request)
    {
        $email = $request->input('student_email');
        if (session()->has('user')) {
            Adldap::connect();
            $query = Adldap::search()->where('mail', $email)->get();
            if (count($query) == 1) {
                return response()->json(
                    array(
                        'success' => true,
                    )
                );
            }
        }
        return response()->json(
            array(
                'success' => false,
            )
        );
    }

    //create a clone of the navbar items array and activate the item with the given index
    public static function activate($index) : array
    {
        $nvbaritems = self::navbaritems();
        $nvbaritems[$index]['active'] = true;
        return $nvbaritems;
    }

    public static function activateByName($name) : array
    {
        $nvbaritems = self::navbaritems();
        foreach ($nvbaritems as $key => $value) {
            if ($value['name'] == $name) {
                $nvbaritems[$key]['active'] = true;
            }
        }
        return $nvbaritems;
    }

    public static function activateByRoute($route) : array
    {
        $nvbaritems = self::navbaritems();
        foreach ($nvbaritems as $key => $value) {
            if ($value['route'] == $route) {
                $nvbaritems[$key]['active'] = true;
            }
        }
        return $nvbaritems;
    }

    public static function navbaritems() : array
    {
        //check if user is logged in
        $nvbarItems = array(
            [
                'name' => 'Home',
                'route' => 'home',
                'active' => false
            ],
            [
                'name' => trans_choice('words.intership', 2),
                'route' => 'aluno.estagios',
                'active' => false
            ],
            [
                'name' => trans_choice('words.meeting', 2),
                'route' => 'aluno.reunioes',
                'active' => false
            ],
            [
                'name' => trans_choice('words.personaldata',1),
                'route' => 'aluno.dados',
                'active' => false
            ]
        );

        //append more items acording to user role
        //for docente
        return $nvbarItems;
    }

    //show dados aluno
    public function index()
    {
        return view('layouts.aluno.dados', array(
            'navbaritems' => self::activateByRoute('aluno.dados'),
        ));
    }

    //store 
    public function dados(Request $request)
    {
        //check if post or get
        if ($request->isMethod('get')) {
            return view('layouts.aluno.dadosedit', array(
                'navbaritems' => self::activateByRoute('aluno.dados'),
            ));
        }
    }

    //edit
    public function dadosEdit(StudentFormRequest $request)
    {
        //check if post or get
        $validated = $request->validated();
        //find or create a student;
        $student = Aluno::firstOrNew(['utilizador_email' => session()->get('user')->email]);
        $user = Authentication::getUser();
        $user->fill($validated);
        $student->fill($validated);
        $student->aluno_cv = "temp"; //TODO: add cv upload
        $student->utilizador_email = $user->email;
        $student->save();
        $user->save();
        session()->put('user', $user);
        return json_encode([
            'success' => true,
            'message' => 'Dados guardados com sucesso!',
            'redirect' => route('aluno.dados'),
            'data' => $student
        ]);
    }
}
