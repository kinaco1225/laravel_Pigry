<?php

namespace App\Http\Controllers;

use App\Http\Requests\WeightLogRequest;
use App\Http\Requests\GoalWeightRequest;
use App\Models\WeightLog;
use App\Models\WeightTarget;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class WeightLogController extends Controller {

    public function index()
    {
        $userId = auth()->id();

        // 目標体重（1件想定）
        $targetWeight = WeightTarget::where('user_id', $userId)->value('target_weight');

        // 最新の体重ログ
        $latestWeight = WeightLog::where('user_id', $userId)->orderBy('date', 'desc')->value('weight');

        // 目標までの差
        $diffToTarget = null;
        if ($targetWeight !== null && $latestWeight !== null) {
            $diffToTarget = round($targetWeight -  $latestWeight, 1);
        }

        // 一覧用
        $weightLogs = WeightLog::where('user_id', $userId)->orderBy('date', 'desc')->paginate(8);

        return view('weight_logs.index', compact(
            'weightLogs',
            'targetWeight',
            'latestWeight',
            'diffToTarget'
        ));
    }


    public function store(WeightLogRequest $request)
    {
        $user = Auth::user();

        WeightLog::create([
            'user_id' => $user->id,
            'date' => $request->date,
            'weight' => $request->weight,
            'calories' => $request->calories,
            'exercise_time' => $request->exercise_time,
            'exercise_content' => $request->exercise_content,
        ]);

        return redirect('/weight_logs')->with('message','体重を登録しました');
    }

    public function goalSetting()
    {
        return view('weight_logs.goal_setting');
    }

    public function show(WeightLog $weightLog)
    {
        if ($weightLog->user_id !== Auth::id()) {
            abort(403);
        }

        return view('weight_logs.show', compact('weightLog'));
    }

    public function update(WeightLogRequest $request,WeightLog $weightLog)
    {
        if ($weightLog->user_id !== Auth::id()) {
            abort(403);
        }

        $weightLog->update([
            'date'             => $request->date,
            'weight'           => $request->weight,
            'calories'         => $request->calories,
            'exercise_time'    => $request->exercise_time,
            'exercise_content' => $request->exercise_content,
        ]);

        return redirect('/weight_logs')->with('message', '詳細を更新しました');
    }

    public function destroy(WeightLog $weightLog)
    {
        if ($weightLog->user_id !== Auth::id()) {
            abort(403);
        }

        $weightLog->delete();

        return response()->json(['success' => true]);
    }


    public function search(Request $request)
    {
        $userId = auth()->id();

        $from = $request->input('from');
        $to   = $request->input('to');

        $weightLogs = WeightLog::where('user_id', $userId)
            ->dateBetween($from, $to)
            ->orderBy('date', 'desc')
            ->paginate(8)
            ->appends($request->query());

        $count = $weightLogs->total();

        $targetWeight = WeightTarget::where('user_id', $userId)->value('target_weight');
        $latestWeight = WeightLog::where('user_id', $userId)->orderBy('date', 'desc')->value('weight');

        $diffToTarget = null;
        if ($targetWeight !== null && $latestWeight !== null) {
            $diffToTarget = round($targetWeight - $latestWeight, 1);
        }

        return view('weight_logs.index', compact(
            'weightLogs',
            'targetWeight',
            'latestWeight',
            'diffToTarget',
            'from',
            'to',
            'count'
        ));
    }
}
