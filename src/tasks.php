<?php
    class Tasks
    {
        private $description;

        function __construct($task_description)
        {
            $this->description = $task_description;
        }

        //SETTER and GETTER
        function setTask($new_task)
        {
            $this->description = $new_task;
        }
        function getTask()
        {
            return $this->description;
        }

        // SAVE()
        function save()  // Adds instantiation of Task object to array
        {
            array_push($_SESSION['array_of_tasks'], $this);
        }

        // GET ALL TASKS = GET THE ARRAY
        static function getAll()
        {
            return $_SESSION['array_of_tasks'];
        }

        // DELETE TASKS EMPTY ARRAY
        static function deleteAll()
        {
            $_SESSION['array_of_tasks'] = array();
        }

    }
?>
