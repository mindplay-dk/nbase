<?php

use mindplay\nbase\NBaseConverter;

require dirname(__DIR__) . "/vendor/autoload.php";

test(
    'can convert between notations',
    function () {
        $converter = new NBaseConverter();

        eq($converter->convert('12345', 'dec', 'hex'), '3039');
        eq($converter->convert('3039', 'hex', 'dec'), '12345');

        eq($converter->convert('012345', 'dec', 'hex'), '3039', "ignore leading zeroes");
        eq($converter->convert('03039', 'hex', 'dec'), '12345', "ignore leading zeroes");

        foreach (array_keys($converter->notations) as $notation) {
            foreach ([0, 1, 8, PHP_INT_MAX] as $value) {
                eq((int) $converter->convert($converter->convert($value, 'dec', $notation), $notation, 'dec'), $value);
            }
        }
    }
);

test(
    'should throw for undefined notation types',
    function () {
        $converter = new NBaseConverter();

        expect(
            'InvalidArgumentException',
            'should throw for undefined input notation',
            function () use ($converter) {
                $converter->convert('1', 'fudge', 'hex');
            },
            '/undefined notation type: fudge/'
        );

        expect(
            'InvalidArgumentException',
            'should throw for undefined input notation',
            function () use ($converter) {
                $converter->convert('1', 'hex', 'fudge');
            },
            '/undefined notation type: fudge/'
        );
    }
);

exit(run());
