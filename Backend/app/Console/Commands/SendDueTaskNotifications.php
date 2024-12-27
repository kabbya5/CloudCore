<?php

namespace App\Console\Commands;

use App\Models\Task;
use App\Notifications\TaskDueNotification;
use Carbon\Carbon;
use Illuminate\Console\Command;

class SendDueTaskNotifications extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-due-task-notifications';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send notifications for tasks due today';

    /**
     * Execute the console command.
     */

    public function handle()
    {
        $tasks = Task::whereDate('due_date', Carbon::today())->get();

        foreach ($tasks as $task) {
            $task->user->notify(new TaskDueNotification($task));
        }

        $this->info('Due task notifications sent successfully.');
    }

}
