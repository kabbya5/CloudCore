<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use DB;

class TaskController extends Controller
{
    public function index(Request $request){
        $page = $request->input('page', 1);
        $limit = $request->input('limit', 100);
        $offset = ($page - 1) * $limit;

        $priority = $request->priority;
        $status = $request->status;
        $search_query = $request->search_query;
        $due_date = $request->due_date;
        $order_by = $request->order_by ?? 'due_date-ASC';

        list($column, $direction) = explode('-', $order_by);
        $user_id = auth()->id();

        $sql = "
            SELECT
                t.id, t.slug, t.title, t.description, t.due_date, -- t for tasks table
                t.priority, t.status,
                u.first_name, u.last_name -- u for user table (assigned to)
            FROM tasks AS t
            LEFT JOIN users AS u ON u.id = t.assigned_to
            WHERE t.user_id = {$user_id}
        ";

        $bindings = [];

        if ($priority != null) {
            $sql .= " AND t.priority = :priority";
            $bindings['priority'] = $priority;
        }
        if ($status != null) {
            $sql .= " AND t.status = :status";
            $bindings['status'] = $status;
        }

        if ($search_query != null) {
            $sql .= " AND t.title LIKE :search_query";
            $bindings['search_query'] = "%$search_query%";
        }
        if ($due_date != null) {
            $sql .= " AND t.due_date = :due_date";
            $bindings['due_date'] = $due_date;
        }

        $sql .= " ORDER BY {$column} {$direction}";

        $total_tasks = DB::select($sql, $bindings);

        $sql .= " LIMIT :limit OFFSET :offset";
        $bindings['limit'] = $limit;
        $bindings['offset'] = $offset;

        $tasks = DB::select($sql, $bindings);

        return response()->json(['tasks' => $tasks, 'total_tasks' => $total_tasks], 200);
    }

    public function getUsers() {
        $user_id = auth()->id();

        $users = DB::select("
            SELECT CONCAT(first_name, ' ', last_name) as name, id
            FROM users
            WHERE id != :user_id
        ", ['user_id' => $user_id]);

        return response()->json(['users' => $users], 200);
    }

    public function store(StoreTaskRequest $request){
        $user_id = auth()->id();
        $data = $request->only('title', 'status', 'priority', 'due_date', 'description');
        $data['user_id'] = $user_id;
        $task = Task::create($data);

        return response()->json(['task' => $task],200);
    }

    public function show(Task $task){
        return response()->json(['task' => $task],200);
    }

    public function update(StoreTaskRequest $request,Task $task){
        $data = $request->only('title', 'status', 'priority', 'due_date', 'description');
        $task->update($data);

        return response()->json(['task' => $task],200);
    }
}
