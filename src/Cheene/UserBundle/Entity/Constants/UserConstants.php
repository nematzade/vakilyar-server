<?php
// src/Cheene/UserBundle/Entity/UserConstants.php
namespace Cheene\UserBundle\Entity\Constants;

use Cheene\CoreBundle\Entity\TimestampedEntity;
use Doctrine\ORM\Mapping as ORM;

class UserConstants
{
    const SEX_MALE = "MALE";
    const SEX_FEMALE = "FEMALE";

    const PERSIAN = 'fa';
    const ENGLISH = 'en';

    public static $user_sexes = array(
        UserConstants::SEX_MALE => "label.users.sex.male",
        UserConstants::SEX_FEMALE => "label.users.sex.female",
    );

    public static $user_locales = array(
        UserConstants::PERSIAN => "label.locale.fa",
        UserConstants::ENGLISH => "label.locale.en",
    );

    const TYPE_BACKEND = "BACKEND";
    const TYPE_FRONTEND = "FRONTEND";

    public static $user_types = array(
        UserConstants::TYPE_BACKEND => "Backend User",
        UserConstants::TYPE_FRONTEND => "Frontend User",
    );

    const STATUS_NOT_VERIFIED = "NOT_VERIFIED";
    const STATUS_NOT_VALIDATED = "NOT_VALIDATED";
    const STATUS_VERIFIED = "VERIFIED";
    const STATUS_ACTIVE = "ACTIVE";
    const STATUS_DEACTIVATED = "DEACTIVATED";
    const STATUS_DELETED = "DELETED";
    const STATUS_LOCKED = "LOCKED";
    const STATUS_EXPIRED = "EXPIRED";

    const USER_PROFILE_IMAGE_PATH = "/uploads/images/user-profiles/";
    const USER_PROFILE_IMAGE_TYPE ='user_profile_image';

    public static $user_statuses = array(
        self::STATUS_NOT_VERIFIED => "label.users.not_verified",
        self::STATUS_NOT_VALIDATED => "label.users.not_validated",
        self::STATUS_VERIFIED => "label.users.verified",
        self::STATUS_ACTIVE => "label.users.active",
        self::STATUS_DEACTIVATED => "label.users.deactivated",
        self::STATUS_DELETED => "label.users.deleted",
        self::STATUS_LOCKED => "label.users.locked",
        self::STATUS_EXPIRED => "label.users.expired",
    );


    const ROLES_SUPER_ADMIN = "SUPER_ADMIN";
    const ROLES_Admin = "Admin";
    const ROLES_Accounting = "Accounting";
    const ROLES_Supervisor = "Supervisor";

    public static $user_roles = array(
        self::ROLES_SUPER_ADMIN => "Super Admin",
        self::ROLES_Admin => "Admin",
        self::ROLES_Accounting => "Accounting",
        self::ROLES_Supervisor => "Supervisor",
    );

    //
    const MAXIMUM_FORGOT_TRIES = 10;

    const MAX_PAGES_SIZE = 50;
    const FORGET_PASSWORD_LIFECYCLE = '+10 min';

    const FORGET_PASSWORD_TYPE_SMS = 'SMS';
    const FORGET_PASSWORD_TYPE_EMAIL = 'EMAIL';
}
