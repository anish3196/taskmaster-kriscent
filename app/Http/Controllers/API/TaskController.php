<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    private ApiResponse $apiResponse;

    public function __construct(ApiResponse $apiResponse)
    {
        $this->apiResponse = $apiResponse;
    }
    
    public function alltask(Request $request): Response|Application|ResponseFactory
    {
        if (Auth::check()){
           $data =  Task::orderBy('created_at')->where('userid', Auth::user()->id)->get();
           return $this->apiResponse->adminSendResponse(200, 'slider Fetched Successfully',  $data);
        } else {
            return $this->apiResponse->adminSendResponse(401, 'User unauthorized', null);
        }
    }

    public function addtask(Request $request): Response|Application|ResponseFactory
    {
        if (Auth::check()){
            $validator = Validator::make($request->all(), [
                'title' => 'required|string|max:255',
                'desc' => 'required|string',
                'due_date' => 'required'
            ]);

            if ($validator->fails()) {
                return $this->apiResponse->adminSendResponse(400, 'Parameters missing or invalid.', $validator->errors());
            }

            $title = Task::where('title', $request->title)->first();
            if ($title) {
                return $this->apiResponse->adminSendResponse(403, "Task Already Exists", null);
            }

            try {
                $slider = Task::create($request->all() + ['userid'=>Auth::user()->id]);
                return $this->apiResponse->adminSendResponse(200, "Task added successfully",$slider);
            } catch (\Exception $e) {
                return $this->apiResponse->adminSendResponse(500, $e->getMessage(), $e->getTraceAsString());
            }
        } else {
            return $this->apiResponse->adminSendResponse(401, 'User unauthorized', null);
        }
    }

    public function edittask(Request $request): Response|Application|ResponseFactory
    {
        if (Auth::check()){
            $validator = Validator::make($request->all(), [
                'title' => 'required|string|max:255',
                'desc' => 'required|string',
                'due_date' => 'required'
            ]);

            if ($validator->fails()) {
                return $this->apiResponse->adminSendResponse(400, 'Parameters missing.', $validator->errors());
            }

            try {
                $findtask = Task::where('id' , $request->id);
                if ($findtask->first()) {
                    $findtask->update($request->all());
                    return $this->apiResponse->adminSendResponse(200, 'Task Update Successfully', $findtask->first());
                }
                return $this->apiResponse->adminSendResponse(404, 'Task not found', null);
            } catch (\Exception $e) {
                return $this->apiResponse->adminSendResponse(500, $e->getMessage(), $e->getTraceAsString());
            }
        } else {
            return $this->apiResponse->adminSendResponse(401, 'User unauthorized', null);
        }
    }

    public function deletetask(Request $request): Response|Application|ResponseFactory
    {
        if(Auth::check()){
            $validator = Validator::make($request->all(), [
                'id' => 'required|string',
            ]);

            if ($validator->fails()) {
                return $this->apiResponse->adminSendResponse(400, 'Parameters missing.', $validator->errors());
            }

            try {
                $findtask = Task::where('id' , $request->id);
                if ($findtask->first()) {
                    $findtask->delete();
                    return $this->apiResponse->adminSendResponse(200, 'Task delete Successfully', $findtask->first());
                }
                return $this->apiResponse->adminSendResponse(404, 'Task not found', null);
            } catch (\Exception $e) {
                return $this->apiResponse->adminSendResponse(500, $e->getMessage(), $e->getTraceAsString());
            }
        } else {
            return $this->apiResponse->adminSendResponse(401, 'User unauthorized', null);
        }
    }
}
