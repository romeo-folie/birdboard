<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectsController extends Controller
{
    public function index(){
        $projects = Project::all();

        return view('projects.index', compact('projects'));
    }

    public function store(Request $request){
        $attributes = $request->validate([
            'title' => 'required',
            'description' => 'required',
        ]);

        auth()->user()->projects()->create($attributes);

        return redirect('/projects');
    }

    public function show(Project $project){

        if(auth()->user()->isNot($project->owner)){
            abort(403);
        }

        return view('projects.show', compact('project'));
    }
}
