<?php
  namespace ctibor\project\http\controllers;
  use Backend\Controllers\BackendController;
  use Backend\Classes\Controller;
  use ctibor\project\models\Project;
  use ctibor\project\http\resources\ProjectResource;


  class ProjectsController extends Controller
  {
   
    public function create_project()
    {
      $project = new Project;
      $project->name = request("name");
      $project->description = request("description");
      $project->completed = request("completed");
      $project->due_date = request("due_date");
      $project->save();
      return new ProjectResource($project);
    }


    public function get_project($id)
    {
      return new ProjectResource(Project::find($id));
    }

    public function get_all_projects()
    {
      return ProjectResource::collection(Project::all());
    }

    public function update_project($id)
    {
      $project = Project::find($id);
      $project->name = request("name");
      $project->description = request("description");
      $project->completed = request("completed");
      $project->due_date = request("due_date");
      $project->save();
      return new ProjectResource($project);
    }

    public function complete_project($id)
    {
      $project = Project::find($id);
      $project->completed = true;
      $project->save();
      return new ProjectResource($project);
    }

    public function delete_project($id)
    {
      $project = Project::find($id);
      $project->delete();
      return new ProjectResource($project);
    }



  }