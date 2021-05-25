<?php declare(strict_types = 1);

namespace PHPStan\Rules\Api;

use PHPStan\Testing\RuleTestCase;

/**
 * @extends RuleTestCase<ApiClassImplementsRule>
 */
class ApiClassImplementsRuleTest extends RuleTestCase
{

	protected function getRule(): \PHPStan\Rules\Rule
	{
		return new ApiClassImplementsRule(new ApiRuleHelper(), $this->createReflectionProvider());
	}

	public function testRuleInPhpStan(): void
	{
		$this->analyse([__DIR__ . '/data/class-implements-in-phpstan.php'], []);
	}

	public function testRuleOutOfPhpStan(): void
	{
		$tip = sprintf(
			"If you think it should be covered by backward compatibility promise, open a discussion:\n   %s\n\n   See also:\n   https://phpstan.org/developing-extensions/backward-compatibility-promise",
			'https://github.com/phpstan/phpstan/discussions'
		);

		$this->analyse([__DIR__ . '/data/class-implements-out-of-phpstan.php'], [
			[
				'Implementing PHPStan\DependencyInjection\Type\DynamicThrowTypeExtensionProvider is not covered by backward compatibility promise. The interface might change in a minor PHPStan version.',
				11,
				$tip,
			],
		]);
	}

}
