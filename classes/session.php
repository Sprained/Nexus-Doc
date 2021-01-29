<?php

session_start();

if(isset($_POST['plano'])) {
    $_SESSION['id_plano'] = $_POST['plano'];
}