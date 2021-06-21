<?php
require __DIR__ . '/vendor/autoload.php';

$loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/templates');
$twig = new \Twig\Environment($loader, [
    'cache' => __DIR__ . '/cache'
]);

class TasksRepository {
    public function retrieveTasks(): array {
        $string = file_get_contents("./tasks.json");
        $tasksObject = json_decode($string, true);

        return $tasksObject;
    }

    public function addNewTask($description) {
        $string = file_get_contents("./tasks.json");
        $tasksObject = json_decode($string, true);

        $tasksObject[] = [
            "description" => $description
        ];

        $newTasksObject = json_encode($tasksObject);

        file_put_contents("./tasks.json", $newTasksObject);
    }
}

$tasksRepository = new TasksRepository();

$taskDescription = !empty($_GET["description"]) ? $_GET["description"] : '';

if ($taskDescription != '') {
    $tasksRepository->addNewTask($taskDescription);
}

$tasks = $tasksRepository->retrieveTasks();

echo $twig->render('template.twig', ['tasks' => $tasks]);

?>