<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;
use BenSampo\Enum\Attributes\Description;

/**
 * @method static static List()
 * @method static static Detail()
 */
#[Description('View types')]
final class ViewType extends Enum
{
    #[Description('List view')]
    const List = 1;
    #[Description('Detail view')]
    const Detail = 2;
}
