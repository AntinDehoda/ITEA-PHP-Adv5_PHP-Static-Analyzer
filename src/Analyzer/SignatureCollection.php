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
    public $privateMethods;
    public $publicMethods;
    public $protectedMethods;
    public $privateProperties;
    public $protectedProperties;
    public $publicProperties;
    public $type;

    public function __construct()
    {
        $this->privateMethods = 0;
        $this->publicMethods = 0;
        $this->protectedMethods = 0;
        $this->privateProperties = 0;
        $this->protectedProperties = 0;
        $this->publicProperties = 0;
    }
}
