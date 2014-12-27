<?php namespace spec\Bound1ess\PhpLinter;

use PhpSpec\ObjectBehavior;
use Bound1ess\PhpLinter\Support\Cmd;

class LinterSpec extends ObjectBehavior {

	function let(Cmd $cmd)
	{
		$this->beConstructedWith($cmd);
	}

    function it_is_initializable()
    {
        $this->shouldHaveType('Bound1ess\PhpLinter\Linter');
    }

	function it_checks_given_file_for_potential_errors(Cmd $cmd)
	{
		$file = getcwd().'/invalid.php';	

		$cmd->run(
			"php --syntax-check \"{$file}\""
			.' --no-php-ini --define display_errors=On --define log_errors=Off'
		)->shouldBeCalled();

		$this->lint($file)->shouldReturn([
			// Should return WHAT?
		]);
	}

}
