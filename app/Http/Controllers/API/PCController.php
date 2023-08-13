<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePCRequest;
use App\Models\PC;
use Illuminate\Http\Request;

class PCController extends Controller
{
    public function index()
    {
        return PC::all();
    }

    public function store(StorePCRequest $request)
    {
        return PC::create($request->validated() + ['user_id' => $request->user()->id]);
    }

    public function show(PC $pc)
    {
        return $pc;
    }

    public function update(StorePCRequest $request, PC $pc)
    {
        return tap($pc)->update($request->all());
    }

    public function destroy(PC $pc)
    {
        $pc->delete();

        return response()->noContent();
    }
}
