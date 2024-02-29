<?php

/**
 * League.Csv (https://csv.thephpleague.com)
 *
 * (c) Ignace Nyamagana Butera <nyamsprod@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace League\Csv\Serializer;

/**
 * @template TValue
 */
interface TypeCasting
{
    /**
     * @throws TypeCastingFailed
     *
     * @return TValue
     */
    public function toVariable(?string $value): mixed;

    /**
     * Accepts additional parameters to configure the class
     * Parameters should be scalar value, null or array containing
     * only scalar value and null.
     *
     * @throws MappingFailed
     */
    public function setOptions(): void;
}
