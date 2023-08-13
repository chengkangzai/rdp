<?php

namespace App\Http\Controllers;

use App\Models\PC;
use Illuminate\Http\Request;

class PCController extends Controller
{
    public function index()
    {
        return PC::all();
    }

    public function store(Request $request)
    {
        return PC::create($request->all() + ['user_id' => $request->user()->id]);
    }

    public function show(PC $PC)
    {
        return $PC;
    }

    public function update(Request $request, PC $PC)
    {
        return tap($PC)->update($request->all());
    }

    public function destroy(PC $PC)
    {
        $PC->delete();

        return response()->noContent();
    }
}
