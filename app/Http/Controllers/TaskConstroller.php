<?php

namespace App\Http\Controllers;

use App\Reps\TaskRepository;
use Illuminate\Http\Request;

class TaskConstroller extends Controller
{
    public function get(Request $request)
    {
        if (!isset($request->id)) {
            $result = TaskRepository::getTasks();
        } else {
            $result = TaskRepository::getTaskById($request->id);
        }

        return response($result['content'], $result['status']);
    }

    public function create(Request $request)
    {
        $result = TaskRepository::createTasks(
            $request->header,
            $request->description,
            $request->status,
            $request->deadline
        );

        return response($result['content'], $result['status']);
    }

    public function update(Request $request)
    {
        $result = TaskRepository::updateTask($request->id, $request->fields);
        return response($result['content'] ?? [], $result['status']);
    }

    public function delete(Request $request)
    {
        $result = TaskRepository::deleteTask($request->id);
        return response($result['content'] ?? [], $result['status']);
    }

    public function search(Request $request)
    {
        $result = TaskRepository::searchTask($request->status, $request->deadline);
        return response($result['content'] ?? [], $result['status']);
    }
}
