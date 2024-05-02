<?php

namespace FakeData\Provider;

/**
 * @experimental This class is experimental and does not fall under our BC promise
 */
class Version extends Base
{
    /**
     * @var string[]
     */
    protected static array $semverCommonPreReleaseIdentifiers = ['alpha', 'beta', 'rc'];

    /**
     * Get a version number in semantic versioning syntax 2.0.0. (https://semver.org/spec/v2.0.0.html)
     *
     * @param bool $preRelease Pre release parts may be randomly included
     * @param bool $build      Build parts may be randomly included
     *
     * @example 1.0.0
     * @example 1.0.0-alpha.1
     * @example 1.0.0-alpha.1+b71f04d
     */
    public function semver(bool $preRelease = false, bool $build = false): string
    {
        return sprintf(
            '%d.%d.%d%s%s',
            static::numberBetween(0, 9),
            static::numberBetween(0, 99),
            static::numberBetween(0, 99),
            $preRelease && static::numberBetween(0, 1) === 1 ? '-' . $this->semverPreReleaseIdentifier() : '',
            $build && static::numberBetween(0, 1) === 1 ? '+' . $this->semverBuildIdentifier() : '',
        );
    }

    /**
     * Common pre-release identifier
     */
    private function semverPreReleaseIdentifier(): string
    {
        $ident = static::randomElement(static::$semverCommonPreReleaseIdentifiers);

        if (static::numberBetween(0, 1) !== 1) {
            return $ident;
        }

        return $ident . '.' . static::numberBetween(1, 99);
    }

    /**
     * Common random build identifier
     */
    private function semverBuildIdentifier(): string
    {
        if (static::numberBetween(0, 1) === 1) {
            // short git revision syntax: https://git-scm.com/book/en/v2/Git-Tools-Revision-Selection
            return substr(sha1(static::lexify('??????')), 0, 7);
        }

        return $this->generator->format('date', ['YmdHis']);
    }
}
