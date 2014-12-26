<?php namespace spec\Bound1ess\PhpLinter;

use PhpSpec\ObjectBehavior;

class LinterSpec extends ObjectBehavior {

    function it_is_initializable()
    {
        $this->shouldHaveType('Bound1ess\PhpLinter\Linter');
    }

	function it_checks_given_file_for_potential_errors()
	{
		$this->lint(getcwd().'/invalid.php')->shouldReturn([
			// Should return WHAT?
		]);
	}

}
