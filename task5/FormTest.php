<?php

use PHPUnit\Framework\TestCase;

class FormTest extends TestCase
{
    private $db;

    protected function setUp(): void
    {

        $dsn = 'mysql:host=localhost;dbname=todolist';
        $username = 'root';
        $password = '';
        $this->db = new PDO($dsn, $username, $password);
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


        $this->db->exec("CREATE TABLE IF NOT EXISTS task (
            id INT AUTO_INCREMENT PRIMARY KEY,
            taskname VARCHAR(255) NOT NULL,
            status VARCHAR(50) NOT NULL DEFAULT 'Невыполнено'
        )");
    }

    protected function tearDown(): void
    {

        $this->db->exec("DROP TABLE IF EXISTS task");
    }

    public function testAddTaskForm()
    {

        $_POST['taskname'] = 'Test Task';
        $_POST['save'] = true;


        ob_start();
        include 'index.php';
        ob_end_clean();


        $stmt = $this->db->prepare("SELECT * FROM task WHERE taskname = ?");
        $stmt->execute(['Test Task']);
        $task = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->assertEquals('Test Task', $task['taskname']);
    }

    public function testUpdateTaskForm()
    {

        $stmt = $this->db->prepare("INSERT INTO task (taskname) VALUES (?)");
        $stmt->execute(['Old Task']);
        $taskId = $this->db->lastInsertId();


        $_POST['update'] = 'Updated Task';
        $_POST['formid2'] = $taskId;
        $_POST['buttonupdate'] = true;


        ob_start();
        include 'index.php';
        ob_end_clean();


        $stmt = $this->db->prepare("SELECT * FROM task WHERE id = ?");
        $stmt->execute([$taskId]);
        $task = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->assertEquals('Updated Task', $task['taskname']);
    }

    public function testUpdateTaskStatusForm()
    {

        $stmt = $this->db->prepare("INSERT INTO task (taskname) VALUES (?)");
        $stmt->execute(['Task with Status']);
        $taskId = $this->db->lastInsertId();

        $_POST['taskstatus'] = 'Выполнено';
        $_POST['formid'] = $taskId;
        $_POST['savecheckbox'] = true;


        ob_start();
        include 'index.php';
        ob_end_clean();


        $stmt = $this->db->prepare("SELECT * FROM task WHERE id = ?");
        $stmt->execute([$taskId]);
        $task = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->assertEquals('Выполнено', $task['status']);
    }

    public function testDeleteTaskForm()
    {

        $stmt = $this->db->prepare("INSERT INTO task (taskname) VALUES (?)");
        $stmt->execute(['Task to Delete']);
        $taskId = $this->db->lastInsertId();

        $_POST['delete'] = $taskId;


        ob_start();
        include 'index.php';
        ob_end_clean();

        $stmt = $this->db->prepare("SELECT * FROM task WHERE id = ?");
        $stmt->execute([$taskId]);
        $task = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->assertFalse($task);
    }
}