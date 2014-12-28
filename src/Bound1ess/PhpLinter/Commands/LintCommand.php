<?php namespace Bound1ess\PhpLinter\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class LintCommand extends Command {

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
		$output->writeln(
			"<info>Checking {$input->getArgument('file')} for potential errors...</info>"
		);
	}

}
