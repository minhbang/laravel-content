@extends('layouts.column2')
@section('content')
    <div class="content-show">
        <div class="meta-top">
            {{ $content->present()->updatedAt }}
        </div>
        <div class="page-header">
            <h1>{{$content->title}}</h1>
        </div>
        <div class="content">
            {!! $content->body !!}
        </div>
    </div>
@stop
