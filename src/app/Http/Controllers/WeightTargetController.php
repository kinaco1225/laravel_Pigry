<?php

namespace App\Http\Controllers;

use App\Http\Requests\WeightTargetRequest;
use Illuminate\Http\Request;
use App\Models\WeightTarget;
use App\Models\WeightLog;
use Illuminate\Support\Facades\Auth;

class WeightTargetController extends Controller
{
    public function store(WeightTargetRequest $request)
    {
        $user = Auth::user();

        WeightLog::create([
            'user_id' => $user->id,
            'date' =>now() -> toDateString(),
            'weight' => $request->weight,
        ]);

        WeightTarget::create([
            'user_id' => $user->id,
            'target_weight' => $request->target_weight,
        ]);

        return redirect('/login');

    }

    public function update(WeightTargetRequest $request)
    {

        $user = Auth::user();

        $weightTarget = WeightTarget::where('user_id', $user->id)->firstOrFail();

        $weightTarget->update([
            'target_weight' => $request->target_weight
        ]);

        return redirect('/weight_logs')->with('message', '目標体重を変更しました');
    }

    
}
