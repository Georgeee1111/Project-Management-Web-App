<?php 

// app/Repositories/ProjectRepository.php
namespace App\Repositories;

use Illuminate\Support\Facades\DB;

class ProjectRepository implements ProjectRepositoryInterface
{
    public function getProjectsAndTasks()
    {
        return DB::select('
            SELECT projects.*, tasks.id as task_id, tasks.name as task_name, tasks.description as task_description, tasks.status as task_status, tasks.due_date as task_due_date
            FROM projects
            LEFT JOIN tasks ON tasks.project_id = projects.id
            WHERE projects.deleted_at IS NULL
        ');
    }

    public function getProjectWithTasks($projectId)
    {
        return DB::select('
            SELECT projects.*, tasks.id as task_id, tasks.name as task_name, tasks.description as task_description, tasks.status as task_status, tasks.due_date as task_due_date
            FROM projects
            LEFT JOIN tasks ON tasks.project_id = projects.id
            WHERE projects.id = ? AND projects.deleted_at IS NULL
        ', [$projectId]);
    }

    public function getProjectWithUsers($projectId)
    {
        return DB::select('
            SELECT projects.*, created_by_user.name as created_by_name, updated_by_user.name as updated_by_name
            FROM projects
            LEFT JOIN users as created_by_user ON created_by_user.id = projects.created_by
            LEFT JOIN users as updated_by_user ON updated_by_user.id = projects.updated_by
            WHERE projects.id = ? AND projects.deleted_at IS NULL
        ', [$projectId]);
    }
}
