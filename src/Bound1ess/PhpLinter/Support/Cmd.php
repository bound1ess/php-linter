<?php namespace Bound1ess\PhpLinter\Support;

class Cmd {

	/**
	 * @param string $command
	 * @return null|string
	 */
	public function run($command) 
	{
		$pipes = [];
		$spec  = [['pipe', 'r'], ['pipe', 'w'], ['pipe', 'w']];
	
		$process = proc_open($command, $spec, $pipes, getcwd(), null);

		if ( ! is_resource($process))
		{
			return null;
		}

		list($stdout, $stderr) = [
			stream_get_contents($pipes[1]),
			stream_get_contents($pipes[2]),
		];

		fclose($pipes[1]); fclose($pipes[2]);

		proc_close($process);

		return $stderr.$stdout;
	}

}
