@extends('laravel-installer::layouts.master')

@section('template_title')
    {{ trans('laravel-installer::installer_messages.requirements.templateTitle') }}
@endsection

@section('title')
    <i class="fa fa-list-ul fa-fw" aria-hidden="true"></i>
    {{ trans('laravel-installer::installer_messages.requirements.title') }}
@endsection

@section('container')
    <form id="formModule" action="{{ route('laravel-installer::modules-install') }}" method="POST">
    @csrf
    <select name="modules[]" multiple size="10" style="height: 100%;">
        @foreach($modules as $module)
            <option value="{{ $module }}"> {{ $module }}</option>
        @endforeach
    </select>
    <div class="buttons">
        <a class="button" href="#" id="installModule">
            {{ trans('laravel-installer::installer_messages.requirements.next') }}
            <i class="fa fa-angle-right fa-fw" aria-hidden="true"></i>
        </a>
    </div>
    </form>
@endsection

@section('scripts')
    <script>
        var button = document.getElementById("installModule");
        button.addEventListener("click",function(e){
            document.getElementById("formModule").submit();
        },false);
    </script>
@endsection