<?php

namespace App\Http\Controllers;

use App\Project;
use App\Support\Formatter;
use App\Time;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class ExportController extends Controller {

     public function store()
     {
         $request = request();

         $query = Time::orderBy('started', 'desc');

         if (($activity = $request->activity_id)) {
             $query->where('activity_id', $activity);
         }
         if (($project = $request->project_id)) {
             $query->whereHas('task', function ($query) use ($project) {

                 $query->where('project_id', $project);
             });
         }
         if (($task = $request->task_id)) {
             $query->where('task_id', $task);
         }
         if (($user = $request->user_id)) {
             $query->where('user_id', $user);
         }
         if (($started = $request->started)) {
             $query->where('started', '>=', $started);
         }
         if (($finished = $request->finished)) {
             $query->where('finished', '<=', $finished);
         }

         $times = $query->get();

         $tmpfname = tempnam ("/tmp", "times.csv");

         $name = 'report-' . Carbon::now()->format('Y-m-d');

         if ($project) {
             $name .= '-' . Str::slug(Project::find($project)->name);
         }

         $name .= '.csv';

         $out = fopen($tmpfname, 'w');

         fputcsv($out, [
             'Project',
             'Task',
             'Activity',
             'User',
             'Started',
             'Finished',
             'Total',
         ]);

         foreach ($times as $time) {
             fputcsv($out, [
                 $time->task->project->name,
                 $time->task->name,
                 $time->activity->name,
                 $time->user->name,
                 $time->started,
                 $time->finished,
                 $time->finished ? Formatter::intervalTime($time->finished->diffAsCarbonInterval($time->started)) : '-',
             ]);
         }

         fclose($out);

         return response()->download($tmpfname, $name);
     }
}
