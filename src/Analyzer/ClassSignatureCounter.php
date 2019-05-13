<?php

/*
 * This file is part of the "PHP Static Analyzer" project.
 *
 * (c) Vladimir Kuprienko <vldmr.kuprienko@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Greeflas\StaticAnalyzer\Analyzer;

use Greeflas\StaticAnalyzer\Exception\InvalidClassNameExeption;

/**
 * The methods and properties of the required class are counted, the type is determined by the specified class name.
 *
 * @author Anton Degoda <dehoda@ukr.net>
 */
final class ClassSignatureCounter
{
    private $classFullName;

    public function __construct(string $classFullName)
    {
        $this->classFullName = $classFullName;
    }

    public function analyze(): object
    {
        try {
            $reflector = new \ReflectionClass($this->classFullName);
        } catch (\ReflectionException $e) {
            throw new InvalidClassNameExeption($e);
        }

        $signature = new SignatureCollection();

        $signature->type = \implode(' ', \Reflection::getModifierNames($reflector->getModifiers()));

        $methods = $reflector->getMethods();

        foreach ($methods as $method) {
            if ($method->isPrivate()) {
                $signature->privateMethods++;
            } elseif ($method->isProtected()) {
                $signature->protectedMethods++;
            } elseif ($method->isPublic()) {
                $signature->publicMethods++;
            }
        }

        $properties = $reflector->getProperties();


        foreach ($properties as $property) {
            if ($property->isPrivate()) {
                $signature->privateProperties++;
            } elseif ($property->isProtected()) {
                $signature->protectedProperties++;
            } elseif ($property->isPublic()) {
                $signature->publicProperties++;
            }
        }

        return $signature;
    }
}
