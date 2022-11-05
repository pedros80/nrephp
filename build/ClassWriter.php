<?php

declare(strict_types=1);

namespace Pedros80\Build;

interface ClassWriter
{
    public function write(string $content): void;
}
