<?php namespace spec\Bound1ess\PhpLinter\Support;

use PhpSpec\ObjectBehavior;

class CmdSpec extends ObjectBehavior {

    function it_is_initializable() 
	{
        $this->shouldHaveType('Bound1ess\PhpLinter\Support\Cmd');
    }

	function it_runs_a_command_and_returns_its_output() 
	{
		if (PHP_OS == 'Linux') 
		{
			$this->run('pwd')->shouldReturn(getcwd().PHP_EOL);
		}
	}

}
