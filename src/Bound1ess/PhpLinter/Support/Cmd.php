<?php namespace Bound1ess\PhpLinter\Support;

class Cmd {

	/**
	 * @param string $cmd
	 * @return null|string
	 */
	public function run($cmd) 
	{
		return `$cmd`;
	}

}
