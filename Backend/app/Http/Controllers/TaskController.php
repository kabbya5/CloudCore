<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use Illuminate\Http\Request;
use DB;

class TaskController extends Controller
{
    public function index(Request $request){
        $page = $request->input('page', 1);
        $limit = $request->input('limit', 30);
        $offset = ($page - 1) * $limit;

        $priority = $request->priority;
        $status = $request->status;
        $order_by = $request->order_by ?? 'due_date-DESC';
        list($column, $direction) = explode('-', $order_by);
        $user_id = 1;

        $sql = "
            SELECT
                t.id, t.title, t.description, t.due_date,
                t.priority, t.status,
                u.first_name, u.last_name
            FROM tasks AS t
            JOIN users AS u ON u.id = t.assigned_to
            WHERE t.user_id = {$user_id}
        ";

        $bindings = [];

        if ($priority) {
            $sql .= " AND t.priority = :priority";
            $bindings['priority'] = $priority;
        }
        if ($status) {
            $sql .= " AND t.status = :status";
            $bindings['status'] = $status;
        }
        $sql .= " ORDER BY {$column} {$direction}";
        $sql .= " LIMIT :limit OFFSET :offset";
        $bindings['limit'] = $limit;
        $bindings['offset'] = $offset;

        $tasks = DB::select($sql, $bindings);
        return response()->json(['tasks' => $tasks], 200);
    }

    public function store(StoreTaskRequest $request){
        return $request->all();
    }

}
