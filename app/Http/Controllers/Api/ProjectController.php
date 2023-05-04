<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::paginate(3);

        return response()->json([
            'projects' => $projects,
        ]);
    }

    public function show($slug)
    { //questo slug lo riceve dalla call client
        // $project = Project::where('slug', $slug)->first();
        // $project->load('technologies.projects');
        $project = Project::where('slug', $slug)->with(['technologies.projects' => function ($query) use ($slug) {
            //no BUilder, solo $query dentro la =>function() (da docs Laravel https://laravel.com/docs/9.x/eloquent-relationships#eager-loading)
            //use serve per portare sotto la variabile (vedi thread laracast https://laracasts.com/discuss/channels/eloquent/eager-load-relation-with-parameters)
            $query->where('slug', '!=', $slug);
        }])->first();

        //controlliamo se esiste il post
        if ($project) {
            return response()->json([
                'success' => true,
                'project' => $project,
            ]);
        } else {
            return response()->json([
                'success' => false,
                'error' => 'nessun project trovato',
            ]);
        }
    }
}
