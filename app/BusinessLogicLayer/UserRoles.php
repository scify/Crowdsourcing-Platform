<?php

namespace App\BusinessLogicLayer;

abstract class UserRoles {
    //ATTENTION: these values match with the db values defined in database\seeds\UsersRoles.php
    const ADMIN = 1;
    const CONTENT_MANAGER = 2;
    const REGISTERED_USER = 3;
    const ANSWERS_MODERATOR = 4;
}
