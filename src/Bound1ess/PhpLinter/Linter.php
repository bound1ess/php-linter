<?php namespace Bound1ess\PhpLinter;

class Linter {

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
		// What should be here?
	}

}
