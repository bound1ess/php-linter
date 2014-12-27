<?php namespace Bound1ess\PhpLinter;

class Linter {

	/**
	 * @var Support\Cmd
	 */
	protected $cmd;

	/**
	 * @param Support\Cmd $cmd
	 * @return Linter
	 */
	public function __construct(Support\Cmd $cmd)
	{
		$this->cmd = $cmd;
	}

	/**
	 * @param string $file
	 * @return array
	 */
	public function lint($file)
	{
		$output = $this->runLinter($file, [
			'display_errors' => true,
			'log_errors' => false,
		]);

		// What should I do with the $output?
	}

	/**
	 * @param string $file
	 * @param array $options
	 * @param boolean $usePhpIni
	 * @return string
	 */
	protected function runLinter($file, array $options = [], $usePhpIni = false)
	{
		$command = "php --syntax-check \"{$file}\"";

		if ( ! $usePhpIni)
		{
			$command .= ' --no-php-ini';
		}

		foreach ($options as $key => $value)
		{
			$command .= sprintf(' --define %s=%s', $key, $value ? 'On' : 'Off'); 
		}

		return $this->cmd->run($command);
	}

}
