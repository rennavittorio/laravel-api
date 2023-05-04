<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::with('type', 'technologies')->paginate(3);

        return response()->json([
            'projects' => $projects,
        ]);
    }

    public function show($slug)
    { //questo slug lo riceve dalla call client
        $project = Project::with('type', 'technologies')->where('slug', $slug)->first();

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
