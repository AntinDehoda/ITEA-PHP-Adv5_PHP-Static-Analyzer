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

use Greeflas\StaticAnalyzer\Exceptions\InvalidClassNameException;

/**
 * Class ClassSignatureCounter
 *
 * The methods and properties of the required class are counted, the type is determined by the specified class name.
 *
 * @author Anton Degoda <dehoda@ukr.net>
 */
final class ClassSignatureCounter
{
    private $classFullName;
    public $privateMethods;
    public $publicMethods;
    public $protectedMethods;
    public $privateProperties;
    public $protectedProperties;
    public $publicProperties;
    public $type;

    public function __construct(string $classFullName)
    {
        $this->classFullName = $classFullName;
        $this->privateMethods = 0;
        $this->publicMethods = 0;
        $this->protectedMethods = 0;
        $this->privateProperties = 0;
        $this->protectedProperties = 0;
        $this->publicProperties = 0;
    }

    public function analyze(): self
    {
        $reflector = new \ReflectionClass($this->classFullName);

        if (null == $reflector) {
            throw new InvalidClassNameException('Invalid class name');
        }

        $this->type = \implode(' ', \Reflection::getModifierNames($reflector->getModifiers()));

        $methods = $reflector->getMethods();

        foreach ($methods as $method) {
            if ($method->isPrivate()) {
                $this->privateMethods++;
            } elseif ($method->isProtected()) {
                $this->protectedMethods++;
            } elseif ($method->isPublic()) {
                $this->publicMethods++;
            }
        }

        $properties = $reflector->getProperties();


        foreach ($properties as $property) {
            if ($property->isPrivate()) {
                $this->privateProperties++;
            } elseif ($property->isProtected()) {
                $this->protectedProperties++;
            } elseif ($property->isPublic()) {
                $this->publicProperties++;
            }
        }

        return $this;
    }
}
