<?php
session_start();

function fileAppend($name){
    $data = json_decode(file_get_contents("requests.json"), TRUE);
    $data[$_SESSION["id"]] = [$name, false];
    file_put_contents("requests.json", json_encode($data));
}

function getStatus(){
    $data = json_decode(file_get_contents("requests.json"), TRUE);
    return $data[$_SESSION["id"]][1];
}

if (!empty($_POST["name"])){
    if (empty($_SESSION["id"])){
        $_SESSION["id"] = time();
        fileAppend($_POST["name"]);
    }
}

if (!empty($_SESSION["id"])){
    if(getStatus()){
        echo "<h3>Добро пожаловать</h3>";
        die();
    }else{
        echo "<h3>Ожидание входа...</h3>";
        header("Refresh: 5");
        die();
    }
}

?>
<html>
    <head>
        <title>Модерация входа</title>
    </head>
<body>
<form action="" method="POST">
    <input type="text" name="name" placeholder="Ваше имя">
    <button type="submit">Войти</button>
</form>
</body>
</html>
