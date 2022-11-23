<?php
  namespace Ctibor\Project\Http\Controllers;
  use Backend\Controllers\BackendController;
  use Backend\Classes\Controller;
  use ctibor\project\models\Project;
  use ctibor\project\http\resources\ProjectResource;


  class ProjectsController extends Controller
  {


    public function index()
    {
      return ProjectResource::collection(Project::all());
    }
   
    public function store()
    {
      $project = new Project;
      $project->fill(request()->all());
      $project->save();
      return new ProjectResource($project);
    }


    public function show($id)
    {
      return new ProjectResource(Project::find($id));
    }


    public function update($id)
    {
      $project = Project::findOrFail($id);
      $project->fill(request()->all());
      return new ProjectResource($project);
    }


    public function delete($id)
    {
      $project = Project::findOrFail($id);
      $project->delete();
      return new ProjectResource($project);
    }


    public function show_tasks($id)
    {
      $project = Project::findOrFail($id);
      return $project->tasks;
    }


  }