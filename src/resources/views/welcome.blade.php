@extends('laravel-installer::layouts.master')

@section('template_title')
    {{ trans('laravel-installer::installer_messages.welcome.templateTitle') }}
@endsection

@section('title')
    {{ trans('laravel-installer::installer_messages.welcome.title') }}
@endsection

@section('container')
    <p class="text-center">
      {{ trans('laravel-installer::installer_messages.welcome.message') }}
    </p>
    <p class="text-center">
      <a href="{{ route('laravel-installer::requirements') }}" class="button">
        {{ trans('laravel-installer::installer_messages.welcome.next') }}
        <i class="fa fa-angle-right fa-fw" aria-hidden="true"></i>
      </a>
    </p>
@endsection