<?php
require_once "../autoload.php";
require_once "../config/config.php";
use Models\User;
use Utils\Functions;

$user = new User;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <?php
    if ( !empty($_POST) ) {
        $postForm = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        
        $user->exeRegister($postForm);
        if ( $user->getResult() ) {
            // Sucesso
            echo '<div class="alert alert-success">' . $user->getError() . '</div>';
            Functions::location('http://' . URL_BASE . '/pages/login', 3);
        } else {
            // Erro
            echo '<div class="alert alert-danger">' . $user->getError() . '</div>';
        }
    }
    ?>
    <main class="container mt-5">
        <h3 class="text-center">Comments - Register</h3>
        <div class="row justify-content-center align-items-center">
            <section class="col-6">
                <form class="row gap-2" action="" method="post">
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-person"></i></span>
                        <input class="form-control" type="text" name="username" id="username" placeholder="Usuário">
                    </div>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-shield-lock"></i></span>
                        <input class="form-control" type="password" name="password" id="password" placeholder="Senha" minlength="8">
                    </div>
                    <div class="row justify-content-center align-items-center mx-auto">
                        <button class="btn btn-sm btn-primary" type="submit">Login</button>
                    </div>
                </form>
            </section>
        </div>
    </main>
</body>
    <script src="../js/index.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</html>