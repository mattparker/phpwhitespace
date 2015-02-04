<?php
/**
 * Class PHPWhiteSpace
 *
 * Converts to space
 */

/**
 * // Stack
 * @method push
 * @method duplicate
 * @method copy
 * @method swap
 * @method discard
 * @method slide
 *
 * // Arithmetic 
 * @method add
 * @method subtract
 * @method multiply
 * @method divide
 * @method modulo
 *
 * // Heap 
 * @method store
 * @method retrieve
 *
 * // Flow control 
 * @method label
 * @method call
 * @method jump
 * @method jumpz
 * @method jumplz
 * @method return
 * @method end
 *
 * // IO 
 * @method write_character
 * @method write_number
 * @method read_character
 * @method read_number
 *
 */

namespace mattp;

class PHPWhiteSpace {


    /**
     * @var string
     */
    private $space = " ";

    /**
     * @var string
     */
    private $tab = "\t";

    /**
     * @var string
     */
    private $lf = "\n";

    /**
     * @var array
     */
    private $operations = [];


    /**
     * Class constructor
     *
     * Passing true turns on debug, which replaces whitespace with letters.
     */
    public function __construct ($debug = false) {
        if ($debug) {
            $this->space = "s";
            $this->tab = "t";
            $this->lf = "l";
        }
    }


    /**
     * See methods documented above
     *
     * @param       $name
     * @param array $args
     *
     * @return $this
     */
    public function __call ($name, array $args = array()) {
        $arg = null;
        if ($args && count($args)) {
            $arg = $args[0];
        }
        $this->operations[] = [$name, $arg];
        return $this;
    }


    /**
     * Renders the programe as whitespace
     *
     * @throws \InvalidArgumentException
     * @return string
     */
    public function export () {

        $instructions = $this->operations;
        $whitespace = "";
        $labels = [];

        $lf = $this->lf;
        $space = $this->space;
        $tab = $this->tab;


        $conversions = [
            /* Stack */
            'push'            => $space . $space,
            'duplicate'       => $space . $lf . $space,
            'copy'            => $space . $tab . $space,
            'swap'            => $space . $lf . $tab,
            'discard'         => $space . $lf . $lf,
            'slide'           => $space . $tab . $lf,

            /* Arithmetic */
            'add'             => $tab . $space . $space . $space,
            'subtract'        => $tab . $space . $space . $tab,
            'multiply'        => $tab . $space . $space . $lf,
            'divide'          => $tab . $space . $tab . $space,
            'modulo'          => $tab . $space . $tab . $tab,

            /* Heap */
            'store'           => $tab . $tab . $space,
            'retrieve'        => $tab . $tab . $tab,

            /* Flow control */
            'label'           => $lf . $space . $space,
            'call'            => $lf . $space . $tab,
            'jump'            => $lf . $space . $lf,
            'jumpz'           => $lf . $tab . $space,
            'jumplz'          => $lf . $tab . $tab,
            'return'          => $lf . $tab . $lf,
            'end'             => $lf . $lf . $lf,

            /* IO */
            'write_character' => $tab . $lf . $space . $space,
            'write_number'    => $tab . $lf . $space . $tab,
            'read_character'  => $tab . $lf . $tab . $space,
            'read_number'     => $tab . $lf . $tab . $tab
        ];


        foreach ($instructions as list($inst, $arg)) {

            if (!array_key_exists($inst, $conversions)) {
                throw new \InvalidArgumentException("instruction $inst not recognised");
            }

            // This gives the main instruction in whitespace
            $whitespace .= $conversions[$inst];

            // And this converts any arguments passed:
            switch ($inst) {

                case 'push':
                case 'copy':
                case 'slide':

                    $whitespace .= $this->render_number_as_whitespace($arg);

                    break;

                case 'label':
                case 'call':
                case 'jump':
                case 'jumpz':
                case 'jumplz':

                    if (!array_key_exists($arg, $labels)) {
                        $labels[$arg] = $this->make_unique_label($labels);
                    }
                    $whitespace .= $labels[$arg];

                    break;

                default:
                    break;

            }


        }

        $whitespace .= $conversions['end'];

        return $whitespace;

    }


    /**
     * @param $existing_labels array
     *
     * @return string
     */
    private function make_unique_label (array $existing_labels = array()) {
        return $this->tab . str_repeat($this->space, count($existing_labels) + 1) . $this->lf;
    }


    /**
     * @param $number int
     *
     * @return string
     */
    private function render_number_as_whitespace ($number) {

        $whitespace = ($number > 0 ? $this->space : $this->tab)
            . str_replace(
                ["0", "1"],
                [$this->space, $this->tab],
                base_convert($number, 10, 2)
            )
            . $this->lf;

        return $whitespace;
    }

}


