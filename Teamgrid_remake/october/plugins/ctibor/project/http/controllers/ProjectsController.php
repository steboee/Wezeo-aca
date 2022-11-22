<?php
  namespace ctibor\project\http\controllers;
  use Backend\Controllers\BackendController;
  use Backend\Classes\Controller;
  use ctibor\project\models\Project;


  class ProjectsController extends Controller
  {
    public function index()
    {
      
    }

    public function create_project()
    {
      $project = new Project();
      
      
    }
  }