<?php

namespace AppBundle\Model;

class TodoModel
{
    private static $initTodos = [
        [
            'task' => 'Installer Symfony',
            'status' => 'undone',
            'created_at' => '2017-05-12 14:12:05',
        ],
        [
            'task' => 'Faire la vaisselle',
            'status' => 'undone',
            'created_at' => '2017-06-24 09:52:31',
        ],
        [
            'task' => 'Démarrer le challenge',
            'status' => 'undone',
            'created_at' => '2017-07-02 18:36:45',
        ],
    ];

    private static function setTodos($todos)
    {
        // La session est-elle démarrée ?
        if (!isset($_SESSION)) {
            session_start();
        }

        $_SESSION["todos"] = $todos;
    }

    private static function getTodos()
    {
        if(!isset($_SESSION["todos"]))
        {
            self::setTodos(self::$initTodos);
        }
        return $_SESSION["todos"];

    }

    public static function find($index)
    {
        $todos = self::getTodos();
        if(isset($todos[$index]))
        {
            return $todos[$index];
        }
        return false;
    }

    public static function findAll()
    {
        return self::getTodos();
    }

    public static function setStatus($id, $status)
    {
        $todos = self::getTodos();
        if(isset($todos[$id]) && ($status == 'done' || $status == 'undone' ))
        {
            $todos[$id]['status'] = $status;
            self::setTodos($todos);
            return true;
        }
        return false;
    }

    // fonction pour ajouter une tâche à la liste
    public static function add($task)
    {
        $todos = self::getTodos();

        $dateTime = new \DateTime();
        $todos[] = [
            'task' => strip_tags($task),
            'status' => 'undone',
            'created_at' => $dateTime->format('Y-d-m H:i:s'),
        ];

        self::setTodos($todos);
    }

    // fonction pour enlever une tâche de la liste à partir de son index
    public static function delete($index)
    {
        $todos = self::getTodos();

        if(isset($todos[$index]))
            unset($todos[$index]);

        self::setTodos($todos);
    }
}
