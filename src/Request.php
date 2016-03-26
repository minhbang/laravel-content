<?php
namespace Minhbang\Content;

use Minhbang\Locale\TranslatableRequest;

/**
 * Class Request
 *
 * @package Minhbang\Content
 */
class Request extends TranslatableRequest
{
    public $trans_prefix = 'content::common';
    public $rules = [
        'title' => 'required|max:255',
        'slug'  => 'max:255|alpha_dash',
        'body'  => 'required',
    ];
    public $translatable = ['title', 'slug', 'body'];

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        /** @var \Minhbang\Content\Content $content */
        if ($content = $this->route('content')) {
            //update Content
            if (!$content->isGuardedItem()) {
                $this->rules['slug'] .= '|required';
            }
        } else {
            // create Content
        }

        return $this->rules;
    }

}
