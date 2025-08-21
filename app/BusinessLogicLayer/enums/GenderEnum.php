<?php

declare(strict_types=1);

namespace App\BusinessLogicLayer\enums;

enum GenderEnum: string {
    case Male = 'MALE';
    case Female = 'FEMALE';
    case Other = 'OTHER';
}
