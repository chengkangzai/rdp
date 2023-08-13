<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePcRequest;
use App\Models\Pc;

class PcController extends Controller
{
    public function ping(StorePcRequest $request)
    {
        $pc = Pc::query()
            ->where('user_id', $request->user()->id)
            ->where('name', $request->name)
            ->first();

        if ($pc) {
            return $pc->update($request->validated() + [
                'updated_at' => now(),
            ]);
        } else {
            return Pc::create($request->validated() + [
                'user_id' => $request->user()->id,
            ]);
        }
    }
}
