<?php

namespace App\Http\Controllers;

use App\Helpers\CalendarBuilder;
use App\Http\Controllers\GestorController;
use App\Models\Curso;
use App\Models\PapelUtilizador;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{

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
                'name' => trans_choice('words.degree', 2),
                'route' => 'cursos',
                'active' => false
            ],
        );

        //append more items acording to user role
        //for docente
        return $nvbarItems;
    }
    /**
     * Application home page, mostly static
     */
    public function index()
    {
        //get navbar items according to user role and activate the home item
        if(session()->has('user')) {
            switch (session()->get('activeRole')) {

                case PapelUtilizador::Aluno:
                    $navbaritems = StudentController::activateByRoute('home');
                    break;
                case PapelUtilizador::Docente:
                    $navbaritems = DocenteController::activateByRoute('home');
                    break;
                case PapelUtilizador::Gestor:
                    $navbaritems = GestorController::activateByRoute('home');
                    break;
                default:
                    $navbaritems = $this->activateByRoute('home');
                    break;
            }
        } else {
            $navbaritems = $this->activateByRoute('home');
        }
        return view(
            'layouts.home.home',
            array(
                'navbaritems' => $navbaritems
            )
        );
    }

    /**
     * Application cursos page. mostly static
     */
    public function cursos()
    {
        $navbaritems = $this->activate(1);
        return view(
            'layouts.home.cursos',
            array(
                'navbaritems' => $navbaritems
            )
        );
    }

    /**
     * Application curso page with calendar for current periodo de estagio
     * @param Request $request
     * @param $curso string curso title
     * @return Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     * 
     */
    public function curso(Request $request, $curso)
    {
        //convert $curso to uppercase to match database
        $curso = strtoupper($curso);
        //get curso from database
        $curso = Curso::where(Curso::ACRONIMO, $curso)->orderBy(Curso::ANO_CRIACAO, 'desc')->first();
        if ($curso) {
            //TODO: Make sure it's active and current
            $periodoEstagio = $curso->edicao_estagios()->first();
            $view = 'layouts.home.curso';
            $cursoTitle = strtolower($curso->titulo);
        }
        //get view from curso title
        if (view()->exists('layouts.cursos.' . $cursoTitle)) {
            $view = 'layouts.cursos.' . $cursoTitle;
        } else {
            $view = 'layouts.home.curso';
        }

        //if $periodoEstagio is not null, create calendar, else set calendar to null
        $calendar = null;
        if ($periodoEstagio) {
            $calendar = new CalendarBuilder(
                title: __('words.calendar'),
                subtitle: $periodoEstagio->descricao,
                description: '',
                events: CalendarBuilder::buildEventsFromPeriodoEstagio($periodoEstagio),
                columnThreshold: 1,
                doubleColumn: 1,
            );
        } else {
            $calendar = null;
        }
        return view(
            $view,
            array(
                'curso' => $curso,
                'periodoEstagio' => $periodoEstagio,
                'navbaritems' => $this->navbaritems(),
                'calendar' => $calendar,
            )
        );
    }

}