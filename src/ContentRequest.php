<?php
namespace Minhbang\LaravelContent;

use Minhbang\LaravelKit\Extensions\Request;

/**
 * Class ContentRequest
 *
 * @package Minhbang\LaravelContent
 */
class ContentRequest extends Request
{
    public $trans_prefix = 'content::common';
    public $rules = [
        'title'       => 'required|max:255',
        'slug'        => 'max:255|alpha_dash|unique:contents',
        'body'        => 'required',
    ];

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        /** @var \Minhbang\LaravelContent\Content $content */
        if ($content = $this->route('content')) {
            // update
            $this->rules['slug'] .= ',slug,' . $content->id;
            if(!$content->isGuardedItem()){
                $this->rules['slug'] .= '|required';
            }
        } else {
            // create
            $this->rules['slug'] .= '|required';
        }
        return $this->rules;
    }

}
