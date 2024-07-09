<?php


namespace App\Reps;


use App\Models\Task;
use Carbon\Carbon;
use Symfony\Component\HttpFoundation\Response;

class TaskRepository
{
    public static function getTaskById(int $id): array
    {
        try {
            $result['content'] = Task::where('id', '=', $id)
                ->first();

            if (empty($result['content'])) {
                throw new \Exception(ExceptionRepository::TASK_NOT_FOUND);
            }
            $result['status'] = Response::HTTP_OK;
        } catch (\Exception $e) {
            $result['content']['error'] = [
                'message' => $e->getMessage()
            ];
            $result['status'] = Response::HTTP_BAD_REQUEST;
        }

        return $result;
    }

    public static function getTasks(): array
    {
        try {
            $result['content'] = Task::get();

            if ($result['content']->isEmpty()) {
                throw new \Exception(ExceptionRepository::TASKS_NOT_FOUND);
            }
            $result['status'] = Response::HTTP_OK;
        } catch (\Exception $e) {
            $result['content']['error'] = [
                'message' => $e->getMessage()
            ];
            $result['status'] = Response::HTTP_NO_CONTENT;
        }

        return $result;
    }

    public static function createTasks(string $header, string $description, string $status, int $deadline): array
    {
        try {
            if ($deadline <= Carbon::now()->timestamp) {
                throw new \Exception(ExceptionRepository::TASK_DEADLINE_SET_IN_PAST);
            }
            $task = new Task();
            $task->setHeader($header);
            $task->setDescription($description);
            $task->setStatus($status);
            $task->setDeadline($deadline);
            $task->save();

            $result['content']['id'] = $task->id;

            $result['status'] = Response::HTTP_CREATED;
        } catch (\Exception $e) {
            $result['content']['error'] = [
                'message' => $e->getMessage()
            ];
            $result['status'] = Response::HTTP_BAD_REQUEST;
        }

        return $result;
    }

    public static function updateTask(int $id, array $fields)
    {
        try {
            if ($id === null) {
                throw new \Exception(ExceptionRepository::TASK_ID_IS_NULL);
            }
            $task = Task::where('id', '=', $id)->first();
            if (empty($task)) {
                throw new \Exception(ExceptionRepository::TASK_NOT_FOUND);
            }
            foreach ($fields as $field => $value) {
                if (!in_array($field, Task::FIELDS)) {
                    throw new \Exception(sprintf(ExceptionRepository::TASK_FIELD_NOT_FOUND, $field));
                }
                if ($field === Task::FIELDS['deadline']) {
                    if ($value <= Carbon::now()->timestamp) {
                        throw new \Exception(ExceptionRepository::TASK_DEADLINE_SET_IN_PAST);
                    }
                }
                $task->setAttribute($field, $value);
            }
            $task->save();
            $result['content'] = $task;
            $result['status'] = Response::HTTP_OK;
        } catch (\Exception $e) {
            $result['content']['error'] = [
                'message' => $e->getMessage()
            ];
            $result['status'] = Response::HTTP_BAD_REQUEST;
        }

        return $result;
    }

    public static function deleteTask(int $id): array
    {
        try {
            if ($id === null) {
                throw new \Exception(ExceptionRepository::TASK_ID_IS_NULL);
            }
            $task = Task::where('id', '=', $id)->first();
            if (empty($task)) {
                throw new \Exception(ExceptionRepository::TASK_WITH_ID_NOT_EXIST);
            }

            $task->delete();

            $result['status'] = Response::HTTP_OK;
        } catch (\Exception $e) {
            $result['content']['error'] = [
                'message' => $e->getMessage()
            ];
            $result['status'] = Response::HTTP_BAD_REQUEST;
        }

        return $result;
    }

    public static function searchTask(string $status, int $deadline)
    {
        try {
            if ($status === null) {
                throw new \Exception(ExceptionRepository::TASK_STATUS_IS_NULL);
            }
            if ($deadline === null) {
                throw new \Exception(ExceptionRepository::TASK_DEADLINE_IS_NULL);
            }

            $result['content'] = Task::where('status', '=', $status)
                ->where('deadline', '=', Carbon::createFromTimestamp($deadline))
                ->get();
            if ($result['content']->isEmpty()) {
                throw new \Exception(ExceptionRepository::TASKS_NOT_FOUND);
            }

            $result['status'] = Response::HTTP_OK;
        } catch (\Exception $e) {
            $result['content']['error'] = [
                'message' => $e->getMessage()
            ];
            $result['status'] = Response::HTTP_BAD_REQUEST;
        }

        return $result;
    }
}
