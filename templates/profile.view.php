<?php
    include __DIR__. '/../app/profile.php';


//    var_dump($user);die;

//}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <title>##########</title>
    <link rel="icon" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 128 128%22><text y=%221.2em%22 font-size=%2296%22>⚫️</text></svg>">



</head>
<body>
<div class="container-fluid">

    <?php
    include __DIR__. '/../templates/headerLogin.view.php';
    ?>

    <?php
    if (Session::exists('registerError')) {
        include __DIR__. '/../templates/messageDanger.view.php';
    }
    if (Session::exists('successCreateUser')) {
        include __DIR__. '/../templates/messageSuccess.view.php';
    }
    ?>

    <div class="container-fluid">
        <main class="form-signin w-100 m-auto">
            <div class="row justify-content-center">
                <div class="col-md-4 ">
                    <div class="position-absolute top-50 start-50 translate-middle">

                        <body class="text-center">

                        <form method="post" action="/updateProfile" name="form">
                            <h1 class="h3 mb-3 fw-normal">Профиль</h1>
<!--                            <div class="mb-3">-->
<!--                                You are logged in as ##########, <a href="##########">Logout</a>-->
<!--                            </div>-->



                            <div class="form-floating">
                                <input type="text" value="<?php echo $user->getName() ?>" name="name" class="form-control" id="floatingInput" placeholder="name@example.com" autocomplete="name" required autofocus>
                                <label for="floatingInput">Имя</label>
                            </div>
                            <div class="form-floating">
                                <input type="text" value="<?php echo $user->getPhone() ?>" name="phone" class="form-control" id="floatingInput" placeholder="name@example.com" autocomplete="phone" required autofocus>
                                <label for="floatingInput">Телефон</label>
                            </div>

                            <div class="form-floating">
                                <input type="email" value="<?php echo $user->getEmail() ?>" name="email" class="form-control" id="floatingInput" placeholder="name@example.com" autocomplete="email" required autofocus>
                                <label for="floatingInput">Email</label>
                            </div>

                            <input type="hidden" name="token" value="##########">

                            <a href="/updatePassword" class="w-100 btn btn-lg btn-success" type="submit">
                                Сменить пароль
                            </a>
                           <div class="checkbox mb-3">
                                    <label>

                                        </label>
                                </div>


                           <div class="mb-3">

                           <button  class="w-100 btn btn-lg btn-primary" type="submit">
                              Применить
                           </button>
<?php //var_dump($_POST); die;?>
                            </div>

                        </form>

                        </body>
                    </div>
                </div>
            </div>
        </main>
    </div>

</div>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
</body>
</html>
