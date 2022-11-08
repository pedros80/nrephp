<?php

declare(strict_types=1);

namespace Pedros80\Build\Writers;

use Pedros80\Build\Writers\ClassWriter;

final class ConsoleClassWriter implements ClassWriter
{
    public function write(string $path, string $content): void
    {
        echo "{$path}\n{$content}\n";
    }
}
