<?php

namespace App\BusinessLogicLayer\lkp;


abstract class UserRolesLkp {
    //ATTENTION: these values match with the db values defined in database\seeds\UsersRoleLkpTableSeeder.php
    const ADMIN = 1;
    const CONTENT_MANAGER = 2;
    const REGISTERED_USER = 3;
    const ANSWERS_MODERATOR = 4;
}
