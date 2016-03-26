<?php
namespace Minhbang\Content;

use Laracasts\Presenter\PresentableTrait;
use Minhbang\Image\ImageableModel as Model;
use Minhbang\Kit\Traits\Model\AttributeQuery;
use Minhbang\Kit\Traits\Model\DatetimeQuery;
use Minhbang\Kit\Traits\Model\SearchQuery;
use Minhbang\Locale\Translatable;
use Minhbang\User\Support\UserQuery;
use LocaleManager;

/**
 * Class Content
 *
 * @package Minhbang\Content
 * @property integer $id
 * @property integer $hit
 * @property integer $user_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read mixed $url
 * @property string $title
 * @property string $slug
 * @property string $body
 * @property mixed $linked_image_ids
 * @property-read mixed $linked_image_ids_original
 * @property-read \Illuminate\Database\Eloquent\Collection|\Minhbang\Image\ImageModel[] $images
 * @property-read \Minhbang\User\User $user
 * @property-read \Illuminate\Database\Eloquent\Collection|\Minhbang\Content\ContentTranslation[] $translations
 * @method static \Illuminate\Database\Query\Builder|\Minhbang\Content\Content whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Minhbang\Content\Content whereHit($value)
 * @method static \Illuminate\Database\Query\Builder|\Minhbang\Content\Content whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\Minhbang\Content\Content whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Minhbang\Content\Content whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Minhbang\Content\Content queryDefault()
 * @method static \Illuminate\Database\Query\Builder|\Minhbang\Content\Content slug($slug, $locale = null)
 * @method static \Illuminate\Database\Query\Builder|\Minhbang\Kit\Extensions\Model except($id = null)
 * @method static \Illuminate\Database\Query\Builder|\Minhbang\Kit\Extensions\Model whereAttributes($attributes)
 * @method static \Illuminate\Database\Query\Builder|\Minhbang\Kit\Extensions\Model findText($column, $text)
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
 * @method static \Illuminate\Database\Query\Builder|\Minhbang\Content\Content searchKeyword($keyword, $columns = null)
 * @method static \Illuminate\Database\Query\Builder|\Minhbang\Content\Content searchWhere($column, $operator = '=', $fn = null)
 * @method static \Illuminate\Database\Query\Builder|\Minhbang\Content\Content searchWhereIn($column, $fn)
 * @method static \Illuminate\Database\Query\Builder|\Minhbang\Content\Content searchWhereBetween($column, $fn = null)
 * @method static \Illuminate\Database\Query\Builder|\Minhbang\Content\Content searchWhereInDependent($column, $column_dependent, $fn, $empty = [])
 * @mixin \Eloquent
 */
class Content extends Model
{
    use AttributeQuery;
    use DatetimeQuery;
    use UserQuery;
    use SearchQuery;
    use PresentableTrait;
    use Translatable;

    protected $table = 'contents';
    protected $presenter = Presenter::class;
    protected $fillable = ['title', 'slug', 'body', 'user_id'];
    protected $translatable = ['title', 'slug', 'body'];
    public $guarded_item;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->guarded_item = (array)config('content.guarded_item', []);
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

    /**
     * @param \Illuminate\Database\Query\Builder|static $query
     * @param string $slug
     * @param string $locale
     *
     * @return \Illuminate\Database\Query\Builder|static
     */
    public function scopeSlug($query, $slug, $locale = null)
    {
        return $this->scopeWhereTranslation($query, 'slug', $slug, $locale);
    }

    /**
     * @param string $slug
     * @param string $locale
     *
     * @return null|static
     */
    public static function findBySlug($slug, $locale = null)
    {
        return static::slug($slug, $locale)->first();
    }

    /**
     * @param string $slug
     *
     * @return null|static
     */
    public static function findByFallbackSlug($slug)
    {

        return static::slug($slug, LocaleManager::getFallback())->first();
    }

    /**
     * Tạo mới nếu chưa có Guarded Items (chỉ tạo cho fallback locale)
     */
    public static function checkGuardedItems()
    {
        foreach (app()->make(static::class)->guarded_item as $slug => $title) {
            if (!Content::slug($slug, LocaleManager::getFallback())->count()) {
                Content::create([
                    LocaleManager::getFallback() => [
                        'title' => $title,
                        'slug'  => $slug,
                        'body'  => "Body of $title",
                    ],
                    'user_id'                    => user('id'),
                ]);
            }
        }
    }
}
