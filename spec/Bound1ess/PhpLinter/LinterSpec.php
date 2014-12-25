<?php namespace spec\Bound1ess\PhpLinter;

use PhpSpec\ObjectBehavior;

class LinterSpec extends ObjectBehavior {

    function it_is_initializable()
    {
        $this->shouldHaveType('Bound1ess\PhpLinter\Linter');
    }

}
