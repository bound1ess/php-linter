<?php namespace Bound1ess\PhpLinter\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use Bound1ess\PhpLinter\Linter;
use Bound1ess\PhpLinter\Support\Cmd;

class LintCommand extends Command {

	/**
	 * @param Linter|null $linter
	 * @return LintCommand
	 */
	public function __construct(Linter $linter = null)
	{
		$this->linter = $linter ?: new Linter(new Cmd);

		parent::__construct();
	}

	/**
	 * @return void
	 */
	protected function configure()
	{
		$this->setName('lint')->setDescription('Checks a file for potential errors');

		$this->addArgument('file', InputArgument::REQUIRED, 'File you want to check.');
	}

	/**
	 * @param InputInterface $input
	 * @param OutputInterface $output
	 * @return void
	 */
	protected function execute(InputInterface $input, OutputInterface $output)
	{
		$file = $input->getArgument('file');

		$output->writeln("<info>Checking {$file} for potential errors...</info>");

		if ( ! $errors = $this->linter->lint($file))
		{
			$output->writeln('No syntax errors were detected.');

			return null;
		}

		foreach ($errors as $error)
		{
			$output->writeln(sprintf(
				'<error>[%s]</error>[%s:%s] <comment>%s</comment>',
				strtoupper($error['type']), $error['file'], $error['line'], $error['error']
			));	
		}
	}

}
