<?php

declare(strict_types=1);

namespace Pedros80\Build;

use Nette\PhpGenerator\ClassType;
use Nette\PhpGenerator\PhpFile;
use Nette\PhpGenerator\PhpNamespace;
use Pedros80\Build\Parser;
use Pedros80\Build\Printer;

abstract class Generator
{
    protected array $data;

    public function __construct(
        protected Parser $parser,
        protected Printer $printer
    ) {
        $this->data = $this->parser->parse();
    }

    abstract public function getFileName(): string;
    abstract protected function getClassName(): string;
    abstract protected function addConstants(ClassType $class): void;
    abstract protected function addConstructor(ClassType $class): void;
    abstract protected function getMethods(): array;
    abstract protected function getUses(): array;

    private function getNamespace(): string
    {
        return 'Pedros80\NREphp\Darwin\Params';
    }

    public function generate(): string
    {
        $file = new PhpFile();
        $file->setStrictTypes();
        $this->addFileComment($file);

        $namespace = new PhpNamespace($this->getNamespace());
        $this->addUses($namespace);

        $class = $namespace->addClass($this->getClassName())->setFinal();
        $this->addConstants($class);
        $this->addConstructor($class);
        $this->addMethods($class);
        $file->addNamespace($namespace);

        return $this->printer->printFile($file);
    }

    protected function addFileComment(PhpFile $file): void
    {
        $file->addComment('This class was autogenerated');
        $file->addComment('Do NOT edit');
    }

    protected function addUses(PhpNamespace $namespace): void
    {
        foreach ($this->getUses() as $class) {
            $namespace->addUse($class);
        }
    }

    protected function addMethods(ClassType $class): void
    {
        foreach ($this->getMethods() as $m) {
            $method = $class->addMethod($m['name']);

            if ($m['static']) {
                $method->setStatic();
            }

            $method->setBody($m['body'])->setReturnType($m['return']);
        }
    }
}
