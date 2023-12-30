<?php

namespace Andywaite\Axelrod\Logger;

interface Logger
{
    public function log(string $message, array $params = []): void;
}
