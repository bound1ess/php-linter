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
			'log_errors'     => false,
		]);
	
		if (strpos($output, 'No syntax errors detected') !== false)
		{
			return [];
		}

		return $this->parseOutput($output);
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

	/**
	 * @param string $output
	 * @return array
	 */
	protected function parseOutput($output)
	{
		$result = [];

		foreach (array_filter(explode(PHP_EOL, $output)) as $error)
		{
			if (strpos($error, 'Errors parsing') !== false)
			{
				continue;
			}

			$message = [];

			preg_match(
				'/PHP (?<type>\w+) error: (?<error>.+) in (?<file>.+) on line (?<line>\d+)/', 
				$error, 
				$message
			);

			$result[] = [
				'type'  => strtolower($message['type']),
				'error' => trim($message['error']),
				'file'  => $message['file'],
				'line'  => intval($message['line']),
			];
		}
		
		return $result;
	}

}
