<?php

namespace App\Http\Controllers\Api\Task;

use App\Helpers\Json;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Task\StoreRequest;
use App\Http\Resources\Api\Task\TaskCollection;
use App\Models\Task;
use App\Models\TaskItem;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $tasks = Task::latest()
            ->userId($request->user()->id)
            ->with('items')
            ->get();

        return new TaskCollection($tasks);
    }

    public function check($id, Request $request)
    {
        $taskItem = TaskItem::whereId($id)
            ->whereHas('task', function (Builder $query) use ($request) {
                $query->userId($request->user()->id);
            })
            ->unchecked()
            ->firstOrFail();

        $taskItem->update([
            'is_done' => 1,
            'done_at' => now()
        ]);

        return Json::response(200, 'با موفقیت انجام شد');
    }

    public function uncheck($id, Request $request)
    {

        $taskItem = TaskItem::whereId($id)
            ->whereHas('task', function (Builder $query) use ($request) {
                $query->userId($request->user()->id);
            })
            ->checked()
            ->firstOrFail();

        $taskItem->update([
            'is_done' => 0,
            'done_at' => NULL
        ]);

        return Json::response(200, 'با موفقیت انجام شد');
    }


    public function store(StoreRequest $request)
    {

        DB::beginTransaction();
        try {

            $taskId = Task::create([
                'user_id'       => $request->user()->id,
                'expectation'   => $request->safe()->expectation ?? NULL,
                'desire'        => $request->safe()->desire ?? NULL,
            ])->id;

            $taskItems = [];
            foreach ($request->safe()->tasks as $item) {
                $taskItems[] = [
                    'task_id'       => $taskId,
                    'content'       => $item,
                    'created_at'    => now()
                ];
            }

            TaskItem::insert($taskItems);

            DB::commit();

            return Json::response(200, 'کار های امروز شما با موفقیت ثبت شد');

            //
        } catch (Exception $e) {

            DB::rollBack();
            info($e);

            return Json::response(500, 'There is a problem with your request');
        }
    }
}
