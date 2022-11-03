<?php

namespace Pedros80\Build;

use Nette\PhpGenerator\ClassType;
use Nette\PhpGenerator\PhpFile;
use Nette\PhpGenerator\PhpNamespace;
use Pedros80\Build\Parser;
use Pedros80\NREphp\Darwin\Exceptions\InvalidStationCode;

final class Generator
{
    private const NAMESPACE = 'Pedros80\NREphp\Darwin';
    private const CLASSNAME = 'StationCode';
    private const METHODS   = [
        [
            'name'   => 'name',
            'static' => false,
            'body'   => 'return self::STATIONS[$this->code];',
            'return' => 'string',
        ],
        [
            'name'   => '__toString',
            'static' => false,
            'body'   => 'return $this->code;',
            'return' => 'string',
        ],
        [
            'name'   => 'random',
            'static' => true,
            'body'   => 'return new StationCode(array_rand(self::STATIONS));',
            'return' => 'Pedros80\NREphp\Darwin\StationCode',
        ],
    ];

    private array $stations;

    public function __construct(
        private Parser $parser,
        private Printer $printer
    ) {
        $this->stations = $this->parser->parse();
    }

    public function generate(): string
    {
        $file = new PhpFile();
        $this->addFileComment($file);

        $namespace = new PhpNamespace(self::NAMESPACE);
        $namespace->addUse(InvalidStationCode::class);

        $class = $namespace->addClass(self::CLASSNAME)->setFinal();
        $this->addConstants($class);
        $this->addConstructor($class);
        $this->addMethods($class);
        $file->addNamespace($namespace);

        return $this->printer->printFile($file);
    }

    private function addFileComment(PhpFile $file): void
    {
        $file->addComment('This class was autogenerated');
        $file->addComment('Do NOT edit');
    }

    private function addConstants(ClassType $class): void
    {
        $this->addStations($class);
    }

    private function addConstructor(ClassType $class): void
    {
        $constructor = $class->addMethod('__construct');
        $constructor->addPromotedParameter('code')->setType('string')->setPrivate();
        $constructor->setBody("if (!in_array(\$code, array_keys(self::STATIONS))) {\n\tthrow InvalidStationCode::fromCode(\$code);\n}");
    }

    private function addMethods(ClassType $class): void
    {
        foreach (self::METHODS as $m) {
            $method = $class->addMethod($m['name']);

            if ($m['static']) {
                $method->setStatic();
            }

            $method->setBody($m['body'])->setReturnType($m['return']);
        }
    }

    private function addStations(ClassType $class): void
    {
        $class->addConstant('STATIONS', $this->stations)->setPrivate();
    }
}