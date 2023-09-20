<?php // Code within app\Helpers\Helper.php

namespace App\Helpers;
use Illuminate\Support\Facades\Log;
use DB;
use Illuminate\Support\Str;
use List_Util;

class Helper
{

    public static function list_filter( $list, $args = array(), $operator = 'AND' )
    {
        //Log::debug($list);
        Log::debug($args);

        if ( ! is_array( $list ) ) {
            return array();
        }

        $util = new List_Util( $list );

        //Log::debug($args);

        return $util->filter( $args, $operator );
    }

    public static function tituloCurso( $acronimo )
    {
        //Log::debug($acronimo);

        if (Str::contains($acronimo, ' ')) {
            $aux = explode(' ', $acronimo);
            if(sizeof($aux>0)) {
                $acronimo= $aux[0];
            }
        }

        //Log::debug($acronimo);

        switch($acronimo) {
            case 'MECD':
                return 'Mestrado em Engenharia e Ciência de Dados';
            case 'MSI':
                return 'Mestrado em Segurança Informática';
            case 'MEI':
                return 'Mestrado em Engenharia Informática';
            case 'MDM':
                return 'Mestrado em Design e Multimédia';
            default:
                return "-- curso desconhecido --";
        }
    }

    public static function validEmail($str) {
        return (!preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $str)) ? FALSE : TRUE;
    }

    public static function getEstagioEstado(int $idEstado) {
        $estado = array();

        $estadoestagio = array(
            "10" => array(
                'text' => "Novo",
                'colour' => '#666666',
                'badge' => 'secondary'
            ),
            "15" => array(
                'text' => "Aguarda Aprovação do Coordenador",
                'colour' => '#ffc700',
                'badge' => 'warning'
            ),
            "20" => array(
                'text' => "Aprovado",
                'colour' => 'green',
                'badge' => 'success'
            ),
            "25" => array(
                'text' => "Aguarda Revisão do Coordernador",
                'colour' => '#cc9900',
                'badge' => 'warning'
            ),
            "30" => array(
                'text' => "Em Revisão",
                'colour' => '#cc9900',
                'badge' => 'warning'
            ),
            "40" => array(
                'text' => "Revisto",
                'colour' => '#35a7e0',
                'badge' => 'success'
            ),
            "45" => array(
                'text' => "Aguarda Rejeição do Coordenador",
                'colour' => 'red',
                'badge' => 'warning'
            ),
            "50" => array(
                'text' => "Rejeitado",
                'colour' => 'red',
                'badge' => 'danger'
            ),
            "60" => array(
                'text' => "Cancelado",
                'colour' => '#333333',
                'badge' => 'danger'
            )
        );

        if($idEstado==0) {
            return $estadoestagio;
        }

        $estado = $estadoestagio[$idEstado];

        return $estado;
    }

    public static function getUsernameFromEmail($email) {
        if(Str::contains($email, '@')) {
            $parts = explode('@', $email);

            if(sizeof($parts)==2) {
                return $parts[0];
            }
        } else return $email;
    }


    //PERMISSOES / PERMISSIONS

    public static function permissionAcessoEmpresaEstagio($idEmpresa=0, $idEstagio=0)
    {
        $sqlStatement = "select empresa_idempresa from estagio where idestagio=" . $idEstagio . " and empresa_idempresa=" . $idEmpresa;
        $res = DB::select($sqlStatement);

        if (sizeof($res) == 1) {
            return true;
        }

        if (session()->has('profile') == 4) {
            if (session()->get('profile') == 4) {
                return true;
            }
        }

        return false;
    }


    /**
     * This function is used to convert object into array
     * @param $array
     * @return array
     */
    private static function arrayCastRecursive($array)
    {
        if (is_array($array)) {
            foreach ($array as $key => $value) {
                if (is_array($value)) {
                    $array[$key] = self::arrayCastRecursive($value);
                }
                if ($value instanceof stdClass) {
                    $array[$key] = self::arrayCastRecursive((array)$value);
                }
            }
        }
        if ($array instanceof stdClass) {
            return self::arrayCastRecursive((array)$array);
        }
        return $array;
    }

    /**
     * This function is used to convert array into utf8
     * @param $dat
     * @return array|string
     */
    public static function array_utf8_encode($dat){
        if (is_string($dat))
            return utf8_encode($dat);
        if (!is_array($dat))
            return $dat;
        $ret = array();
        foreach ($dat as $i => $d)
            $ret[$i] = Helper::array_utf8_encode($d);
        return $ret;
    }

    /**
     * Returns user object of logged in user
     */
    public static function getLoggedInUser()
    {
        // $user = Auth::user();
        // return $user;
    }
}