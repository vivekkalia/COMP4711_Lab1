<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        $squares = $_GET['board'];


        $game = new Game($squares);
        $game->display();
        if($game->winner('x')) {
            echo 'You win. Lucky guesses!';
        } else if ($game->winner('o')) {
            echo 'I win. Muahahahaha';
        } else {
            echo 'No winner yet, but you are losing.';
        }


        ?>
</body>
</html>

<?php
class Game {
    var $position;
    var $newposition;

    function __construct($squares) {
        $this->position = str_split($squares);
    }

    function winner($token) {
        $won = false;
        for ($row = 0; $row < 3; $row++) {
            if (($this->position[3 * $row] == $token) && ($this->position[3 * $row + 1]
                    == $token) && ($this->position[3 * $row + 2] == $token)) {
                $won = true;
            }
        }
        for ($col = 0; $col < 3; $col++) {
            if (($this->position[$col] == $token) &&
                ($this->position[$col + 3] == $token) &&
                ($this->position[$col + 6] == $token)) {
                $won = true;
            }
        }
        if (($this->position[0] == $token) &&
            ($this->position[4] == $token) &&
            ($this->position[8] == $token)) {
            $won = true;
        }
        if (($this->position[2] == $token) &&
            ($this->position[4] == $token) &&
            ($this->position[6] == $token)) {
            $won = true;
        }
        return $won;
    }

    function display() {
        echo '<table cols="3" style="font-size:large; font-weight:bold">';
        echo '<tr>';
        for($pos = 0; $pos < 9; $pos++) {
            echo '<td>'.$this->show_cell($pos).'</td>';
            if($pos % 3 == 2) echo '</tr><tr>';
        }
        echo '</tr>';
        echo '</table>';
    }

    function show_cell($which) {
        $token = $this->position[$which];
        // deal with the easy case
        if($token <> '-') return '<td>' . $token . '</td>';
        // now the hard case
        $this->newposition = $this->position;
        $this->newposition[$which] = 'o';
        $move = implode($this->newposition);
        $link = '/?board='.$move;
        return '<td><a href="'.$link.'">-</a></td>';
    }

}


?>
