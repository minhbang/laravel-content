@extends('backend.layouts.main')
@section('content')
    <div class="row">
        <div class="col-lg-4">
            <table class="table table-hover table-striped table-bordered table-detail">
                <tr>
                    <td>ID</td>
                    <td><strong>{{ $content->id}}</strong></td>
                </tr>
                <tr>
                    <td>{{ trans('content::common.user') }}</td>
                    <td><strong>{{ $content->user->username }}</strong></td>
                </tr>
                <tr>
                    <td>{{ trans('common.created_at') }}</td>
                    <td>{!! $content->present()->createdAt !!}</td>
                </tr>
                <tr>
                    <td>{{ trans('common.updated_at') }}</td>
                    <td>{!! $content->present()->updatedAt !!}</td>
                </tr>
            </table>
        </div>
        <div class="col-lg-8">
            <ul class="nav nav-tabs nav-tabs-no-boder">
                @foreach($locales as $locale => $lang)
                    <li role="presentation" class="{{$locale == $active_locale ? 'active': ''}}">
                        <a href="#{{$locale}}-attributes" role="tab" data-toggle="tab">
                            <span class="text-{{LocaleManager::css($locale)}}">{{$lang}}</span>
                        </a>
                    </li>
                @endforeach
            </ul>
            <div class="tab-content">
                @foreach($locales as $locale => $lang)
                    <div role="tabpanel" class="tab-pane{{$locale == $active_locale ? ' active': ''}}"
                         id="{{$locale}}-attributes">
                        <table class="table table-hover table-striped table-bordered table-detail">
                            <tr>
                                <td>{{ trans('content::common.title') }}</td>
                                <td class="text-{{LocaleManager::css($locale)}}"><strong>{{ $content->{"title:$locale| "} }}</strong></td>
                            </tr>
                            <tr>
                                <td>{{ trans('content::common.slug') }}</td>
                                <td class="text-{{LocaleManager::css($locale)}}"><strong>{{ $content->{"slug:$locale| "} }}</strong></td>
                            </tr>
                            <tr>
                                <td>{{ trans('content::common.body') }}</td>
                                <td class="text-{{LocaleManager::css($locale)}}">{!! $content->{"body:$locale| "} !!}</td>
                            </tr>
                        </table>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@stop
