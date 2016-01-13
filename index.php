<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8">
        <title></title>
    </head>
    <body>
        <?php

        $name  = "Jim";
        $what  = "geek";
        $level = 10;
        echo 'Hi, my name is ' . $name . ' and I am a level ' . $level . ' ' . $what;

        $hoursworked = 10;
        $rate = 12;
        $total = $hoursworked * $rate;
        echo "<br />You owe me " . $total . "<br />";

        if($hoursworked > 40) {
            $total = $hoursworked * $rate *1.5;
        } else {
            $total = $hoursworked * $rate;
        }

        echo ($total > 0) ? 'You owe me ' . $total : "You're welcome!";

        ?>
</body>
</html>
