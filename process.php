<?php
header('Content-Type: application/json');

/**
 * Word Frequency Counter Process
 * 
 * Get the user input text
 * List the words to ignore
 * 
 * The Tokenizer: Function to extract words from the text and remove ignored words, 
 * and exclude the following:
 * Spaces
 * Punctuation
 * Line breaks
 * Other marks like question mark
 * Periods
 * 
 * Word Frequency Calculator function
 * It will count the frequency of each unique word
 * 
 * Limiter
 * It limits the result based on the user input
 * Also, it already gets the top N most frequent words before limiting 
 * 
 * Sorting by Order
 * It will consider the choice of the user to list the words based on frequency of its count
 */

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $user_text = strval($_POST['text']);

    $ignore_word_list = ['the', 'and', 'in', 'is', 'it', 'to', 'of', 'a', 'for', 'on', 'with', 'as', 'that', 'by', 'at', 'be', 'this', 'from', 'or', 'an', 'if','i','ve','m','s','me','my','was','t',];

    function word_tokenizer ($text, $ignore_word_list) {
        // convert everything to lowercase
        $text = strtolower($text); 

        //use regex to ignore special characters
        $text = preg_replace('/([^a-zA-z0-9]+)/', ' ', $text);
        $words = explode(' ', $text);
        $words = array_diff($words, $ignore_word_list);
        return $words;
    }
    
    echo json_encode(word_tokenizer($user_text, $ignore_word_list));
}