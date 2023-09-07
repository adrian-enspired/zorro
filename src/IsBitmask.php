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

use BackedEnum,
  InvalidArgumentException;

use at\zorro\ {
  Bitmask,
  Error as BitmaskError
};

/**
 * Implementation of Bitmask.
 *
 * This trait must be used only with integer-backed Enums (not regular classes).
 * All of the Enum's cases must be backed by powers of two (that is, 0, 1, 2, 4, 8, ...).
 * @see and extend at\zorro\tests\BitmaskTest to validate that your implementations will work correctly.
 *
 * If your IsBitmask implementation is expected to be used by a UsesBitmask class,
 *  it must also `implement Bitmask`.
 * If not, the trait will function as expected without implementing the interface.
 */
trait IsBitmask {

  /** {@inheritDoc} */
  public static function buildFrom(BackedEnum ...$values) : int {
    return array_reduce(
      $values,
      fn ($bitmask, $value) => $value instanceof static ?
        $bitmask | $value->value :
        BitmaskError::throw(BitmaskError::INVALID_BITMASK_VALUE, ["type" => $value::class]),
      Bitmask::EMPTY
    );
  }

  /** {@inheritDoc} */
  public function and(int $bitmask = Bitmask::EMPTY ) : int {
    return $bitmask & $this->value;
  }

  /** {@inheritDoc} */
  public function in(int $bitmask) : bool {
    return ($this->value & $bitmask) === $this->value;
  }

  /** {@inheritDoc} */
  public function not(int $bitmask = Bitmask::EMPTY ) : int {
    return $bitmask ^ $this->value;
  }

  /** {@inheritDoc} */
  public function or(int $bitmask = Bitmask::EMPTY ) : int {
    return $bitmask | $this->value;
  }

  /** {@inheritDoc} */
  public function on(int $bitmask) : int {
    return $this->or($bitmask);
  }

  /** {@inheritDoc} */
  public function off(int $bitmask) : int {
    return $this->not($bitmask);
  }

  /** {@inheritDoc} */
  public function xor(int $bitmask = Bitmask::EMPTY ) : int {
    return $bitmask xor $this->value;
  }
}
