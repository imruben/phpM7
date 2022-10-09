<?php

require 'src\db.php';
require 'config.php';
require 'src\render.php';


try {
    $db = connectMysql($dbhost, $dbuser, $dbpass, $dbname);
    if (!empty($_POST['email']) && !empty($_POST['password'])) {
        if (isset($_POST['email']) && isset($_POST['password'])) {
            $email = $_REQUEST['email'];
            $password =  $_REQUEST['password'];
            $result = $db->query("SELECT * FROM USERS WHERE EMAIL = '"  . $email . "'");
            $user = mysqli_fetch_array($result);

            if (!is_null($user) && $user['email'] == $email && password_verify($password, $user['password'])) {
                $_SESSION['username'] = $user['username'];
                echo render('dashboard');
            } else {
                $logmessage = "Cuenta incorrecta";
                echo render('login', ['logmessage' => $logmessage]);
            }
        }
    }
} catch (mysqli_sql_exception $e) {
    print "Error conexión SQL -> " . $e->getMessage();
}

$loged = false;