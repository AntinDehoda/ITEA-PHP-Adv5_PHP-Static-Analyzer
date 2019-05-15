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

    public function analyze(): SignatureCollection
    {
        try {
            $reflector = new \ReflectionClass($this->classFullName);
        } catch (\ReflectionException $e) {
            throw new InvalidClassNameException(\sprintf('Invalid class name %s', $this->classFullName));
        }

        $signature = new SignatureCollection();

        $modifierNames = \Reflection::getModifierNames($reflector->getModifiers());
        $modifierName = (0 == \count($modifierNames)) ? $signature::TYPE_NORMAL : \implode(' ', $modifierNames);

        $signature->setType($modifierName);

        $methods = $reflector->getMethods();
        $signature = $this->countSignature($methods, $signature);

        $properties = $reflector->getProperties();
        $signature = $this->countSignature($properties, $signature);


        return $signature;
    }
    /**
     * Counting methods or properties
     *
     * @param \ReflectionMethod []| \ReflectionProperty[] $reflectorElementsArray
     *
     * @return SignatureCollection
     */
    private function countSignature(array $reflectorElementsArray, SignatureCollection $signatureObject)
    {
        foreach ($reflectorElementsArray as $elem) {
            if ($elem->isPrivate()) {
                $signatureObject->increasePrivateProperties();
            } elseif ($elem->isProtected()) {
                $signatureObject->increaseProtectedProperties();
            } elseif ($elem->isPublic()) {
                $signatureObject->increasePublicProperties();
            }
        }

        return $signatureObject;
    }
}
