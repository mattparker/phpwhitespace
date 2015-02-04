<?php
/**
 * Created by PhpStorm.
 * User: matt
 * Date: 02/02/15
 * Time: 21:20
 */
namespace mattp;
require_once __DIR__ . '/../src/PHPWhiteSpace.php';



class PHPWhiteSpaceTest extends \PHPUnit_Framework_TestCase {

    /**
     * @var PHPWhiteSpace
     */
    protected $ws;

    public function setUp () {
        $this->ws = new PHPWhiteSpace();
    }


    public function test_put_1_on_stack () {

        $ws = $this->ws;
        $ws->push(1);

        $space = $ws->export();
        $this->assertEquals("   \t\n\n\n\n", $space);

    }

    public function test_set_a_label () {

        $ws = $this->ws;
        $ws->label('a');


        $this->assertEquals("\n  \t \n\n\n\n", $ws->export());

    }

    public function test_duplicate_top_stack_item () {

        $ws = $this->ws;
        $ws->duplicate();
        $this->assertEquals(" \n \n\n\n", $ws->export());
    }

    public function test_output_current_value () {

        $ws = $this->ws;
        $ws->write_number();
        $this->assertEquals("\t\n \t\n\n\n", $ws->export());

    }

    public function test_output_character () {
        $ws = $this->ws;
        $ws->write_character();
        $this->assertEquals("\t\n  \n\n\n", $ws->export());

    }

    public function test_add () {
        $ws = $this->ws;
        $ws->add();
        $this->assertEquals("\t   \n\n\n", $ws->export());
    }


    public function test_the_rest () {

        $tests = [
            ['copy', 3, " \t  \t\t\n"],
            ['swap', null, " \n\t"],
            ['discard', null, " \n\n"],
            ['slide', 5, " \t\n \t \t\n"],

            ['subtract', null, "\t  \t"],
            ['multiply', null, "\t  \n"],
            ['divide', null, "\t \t "],
            ['modulo', null, "\t \t\t"],

            ['store', null, "\t\t "],
            ['retrieve', null, "\t\t\t"],

            ['return', null, "\n\t\n"],
            ['end', null, "\n\n\n"]
        ];


        foreach ($tests as list($method, $arg, $expected)) {
            $ws = new PHPWhiteSpace();
            $ws->{$method}($arg);
            $this->assertEquals($expected . "\n\n\n", $ws->export(), $method . ' Failed');
        }


    }

    public function test_flow_label_and_call () {

        $ws = new PHPWhiteSpace();
        $ws->label('a');
        $ws->call('a');

        $expected = "\n  \t \n" . "\n \t\t \n";
        $this->assertEquals($expected . "\n\n\n", $ws->export());
    }

    public function test_flow_jump () {

        $ws = new PHPWhiteSpace();
        $ws->label('a');
        $ws->jump('a');

        $exected = "\n  \t \n" . "\n \n\t \n";
        $this->assertEquals($exected . "\n\n\n", $ws->export());
    }

    public function test_two_labels () {

        $ws = new PHPWhiteSpace();
        $ws->label('a');
        $ws->label('b');
        $ws->jump('a');
        $ws->jump('b');
        $expected = "\n  \t \n" . "\n  \t  \n" . "\n \n\t \n" . "\n \n\t  \n";
        $this->assertEquals($expected . "\n\n\n", $ws->export());
    }


} 