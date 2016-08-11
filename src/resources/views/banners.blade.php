@extends('admin::layouts.default')

@section('title')
    {{__cms($title)}}
@stop

@section('ribbon')
    <ol class="breadcrumb">
        <li><a href="/admin">{{__cms("Главная")}}</a></li>
        <li><a>{{__cms($title)}}</a></li>
    </ol>
@stop

@section('main')

    @include("banners::part.banners_banner_center")

@stop