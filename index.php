<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        // Set up a game board if not already playing
        if(!isset($_GET['board'])) {
            $squares = $_GET['board'] = '---------';
        } else {
            $squares = $_GET['board'];
        }


        $game = new Game($squares);

        // Check for winners or tie game
        // If both checks fail then keep the playing the game
        if($game->winner('x')) {
            echo 'You win. Lucky guesses!<br />';
            echo '<a href="/">Play Again</a>';
        } else if ($game->winner('o')) {
            echo 'I win. Muahahahaha<br />';
            echo '<a href="/">Play Again</a>';
        } else if($game->tie_game()) {
            echo 'Tie game!<br />';
            echo '<a href="/">Play Again</a>';
        } else {
            echo 'No winner yet, but you are losing.';
            $game->display();
        }


        ?>
</body>
</html>

<?php
class Game {
    var $position;
    var $newposition;
    var $turn = 'x';
    var $gameover = false;
    var $dashes = 0;

    // Game constructor.
    // Gets status of game board.
    function __construct($squares) {
        $this->position = str_split($squares);

        // Check number of dashes to determine if computer can play a turn
        for($cell = 0; $cell < 9; $cell++) {
            if ($this->position[$cell] == '-' ) {
                $this->dashes++;
            }
        }

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
        $this->newposition[$which] = $this->turn;
        if($this->dashes >= 2) {
            $this->newposition[$this->pick_move()] = 'o';
        }
        $move = implode($this->newposition);
        //$link = '/4711l1/index.php?board=' .$move; // This was used for testing purposes
        $link = '/?board='.$move;
        return '<td><a href="'.$link.'">-</a></td>';
    }

    // Function to determine computer's move
    function pick_move() {
        $rand_num = rand(0, 8);
        // Keep choosing a random number between 0 and 8 until
        // you choose a slot that is open
        while($this->newposition[$rand_num] != '-') {
            $rand_num = rand(0, 8);
        }
        return $rand_num;
    }

    // To check for a tie game see if there are 0 dashes left on the board.
    // By the time the game checks for a tie game it would have already checked
    // For winners
    function tie_game() {
        $tie = false;
        $tie_dash = 0;
        for($cell = 0; $cell < 9; $cell++) {
            if ($this->position[$cell] == '-' ) {
                $tie_dash++;
            }
        }
        if($tie_dash == 0) {
            $tie = true;
        }
        return $tie;
    }

}


?>
