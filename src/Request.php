<?php
namespace Minhbang\Content;

use Minhbang\Kit\Extensions\Request as BaseRequest;


class Request extends BaseRequest
{
    public $trans_prefix = 'content::common';
    public $rules = [
        'title'       => 'required|max:255',
        'slug'        => 'max:255|alpha_dash|unique:contents',
        'body'        => 'required',
    ];

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        /** @var \Minhbang\Content\Content $content */
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
