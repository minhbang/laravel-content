@extends('backend.layouts.main')
@section('content')
    {!! Form::model($content, ['files' => true, 'url'=>$url, 'method' => $method]) !!}
    <ul class="nav nav-tabs nav-tabs-no-boder">
        @foreach($locales as $locale => $locale_title)
            <li role="presentation" class="{{$locale == $active_locale ? 'active': ''}}">
                <a href="#{{$locale}}-attributes" role="tab" data-toggle="tab">
                    <span class="text-{{LocaleManager::css($locale)}}">{{$locale_title}}</span>
                </a>
            </li>
        @endforeach
    </ul>
    <div class="ibox">
        <div class="ibox-title">
            <h5>{!! trans('content::common.main_info') !!}</h5>
        </div>
        <div class="ibox-content">
            <div class="tab-content">
                @foreach($locales as $locale => $locale_title)
                    <div role="tabpanel" class="tab-pane{{$locale == $active_locale ? ' active': ''}}"
                         id="{{$locale}}-attributes">
                        <div class="form-group{{ $errors->has("title") ? ' has-error':'' }}">
                            {!! Form::label("title", trans('content::common.title'), ['class' => "control-label text-". LocaleManager::css($locale)]) !!}
                            @if($content->isGuardedItem())
                                {!! Form::text("{$locale}[title]", $content->{"title:$locale| "}, ['class' => 'form-control']) !!}
                            @else
                                {!! Form::text("{$locale}[title]", $content->{"title:$locale| "}, ['class' => 'has-slug form-control','data-slug_target' => "#{$locale}-title-slug"]) !!}
                            @endif
                            @if($errors->has("title"))
                                <p class="help-block">{{ $errors->first("title") }}</p>
                            @endif
                        </div>
                        @if($content->isGuardedItem())
                            <div class="form-group">
                                {!! Form::label("slug", trans('content::common.slug'), ['class' => "control-label text-". LocaleManager::css($locale)]) !!}
                                <div class="form-control text-danger">{{$content->slug}}</div>
                            </div>
                        @else
                            <div class="form-group{{ $errors->has("slug") ? ' has-error':'' }}">
                                {!! Form::label("slug", trans('content::common.slug'), ['class' => "control-label text-". LocaleManager::css($locale)]) !!}
                                {!! Form::text("{$locale}[slug]", $content->{"slug:$locale| "}, ['id'=>"{$locale}-title-slug", 'class' => 'form-control']) !!}
                                @if($errors->has("slug"))
                                    <p class="help-block">{{ $errors->first("slug") }}</p>
                                @endif
                            </div>
                        @endif
                        <div class="form-group{{ $errors->has("body") ? ' has-error':'' }}">
                            {!! Form::label("body", trans('content::common.body'), ['class' => "control-label text-". LocaleManager::css($locale)]) !!}
                            {!! Form::textarea("{$locale}[body]", $content->{"body:$locale| "}, [
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
                @endforeach
            </div>
        </div>
    </div>

    <div class="ibox">
        <div class="ibox-content">
            <div class="form-group text-center">
                <button type="submit" class="btn btn-success"
                        style="margin-right: 15px;">{{ trans('common.save') }}</button>
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
