<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMortageRequest;
use App\Http\Requests\UpdateMortageRequest;
use App\Http\Resources\Admin\MortageResource;
use App\Models\Mortage;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MortageApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('mortage_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new MortageResource(Mortage::with(['user'])->get());
    }

    public function store(StoreMortageRequest $request)
    {
        $mortage = Mortage::create($request->all());

        return (new MortageResource($mortage))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Mortage $mortage)
    {
        abort_if(Gate::denies('mortage_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new MortageResource($mortage->load(['user']));
    }

    public function update(UpdateMortageRequest $request, Mortage $mortage)
    {
        $mortage->update($request->all());

        return (new MortageResource($mortage))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Mortage $mortage)
    {
        abort_if(Gate::denies('mortage_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $mortage->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
