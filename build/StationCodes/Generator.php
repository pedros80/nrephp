<?php

declare(strict_types=1);

namespace Pedros80\Build\StationCodes;

use Nette\PhpGenerator\ClassType;
use Pedros80\Build\Generator as BuildGenerator;
use Pedros80\NREphp\Exceptions\InvalidStationCode;

final class Generator extends BuildGenerator
{
    protected function getClassName(): string
    {
        return 'StationCode';
    }

    public function getFileName(): string
    {
        return 'Params\StationCode.php';
    }

    protected function getMethods(): array
    {
        return [
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
                'return' => 'Pedros80\NREphp\Params\StationCode',
            ],
        ];
    }

    protected function getUses(): array
    {
        return [InvalidStationCode::class];
    }

    protected function addConstants(ClassType $class): void
    {
        $class->addConstant('STATIONS', $this->data)->setPrivate();
    }

    protected function addConstructor(ClassType $class): void
    {
        $constructor = $class->addMethod('__construct');
        $constructor->addPromotedParameter('code')->setType('string')->setPrivate();
        $constructor->setBody("if (!in_array(\$code, array_keys(self::STATIONS))) {\n\tthrow InvalidStationCode::fromCode(\$code);\n}");
    }
}
