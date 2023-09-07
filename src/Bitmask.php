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

use BackedEnum;

/**
 * Masked Enums.
 *
 * This interface must be implemented only by integer-backed Enums (not regular classes).
 * All of the Enum's cases must be backed by powers of two (that is, 0, 1, 2, 4, 8, ...).
 * @see and extend at\zorro\tests\BitmaskTest to validate that your implementations will work correctly.
 */
interface Bitmask extends BackedEnum {

  /** @var int An empty bitmask. */
  public const EMPTY = 0;

  /**
   * Builds a bitmask from a list of values.
   *
   * @param BackedEnum ...$values List of Enum cases to build from
   * @throws BitmaskError INVALID_BITMASK_TYPE If value(s) are not valid for this bitmask
   * @return int A bitmask
   */
  public static function buildFrom(BackedEnum ...$values) : int;

  /**
   * ANDs this value to the given bitmask.
   *
   * @param int $bitmask The bitmask to operate on
   * @return int The new bitmask
   */
  public function and(int $bitmask = Bitmask::EMPTY) : int;

  /**
   * Checks whether this value is present in the given bitmask.
   *
   * @param int $bitmask The bitmask to operate on
   * @return bool True if this value is present in the bitmask; false otherwise
   */
  public function in(int $bitmask) : bool;

  /**
   * NOTs this value to the given bitmask.
   *
   * @param int $bitmask The bitmask to operate on
   * @return int The new bitmask
   */
  public function not(int $bitmask = Bitmask::EMPTY) : int;

  /**
   * ORs this value to the given bitmask.
   *
   * @param int $bitmask The bitmask to operate on
   * @return int The new bitmask
   */
  public function or(int $bitmask = Bitmask::EMPTY) : int;

  /**
   * Adds this value to the given bitmask.
   * This method aliases or().
   *
   * @param int $bitmask The bitmask to operate on
   * @return int The new bitmask
   */
  public function on(int $bitmask) : int;

  /**
   * Removes this value from the given bitmask.
   * This method aliases not().
   *
   * @param int $bitmask The bitmask to operate on
   * @return int The new bitmask
   */
  public function off(int $bitmask) : int;

  /**
   * XORs this value to the given bitmask.
   *
   * @param int $bitmask The bitmask to operate on
   * @return int The new bitmask
   */
  public function xor(int $bitmask = Bitmask::EMPTY) : int;
}
