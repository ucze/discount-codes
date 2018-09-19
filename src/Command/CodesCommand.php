<?php

namespace App\Command;

use App\Form\CodeType;
use App\Util\CodesInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Form\FormFactoryInterface;

/**
 * Class CodesCommand
 * @package App\Command
 */
class CodesCommand extends Command
{
    /**
     * @var CodesInterface
     */
    protected $codesService;
    /**
     * @var FormFactoryInterface
     */
    protected $form;
    /**
     * @var Filesystem
     */
    protected $fs;

    /**
     * CodesCommand constructor.
     * @param CodesInterface $codesService
     * @param FormFactoryInterface $form
     * @param Filesystem $fs
     */
    public function __construct(CodesInterface $codesService, FormFactoryInterface $form, Filesystem $fs)
    {
        $this->codesService = $codesService;
        $this->form = $form;
        $this->fs = $fs;
        parent::__construct();
    }

    /**
     * Method called before execute()
     */
    protected function configure()
    {
        $this
            ->setName('app:generate-codes')
            ->setDescription('Generate discount codes')
            ->setHelp('This command allows you to generate discount codes')
            ->addOption('numberOfCodes', 'u', InputOption::VALUE_REQUIRED, 'numberOfCodes of codes', 100)
            ->addOption('lengthOfCodes', 'l', InputOption::VALUE_REQUIRED, 'length of codes', 5)
            ->addOption('filename', 'f', InputOption::VALUE_REQUIRED, 'filename', '/tmp/codes.txt');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|null|void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $formBuilder = $this->form->createBuilder(CodeType::class);
        $form = $formBuilder->getForm();
        $numberOfCodes = $input->getOption('numberOfCodes');
        $lengthOfCodes = $input->getOption('lengthOfCodes');
        $filename = $input->getOption('filename');
        $form->submit(['numberOfCodes' => $numberOfCodes, 'lengthOfCodes' => $lengthOfCodes], false);
        if ($form->isValid()) {
            $output->writeln([ '============', '<info>Codes Generator</info>', '============', 'Generating ' . $numberOfCodes . ' codes', 'Max length ' . $lengthOfCodes, 'File location ' . $filename, '============']);
            $codes = $this->codesService->generate($numberOfCodes, $lengthOfCodes);
            if (empty($codes)) {
                $output->writeln("<error>Can't generate so many codes, reduce amount and try again</error>");
                exit();
            }
            $this->fs->dumpFile($filename, implode(", ", $codes));
            //something
            $output->writeln(['<info>Codes successfuly created</info>',  '============']);
        } else {
            $output->writeln(['============',"<error>Validation Errors</error>", '============']);
            foreach ($form->all() as $record) {
                $name = $record->getName();
                if ($name !== 'generate' && $record->getErrors()->getChildren()) {
                    $output->writeln('<error>'. $name . '</error> - <comment>' . $record->getErrors()->getChildren()->getMessage().'</comment>');;
                }
            }
        }
    }
}