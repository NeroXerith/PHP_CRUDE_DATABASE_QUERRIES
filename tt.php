<?php

function drawLine($number) {
    return str_repeat('*', $number);
}

function drawStripedLine($number) {
    $output = '';
    for ($i = 0; $i < $number; $i++) {
        $output .= ($i % 2 == 0) ? '*' : '_';
    }
    return $output;
}

function drawSquare($size) {
    $line = str_repeat('*', $size) . PHP_EOL;
    return str_repeat($line, $size);
}

function drawParallelogram($number) {
    $output = '';
    for ($i = 0; $i < $number; $i++) {
        $output .= str_repeat('_', $number - $i - 1);
        $output .= str_repeat('*', $number);
        $output .= str_repeat('_', $i);
        $output .= PHP_EOL;
    }
    return $output;
}

function drawTriangle($number) {
    $output = '';
    for ($i = 0; $i < $number; $i++) {
        $output .= str_repeat('*', $number - $i);
        $output .= str_repeat('_', $i);
        $output .= PHP_EOL;
    }
    return $output;
}

function drawRTriangle($number) {
    $output = '';
    for ($i = 0; $i < $number; $i++) {
        $output .= str_repeat('*', $i + 1);
        $output .= str_repeat('_', $number - $i - 1);
        $output .= PHP_EOL;
    }
    return $output;
}

$line = $stripedLine = $square = $parallelogram = $triangle = $rtriangle = '';

if (isset($_POST['number'])) {
    $number = intval($_POST['number']);
    $line = drawLine($number);
    $stripedLine = drawStripedLine($number);
    $square = drawSquare($number);
    $parallelogram = drawParallelogram($number);
    $triangle = drawTriangle($number);
    $rtriangle = drawRTriangle($number);
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Biene Bryle T. Sanico</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <div class="header-container">
        <h1>Mobile Dev LAB</h1>
        
        <form action="" method="post">
            <input type="number" name="number" placeholder="Enter a number" required>
            <input type="submit" value="Submit">
        </form>
    </div>

    <div class="output-container">
        <div class="output-box">
            <p>The line is:</p>
            <?php echo nl2br($line); ?>
        </div>
        <div class="output-box">
            <p>The striped line is:</p>
            <?php echo nl2br($stripedLine); ?>
        </div>
        <div class="output-box">
            <p>The square is:</p>
            <?php echo nl2br($square); ?>
        </div>
        <div class="output-box">
            <p>The Parallelogram is:</p>
            <?php echo nl2br($parallelogram); ?>
        </div>
        <div class="output-box">
            <p>The triangle is:</p>
            <?php echo nl2br($triangle); ?>
        </div>
        <div class="output-box">
            <p>The reverse triangle is:</p>
            <?php echo nl2br($rtriangle); ?>
        </div>
    </div>
</body>
</html>
