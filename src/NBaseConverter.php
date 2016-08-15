<?php

namespace mindplay\nbase;

use InvalidArgumentException;

/**
 * This class contains utility functions for dealing with N-Base numbers.
 */
class NBaseConverter
{
    /**
     * Map of available notation types.
     *
     * @var string[] map where notation name => string of distinct (ASCII character) symbols
     */
    public $notations = [
        'bin'      => '01',
        'oct'      => '01234567',
        'dec'      => '0123456789',
        'hex'      => '0123456789abcdef',
        'base62'   => '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ',
        'base64'   => '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ+/',
        'url64'    => '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ-_',
        'legible'  => '23456789abcdefghijkmnopqrstuvwxyzABCDEFGHJKLMNPQRSTUVWXYZ',
        'alphanum' => '0123456789abcdefghijklmnopqrstuvwxyz',
        'iso'      => '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ_',
    ];

    /**
     * Convert arbitrary-length numbers from one numerical notation to another
     *
     * @param string|int $input input value (in the notation specified by $from)
     * @param string     $from  input notation name
     * @param string     $to    target notation name
     *
     * @return string converted value (in the notation specified by $to)
     *
     * @see http://us2.php.net/base_convert (based on code by Michael Renner)
     */
    public function convert($input, $from, $to)
    {
        if ($from === $to) {
            return $input;
        }

        if (! isset($this->notations[$from])) {
            throw new InvalidArgumentException("undefined notation type: {$from}");
        }

        $from = $this->notations[$from];

        if (! isset($this->notations[$to])) {
            throw new InvalidArgumentException("undefined notation type: {$to}");
        }

        $to = $this->notations[$to];

        $input = (string) $input;

        $from_base = strlen($from);
        $to_base = strlen($to);

        $length = strlen($input);
        $result = '';
        $number = '';

        for ($i = 0; $i < $length; $i++) {
            $number[$i] = strpos($from, $input{$i});
        }

        do {
            $divide = 0;
            $newlen = 0;

            for ($i = 0; $i < $length; $i++) {
                $divide = $divide * $from_base + $number[$i];

                if ($divide >= $to_base) {
                    $number[$newlen++] = (int) ($divide / $to_base);
                    $divide = $divide % $to_base;
                } elseif ($newlen > 0) {
                    $number[$newlen++] = 0;
                }
            }

            $length = $newlen;

            $result = $to{$divide} . $result;
        } while ($newlen !== 0);

        return $result;
    }
}
