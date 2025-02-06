<?php

declare(strict_types=1);

namespace Tests\Type;

use PHPStan\Testing\TypeInferenceTestCase;

use function version_compare;

class CollectionDynamicReturnTypeExtensionsTest extends TypeInferenceTestCase
{
    /** @return iterable<mixed> */
    public static function dataFileAsserts(): iterable
    {
        yield from self::gatherAssertTypes(__DIR__ . '/data/collection-helper.php');
        yield from self::gatherAssertTypes(__DIR__ . '/data/collection-make-static.php');
        yield from self::gatherAssertTypes(__DIR__ . '/data/collection-stubs.php');
        yield from self::gatherAssertTypes(__DIR__ . '/data/collection-generic-static-methods.php');

        // 11.100 is an artificial constraint until 12.0.0 is released
        if (version_compare(LARAVEL_VERSION, '11.0.0', '>=') && version_compare(LARAVEL_VERSION, '11.100.0', '<')) {
            yield from self::gatherAssertTypes(__DIR__ . '/data/collection-generic-static-methods-l11.php');
        }

        if (! version_compare(LARAVEL_VERSION, '12.0.0', '>=') && LARAVEL_VERSION !== '12.x-dev') {
            return;
        }

        yield from self::gatherAssertTypes(__DIR__ . '/data/collection-generic-static-methods-l12.php');
    }

    /** @dataProvider dataFileAsserts */
    public function testFileAsserts(
        string $assertType,
        string $file,
        mixed ...$args,
    ): void {
        $this->assertFileAsserts($assertType, $file, ...$args);
    }

    /** @return string[] */
    public static function getAdditionalConfigFiles(): array
    {
        return [__DIR__ . '/../phpstan-tests.neon'];
    }
}
