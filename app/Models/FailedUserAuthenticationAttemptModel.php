<?php


namespace App\Models;


use DateTime;
use Illuminate\Database\Eloquent\Model;

/**
 * Class FailedUserAuthenticationAttemptModel
 * @package App\Models
 *
 * @property string $id
 * @property string $username
 * @property string $headers
 * @property DateTime $created_at
 * @property DateTime $updated_at
 */
class FailedUserAuthenticationAttemptModel extends Model
{

    public const TABLE_NAME = 'failed_authentication_attempts';

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
}