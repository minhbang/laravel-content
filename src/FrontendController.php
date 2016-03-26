<?php
namespace Minhbang\Content;

use Minhbang\Kit\Extensions\Controller;

/**
 * Class FrontendController
 *
 * @package Minhbang\Content
 */
class FrontendController extends Controller
{
    /**
     * @param string $slug
     * @return \Illuminate\View\View
     */
    public function show($slug)
    {
        if (is_null($content = Content::findByFallbackSlug($slug))) {
            abort(404, trans('content::common.not_found'));
        }
        return view('content::frontend.show', compact('content'));
    }

}
