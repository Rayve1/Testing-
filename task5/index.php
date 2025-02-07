<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

    <?
        $dsn = 'mysql:host=localhost;dbname=todolist';
        $username = 'root';
        $password = '';

        $db = new PDO($dsn, $username, $password);
    ?>



    <form action="" method="POST">
        <input type="text" name="taskname" placeholder="taskname">
        <button type="submit" name="save">Сохранить</button>
    </form>

    <?
        if ($_SERVER['REQUEST_METHOD'] === 'POST'){
            if(isset($_POST['save'])){
                $taskname = $_POST['taskname'];
                $stmt = $db->prepare("INSERT INTO task(taskname) VALUES (?)");
                $stmt->execute([$taskname]);
                header('Location: index.php');
                exit;
            }
        }
        
    ?>


    <?
        $stmt = $db->prepare("SELECT * FROM task");
        $stmt->execute();
        $tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);

    ?>

    <? foreach ($tasks as $task): ?>
        
        <h1>
            <? echo $task['taskname'] . ": " . $task['status']; ?>
        </h1>

        <form method="POST" action="">
            <input name="formid" type="hidden" value="<?= $task['id'];?>">
                <select name="taskstatus" id="options">
                    <option value="Выполнено">Выполнено</option>
                    <option value="Невыполнено">невыполнено</option>
                </select>
            <button type="submit" name="savecheckbox">Сохранить состояние</button>
        </form>

        <form method="POST" action="">

            <input name="formid2" type="hidden" value="<?= $task['id'];?>">
            <input type="text" name="update" placeholder="Изменить">
            <button name = "buttonupdate" type="submit">Обновить</button>

        </form>

        <form action="" method="POST">
            <input name="delete" type="hidden" value="<?= $task['id'];?>">
            <button type="submit">Удалить</button>
        </form>

    <? endforeach; ?>

    <?
        if ($_SERVER['REQUEST_METHOD'] === 'POST'){
            if(isset($_POST['buttonupdate'])){
                $update = $_POST['update'];
                $taskid = $_POST['formid2'];
                $stmt = $db->prepare("UPDATE task SET taskname = ? WHERE id = ?");
                $stmt->execute([$update, $taskid]);
                header('Location: index.php');
                exit;
            }
        }
    ?>    

    <?
        if ($_SERVER['REQUEST_METHOD'] === 'POST'){
            if(isset($_POST['savecheckbox'])){
                $taskstatus = $_POST['taskstatus'];
                $taskid = $_POST['formid'];
                $stmt = $db->prepare("UPDATE task SET status = ? WHERE id = ?");
                $stmt->execute([$taskstatus, $taskid]);
                header('Location: index.php');
                exit;
            }
        }
    ?>

    <?
        if ($_SERVER['REQUEST_METHOD'] === 'POST'){
            if(isset($_POST['delete'])){
                $delete = $_POST['delete'];
                $stmt = $db->prepare("DELETE FROM `task` WHERE id = :id");
                $stmt->bindParam(':id', $delete, PDO::PARAM_INT);
                $stmt->execute();
                header('Location: index.php');
                exit;
            }
        }
    ?>
</body>
</html>