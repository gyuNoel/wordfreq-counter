<?php
$items = [
    ['name' => 'Widget A', 'price' => 10],
    ['name' => 'Widget B', 'price' => 15],
    ['name' => 'Widget C', 'price' => 20],
];

$total = 0;

foreach ($items as $item) {
    $total += $item['price'];
}

echo "Total price: $" . $total;

$string = "This is a poorly written program with little structure and readability.";

$string_no_spaces = str_replace(' ', '', $string);
$string_lowercase = strtolower($string_no_spaces);

echo "\nModified string: " . $string_lowercase;

$number = 42;

if ($number % 2 == 0) {
    echo "\nThe number " . $number . " is even.";
} else {
    echo "\nThe number " . $number . " is odd.";
}
?>
