<?php
namespace Minhbang\LaravelContent;

use Minhbang\LaravelKit\Extensions\Controller;

class ContentFrontendController extends Controller
{
    public function __construct()
    {
        parent::__construct(config('content.middlewares.frontend'));
    }

    /**
     * @param string $slug
     * @return \Illuminate\View\View
     */
    public function show($slug)
    {
        if (is_null($content = Content::findBy('slug', $slug))) {
            abort(404, trans('content::common.not_found'));
        }

        return view('content::frontend.show', compact('content'));
    }

}
