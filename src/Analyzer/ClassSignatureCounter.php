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

use Greeflas\StaticAnalyzer\Exception\InvalidClassNameException;

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
            throw new InvalidClassNameException(\sprintf('Invalid class name %s', $this->classFullName));
        }

        $signature = new SignatureCollection();

        $modifierNames = \Reflection::getModifierNames($reflector->getModifiers());
        $modifierName = (0 == \count($modifierNames)) ? 'normal' : \implode(' ', $modifierNames);

        $signature->setType($modifierName);

        $methods = $reflector->getMethods();

        foreach ($methods as $method) {
            if ($method->isPrivate()) {
                $signature->increasePrivateMethods();
            } elseif ($method->isProtected()) {
                $signature->increaseProtectedMethods();
            } elseif ($method->isPublic()) {
                $signature->increasePublicMethods();
            }
        }

        $properties = $reflector->getProperties();


        foreach ($properties as $property) {
            if ($property->isPrivate()) {
                $signature->increasePrivateProperties();
            } elseif ($property->isProtected()) {
                $signature->increaseProtectedProperties();
            } elseif ($property->isPublic()) {
                $signature->increasePublicProperties();
            }
        }

        return $signature;
    }
}
