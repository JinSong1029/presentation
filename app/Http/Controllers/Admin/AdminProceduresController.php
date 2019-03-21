<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CreateProcedureRequest;
use App\Http\Requests\UpdateProcedureRequest;
use App\Jobs\AddProcedureJob;
use App\Jobs\UpdateProcedureJob;
use App\Models\SlideTypes\Procedure;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class AdminProceduresController extends Controller
{


    public function store(CreateProcedureRequest $request)
    {
        return $this->dispatchFrom(AddProcedureJob::class, $request);
    }

    public function update(Procedure $procedure, UpdateProcedureRequest $request)
    {
        $request['procedure'] = $procedure;

        return $this->dispatchFrom(UpdateProcedureJob::class, $request);
    }

    public function destroy(Procedure $procedure)
    {
        $procedure->delete();
    }
}
