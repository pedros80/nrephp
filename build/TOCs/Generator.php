<?php

namespace Pedros80\Build\TOCs;

use Nette\PhpGenerator\ClassType;
use Pedros80\Build\Generator as BuildGenerator;
use Pedros80\Build\Printer;
use Pedros80\Build\TOCs\Parser;
use Pedros80\NREphp\Darwin\Exceptions\InvalidTOC;

final class Generator extends BuildGenerator
{
    private array $codes;

    public function __construct(
        protected Parser $parser,
        protected Printer $printer
    ) {
        $this->codes = $this->parser->parse();
    }

    public function getFileName(): string
    {
        return 'Darwin\Params\TOC.php';
    }

    protected function getClassName(): string
    {
        return 'TOC';
    }

    protected function addConstants(ClassType $class): void
    {
        $class->addConstant('CODES', $this->codes)->setPrivate();
    }

    protected function addConstructor(ClassType $class): void
    {
        $constructor = $class->addMethod('__construct');
        $constructor->addPromotedParameter('code')->setType('string')->setPrivate();
        $constructor->setBody("if (!in_array(\$code, array_unique(array_column(self::CODES, 'code')))) {\n\tthrow InvalidTOC::fromCode(\$code);\n}");
    }

    protected function getMethods(): array
    {
        return [
            [
                'name'   => '__toString',
                'static' => false,
                'body'   => 'return $this->code;',
                'return' => 'string',
            ],
        ];
    }

    protected function getUses(): array
    {
        return [InvalidTOC::class];
    }
}
