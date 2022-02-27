<?php

namespace App\Models;

use DateTime;
use Exception;
use Github\Domain\Model\UserAttributesInterface;
use Github\Domain\Model\UserInterface;
use Github\Domain\Repository\UserRepository;
use Illuminate\Database\Eloquent\Model;

/**
 * Class User
 * @package App\Models
 *
 * @property int $id
 * @property string $guid
 * @property string $email
 * @property string $password
 * @property string $status
 * @property DateTime $createdOn
 * @property DateTime $lastUpdatedOn
 */
class UserModel extends Model implements UserRepository
{

    public const TABLE_NAME = 'users';

    /**
     * @var string
     */
    protected $table = self::TABLE_NAME;

    /**
     * @return string
     */
    public function getDateFormat(): string
    {
        return 'U';
    }

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'createdOn',
        'lastUpdatedOn'
    ];

    /**
     * @param UserInterface $user
     * @throws Exception
     */
    public function store(UserInterface $user): void
    {
        $userModel = UserModel::where('email', $user->email())->first();

        if ($userModel instanceof UserModel === false) {
            $userModel = new self();
            $userModel->createdOn = new DateTime();
        }

        $userModel->guid = $user->id();
        $userModel->email = $user->email();
        $userModel->password = $user->password();
        $userModel->status = $user->accountStatus();
        $userModel->lastUpdatedOn = new DateTime();
        $userModel->save();
    }

    /**
     * @param string $email
     * @param $password
     * @return UserInterface|null
     */
    public function findOneByEmailAndPassword(string $email, $password): ?UserAttributesInterface
    {
        $existingUser = UserModel::where('email', $email)
            ->where('password', $password)
            ->first();

        if ($existingUser instanceof UserModel) {
            return (new UserDTO())
                ->setId($existingUser->guid)
                ->setUsername($existingUser->email)
                ->setPassword($existingUser->password)
                ->setAccountStatus($existingUser->status)
                ;
        }
        return null;
    }

    /**
     * @param string $email
     * @return UserInterface|null
     */
    public function findOneByEmail(string $email): ?UserAttributesInterface
    {
        $existingUser = UserModel::where('email', $email)->first();

        if ($existingUser instanceof UserModel) {
            return (new UserDTO())
                ->setId($existingUser->guid)
                ->setUsername($existingUser->email)
                ->setPassword($existingUser->password)
                ->setAccountStatus($existingUser->status)
                ;
        }
        return null;
    }


}
