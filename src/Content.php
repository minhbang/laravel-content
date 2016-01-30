<?php
namespace Minhbang\Content;

use Laracasts\Presenter\PresentableTrait;
use Minhbang\Image\ImageableModel as Model;
use Minhbang\Kit\Traits\Model\AttributeQuery;
use Minhbang\Kit\Traits\Model\DatetimeQuery;
use Minhbang\Kit\Traits\Model\SearchQuery;
use Minhbang\User\Support\UserQuery;

/**
 * Class Content
 *
 * @package Minhbang\Content
 * @property integer $id
 * @property string $title
 * @property string $slug
 * @property string $content
 * @property integer $hit
 * @property integer $user_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read mixed $url
 * @property-read mixed $resource_name
 * @property-read \Minhbang\User\User $user
 * @method static \Illuminate\Database\Query\Builder|\Minhbang\Content\Content whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Minhbang\Content\Content whereTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\Minhbang\Content\Content whereSlug($value)
 * @method static \Illuminate\Database\Query\Builder|\Minhbang\Content\Content whereContent($value)
 * @method static \Illuminate\Database\Query\Builder|\Minhbang\Content\Content whereHit($value)
 * @method static \Illuminate\Database\Query\Builder|\Minhbang\Content\Content whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\Minhbang\Content\Content whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Minhbang\Content\Content whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Minhbang\Content\Content queryDefault()
 * @method static \Illuminate\Database\Query\Builder|\Minhbang\Kit\Extensions\Model except($id = null)
 * @method static \Illuminate\Database\Query\Builder|\Minhbang\Content\Content hasStr($str, $attribute = 'content', $boolean = 'and')
 * @method static \Illuminate\Database\Query\Builder|\Minhbang\Content\Content exclusion($value, $attribute = 'id', $boolean = 'and')
 * @method static \Illuminate\Database\Query\Builder|\Minhbang\Content\Content orderCreated($direction = 'desc')
 * @method static \Illuminate\Database\Query\Builder|\Minhbang\Content\Content orderUpdated($direction = 'desc')
 * @method static \Illuminate\Database\Query\Builder|\Minhbang\Content\Content period($start = null, $end = null, $field = 'created_at', $end_if_day = false, $is_month = false)
 * @method static \Illuminate\Database\Query\Builder|\Minhbang\Content\Content today($field = 'created_at')
 * @method static \Illuminate\Database\Query\Builder|\Minhbang\Content\Content yesterday($same_time = false, $field = 'created_at')
 * @method static \Illuminate\Database\Query\Builder|\Minhbang\Content\Content thisWeek($field = 'created_at')
 * @method static \Illuminate\Database\Query\Builder|\Minhbang\Content\Content thisMonth($field = 'created_at')
 * @method static \Illuminate\Database\Query\Builder|\Minhbang\Content\Content notMine()
 * @method static \Illuminate\Database\Query\Builder|\Minhbang\Content\Content mine()
 * @method static \Illuminate\Database\Query\Builder|\Minhbang\Content\Content withAuthor()
 * @method static \Illuminate\Database\Query\Builder|\Minhbang\Content\Content searchWhere($column, $operator = '=', $fn = null)
 * @method static \Illuminate\Database\Query\Builder|\Minhbang\Content\Content searchWhereIn($column, $fn)
 * @method static \Illuminate\Database\Query\Builder|\Minhbang\Content\Content searchWhereBetween($column, $fn = null)
 * @method static \Illuminate\Database\Query\Builder|\Minhbang\Content\Content searchWhereInDependent($column, $column_dependent, $fn, $empty = [])
 */
class Content extends Model
{
    use AttributeQuery;
    use DatetimeQuery;
    use UserQuery;
    use SearchQuery;
    use PresentableTrait;
    protected $table = 'contents';
    protected $presenter = Presenter::class;
    protected $fillable = ['title', 'slug', 'body', 'user_id'];
    public $guarded_item;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->guarded_item = config('content.guarded_item');
    }


    /**
     * @return array các attributes có thể insert image
     */
    public function imageables()
    {
        return ['body'];
    }

    /**
     * Là trang được bảo vệ:
     * - không được xóa
     * - Không được edit slug
     *
     * @return bool
     */
    public function isGuardedItem()
    {
        return $this->exists && isset($this->guarded_item[$this->slug]);
    }

    /**
     * @param \Illuminate\Database\Query\Builder|static $query
     *
     * @return \Illuminate\Database\Query\Builder|static
     */
    public function scopeQueryDefault($query)
    {
        return $query->select("{$this->table}.*");
    }

    /**
     * Url xem Content
     *
     * @return string $content->url
     */
    public function getUrlAttribute()
    {
        return route('content.show', ['slug' => $this->slug]);
    }

    /**
     * @param string $value
     */
    public function setBodyAttribute($value)
    {
        $this->attributes['body'] = clean($value);
    }
}
