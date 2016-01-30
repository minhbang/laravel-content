<?php
namespace Minhbang\Content;

use Html;
use Laracasts\Presenter\Presenter as BasePresenter;
use Minhbang\Kit\Traits\Presenter\DatetimePresenter;

class Presenter extends BasePresenter
{
    use DatetimePresenter;

    /**
     * Link xem content
     *
     * @return string
     */
    public function link()
    {
        return Html::link($this->entity->url, $this->entity->title);
    }

    /**
     * Link xem content
     *
     * @param array $timeFormat
     * @return string
     */
    public function linkWithTime($timeFormat = [])
    {
        return "<a href=\"{$this->entity->url}\">{$this->entity->title} <span class=\"time\">{$this->updatedAt($timeFormat)}</span></a>";
    }

    /**
     * Thông tin metadata của content
     *
     * @param bool $author
     * @return string
     */
    public function metadata($author = true)
    {
        $metadata = $author ? "<strong>{$this->entity->author}</strong><br>" : '';
        $metadata .= trans(
            'content.metadata',
            [
                'datetime' => $this->updatedAt(),
                'hit'      => $this->entity->hit,
            ]
        );
        return $metadata;
    }

    /**
     * Thông tin metadata của content
     *
     * @param bool $author
     * @return string
     */
    public function metadataBlock($author = true)
    {
        return '<div class="metadata" data-id="' . $this->entity->id . '">' . $this->metadata($author) . '</div>';
    }
}
