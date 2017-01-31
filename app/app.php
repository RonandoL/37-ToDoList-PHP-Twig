<?php
    date_default_timezone_set('America/Los_Angeles');
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/tasks.php";

    session_start();                          // For global variable, saving in browser cache
    if (empty($_SESSION['array_of_tasks'])) {
        $_SESSION['array_of_tasks'] = array();
    }

    $app = new Silex\Application();

    $app->get("/", function() {
        $output = "";                  // 1. create output variable for browser
        $all_tasks = Tasks::getAll();  // 2. create variable for array
                                       // 3. print out homepage HTML
        $output .= "
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
        ";

        if (!empty($all_tasks)) {         // 4. IF array of tasks is NOT empty
            foreach ($all_tasks as $task) {
                $output .= "
                    <p>" . $task->getTask() . "</p>
              ";
            }
        }
        $output .= "
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

    return $output;
    });

    $app->post("/tasks", function() {   // 5. New Route to confirmation page
        $task = new Tasks($_POST["task"]);   // 6. Instantiate a Task object
        $save = $task->save();

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
                <h1>Your new task</h1>
                <div class='row'>
                  <div class='col-md-4'>"
                      . $task->getTask() .
                      "<br><a href='/'>See All Tasks</a>
                      </div> <!-- .col-md-4 -->
                    </div> <!-- .row -->
                  </div> <!-- .container -->
                </body>
              </html>
              ";
    });

    $app->post('/', function() {
        Tasks::deleteAll();

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
