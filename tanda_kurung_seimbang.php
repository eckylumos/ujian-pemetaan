<?php

function isValid(string $s): bool
{
    if (strlen($s) % 2 !== 0) {
        return false;
    }

    $stack = new SplStack();
    $map = [
        ')' => '(',
        ']' => '[',
        '}' => '{',
    ];

    for ($i = 0; $i < strlen($s); $i++) {
        $char = $s[$i];
        if (in_array($char, ['(', '[', '{'])) {
            $stack->push($char);
        } else if (in_array($char, [')', ']', '}'])) {
            if ($stack->isEmpty() || $stack->pop() !== $map[$char]) {
                return false;
            }
        }
    }

    return $stack->isEmpty();
}
?>
