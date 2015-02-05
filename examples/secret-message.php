<?php
/**
 * Put a very secret message in a whitespace program and then hide it in a web page.
 *
 * If the whitespace representation of the secret message is too short
 * (so that you end up with extra whitespace) then it'll fail.  There's
 * fairly obvious ways around that (to make your whitespace message longer)
 * but I can't really be bothered with that right now.
 */

$hidden_message = 'I just adore whitespace';
$visible_message = '<!DOCTYPE html><html><head><title>Hello!</title></head><body>'
    . '<h1>I only write php.</h1><p>  or javascript.  That is all.</p></body></html>';



require_once __DIR__ . '/../src/PHPWhiteSpace.php';
$ws = new mattp\PHPWhiteSpace();


// Make the very simple white space program.
foreach (str_split($hidden_message) as $letter) {

    $ws->push(ord($letter));
    $ws->write_character();

}

// Now get it
$spaces = str_split($ws->export());

// And combine it with our web page:
$combined = '';
foreach (str_split($visible_message) as $letter) {

    if (in_array($letter, [" ", "\t", "\n"]) && count($spaces)) {
        $combined .= array_shift($spaces);
    } else {
        $combined .= $letter;
    }
}

$combined .= implode('', $spaces);



// Now what looks like a regular web page contains a very secret message
// - just run the web page as a ws program!
file_put_contents('secret-message.html', $combined);

