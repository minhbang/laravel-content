@extends('layouts.column2')
@section('content')
    <div class="content-show">
        <div class="page-header">
            <h1 class="main-heading">{{$content->title}}</h1>
            <div class="meta-top">
                {{ $content->present()->updatedAt }}
            </div>
        </div>
        <div class="content">
            {!! $content->body !!}
        </div>
    </div>
@stop
