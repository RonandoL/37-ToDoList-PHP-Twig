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

        return $app['twig']->render('create_task.html.twig', array('newtask' => $task));
    });

    $app->post('/', function() {
        Task::deleteAll();

        return "
          <!DOCTYPE html>
          <html>
            <head>
              <meta charset='utf-8'>
              <title>Tasks: To Do List</title>
              <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css'>
            </head>

            <body>
              <div class='container'>
                <h1>Tasks: To Do List</h1>
                <div class='row'>
                  <div class='col-md-4'>
                  <form action='/tasks' method='post'>
                    <div class='form-group'>
                      <label for='task'>Enter task you need done</label>
                      <input type='text' name='task' id='task' class='form-control' placeholder='Personal Slave'>
                    </div>

                    <button type='submit' class='btn btn-lg btn-info'>Submit Task</button>
                  </form>

                  <br><form action='/' method='post'>
                    <button type='submit' class='btn'>Delete All Tasks</button>
                  </form>

                  </div> <!-- .col-md-4 -->
                  </div> <!-- .row -->
                  </div> <!-- .container -->
                  </body>
                  </html>
                  ";
    });

    return $app;

?>
