@extends('backend.layouts.main')
@section('content')
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
    <tr>
        <td>{{ trans('content::common.title') }}</td>
        <td><strong>{{ $content->title }}</strong></td>
    </tr>
    <tr>
        <td>{{ trans('content::common.slug') }}</td>
        <td><strong>{{ $content->slug }}</strong></td>
    </tr>
    <tr>
        <td>{{ trans('content::common.body') }}</td>
        <td>{!! $content->body !!}</td>
    </tr>
</table>
@stop
