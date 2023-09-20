<?php

namespace App\Http\Controllers;

use App\Reuniao;
use App\Role;
use App\User;
use Illuminate\Http\Request;
use App\Http\Requests\NovaReuniaoRequest;

/**
 * Class MiscController
 * @package App\Http\Controllers
 * 
 * Responsable for handling requests that are not related to any other controller and do not require an isolated controller for them.
 * 
 */
class MiscController extends Controller
{
    //
    /**
     * @param NovaReuniaoRequest $request
     * 
     */
    public function newMeeting(NovaReuniaoRequest $request){

        //no need to check user type as there are no differences on the way the data is handled when creating a meeting
        //create a new meeting based on the request data
        Reuniao::create($request->all());
    }
}
