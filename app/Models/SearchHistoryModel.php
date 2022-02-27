<?php


namespace App\Models;

use DateTime;
use Illuminate\Database\Eloquent\Model;

/**
 * Class SearchHistoryModel
 * @package App\Models
 *
 * @property string $id
 * @property string $email
 * @property string $searchString
 * @property int $resultCount
 * @property int $searchSpeed
 * @property DateTime $searchedOn
 */
class SearchHistoryModel extends Model
{

    public const TABLE_NAME = 'search_history';

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'searchedOn'
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