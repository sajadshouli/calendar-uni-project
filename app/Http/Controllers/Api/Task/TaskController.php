<?php

namespace App\Http\Controllers\Api\Task;

use App\Helpers\Json;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Task\StoreRequest;
use App\Http\Resources\Api\Task\TaskCollection;
use App\Http\Resources\Api\Task\TaskResource;
use App\Models\Task;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $tasks = Task::latest()
            ->userId($request->user()->id)
            ->get();

        return (new TaskCollection($tasks))->setCustomWith([
            'message'               => 'لیست کار ها'
        ]);
    }

    public function show(Task $task)
    {
        return new TaskResource($task);
    }


    public function store(StoreRequest $request)
    {

        DB::beginTransaction();
        try {

            $taskId = Task::create([
                'user_id'       => $request->user()->id,
                'info'          => Json::encode($request->safe()->info)
            ])->id;

            DB::commit();

            return Json::response(200, 'کار های امروز شما با موفقیت ثبت شد');

            //
        } catch (Exception $e) {

            DB::rollBack();
            info($e);

            return Json::response(500, 'There is a problem with your request');
        }
    }


    public function update(Task $task, StoreRequest $request)
    {
        DB::beginTransaction();
        try {

            $taskId = Task::whereId($task->id)
                ->userId($request->user()->id)
                ->firstOrFail()
                ->id;

            Task::whereId($taskId)->update([
                'info'          => Json::encode($request->safe()->info)
            ]);

            DB::commit();

            return Json::response(200, 'کار های شما با موفقیت به روز شد');

            //
        } catch (Exception $e) {

            DB::rollBack();
            info($e);

            return Json::response(500, 'There is a problem with your request');
        }
    }
}
