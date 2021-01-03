<?php
    session_start();
    if(!isset($_SESSION['u_id'])){
        header('login.php');
    }else{
        include '../connect.php';

        //SELECT TERULET 
        
        //SELECT Saját létszám where terulet = te

        //SELECT Kölcsönzött létszám where terulet = te

        //SELECT ÖsszesLétszám where allapot = kolcsonzott és dolgozo WHERE terulet = te 

        //SELECT Saját bejövő where allapot = bejövő AND terulet = te

        //SELECT Kölcsönzött bejövő WHERE allapot = kölcsönzött bejövő AND terulet = te

        //SELECT SZUM bejövö WHERE allapot = bejövő AND allapot = kölcsönzött bejövő AND terulet = te 

        //SELECT igeny WHERE terulet = ter 

        //SUM MINDENT 


        //TÁBLÁBA
        
    }
