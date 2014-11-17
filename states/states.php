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

class StateData {
    public $states_data_file;
    public $all_state_data;

    function __construct($states_data_file){
        $this->states_data_file = $states_data_file;
        $this->loadStateData();
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
        $this->all_state_data = $state_data;
        return $state_data;
    }

    function parseStateData($state_data, $mode = "S"){
        $states = array();
        $birds = array();
        $capitals = array();

        foreach($state_data as $key => $value){
            foreach($value as $key2=>$value2){
                if($key2 == 0){
                    $states[] = $value2;
                }
                elseif($key2 == 1){
                    $capitals[] = $value2 . ', ' . $value[$key2 - 1];
                }
                elseif($key2 == 2){
                    $birds[] = $value[$key2 - 2] . ': ' . $value2;
                }
            }
        }

        if($mode == "S") {return $states;}
        if($mode == "B") {return $birds;}
        if($mode == "C") {return $capitals;}
    }
}

class Search
{
    public function newSearch($mode, $data){
        echo "Enter a letter >";
        $first_letter = getInput();
        return $this->doSearch($first_letter, $mode, $data); 
    }

    private function doSearch($first_letter, $mode, $data){
        $results = array();
        foreach($data as $key=>$value){
            if($value[0] == $first_letter){
                $results[] = $value;
            }
        }
        return $results;   
    }
}

function echoArray($array){
    foreach($array as $key=>$value){
        echo $value . PHP_EOL;
    }
}

function getInput(){
   $input = trim(strtoupper(fgets(STDIN)));
   return substr($input, 0);
}

define('STATE_DATA_FILE', 'states.txt');

$stateDataInstance = new StateData(STATE_DATA_FILE);
//$state_data = $stateDataInstance->loadStateData();
$all_state_data = $stateDataInstance->all_state_data;

$exit = false;    
do {
echo "=================================================================" . PHP_EOL;    
echo "| (L)ist States   (S)earch State Data  (Q)uit |" . PHP_EOL;
echo "-----------------------------------------------" . PHP_EOL;
echo ">";

$list_or_search = trim(strtoupper(fgets(STDIN)));

switch($list_or_search) {
    case "L":
        echo `clear`;
        $list_of_states = $stateDataInstance->parseStateData($all_state_data);
        echoArray($list_of_states);
        break;
    case "S":
        echo `clear`; 
        echo "(S)tates   (B)irds   (C)apitals" . PHP_EOL;
        echo ">";

        $search = new Search();
        $search_birds_or_capitals = getInput();

        switch($search_birds_or_capitals){
            case "S":
                $list_of_states = $stateDataInstance->parseStateData($all_state_data);
                echoArray($search->newSearch("S", $list_of_states));
                break;

            case "B":
                $birds = $stateDataInstance->parseStateData($all_state_data, "B");
                echoArray($search->newSearch("B", $birds));
                break;
            case "C":
                $capitals = $stateDataInstance->parseStateData($all_state_data, "C");
                echoArray($search->newSearch("C", $capitals));    
                break;
        } 

        break;
    case "Q":
        echo `clear`;
        $exit = true;
        break;    
}// list_or_search switch

}while($exit == false);
exit(0);
?>
