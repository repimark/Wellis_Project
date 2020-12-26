<?php
    session_start();
    if(!isset($_SESSION['u_id'])){
        header('login.php');
    }else{
        include 'connect.php';

        //SELECT COUNT(dolgozok.d_id), terulet.t_elnevezes FROM dolgozok, terulet WHERE dolgozok.t_id = terulet.t_id GROUP BY dolgozok.t_id
    }
?>