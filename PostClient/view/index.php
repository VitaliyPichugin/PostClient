<!DOCTYPE html>
<html  lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?=$title?></title>
    <link href="view/css/bootstrap.css" rel="stylesheet" >
    <link href="view/css/jquery-ui.min.css" rel="stylesheet" type="text/css">
    <link href="view/css/style.css" rel="stylesheet" >
    <link href="view/css/DT.css" rel="stylesheet">
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body id="body">

<section class="header">
    <nav class="navbar navbar-default navbar-inverse container" role="navigation">
        <div class="container-fluid">
            <?php if($_SESSION['email'] && $_SESSION['pass'] && !$_SESSION['login_error']): ?>
                <p class="navbar-text">Ваша почта <span class="user"><?=$_SESSION['email']?></span></p>
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <form class="navbar-form navbar-right" role="search" method="post">
                    <input type="submit" class="btn btn-default" name="logout" value="Выйти">
                </form>
            </div>
            <?php endif; ?>

            <?php if(!$_SESSION['email'] && !$_SESSION['pass']): ?>
                    <p class="navbar-text" >Для отправки почты войдите</p>
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <form class="navbar-form navbar-right" role="search" method="post">
                        <div class="form-group">
                            <input type="email" class="form-control" required="required" name="email" placeholder="E-mail">
                            <input type="password" class="form-control" name="pass" placeholder="Password" required="required">
                        </div>
                        <input type="submit" class="btn btn-default" name="login" value="Войти">
                    </form>
                </div>
           <?php endif; ?>
            <?php if($_SESSION['login_error'] && $_SESSION['email']): ?>
                <p class="navbar-text">Был введен неверный пароль от почты - <span class="user"><?=$_SESSION['email']?></span></p>
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <form class="navbar-form navbar-right" role="search" method="post">
                        <input type="submit" class="btn btn-default" name="logout" value="Попробовать снова">
                    </form>
                </div>
            <?php endif; ?>
        </div>
        <!-- /.container-fluid -->
    </nav>
</section>

<?php if($_SESSION['email'] && $_SESSION['pass'] && !$_SESSION['login_error']): ?>

<section class="content container modal-content con">
    <div class=" col-md-3 tbl_left">
        <div  class="modal-form " style="display: none">
           <form  method="post" action="index.php">
                <input class="form-control" type="email" placeholder="Кому*" id="email" required="required">
                <input class="form-control" type="text" placeholder="Тема" id="sub" required="required">
               <br>
                <textarea rows="4" class="form-control" placeholder="Введите текст*" id="message"></textarea>
            </form>
        </div>
        <ul class="list-group">
            <!--<li class="list-group-item"><a href="#">Входящие</a></li>
            <li class="list-group-item"><a href="#">Исходящие</a></li>-->
            <li class="list-group-item"><a href="index.php">Архив сообщений</a></li>
        </ul>
    </div>

    <div class="col-md-9 tbl" >
        <form class="form-group" method="post" action="index.php" name="tableForm">
        <ul class="list-inline">
            <li class="list-inline">
                <p class="send btn btn-default pull-left btn-sm">Написать <span class="glyphicon glyphicon-comment"></span></p>
            </li>
            <li class="list-inline">
                <input type="submit" class="btn btn-default pull-left btn-sm" id="del" name="del_msg" value="Удалить ">
            </li>
        </ul>
        <table id="PostTable" class="display" width="100%" cellspacing="0">
            <thead>
            <tr>
                <th class="text-center"><input type="checkbox" id="all_check"></th>
                <th>Кому <span class="glyphicon glyphicon-sort"></span> </th>
                <th>Тема</th>
                <th>Дата <span class="glyphicon glyphicon-sort"></span></th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($messages as $message): ?>
                <tr>
                    <td class="text-center" scope="row"><input type="checkbox" value="<?=$message['id']?>" class="msg" name="message[]"></td>
                    <td><?=$message['to_mail']?></td>
                    <td><?=$message['subject']?></td>
                    <td><?=$message['date']?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        </form>
 </div>
<script src="view/js/jquery-3.2.1.js"></script>
<script src="view/js/jquery-ui.min.js"></script>
<script src="view/js/bootstrap.min.js"></script>
<script src="view/js/script.js"></script>
<script src="view/js/DT.js"></script>
<script src="view/js/DST.js"></script>
</section>
    <?php endif; ?>
</body>
</html>


