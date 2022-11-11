<?php

declare(strict_types=1);

namespace Pedros80\Build\Writers;

interface Writer
{
    public function write(string $path, string $content): void;
}
