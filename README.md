# PHP to Whitespace

Do you love [Whitespace](http://compsoc.dur.ac.uk/whitespace/) but find the tooling inadequate?
PHPWhitespace is just what you've been waiting for!

PHPWhiteSpace is a simple class that allows you to write your whitespace programmes in php, and then output
them as Whitespace!

Of course, a lot of existing Whitespace programmes are **already** valid php programmes.


## What is whitespace?

[Whitespace](http://compsoc.dur.ac.uk/whitespace/) is a dependently spaced
language created by Edwin Brady and Chris Morris in 2003.


## How do I run my whitespace programme?

There are a number of interpreters.  I've used one written in php by Igor Weidler, which is available
[on github](https://github.com/igorw/whitespace-php).


## So...

You're telling me I can write a program in php, convert it to Whitespace, and then run the
Whitespace program in a Whitespace interpreter written in php?!

**Yes!** Awesome, isnt' it!


## How do I use PHPWhitespace?

Simples:

```php

    $ws = new mattp\PHPWhiteSpace();

    $ws->push(0);       // Push 0 onto the stack
    $ws->push(5);       // Push 1 onto the stack
    $ws->push(97);      // Push 97 onto the stack
    $ws->add();         // Add the top two numbers on the stack

    $ws->store();       // Store the value on the top of the stack (102)
                        // at the position given by the next value on the stack (0)
                        // So 102 is now at location 0 of the heap

    $ws->push(4);       // Put 4 on the stack
    $ws->duplicate();   // Duplicate the value on the top of the stack
    $ws->subtract();    // Now 0 is on top of the stack
    $ws->retrieve();    // Retrieve the value from location 0 of the heap and put it on the stack
    $ws->write_character();     // Write the value on the top of the stack (102) as a character (f)


    $whitespace_code = $ws->export();


```

The `$whitespace_code` is the whitespace representation of the program you have written.
The [Whitespace tutorial](http://compsoc.dur.ac.uk/whitespace/tutorial.php) lists and explains
the various instructions available.  These are all methods on the PHPWhiteSpace class.
