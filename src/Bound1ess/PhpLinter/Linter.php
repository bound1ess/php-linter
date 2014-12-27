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

		if (strpos($output, 'Errors parsing') === false)
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

			$message = '';
			preg_match('/error: (.+) in (.+) on line/', $error, $message);
	
			$result[] = [
				'type'    => strpos($error, 'PHP Parse error:') !== false ? 'parse' : 'fatal',
				'error'   => 
					$type = (strpos($error, 'syntax error') !== false ? 'syntax' : 'fatal'), 
				'message' => 
					trim($type == 'syntax' ? 
						str_replace('syntax error,', '', $message[1]) : $message[1]
					),
				'line'    => intval(end(explode(' ', $error))),
			];
		}

		return $result;
	}

}
