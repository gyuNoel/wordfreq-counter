<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Word Frequency Counter</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
    
</head>
<body>
    <h1>Word Frequency Counter</h1>
    
    <?php
    $result = '';
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        function tokenizeText($text) {
            $text = strtolower($text);
            $text = preg_replace('/[^\w\s]/', '', $text);
            return preg_split('/\s+/', $text);
        }

        function calculateWordFrequency($words) {
            $stopWords = ['the', 'and', 'in', 'to', 'of', 'a', 'is', 'it', 'that', 'with', 'as', 'for', 'on', 'was', 'but', 'by', 'are', 'this', 'or', 'an', 'be', 'not', 'at', 'from', 'which'];
            $filteredWords = array_diff($words, $stopWords);
            return array_count_values($filteredWords);
        }

        function sortFrequency($frequency, $order) {
            if ($order === 'asc') {
                asort($frequency);
            } else {
                arsort($frequency);
            }
            return $frequency;
        }

    
        $text = $_POST['text'];
        $sortOrder = $_POST['sort'];
        $limit = intval($_POST['limit']);

        $words = tokenizeText($text);
        $frequency = calculateWordFrequency($words);
        $sortedFrequency = sortFrequency($frequency, $sortOrder);
        

        $limitedFrequency = array_slice($sortedFrequency, 0, $limit);
    
        $result .= "<h2>Word Frequencies</h2><ul>";
        foreach ($limitedFrequency as $word => $count) {
            $result .= "<strong><br>$word</strong>: $count";
        }
        $result .= "</ul>";
    }
    ?>

    <form action="" method="post">
        <label for="text">Paste your text here:</label><br>
        <textarea id="text" name="text" rows="10" cols="50" required><?php echo isset($_POST['text']) ? htmlspecialchars($_POST['text']) : ''; ?></textarea><br><br>
        
        <label for="sort">Sort by frequency:</label>
        <select id="sort" name="sort">
            <option value="asc" <?php echo (isset($_POST['sort']) && $_POST['sort'] === 'asc') ? 'selected' : ''; ?>>Ascending</option>
            <option value="desc" <?php echo (isset($_POST['sort']) && $_POST['sort'] === 'desc') ? 'selected' : ''; ?>>Descending</option>
        </select><br><br>
        
        <label for="limit">Number of words to display:</label>
        <input type="number" id="limit" name="limit" value="<?php echo isset($_POST['limit']) ? htmlspecialchars($_POST['limit']) : '10'; ?>" min="1"><br><br>
        
        <input type="submit" value="Calculate Word Frequency">
    </form>
    <?php
    if ($result) {
        echo "<div class='result-box'>$result</div>";
    }
    ?>
</body>
</html>