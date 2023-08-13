<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePcRequest;
use App\Models\Pc;

class PcController extends Controller
{
    public function index()
    {
        return Pc::all();
    }

    public function store(StorePcRequest $request)
    {
        return Pc::create($request->validated() + ['user_id' => $request->user()->id]);
    }

    public function show(Pc $pc)
    {
        return $pc;
    }

    public function update(StorePcRequest $request, Pc $pc)
    {
        return tap($pc)->update($request->all());
    }

    public function destroy(Pc $pc)
    {
        $pc->delete();

        return response()->noContent();
    }
}
