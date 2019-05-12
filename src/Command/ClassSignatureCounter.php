<?php


namespace Greeflas\StaticAnalyzer\Command;

use Greeflas\StaticAnalyzer\Analyzer\ClassSignature;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
/**
 * Command for getting information about classes/interfaces/traits
 * was created by some developer.
 *
 * Example of usage
 * ./bin/console stat:class-author vldmr.kuprienko@gmail.com $PWD/src
 *
 * @author Vladimir Kuprienko <vldmr.kuprienko@gmail.com>
 */

final class ClassSignatureCounter extends Command{
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

        $classAnalyzer = new ClassSignature($fullClassName);
        $classInfo = $classAnalyzer->analyze();


        $output->writeln(\sprintf(
            "<info>Class: %s is %s</info>" .
            "\n" .
            "<info>Properties:</info>" .
            "\n" .
            "<info>    public: %d</info>" .
            "\n" .
            "<info>    protected: %d</info>" .
            "\n" .
            "<info>    private: %d</info>" .
            "\n" .
            "<info>Methods:</info>" .
            "\n" .
            "<info>    public: %d</info>" .
            "\n" .
            "<info>    protected: %d</info>" .
            "\n" .
            "<info>    private: %d</info>"
            ,
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