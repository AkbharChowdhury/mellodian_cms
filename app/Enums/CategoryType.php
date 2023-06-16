<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static Pizza()
 * @method static static Crust()
 * @method static static Topping()
 */
final class CategoryType extends Enum
{
    const Pizza = 1;
    const Crust = 2;
    const Topping = 3;
}
