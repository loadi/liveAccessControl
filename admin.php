<?php

$LOGIN = "admin";
$PASSWORD = "admin";

function getLogins(){
    $data = json_decode(file_get_contents("requests.json"), TRUE);
    return $data;
}

function changeStatus($id){
    $data = json_decode(file_get_contents("requests.json"), TRUE);
    $data[$id][1] = !$data[$id][1];
    file_put_contents("requests.json", json_encode($data));
}

if (isset($_POST["id"])) {
    changeStatus($_POST["id"]);
}

if(isset($_POST["login"], $_POST["password"])){
    if ($_POST["login"] == $LOGIN && $_POST["password"] == $PASSWORD){
        $_SESSION["admin"] = True;
    }
}

if (!isset($_SESSION["admin"])){
    $line = "
    <form action='' method='POST'><input type='text' name='login' placeholder='login'>
    <input type='password' name='password' placeholder='password'>
    <button type='submit'>Войти</button></form>
    ";
    echo $line;
    die();
}
?>

<html lang="ru">
<head>
    <title>Админка</title>
</head>
<body>
<table>
    <thead>
        <tr>
            <td>Логин</td>
            <td>Время</td>
            <td>Доступ</td>
        </tr>
    </thead>
    <tbody>
    <?php

    foreach (getLogins() as $id => $data){
        $name = $data[0];
        $allow = $data[1] ? "Разрешен" : "Запрещен";
        $reqDate = date("d.m.y G:i", $id);
        $line = "<tr>
                    <td>$name</td>
                    <td>$reqDate</td>
                    <td><p id='$id'>$allow</p></td>
                 </tr>";
        echo $line;
    }
    ?>
    </tbody>
</table>
<script>
    function changeStatus(id){
        var xhr = new XMLHttpRequest();
        xhr.open('POST', '', false);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.send("id=" + id);
        location.reload()
    }

    var p = document.getElementsByTagName("p");
    for (let i = 0; i < p.length; i++){
        p[i].addEventListener("click", (e) =>{
            changeStatus(e.target.id);
        });
    }
</script>
</body>
</html>
