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
		$file = getcwd().'/errors/parse.php';	

		$cmd->run(
			"php --syntax-check \"{$file}\""
			.' --no-php-ini --define display_errors=On --define log_errors=Off'
		)->willReturn(
			"PHP Parse error:  syntax error, unexpected 'if' (T_IF) in invalid.php on line 3"
			."\nErrors parsing {$file}\n"
		);

		$this->lint($file)->shouldReturn([
			[
				'type'    => 'parse',
				'error'   => 'syntax',
				'message' => "unexpected 'if' (T_IF)",
				'line'    => 3,
			],
		]);
	}

	function it_also_handles_fatal_errors(Cmd $cmd)
	{
		$file = getcwd().'/errors/fatal.php';

		$cmd->run(
			"php --syntax-check \"{$file}\""
			.' --no-php-ini --define display_errors=On --define log_errors=Off'
		)->willReturn(
			($message = "Cannot redeclare foo() (previously declared in {$file}:3)")
			."\nErrors parsing {$file}\n"
		);

		$this->lint($file)->shouldReturn([
			[
				'type'    => 'fatal',
				'error'   => 'fatal',
				'message' => $message,
				'line'    => 4,
			],
		]);
	}

}
