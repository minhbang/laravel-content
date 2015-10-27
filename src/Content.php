<?php
namespace Minhbang\LaravelContent;

use Laracasts\Presenter\PresentableTrait;
use Minhbang\LaravelImage\ImageableModel as Model;
use Minhbang\LaravelKit\Traits\Model\AttributeQuery;
use Minhbang\LaravelKit\Traits\Model\DatetimeQuery;
use Minhbang\LaravelKit\Traits\Model\SearchQuery;
use Minhbang\LaravelUser\Support\UserQuery;

/**
 * Class Content
 *
 * @package Minhbang\LaravelContent
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
 * @property-read \Minhbang\LaravelUser\User $user
 * @method static \Illuminate\Database\Query\Builder|\Minhbang\LaravelContent\Content whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Minhbang\LaravelContent\Content whereTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\Minhbang\LaravelContent\Content whereSlug($value)
 * @method static \Illuminate\Database\Query\Builder|\Minhbang\LaravelContent\Content whereContent($value)
 * @method static \Illuminate\Database\Query\Builder|\Minhbang\LaravelContent\Content whereHit($value)
 * @method static \Illuminate\Database\Query\Builder|\Minhbang\LaravelContent\Content whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\Minhbang\LaravelContent\Content whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Minhbang\LaravelContent\Content whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Minhbang\LaravelContent\Content queryDefault()
 * @method static \Illuminate\Database\Query\Builder|\Minhbang\LaravelKit\Extensions\Model except($id = null)
 * @method static \Illuminate\Database\Query\Builder|\Minhbang\LaravelContent\Content hasStr($str, $attribute = 'content', $boolean = 'and')
 * @method static \Illuminate\Database\Query\Builder|\Minhbang\LaravelContent\Content exclusion($value, $attribute = 'id', $boolean = 'and')
 * @method static \Illuminate\Database\Query\Builder|\Minhbang\LaravelContent\Content orderCreated($direction = 'desc')
 * @method static \Illuminate\Database\Query\Builder|\Minhbang\LaravelContent\Content orderUpdated($direction = 'desc')
 * @method static \Illuminate\Database\Query\Builder|\Minhbang\LaravelContent\Content period($start = null, $end = null, $field = 'created_at', $end_if_day = false, $is_month = false)
 * @method static \Illuminate\Database\Query\Builder|\Minhbang\LaravelContent\Content today($field = 'created_at')
 * @method static \Illuminate\Database\Query\Builder|\Minhbang\LaravelContent\Content yesterday($same_time = false, $field = 'created_at')
 * @method static \Illuminate\Database\Query\Builder|\Minhbang\LaravelContent\Content thisWeek($field = 'created_at')
 * @method static \Illuminate\Database\Query\Builder|\Minhbang\LaravelContent\Content thisMonth($field = 'created_at')
 * @method static \Illuminate\Database\Query\Builder|\Minhbang\LaravelContent\Content notMine()
 * @method static \Illuminate\Database\Query\Builder|\Minhbang\LaravelContent\Content mine()
 * @method static \Illuminate\Database\Query\Builder|\Minhbang\LaravelContent\Content withAuthor()
 * @method static \Illuminate\Database\Query\Builder|\Minhbang\LaravelContent\Content searchWhere($column, $operator = '=', $fn = null)
 * @method static \Illuminate\Database\Query\Builder|\Minhbang\LaravelContent\Content searchWhereIn($column, $fn)
 * @method static \Illuminate\Database\Query\Builder|\Minhbang\LaravelContent\Content searchWhereBetween($column, $fn = null)
 * @method static \Illuminate\Database\Query\Builder|\Minhbang\LaravelContent\Content searchWhereInDependent($column, $column_dependent, $fn, $empty = array())
 */
class Content extends Model
{
    use AttributeQuery;
    use DatetimeQuery;
    use UserQuery;
    use SearchQuery;
    use PresentableTrait;
    protected $table = 'contents';
    protected $presenter = 'Minhbang\LaravelContent\ContentPresenter';
    protected $fillable = ['title', 'slug', 'body'];

    /**
     * @return array các attributes có thể insert image
     */
    public function imageables()
    {
        return ['body'];
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
