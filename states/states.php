<?php
/*
 * Solution by Louis Hawkins
 * 2014
 *
 * # States Array
 *
 * 1. Create an mulidimensional array out of the states text file.
 * 2. Create a function that will list the states.
 * 3. Create a function that will let you search for states by the first letter.
 * 4. Create a function that will let you search for birds by the first letter.
 * 5. Create a function that will let you search for capitals by the first letter.
 *
 * ## Extra Credit (yet-todo) 
 *
 * 1. Create a trivia game. Ask the user a random question like the following:
 * 2. "What is the capital of ____?"
 * 3. "What state is Austin in?"
 * 4. "What is the state bird of California?"
 */

require_once('smart_io.php');
include_once('state_trivia_game.php');

class StateData {
    public $states_data_file;
    public $all_state_data;
    public $list_of_states;
    public $list_of_birds;
    public $list_of_capitals;

    function __construct($states_data_file){
        $this->states_data_file = $states_data_file;
        $this->all_state_data = $this->loadStateData();
        $this->parseStateData($this->all_state_data);
    } 

    function loadStateData() {
        // load the contents of the states data file into an array
        $state_data = array();
        $filesize = filesize($this->states_data_file);
        $handle = fopen($this->states_data_file, 'r');
        $contents = trim(fread($handle, $filesize));
        $contentsArray = explode("\n", $contents);

        foreach($contentsArray as $key => $value) {
             $state_data[] = explode(", ", $value);
        }

        fclose($handle);
        return $state_data;
    }

    function parseStateData($state_data){

        foreach($state_data as $key => $value){
            foreach($value as $key2=>$value2){
                if($key2 == 0){
                    $this->list_of_states[] = $value2;
                }
                elseif($key2 == 1){
                    $this->list_of_capitals[] = $value2 . ', ' . $value[$key2 - 1];
                }
                elseif($key2 == 2){
                    $this->list_of_birds[] = $value[$key2 - 2] . ': ' . $value2;
                }
            }
        }
    }
}

class Query
{
    public function newQuery($sourceArray){
        echo "Enter a letter >";
        $first_letter = getInput();
        return $this->doSearch($first_letter, $sourceArray); 
    }

    private function doSearch($first_letter, $sourceArray){
        $results = array();
        foreach($sourceArray as $key=>$value){
            if($value[0] == $first_letter){
                $results[] = $value;
            }
        }
        return $results;   
    }
}

define('STATE_DATA_FILE', 'states.txt');
$stateDataInstance = new StateData(STATE_DATA_FILE);
$exit = false;    

do {
echo PHP_EOL . "=================================================================" . PHP_EOL;    
echo "   (L)ist States   (S)earch State Data   Trivia (G)ame   (Q)uit    " . PHP_EOL;
echo "-----------------------------------------------------------------" . PHP_EOL;
echo ">";

switch(getInput()) {
    case "L":
        echo `clear`;
        echoArray($stateDataInstance->list_of_states);
        break;
    case "S":
        echo `clear`; 
        echo "(S)tates   (B)irds   (C)apitals" . PHP_EOL;
        echo ">";

        $query = new Query();
        switch(getInput()){
            case "S":
                echoArray($query->newQuery($stateDataInstance->list_of_states));
                break;

            case "B":
                echoArray($query->newQuery($stateDataInstance->list_of_birds));
                break;
            case "C":
                echoArray($query->newQuery($stateDataInstance->list_of_capitals));
                break;
        } 

        break;
    case "G":
        playGame();
        break;    
    case "Q":
        echo `clear`;
        $exit = true;
        break;    
}// list_or_search switch

}while($exit == false);
exit(0);
?>
