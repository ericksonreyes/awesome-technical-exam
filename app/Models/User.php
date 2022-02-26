<?php

namespace App\Models;

use DateTime;
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
 * @property string $username
 * @property string $password
 * @property string $status
 * @property DateTime $created_at
 * @property DateTime $updated_at
 */
class User extends Model implements UserRepository
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
     * @param UserInterface $user
     * @return mixed
     */
    public function store(UserInterface $user): void
    {
        $newUser = new self();
        $newUser->guid = $user->id();
        $newUser->username = $user->username();
        $newUser->password = $user->password();
        $newUser->status = $user->accountStatus();
        $newUser->save();
    }

    /**
     * @param string $username
     * @param $password
     * @return UserInterface|null
     */
    public function findOneByUsernameAndPassword(string $username, $password): ?UserAttributesInterface
    {
        $existingUser = User::where('username', $username)
            ->where('password', $password)
            ->first();

        if ($existingUser instanceof User) {
            return (new UserDTO())
                ->setId($existingUser->guid)
                ->setUsername($existingUser->username)
                ->setPassword($existingUser->password)
                ->setAccountStatus($existingUser->status)
                ;
        }
        return null;
    }

    /**
     * @param string $username
     * @return UserInterface|null
     */
    public function findOneByUsername(string $username): ?UserAttributesInterface
    {
        $existingUser = User::where('username', $username)->first();

        if ($existingUser instanceof User) {
            return (new UserDTO())
                ->setId($existingUser->guid)
                ->setUsername($existingUser->username)
                ->setPassword($existingUser->password)
                ->setAccountStatus($existingUser->status)
                ;
        }
        return null;
    }


}
