<?php
        $host = "82.66.207.188";
        $port = "5432";
        $dbname = "SAE";
        $user = "nicolas";
        $password = "NN8yM8NXSQyaYvd"; 
        $connection_string = "host={$host} port={$port} dbname={$dbname} user={$user} password={$password} ";
        $dbconn = pg_connect($connection_string);
        echo"ok 1";

        if (isset($_POST['login']) && isset($_POST['password'])) {
            echo"ok 2";
            // $hashpassword = md5($_POST['pwd']);
            $sql ="select * from utilisateurs where login = '".pg_escape_string($_POST['login'])."' and password ='".pg_escape_string($_POST['password'])."'";
            // $sql = "SELECT * FROM utilisateurs WHERE login = '$login' AND password = '$password'";
            $data = pg_query($dbconn,$sql); 
            $login_check = pg_num_rows($data);
            echo"ok 3";
            if($login_check > 0){ 

                echo "Login Successfully";    
            }else{

                echo "Invalid Details";
            }
        }
?>