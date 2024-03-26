<?php

date_default_timezone_set('America/Sao_Paulo');

use Connection\Statements;
use Utils\Functions;

require_once("class/Connection/Database.php");
require_once("class/Connection/Statements.php");
require_once("class/Utils/Functions.php");

$statements = new Statements;

$statements->select('*', 'comments');

if ( !empty($_POST) ) {
    $postForm = filter_input_array(INPUT_POST, FILTER_DEFAULT);
    if ( isset($postForm['delete']) AND $postForm['delete'] == 'true' ) {
        unset($postForm['delete']);
        $statements->delete('comments', 'WHERE id = ' . $postForm['id']);
    }

    if ( isset($postForm['create']) AND $postForm['create'] == 'true' ) {
        unset($postForm['create']);
        $statements->insert('comments', $postForm);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comentários</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <main class="container mt-5 mb-5">
        <form id="form" action="" method="post">
            <div id="hidden-inputs">
                <input type="hidden" name="created_at" value="<?php echo date('Y-m-d H:i:s') ?>">
                <input type="hidden" name="create" value="true">
            </div>
            <div class="col form-floating">
                <textarea id="comments" class="form-control" name="comments" placeholder="Deixe seu comentário" style="height:250px"></textarea>
                <label for="comments">Comentário</label>
            </div>
            <div class="d-flex justify-content-end align-items-center mt-2">
                <button class="btn btn-outline-primary d-flex align-items-center gap-2" id="submit" type="submit">Enviar <i class="bi bi-chat"></i></button>
            </div>
        </form>
        
        <section>
            <?php 
            $statements->select('*', 'comments', 'WHERE status = "P"');
            if ( $statements->getRows() > 0 ) {
                foreach ( $statements->getResult() as $comments) {
                    echo "<form action='' class='mt-5' method='post'>";
                    $commentID = $comments['id'];
                    $comment = $comments['comments'];
                    $createdAt = Functions::brazilianDate($comments['created_at'], true);
                    $updatedAt = $comments['updated_at'];
                    
                    // Timestamp
                    echo "<div class='ml-5'><small><strong>$createdAt</strong></small></div>";
                    
                    // Comment card
                    echo "<div class='border p-3 rounded-2 shadow-sm d-flex justify-content-between align-items-center'>",
                         "<span class='d-flex gap-4 align-items-center'>
                         <img src='assets/user.jpg' class='img-thumbnail user-img'>
                         $comment
                         </span>",
                         "<button class='rounded-button' type='submit'><i class='bi bi-x-circle' style='font-size:1.5rem;'></i></button>",
                         "</div>";

                    //  Hidden inputs
                    echo "<div class='hidden-inputs'>",
                         "<input type='hidden' name='id' value='$commentID'>",
                         "<input type='hidden' name='delete' value='true'>",
                         "</div>",
                         "</form>";
                }
            }
            ?>
        </section>
    </main>
    <script src="js/index.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>