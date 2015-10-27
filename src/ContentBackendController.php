<?php
namespace Minhbang\LaravelContent;

use Minhbang\LaravelKit\Extensions\BackendController;
use Minhbang\LaravelKit\Traits\Controller\QuickUpdateActions;
use Request;
use Datatable;
use Session;
use Html;

class ContentBackendController extends BackendController
{
    use QuickUpdateActions;

    /**
     * ContentBackendController constructor.
     */
    public function __construct()
    {
        parent::__construct(config('content.middlewares.backend'));
    }

    /**
     * Danh sách Content theo định dạng của Datatables.
     *
     * @return \Datatable JSON
     */
    public function data()
    {
        /** @var \Minhbang\LaravelContent\Content $query */
        $query = Content::queryDefault()->withAuthor()->orderUpdated();
        if (Request::has('search_form')) {
            $query = $query
                ->searchWhereBetween('contents.created_at', 'mb_date_vn2mysql')
                ->searchWhereBetween('contents.updated_at', 'mb_date_vn2mysql');
        }
        return Datatable::query($query)
            ->addColumn(
                'index',
                function (Content $model) {
                    return $model->id;
                }
            )
            ->addColumn(
                'title',
                function (Content $model) {
                    return Html::linkQuickUpdate(
                        $model->id,
                        $model->title,
                        [
                            'attr'  => 'title',
                            'title' => trans('content::common.title'),
                            'class' => 'w-lg',
                        ]
                    );
                }
            )
            ->addColumn(
                'author',
                function ($model) {
                    return $model->author;
                }
            )
            ->addColumn(
                'actions',
                function (Content $model) {
                    return Html::tableActions(
                        'backend/content',
                        $model->id,
                        $model->title,
                        trans('content::common.content'),
                        [
                            'renderPreview' => 'modal-large',
                            'renderEdit'    => 'link',
                            'renderShow'    => 'link',
                        ]
                    );
                }
            )
            ->searchColumns('contents.title')
            ->make();
    }

    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $tableOptions = [
            'id'        => 'content-manage',
            'row_index' => true,
        ];
        $options = [
            'aoColumnDefs' => [
                ['sClass' => 'min-width text-right', 'aTargets' => [0]],
                ['sClass' => 'min-width', 'aTargets' => [-1, -2]],
            ],
        ];
        $table = Datatable::table()
            ->addColumn(
                '',
                trans('content::common.title'),
                trans('content::common.user'),
                trans('common.actions')
            )
            ->setOptions($options)
            ->setCustomValues($tableOptions);
        $this->buildHeading(
            [trans('common.manage'), trans('content::common.content')],
            'fa-newspaper-o',
            ['#' => trans('content::common.content')]
        );
        return view('content::backend.index', compact('tableOptions', 'options', 'table'));
    }

    /**
     * @return \Illuminate\View\View
     * @throws \Laracasts\Presenter\Exceptions\PresenterException
     */
    public function create()
    {
        $content = new Content();
        $url = route('backend.content.store');
        $method = 'post';
        $this->buildHeading(
            [trans('common.create'), trans('content::common.content')],
            'plus-sign',
            [
                route('backend.content.index') => trans('content::common.content'),
                '#'                            => trans('common.create'),
            ]
        );
        return view('content::backend.form',compact('content', 'url', 'method'));
    }

    /**
     * @param \Minhbang\LaravelContent\ContentRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(ContentRequest $request)
    {
        $content = new Content();
        $content->fill($request->all());
        $content->user_id = user('id');
        $content->save();
        Session::flash(
            'message',
            [
                'type'    => 'success',
                'content' => trans('common.create_object_success', ['name' => trans('content::common.content')]),
            ]
        );
        return redirect(route('backend.content.index'));
    }

    /**
     * @param \Minhbang\LaravelContent\Content $content
     * @return \Illuminate\View\View
     */
    public function show(Content $content)
    {
        $this->buildHeading(
            [trans('common.view_detail'), trans('content::common.content')],
            'list',
            [
                route('backend.content.index') => trans('content::common.content'),
                '#'                            => trans('common.view_detail'),
            ]
        );
        return view('content::backend.show', compact('content'));
    }

    /**
     * @param \Minhbang\LaravelContent\Content $content
     * @return \Illuminate\View\View
     */
    public function preview(Content $content)
    {
        return view('content::backend.preview', compact('content'));
    }

    /**
     * @param \Minhbang\LaravelContent\Content $content
     * @return \Illuminate\View\View
     */
    public function edit(Content $content)
    {
        $url = route('backend.content.update', ['content' => $content->id]);
        $method = 'put';
        $this->buildHeading(
            [trans('common.update'), trans('content::common.content')],
            'edit',
            [
                route('backend.content.index') => trans('content::common.content'),
                '#'                            => trans('common.edit'),
            ]
        );
        return view('content::backend.form',compact('content', 'url', 'method'));
    }

    /**
     * @param \Minhbang\LaravelContent\ContentRequest $request
     * @param \Minhbang\LaravelContent\Content $content
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(ContentRequest $request, Content $content)
    {
        $content->fill($request->all());
        $content->save();
        Session::flash(
            'message',
            [
                'type'    => 'success',
                'content' => trans('common.update_object_success', ['name' => trans('content::common.content')]),
            ]
        );
        return redirect(route('backend.content.index'));
    }

    /**
     * @param \Minhbang\LaravelContent\Content $content
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(Content $content)
    {
        $content->delete();
        return response()->json(
            [
                'type'    => 'success',
                'content' => trans('common.delete_object_success', ['name' => trans('content::common.content')]),
            ]
        );
    }

    /**
     * Các attributes cho phép quick-update
     *
     * @return array
     */
    protected function quickUpdateAttributes()
    {
        return [
            'title' => [
                'rules' => 'required|max:255',
                'label' => trans('content::common.title')
            ],
        ];
    }
}
