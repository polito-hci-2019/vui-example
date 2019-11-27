<?php

if(isset($_POST['submit'])) {
    $userquery = $_POST['message'];

    if(preg_match('/hi|hello/', $userquery)==1)
        echo "hello";
    elseif(preg_match('/weather/', $userquery)==1)
        echo "it will be sunny";
}