<?php

namespace Pedros80\Build;

use Pedros80\Build\ClassWriter;

final class ConsoleClassWriter implements ClassWriter
{
    public function write(string $content): void
    {
        echo "{$content}\n";
    }
}
