<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function sys_session_test(){
    session_name("MELOLSESSION");
    session_start();
    if (isset($_SESSION["userId"]) && isset($_SESSION["sessionId"]) && isset($_REQUEST["sessionId"])) {
            if ($_SESSION["sessionId"] == $_REQUEST["sessionId"]) {
                return TRUE;
            }
    }
    return FALSE;
}

function sys_session_create($userId, $force = FALSE){
    if (!sys_session_test() || $force){
        if (!empty($userId)) {
            $sessionId = md5(uniqid(mt_rand(), true));
            $_SESSION["sessionId"] = $sessionId;
            $_SESSION["userId"] = $userId;
            return $sessionId;
        }
    }
    return "";
}


function sys_session_destroy(){
    $_SESSION = array();
    session_destroy();
}

function sys_user_verify($userName, $userPassword){
    if (!empty($userName) && !empty($userPassword)) { #Si no esta vacio continua
        $userId = sys_user_getId($userName); #Obtenemos el userID mediante otra funcion
        if (!empty($userId)){ # Si el user id no esta vacio continuamos
            # read hashed password from database
            #######
            require 'conexion.php';
            $querrylog=  mysql_db_query($config['dbName'], "SELECT userPass"
                    . "From users"
                    . "WHERE userNick = '$userName'"
                    . "LIMIT 1");
            #######
            $dbPassword = password_hash("melol", PASSWORD_DEFAULT); # Saca el valor de la contraseña
            if (password_verify ($userPassword , $dbPassword )){ #Comprueba si la contraseña y el usuaio son correctos
                return TRUE;
            }
        }
    }
    return FALSE;
}

function sys_user_getId($userName){
    $userId="";
    if (!empty($userName)) {
        # search user in DATABASE
        if ($userName == "melol"){
            #search Id in DATABASE
            $userId = "1" ;
        }
    }
    return $userId;
}
