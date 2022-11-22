<?php

use Backend\Classes\Controller;


class TasksController extends Controller
{
    public function index()
    {
        $this->pageTitle = 'Tasks';
        $this->bodyClass = 'compact-container';
    }

    public function create_task()
    {
        $this->pageTitle = 'Create Task';
        $this->bodyClass = 'compact-container';
    }


    public function create_task_list()
    {
        $this->pageTitle = 'Create Task List';
        $this->bodyClass = 'compact-container';
    }
}