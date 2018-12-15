<?php

namespace App\Controller;

use App\Model\TodoModel;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
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
        $todosAll = TodoModel::findAll();

        //dump($_SESSION);
        return $this->render('todo/task_list.html.twig', [
            'session' => $_SESSION,
            'todosAll' => $todosAll
        ]);
    }

    /**
     * @Route("/task/{id}", name="show_task", requirements={"id"="\d+"})
     */
    public function showTask($id)
    {
        // on cible la tâche à afficher
        $todo = TodoModel::find($id);

        if(!$todo) {
            throw $this->createNotFoundException('Tâche non trouvée');
        }

        //dump($_SESSION);
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
     * 
     */
    public function deleteTask(Request $request)
    {
        // on récupère l'id de la tâche à supprimer
        $taskIdToDelete = $request->request->get('id');
        //dd($taskIdToDelete);

        // on cible la tâche à supprimer
        $taskToDelete = TodoModel::find($taskIdToDelete);

        // on récupère l'intitulé de la tâche
        $taskNameToDelete = $taskToDelete['task'];
        // dd($taskNameToDelete);

        // on supprime la tâche
        TodoModel::delete($taskIdToDelete);
        //dd($taskToDelete);

        // $response = new Response();

        // $response->headers->set('Content-Type', 'application/json');
        // // Allow all websites
        // $response->headers->set('Access-Control-Allow-Origin', '*');

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
        
        // return $this->render('todo/task_list.html.twig', [
        //     'session' => $_SESSION
        // ]);

        // return $response;

        return $this->json([
            'code' => 200,
            'message' => 'tâche supprimée avec succès'
        ], 200);
    }

    /**
     * @Route("/set-status/{id}/{status}",
     * name="set_status",
     * condition="'id' matches '/\d+/' and 'status' in ['done','undone']")
     */
    // public function todoSetStatusAction($id, $status)
    // {
    //     return $this->render('todo/task_list.html.twig');
    // }

    // /**
    //  * @Route("/set-status/{id}/{status}",
    //  * name="set_status",
    //  * requirements={"id": "\d+", "status": "{done}|{undone}"})
    //  */
    // public function todoSetStatusAction($id, $status)
    // {
    //     return $this->render('todo/home.html.twig');
    // }

    // /**
    //  * @Route("/ajax", name="ajax", methods={"POST|GET"}) 
    //  */
    // public function callAjax(Request $request)
    // {
    //     return ;
    // }

}
