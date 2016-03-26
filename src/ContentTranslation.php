<?php
namespace Minhbang\Content;

use Eloquent;

/**
 * Class CategoryTranslation
 *
 * @package Minhbang\Content
 * @property integer $id
 * @property string $title
 * @property string $slug
 * @property string $body
 * @property integer $content_id
 * @property string $locale
 * @method static \Illuminate\Database\Query\Builder|\Minhbang\Content\ContentTranslation whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Minhbang\Content\ContentTranslation whereTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\Minhbang\Content\ContentTranslation whereSlug($value)
 * @method static \Illuminate\Database\Query\Builder|\Minhbang\Content\ContentTranslation whereBody($value)
 * @method static \Illuminate\Database\Query\Builder|\Minhbang\Content\ContentTranslation whereContentId($value)
 * @method static \Illuminate\Database\Query\Builder|\Minhbang\Content\ContentTranslation whereLocale($value)
 * @mixin \Eloquent
 */
class ContentTranslation extends Eloquent
{
    public $timestamps = false;
    protected $table = 'content_translations';
    protected $fillable = ['title', 'slug', 'body'];
}
