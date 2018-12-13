<?php

namespace App\Controller;

use App\Model\TodoModel;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TodoController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function showHome()
    {
        return $this->render('todo/home.html.twig', [
            'controller_name' => 'TodoController',
        ]);
    }

    /**
     * @Route("/task-list", name="task_list")
     */
    public function showTaskList()
    {
        $todos = new TodoModel();
        $todosAll = $todos->findAll();

        //dump($_SESSION);
        return $this->render('todo/task_list.html.twig', [
            'session' => $_SESSION,
            'todosAll' => $todosAll
        ]);
    }

    /**
     * @Route("/task/{id}", name="show_task")
     */
    public function showTask($id)
    {
        // $todos = new TodoModel();
        // // on cible la tâche à supprimer
        // $taskToShow = $todos->find($id);
        // //dd($taskToDelete);

        // // on récupère l'intitulé de la tâche
        // $taskNameToShow = $taskToShow['task'];
        // // dd($taskNameToDelete);

        dump($_SESSION);
        return $this->render('todo/task.html.twig', [
            'session' => $_SESSION,
            'id' => $id
        ]);
    }

    /**
     * @Route("/reset-task", name="reset_task")
     */
    public function resetTaskList()
    {
        $todos = new TodoModel();
        $todos->reset();

        return $this->redirectToRoute('task_list', [
            'session' => $_SESSION
        ]);

        // return $this->render('todo/task_list.html.twig', [
        //     'session' => $_SESSION
        // ]);
    }

    /**
     * @Route("/add-task", name="add_task", methods={"POST"})
     */
    public function addTask(Request $request)
    {
        $newTaskName = $request->get('inputNewTaskName');
        //dump($request->get('inputNewTaskName'));
        $todos = new TodoModel();
        $todos->add($newTaskName);

        $this->addFlash(
            'success',
            'La tâche ' . $newTaskName . ' a bien été ajoutée.'
        );

        return $this->render('todo/task_list.html.twig', [
            'session' => $_SESSION
        ]);
    }

    /**
     * @Route("/delete-task", name="delete_task", methods={"POST"})
     */
    public function deleteTask(Request $request)
    {
        // on récupère l'id de la tâche à supprimer
        $taskIdToDelete = $request->get('taskIdToDelete');
        
        $todos = new TodoModel();
        // on cible la tâche à supprimer
        $taskToDelete = $todos->find($taskIdToDelete);
        //dd($taskToDelete);

        // on récupère l'intitulé de la tâche
        $taskNameToDelete = $taskToDelete['task'];
        // dd($taskNameToDelete);

        // on supprime la tâche
        $todos->delete($taskIdToDelete);

        // on stocke un message flash
        if ($taskToDelete) {
            $this->addFlash(
                'success',
                'La tâche ' . $taskNameToDelete . ' a bien été supprimée.'
            );
        } else {
            $this->addFlash(
                'fail',
                'La tâche ' . $taskNameToDelete . ' n\'a pas été supprimée.'
            );
        }
        
        return $this->render('todo/task_list.html.twig', [
            'session' => $_SESSION
        ]);
    }

    /**
     * @Route("/set-status/{id}/{status}", name="set_status", requirements={done,undone}, methods={"POST"})
     */
    public static function todoSetStatusAction($id, $status)
    {
        
    }
}
