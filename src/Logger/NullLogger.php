<?php

namespace Andywaite\Axelrod\Logger;

class NullLogger implements Logger
{
    public function log(string $message, array $params = []): void
    {
        // Do nothing
    }
}
