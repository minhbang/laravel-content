@extends('backend.layouts.main')
@section('content')
    {!! Form::model($content, ['files' => true, 'url'=>$url, 'method' => $method]) !!}
    <div class="ibox">
        <div class="ibox-title">
            <h5>{!! trans('content::common.main_info') !!}</h5>
            <div class="ibox-tools">
                <a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
            </div>
        </div>
        <div class="ibox-content">
            <div class="form-group{{ $errors->has("title") ? ' has-error':'' }}">
                {!! Form::label("title", trans('content::common.title'), ['class' => "control-label"]) !!}
                @if($content->isGuardedItem())
                    {!! Form::text("title", $content->title, ['class' => 'form-control']) !!}
                @else
                    {!! Form::text("title", $content->title, ['class' => 'has-slug form-control','data-slug_target' => "#title-slug"]) !!}
                @endif
                @if($errors->has("title"))
                    <p class="help-block">{{ $errors->first("title") }}</p>
                @endif
            </div>
            @if($content->isGuardedItem())
                <div class="form-group">
                    {!! Form::label("slug", trans('content::common.slug'), ['class' => "control-label"]) !!}
                    <div class="form-control text-danger">{{$content->slug}}</div>
                </div>
            @else
                <div class="form-group{{ $errors->has("slug") ? ' has-error':'' }}">
                    {!! Form::label("slug", trans('content::common.slug'), ['class' => "control-label"]) !!}
                    {!! Form::text("slug", $content->slug, ['id'=>"title-slug", 'class' => 'form-control']) !!}
                    @if($errors->has("slug"))
                        <p class="help-block">{{ $errors->first("slug") }}</p>
                    @endif
                </div>
            @endif
            <div class="form-group{{ $errors->has("body") ? ' has-error':'' }}">
                {!! Form::label("body", trans('content::common.body'), ['class' => "control-label"]) !!}
                {!! Form::textarea("body", $content->body, [
                    'class' => 'form-control wysiwyg',
                    'data-editor' => 'full',
                    'data-height' => 500,
                    'data-attribute' => 'body',
                    'data-resource' => 'content',
                    'data-id' => $content->id
                ]) !!}
                @if($errors->has("body"))
                    <p class="help-block">{{ $errors->first("body") }}</p>
                @endif
            </div>
        </div>
    </div>

    <div class="ibox">
        <div class="ibox-content">
            <div class="form-group text-center">
                <button type="submit" class="btn btn-success" style="margin-right: 15px;">{{ trans('common.save') }}</button>
                <a href="{{ route('backend.content.index') }}" class="btn btn-white">{{ trans('common.cancel') }}</a>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
@stop

@section('script')
    <script type="text/javascript">
        $(document).ready(function () {
            $('.wysiwyg').mbEditor({
                //upload image
                imageUploadURL: '{!! route('image.store') !!}',
                imageMaxSize: {{setting('system.max_image_size') * 1024 * 1024 }}, //bytes
                // load image
                imageManagerLoadURL: '{!! route('image.data') !!}',
                // custom options
                imageDeleteURL: '{!! route('image.delete') !!}'
            });
        });
    </script>
@stop
