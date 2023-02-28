<?php

/** @var Connection $connection */
$connection = require_once 'pdo.php';
// Read notes from database
$notes = $connection->getNotes();

$currentNote = [
    'id' => '',
    'title' => '',
    'description' => ''
];
if (isset($_GET['id'])) {
    $currentNote = $connection->getNoteById($_GET['id']);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Notepad by Swarnadeep</title>
    <link rel="stylesheet" href="app.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
<div class="header">
  <h1>Notepad</h1>
</div>
<div>
    <div class="wrapper">
    <form style="background: white; padding: 20px; border-radius: 5px;" class="new-note" action="create.php" method="post">
        <input type="hidden" name="id" value="<?php echo $currentNote['id'] ?>"required>
        <input type="text" name="title" placeholder="Note Title" autocomplete="off"
               value="<?php echo $currentNote['title'] ?>" required>
        <textarea name="description" cols="30" rows="4"
                  placeholder="Note Description" required><?php echo $currentNote['description'] ?></textarea>
        <button style="background: #5900FF; border: none; color: white;" >
            <?php if ($currentNote['id']): ?>
                Update
            <?php else: ?>
                Save
            <?php endif ?>
        </button>
    </form>
    </div>
    <div class="notes">
        <?php foreach ($notes as $note): ?>
            <div class="note">
                <div class="title">
                    <a href="?id=<?php echo $note['id'] ?>">
                        <?php echo $note['title'] ?>
                    </a>
                </div>
                <div class="description">
                    <?php echo $note['description'] ?>
                </div>
                <small><?php echo date('d/m/Y H:i', strtotime($note['create_date'])) ?></small>
                <form action="delete.php" method="post">
                    <input type="hidden" name="id" value="<?php echo $note['id'] ?>">
                    <button class="close"><i class="fa fa-trash"></i></button>
                </form>
            </div>
        <?php endforeach; ?>
    </div>
</div>
</body>
</html>