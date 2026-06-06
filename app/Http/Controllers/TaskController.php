<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Http\Resources\TaskResource;

class TaskController extends Controller
{
    /**
     * retourne la liste des tâches de l'utilisateur
     */
    public function index(Request $request)
    {
        $tasks = $request->user()->tasks()->get();
        return response()->json([
            'tasks'=>TaskResource::collection($tasks),
            'total'=>$tasks->count()
        ]);
    }

    /**
     * crée une nouvelle tâche pour l'utilisateur connecté
     */
    public function store(StoreTaskRequest $request)
    {
        
        $task = $request->user()->tasks()->create($request->only([
        'name_task',
        'description',
        'status',
        'priority',
        'due_date',
    ]));
        return response()->json([
            'message'=>'Tâche créée avec succès',
            'task'=>new TaskResource($task)
        ],201);
    }

    /**
     * affiche les détails d'une tâche spécifique de l'utilisateur connecté
     */
    public function show(Request $request, Task $task)
    {
        if($task ->user_id !== $request->user()->id){
            return response()->json([
                'message'=>'Action non autorisée'
                
            ],403);
        }

        return new TaskResource($task);
    }

    /**
     * met à jour une tâche spécifique de l'utilisateur connecté
     */
    public function update(UpdateTaskRequest $request, Task $task)
    {
        if($task->user_id !== $request->user()->id){
            return response()->json([
                'message'=>'Action non autorisée'
            ],403);
        }
       $task->update($request->only([
        'name_task',
        'description',
        'status',
        'priority',
        'due_date',
    ]));
        return response()->json([
            'message'=>'Tâche modifiée avec succès',
            'task'=>new TaskResource($task)
        ]);
        
    }

    /**
     * supprime une tâche spécifique de l'utilisateur connecté
     */
    public function destroy(Request $request, Task $task){
        if($task->user_id !== $request->user()->id){
            return response()->json([
                'message'=>'Action non autorisée'
            ],403);
        }

        $task->delete();
        return response()->json([
            'message'=>'Tâche supprimée avec succès'
        ]);

    }
    
}
