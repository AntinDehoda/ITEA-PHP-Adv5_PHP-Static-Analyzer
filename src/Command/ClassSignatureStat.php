<?php

/*
 * This file is part of the "PHP Static Analyzer" project.
 *
 * (c) Vladimir Kuprienko <vldmr.kuprienko@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Greeflas\StaticAnalyzer\Command;

use Greeflas\StaticAnalyzer\Analyzer\ClassSignatureCounter;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class ClassSignatureStat
 *
 * The team collects information about the signature of a given class - the number of methods and properties,
 * as well as the type of the specified class.
 * The required class is specified using the full name.
 *
 * Example of usage
 * ./bin/console stat:class-signature Greeflas\\StaticAnalyzer\\Analyzer\\ClassSignatureCounter
 *
 * @author Anton Degoda <dehoda@ukr.net>
 */
final class ClassSignatureStat extends Command
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('stat:class-signature')
            ->setDescription('Shows statistic about classes/interfaces/traits signature')
            ->addArgument(
                'full-class-name',
                InputArgument::REQUIRED,
                'Full class name of needed class.'
            )
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $fullClassName = $input->getArgument('full-class-name');

        $classAnalyzer = new ClassSignatureCounter($fullClassName);
        $classInfo = $classAnalyzer->analyze();


        $output->writeln(\sprintf(
            '<info>Class: %s is %s</info>' .
            "\n" .
            '<info>Properties:</info>' .
            "\n" .
            '<info>    public: %d</info>' .
            "\n" .
            '<info>    protected: %d</info>' .
            "\n" .
            '<info>    private: %d</info>' .
            "\n" .
            '<info>Methods:</info>' .
            "\n" .
            '<info>    public: %d</info>' .
            "\n" .
            '<info>    protected: %d</info>' .
            "\n" .
            '<info>    private: %d</info>',
            $fullClassName,
            $classInfo->type,
            $classInfo->publicProperties,
            $classInfo->protectedProperties,
            $classInfo->privateProperties,
            $classInfo->publicMethods,
            $classInfo->protectedMethods,
            $classInfo->privateMethods
        ));
    }
}
