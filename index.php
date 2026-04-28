<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todo List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">



<?php
session_start();
include 'db.php';

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION["user_id"];

if (isset($_POST["add_todo"])) {
    $task = trim($_POST["task"]);

    if (!empty($task)) {
        $stmt = $conn->prepare("INSERT INTO todos (user_id, task) VALUES (?, ?)");
        $stmt->bind_param("is", $user_id, $task);
        $stmt->execute();
    }
}

if (isset($_GET["done"])) {
    $todo_id = (int) $_GET["done"];
    $stmt = $conn->prepare("UPDATE todos SET status = 'done' WHERE id = ? AND user_id = ?");
    $stmt->bind_param("ii", $todo_id, $user_id);
    $stmt->execute();
}

if (isset($_GET["delete"])) {
    $todo_id = (int) $_GET["delete"];
    $stmt = $conn->prepare("DELETE FROM todos WHERE id = ? AND user_id = ?");
    $stmt->bind_param("ii", $todo_id, $user_id);
    $stmt->execute();
}

$todos = $conn->prepare("SELECT * FROM todos WHERE user_id = ? ORDER BY id DESC");
$todos->bind_param("i", $user_id);
$todos->execute();
$result = $todos->get_result();
?>




    <nav class="navbar navbar-dark bg-dark">
        <div class="container">
            <span class="navbar-brand mb-0 h1">Moje ToDo</span>
            <div class="text-white">
                Ahoj, <?php echo htmlspecialchars($_SESSION["user_name"]); ?> |
                <a href="logout.php" class="text-warning text-decoration-none">Odhlásiť sa</a>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm mb-4">
                    <div class="card-body">
                        <h3 class="mb-3">Pridať úlohu</h3>
                        <form method="POST" class="d-flex gap-2">
                            <input type="text" name="task" class="form-control" placeholder="Napíš úlohu...">
                            <button type="submit" name="add_todo" class="btn btn-primary">Pridať</button>
                        </form>
                    </div>
                </div>

                <div class="card shadow-sm">
                    <div class="card-body">
                        <h3 class="mb-3">Zoznam úloh</h3>

                        <?php if ($result->num_rows > 0) { ?>
                            <ul class="list-group">
                                <?php while ($row = $result->fetch_assoc()) { ?>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <div>
                                            <?php if ($row["status"] == "done") { ?>
                                                <span class="text-decoration-line-through text-muted">
                                                    <?php echo htmlspecialchars($row["task"]); ?>
                                                </span>
                                            <?php } else { ?>
                                                <span><?php echo htmlspecialchars($row["task"]); ?></span>
                                            <?php } ?>
                                        </div>
                                        <div>
                                            <?php if ($row["status"] != "done") { ?>
                                                <a href="index.php?done=<?php echo $row['id']; ?>" class="btn btn-sm btn-success">Hotovo</a>
                                            <?php } ?>
                                            <a href="index.php?delete=<?php echo $row['id']; ?>" class="btn btn-sm btn-danger">Zmazať</a>
                                        </div>
                                    </li>
                                <?php } ?>
                            </ul>
                        <?php } else { ?>
                            <p class="text-muted mb-0">Zatiaľ nemáš žiadne úlohy.</p>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
