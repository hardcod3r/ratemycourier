<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;
use BenSampo\Enum\Attributes\Description;

#[Description('Rate Type')]
final class RateType extends Enum
{
    #[Description('Like')]
    const Like = 1;
    #[Description('Dislike')]
    const Dislike = 2;
}
