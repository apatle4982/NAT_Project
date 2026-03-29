<?php
declare(strict_types=1);

namespace App\Model\Entity;
use Authentication\PasswordHasher\DefaultPasswordHasher;
use Cake\ORM\Entity;
use Cake\Core\Configure;

/**
 * User Entity
 *
 * @property int $user_id
 * @property string $user_name
 * @property string $user_lastname
 * @property string $user_phone
 * @property string $user_email
 * @property string $user_username
 * @property string $user_password
 * @property string $original_password
 * @property int $user_companyid
 * @property string $user_active
 * @property string $user_deleted
 * @property string $privileges2add
 * @property string $privileges2edit
 * @property string $privileges2delete
 *
 * @property \App\Model\Entity\Group[] $groups
 */
class User extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array<string, bool>
     */
    protected $_accessible = [
        'user_name' => true,
        'user_lastname' => true,
        'user_phone' => true,
        'user_email' => true,
        'user_username' => true,
        'password' => true,
        'original_password' => true,
        'user_companyid' => true,
        'user_active' => true,
        'user_deleted' => true,
        'privileges2add' => true,
        'privileges2edit' => true,
        'privileges2delete' => true,
        'password_reset_token' => true,
        'hashval' => true,
        'groups' => true,        
    ];

    public const LEVEL_SUPER_ADMIN = 1;
    public const LEVEL_LIMITED     = 2;
    public const LEVEL_READ_ONLY   = 3;
	
	protected function _setPassword(string $password) : ?string
    {
        if (strlen($password) > 0) {
            return (new DefaultPasswordHasher())->hash($password);
        }
    }

    public function isSuperAdmin()
    {

        $userGroupId = \Cake\Core\Configure::read('UserGroup.Id');
        return $userGroupId === self::LEVEL_SUPER_ADMIN;
    }

    public function isLimited()
    {
        $userGroupId = \Cake\Core\Configure::read('UserGroup.Id');
        return $userGroupId === self::LEVEL_LIMITED;
    }

    public function isReadOnly()
    {
        $userGroupId = \Cake\Core\Configure::read('UserGroup.Id');
        return $userGroupId === self::LEVEL_READ_ONLY;
    }

    public function isSuperAdmin_Or_isLimited()
    {

        $userGroupId = \Cake\Core\Configure::read('UserGroup.Id');
        return $userGroupId === self::LEVEL_SUPER_ADMIN || $userGroupId === self::LEVEL_LIMITED;
    }
}
