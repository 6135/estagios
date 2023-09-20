<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Docente;
use App\EstagioAction;
use App\UserAccessLog;
use DB;

class DocenteController extends Controller
{
    public function lista() {
        $actions = EstagioAction::all()->sortByDesc('created')->take(7);
        $userLogs = UserAccessLog::all()->sortByDesc('created_at')->take(10);
        return view('metronicv510.pages.docentesTable', array('title' => 'Plataforma de Gestão de Estágios', 'actions'=>$actions, 'logs' => $userLogs));
    }

    public function showForm($id) {
        //return view('metronicv510.pages.defaultForms');
        $docente = Docente::where('iddocente', $id)->firstOrFail();

        /*echo "<pre>";
        print_r($docente);
        echo "</pre>";*/

        return view('metronicv510.pages.docenteForm', array('title' => 'Plataforma de Gestão de Estágios : Docente', 'docente' => $docente));
    }

    public function update(Request $request, $iddocente) {
        try
        {
            //dd(array($request, $iddocente));
            $docente = Docente::where('iddocente', $iddocente)->firstOrFail();
            $result = $docente->update([
                'nomedocente' => $request->post('nomedocente') ?? null,
                'logindocente' => $request->post('logindocente') ?? null,
                'num_mecanografico' => $request->post('num_mecanografico') ?? null,
                'activo' => $request->post('activo')=='on' ?? 1,
            ]);

            return redirect()->back();
        }catch (Exception $e)
        {

            return response()->json(['error' => 'Failed to Update User', 'errorMessage' => $e->getMessage()], 500);

        }
    }

    private static function array_utf8_encode($dat){
        if (is_string($dat))
            return utf8_encode($dat);
        if (!is_array($dat))
            return $dat;
        $ret = array();
        foreach ($dat as $i => $d)
            $ret[$i] = self::array_utf8_encode($d);
        return $ret;
    }

    public function tabledata() {
        $docentes = Docente::all();

        foreach ($docentes as $docente) {
            $users[] = self::array_utf8_encode((array)$docente->getOriginal());
        }

        $data = $users;

        //$data = $alldata = $empresas;

        $datatable = array_merge(['pagination' => [], 'sort' => [], 'query' => []], $_REQUEST);

// search filter by keywords
        $filter = isset($datatable['query']['generalSearch']) && is_string($datatable['query']['generalSearch'])
            ? $datatable['query']['generalSearch'] : '';
        if ( ! empty($filter)) {
            $data = array_filter($data, function ($a) use ($filter) {
                return (boolean)preg_grep("/$filter/i", (array)$a);
            });
            unset($datatable['query']['generalSearch']);
        }

// filter by field query
        $query = isset($datatable['query']) && is_array($datatable['query']) ? $datatable['query'] : null;
        if (is_array($query)) {
            $query = array_filter($query);
            foreach ($query as $key => $val) {
                $data = list_filter($data, [$key => $val]);
            }
        }

        $sort  = ! empty($datatable['sort']['sort']) ? $datatable['sort']['sort'] : 'asc';
        $field = ! empty($datatable['sort']['field']) ? $datatable['sort']['field'] : 'RecordID';

        $meta    = [];
        $page    = ! empty($datatable['pagination']['page']) ? (int)$datatable['pagination']['page'] : 1;
        $perpage = ! empty($datatable['pagination']['perpage']) ? (int)$datatable['pagination']['perpage'] : -1;

        $pages = 1;
        $total = count($data); // total items in array

// sort
        usort($data, function ($a, $b) use ($sort, $field) {
            if ( ! isset($a->$field) || ! isset($b->$field)) {
                return false;
            }

            if ($sort === 'asc') {
                return $a->$field > $b->$field ? true : false;
            }

            return $a->$field < $b->$field ? true : false;
        });

// $perpage 0; get all data
        if ($perpage > 0) {
            $pages  = ceil($total / $perpage); // calculate total pages
            $page   = max($page, 1); // get 1 page when $_REQUEST['page'] <= 0
            $page   = min($page, $pages); // get last page when $_REQUEST['page'] > $totalPages
            $offset = ($page - 1) * $perpage;
            if ($offset < 0) {
                $offset = 0;
            }

            $data = array_slice($data, $offset, $perpage, true);
        }

        $meta = [
            'page'    => $page,
            'pages'   => $pages,
            'perpage' => $perpage,
            'total'   => $total,
        ];


// if selected all records enabled, provide all the ids
        if (isset($datatable['requestIds']) && filter_var($datatable['requestIds'], FILTER_VALIDATE_BOOLEAN)) {
            $meta['rowIds'] = array_map(function ($row) {
                return $row->RecordID;
            }, $alldata);
        }


        header('Content-Type: application/json');
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type, Content-Range, Content-Disposition, Content-Description');

        $result = [
            'meta' => $meta + [
                    'sort'  => $sort,
                    'field' => $field,
                ],
            'data' => $data,
        ];

        echo json_encode($result, JSON_PRETTY_PRINT);
    }

    public function select2List() {
        $lista = DB::select("select * from docente where activo=1");

        $elementos = array();

        if(sizeof($lista)==0) {
            $elementos[] = array(
                'id' => -1,
                'login' => 'nologin',
                'nome' => 'NÃO EXISTEM DOCENTES A APRESENTAR',
            );
        } else {
            foreach ($lista as $elemento) {
                $elemento = self::array_utf8_encode((array)$elemento);

                $elementos[] = array(
                    'id' => $elemento['iddocente'],
                    'login' => $elemento['logindocente'],
                    'nome' => $elemento['nomedocente'],
                );
            }
        }

        echo json_encode($elementos);
    }
}
