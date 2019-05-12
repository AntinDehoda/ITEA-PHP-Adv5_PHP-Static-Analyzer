<?php


namespace Greeflas\StaticAnalyzer\Analyzer;

final class ClassSignature
{
    private $classFullName;
    private $reflector;
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
            $this->type = 'not found at this moment';
    }

    public function analyze(): self
    {
        try {
            $this->reflector = new \ReflectionClass($this->classFullName);
        } catch (\ReflectionException $e) {
            return $this;
        }
            $this->type = implode(' ', \Reflection::getModifierNames($this->reflector->getModifiers()));

            $methods = $this->reflector->getMethods();

            foreach ($methods as $method) {
                if ($method->isPrivate()) {
                    $this->privateMethods++;
                } elseif ($method->isProtected()) {
                    $this->protectedMethods++;
                } elseif ($method->isPublic()) {
                    $this->publicMethods++;
                }
            }

            $properties = $this->reflector->getProperties();


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