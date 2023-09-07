<?php
/**
 * @package    at.zorro
 * @author     Adrian <adrian@enspi.red>
 * @copyright  2023
 * @license    GPL-3.0 (only)
 *
 *  This program is free software: you can redistribute it and/or modify it
 *  under the terms of the GNU General Public License, version 3.
 *  The right to apply the terms of later versions of the GPL is RESERVED.
 *
 *  This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY;
 *  without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *  See the GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License along with this program.
 *  If not, see <http://www.gnu.org/licenses/gpl-3.0.txt>.
 */

declare(strict_types = 1);

namespace at\zorro;

use at\zorro\Bitmask;

/**
 * Base class for storing and managing bitmasks.
 *
 * Concrete subclasses MUST override the class constant `BITMASK`
 *  with the fully qualified classname of the Bitmask to be used.
 * The subclass will be unusable otherwise.
 */
abstract class UsesBitmask {

  /** @var string FQCN of Bitmask to use. */
  public const BITMASK = null;

  /** @var int Current value of this bitmask. */
  private int $bitmask = Bitmask::EMPTY;

  /**
   * Gets the underlying bitmask, as an integer.
   *
   * @return int Current value of this bitmask
   */
  public function bitmask() : int {
    return $this->bitmask;
  }

  /**
   * Checks whether all of the the given value(a) are currently set on this bitmask.
   *
   * @param Bitmask ...$bits The bitmask values to check
   * @throws BitmaskError INVALID_BITMASK_TYPE If value(s) are not valid for this bitmask
   * @return bool True if all values are set on this bitmask; false otherwise
   */
  public function has(Bitmask ...$values) : bool {
    foreach ($values as $value) {
      $this->ensureCorrectType($value);
      if (! $value->in($this->bitmask)) {
        return false;
      }
    }

    return true;
  }

  /**
   * Checks whether any of the given value(s) are currently set on this bitmask.
   *
   * @param Bitmask ...$bits The bitmask values to check
   * @throws BitmaskError INVALID_BITMASK_TYPE If value(s) are not valid for this bitmask
   * @return bool True if any values are set on this bitmask; false otherwise
   */
  public function hasAny(Bitmask ...$values) : bool {
    foreach ($values as $value) {
      $this->ensureCorrectType($value);
      if ($value->in($this->bitmask)) {
        return true;
      }
    }

    return false;
  }

  /**
   * Checks whether all of the given value(s) are currently not set on this bitmask.
   *
   * @param Bitmask ...$bits The bitmask values to check
   * @throws BitmaskError INVALID_BITMASK_TYPE If value(s) are not valid for this bitmask
   * @return bool True if all values are not set on this bitmask; false otherwise
   */
  public function hasNone(Bitmask ...$values) : bool {
    foreach ($values as $value) {
      $this->ensureCorrectType($value);
      if ($value->in($this->bitmask)) {
        return false;
      }
    }

    return true;
  }

  /**
   * Turns value(s) on.
   *
   * @param Bitmask ...$values The values to turn on
   * @throws BitmaskError INVALID_BITMASK_TYPE If value(s) are not valid for this bitmask
   * @return static $this
   */
  public function add(Bitmask ...$values) : static {
    $this->bitmask = array_reduce(
      $values,
      function ($bitmask, $value) {
        $this->ensureCorrectType($value);
        return $value->on($bitmask);
      },
      $this->bitmask
    );

    return $this;
  }

  /**
   * Turns value(s) off.
   *
   * @param Bitmask ...$values The values to turn off
   * @throws BitmaskError INVALID_BITMASK_TYPE If value(s) are not valid for this bitmask
   * @return static $this
   */
  public function remove(Bitmask ...$values) : static {
    $this->bitmask = array_reduce(
      $values,
      function ($bitmask, $value) {
        $this->ensureCorrectType($value);
        return $value->off($bitmask);
      },
      $this->bitmask
    );

    return $this;
  }

  /**
   * ensureCorrectTypes that the given value is valid for this bitmask.
   *
   * @throws BitmaskError INVALID_BITMASK_TYPE If value is not valid for this bitmask
   */
  protected function ensureCorrectType(Bitmask $value) : void {
    if (! $value instanceof (static::BITMASK)) {
      BitmaskError::throw(BitmaskError::INVALID_BITMASK_VALUE, ["type" => $value::class]);
    }
  }
}
