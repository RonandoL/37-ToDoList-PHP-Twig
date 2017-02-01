<?php

    date_default_timezone_set('America/Los_Angeles');
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/tasks.php";

    session_start();                          // For global variable, saving in browser cache
    if (empty($_SESSION['array_of_tasks'])) {
        $_SESSION['array_of_tasks'] = array();
    }

    $app = new Silex\Application();

    $app->register(new Silex\Provider\TwigServiceProvider(), array(
        'twig.path' => __DIR__.'/../views'
    ));
  // End Red Tape

  // 1. Route for home page - The route is where we put the the information together and making sure it's in the correct form (an array, or a string etc)
    $app->get("/", function() use ($app) {
        return $app['twig']->render('tasks.html.twig', array('tasks' => Task::getAll()));
    });

  // 2. Route for sending instantiated new object (new task) to /tasks URL
    $app->post("/tasks", function() use ($app) {
        $task = new Task($_POST["task"]);     // Instantiation
        $save = $task->save();
        return $app['twig']->render('create_task.html.twig', array('newtask' => $task, 'tasks' => Task::getAll()));
    });

  // 3. Route for deleting all tasks
    $app->post('/delete', function() use ($app) {
        Task::deleteAll();
        return $app['twig']->render('delete_tasks.html.twig');
    });

    return $app;

?>
