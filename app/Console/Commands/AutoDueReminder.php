<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use Mail;
use App\Mail\DueReminder;
use App\Models\Task;
use App\Models\User;

class AutoDueReminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'auto:duetaskremind';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $tasks = Task::whereMonth('due_date', date('m'))
        ->whereDay('due_date', date('d'))
        ->get();

        if ($tasks->count() > 0) {
        foreach ($tasks as $task) {
            $user = User::where('id',$task->userid)->first();
            Mail::to($user)->send(new DueReminder($task));
        }
}

return 0;
    }
}
