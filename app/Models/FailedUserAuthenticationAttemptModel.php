<?php


namespace App\Models;


use DateTime;
use Illuminate\Database\Eloquent\Model;

/**
 * Class FailedUserAuthenticationAttemptModel
 * @package App\Models
 *
 * @property string $id
 * @property string $email
 * @property string $headers
 * @property DateTime $attemptedOn
 */
class FailedUserAuthenticationAttemptModel extends Model
{

    public const TABLE_NAME = 'failed_authentication_attempts';

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'attemptedOn'
    ];

    /**
     * @var bool
     */
    public $timestamps = false;

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