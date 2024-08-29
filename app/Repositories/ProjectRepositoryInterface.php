<?php

namespace App\Repositories;

interface ProjectRepositoryInterface
{
    public function getProjectsAndTasks();
    public function getProjectWithTasks($projectId);
    public function getProjectWithUsers($projectId);
}

