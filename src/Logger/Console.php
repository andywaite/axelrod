<?php

namespace Andywaite\Axelrod\Logger;

class Console implements Logger
{
    public function log(string $message, array $params = []): void
    {
        echo "\n" .$message;

        foreach ($params as $key => $param) {
            echo "\n\t{$key}: {$param}";
        }
    }
}
