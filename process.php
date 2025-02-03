<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $user_text = strval($_POST['text']);

    $ignore_word_list = ['the', 'and', 'in', 'is', 'it', 'to', 'of', 'a', 'for', 'on', 'with', 'as', 'that', 'by', 'at', 'be', 'this', 'from', 'or', 'an', 'if','i','ve','m','s','me','my','was','t','can','you'];

    $sortOrder = $_POST['sort'];

    $displayLimit = $_POST['limit'];

    function word_tokenizer ($text, $ignore_word_list) {
        // convert everything to lowercase
        $text = strtolower($text); 

        //use regex to ignore special characters
        $text = preg_replace('/([^a-zA-z0-9]+)/', ' ', $text);

        //explode function separates the words and converts it into an array using whitespace as separator
        $words = explode(' ', $text);

        //array_diff compare contents and ignore words from the list of set ignored word array
        $words = array_diff($words, $ignore_word_list);
        
        //return of array of words, still have dupes
        return $words;
    }

    $tokenized_json = word_tokenizer($user_text, $ignore_word_list);
    


    //WORD FREQUENCY CALC
    function frequency_calc($word_array){
        $word_freq = array_count_values($word_array);
        return $word_freq;
    }

    //variable for array where each occurences are tallied
    $word_freq_array = frequency_calc($tokenized_json);

    //ascension sorting
    function sort_array($tallied_array,$sortOrder){
        if($sortOrder == 'asc'){
            asort($tallied_array);
        }
        else if ($sortOrder == 'desc')
        {
            arsort($tallied_array);
        }
        return $tallied_array;
    }
    //array sorted by its frequency
    $sorted_array = sort_array($word_freq_array,$sortOrder);

    //display only based on limit

    function display_array_with_limit($array,$limit){
        $sliced_array = array_slice($array,1,$limit);
        return $sliced_array;
    }

    $limited_array = display_array_with_limit($sorted_array,$displayLimit);


    //display as list
    function displayJSONtoTable($json) {
        echo "<table border='1' cellspacing='0' cellpadding='5'>";
        echo "<tr><th>Word</th><th>Occurences</th></tr>";
    
        foreach ($json as $key => $value) {
            if (is_array($value)) {
                echo "<tr><td><strong>$key</strong></td><td>";
                foreach ($value as $subKey => $subValue) {
                    echo "<tr><td>$subKey</td><td>$subValue</td></tr>";
                }
                echo "</td></tr>";
            } else {
                echo "<tr><td><strong>$key</strong></td><td>$value</td></tr>";
            }
        }
        echo "</table>";
    }

    echo displayJSONtoTable($limited_array);

}