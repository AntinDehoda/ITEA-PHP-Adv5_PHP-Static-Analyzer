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

/**
 * This class contains quantitative values of methods and properties, as well as the type of requested class.
 *
 * @author Anton Degoda <dehoda@ukr.net>
 */
final class SignatureCollection
{
    private $privateMethods;
    private $publicMethods;
    private $protectedMethods;
    private $privateProperties;
    private $protectedProperties;
    private $publicProperties;
    private $type;

    public function __construct()
    {
        $this->privateMethods = 0;
        $this->publicMethods = 0;
        $this->protectedMethods = 0;
        $this->privateProperties = 0;
        $this->protectedProperties = 0;
        $this->publicProperties = 0;
    }

    public function getPrivateMethods(): int
    {
        return $this->privateMethods;
    }

    public function increasePrivateMethods(): void
    {
        $this->privateMethods++;
    }

    public function getPublicMethods(): int
    {
        return $this->publicMethods;
    }

    public function increasePublicMethods(): void
    {
        $this->publicMethods++;
    }

    public function getProtectedMethods(): int
    {
        return $this->protectedMethods;
    }

    public function increaseProtectedMethods(): void
    {
        $this->protectedMethods;
    }

    public function getPrivateProperties(): int
    {
        return $this->privateProperties;
    }

    public function increasePrivateProperties(): void
    {
        $this->privateProperties++;
    }

    public function getProtectedProperties(): int
    {
        return $this->protectedProperties;
    }

    public function increaseProtectedProperties(int $protectedProperties): void
    {
        $this->protectedProperties ++;
    }

    public function getPublicProperties(): int
    {
        return $this->publicProperties;
    }

    public function increasePublicProperties(): void
    {
        $this->publicProperties ++;
    }

    public function getType()
    {
        return $this->type;
    }

    public function setType($type): void
    {
        $this->type = $type;
    }
}
