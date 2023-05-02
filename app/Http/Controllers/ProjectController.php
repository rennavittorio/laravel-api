<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Models\Technology;
use App\Models\Type;
use Illuminate\Http\Request; //serve per aggiungere la request all'index, per ricevere paramas
use Illuminate\Support\Str;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $trashed = $request->input('trashed'); //->input('nome') permette di recuperare un singolo params

        if ($trashed) {
            $projects = Project::onlyTrashed()->get(); //per recupera solo i trashed
        } else {
            $projects = Project::all();
        }

        //$num_trashed = Project::onlyTrashed()->get()->count(); //cosi ci ritorna una collection, e poi calcola il num
        $num_trashed = Project::onlyTrashed()->count(); //cosi ci ritorna un record con già il valore

        return view('projects.index', compact('projects', 'num_trashed'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $project_categories = [
            'frontend' => 'frontend',
            'backend' => 'backend',
            'fullstack' => 'fullstack',
        ];

        $client_categories = [
            'food-and-beverage' => 'food and beverage',
            'fashion' => 'fashion',
            'tech' => 'tech',
        ];

        $project_types = Type::all();

        $technologies = Technology::all();

        return view('projects.create', compact('project_categories', 'client_categories', 'project_types', 'technologies'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreProjectRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProjectRequest $request)
    {

        $data = $request->validated(); //richiama la form request validation

        // dd($data);

        $new_proj = new Project();
        $new_proj->fill($data);
        $new_proj->slug = Str::of($data['title'])->slug();

        $new_proj->save();

        if (isset($data['techs'])) { //se l'array tags è presente (non null)
            $new_proj->technologies()->attach($data['techs']); //attacchiamo l'array di tag al post
            //in fase di update useremo il metodo sync
        }

        return to_route('projects.show', $new_proj->slug);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        return view('projects.show', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {

        $project_categories = [
            'frontend' => 'frontend',
            'backend' => 'backend',
            'fullstack' => 'fullstack',
        ];

        $client_categories = [
            'food-and-beverage' => 'food and beverage',
            'fashion' => 'fashion',
            'tech' => 'tech',
        ];

        $project_types = Type::all();

        $technologies = Technology::all();

        return view('projects.edit', compact('project', 'project_categories', 'client_categories', 'project_types', 'technologies'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateProjectRequest  $request
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProjectRequest $request, Project $project)
    {
        $data = $request->validated();

        $project->update($data);

        $project->technologies()->sync($data['techs']);

        return to_route('projects.show', $project->slug);
    }


    public function restore(Project $project, Request $request)
    {

        if ($project->trashed()) { //controllo che sia stato effettivamente cancellato
            $project->restore(); //metodo restore per eliminate il delete_at

            $request->session()->flash('message', 'il post: ' . $project->title . ' è stato ripristinato');
        }

        return back(); //riporta alla pagina precedente, rispetto alla chiamata

    }

    public function delete(Project $project)
    {
        return view('projects.delete', compact('project'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {

        if ($project->trashed()) {
            $project->forceDelete(); //eliminazione permanente
        }

        $project->delete(); //capire il delete permanently

        return to_route('projects.index');

        //return back(); //meglio, perché abbiamo aggiunto doppia-view proj active vs trashed
    }
}
