<?php

namespace Pedros80\Build;

interface ClassWriter
{
    public function write(string $content): void;
}
