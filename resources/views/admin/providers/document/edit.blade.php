@extends('admin.layout.base')

@section('title', 'Provider Documents ')

@section('content')
<div class="card">
    <div class="card-body">
        
        <div >
            <h5 class="mb-1">@lang('admin.provides.provider_name'): {{ $Document->provider->first_name }} {{ $Document->provider->last_name }}</h5>
            <h5 class="mb-1">Document: {{ $Document->document->name }}</h5>
            <h5 class="mb-1">Expires: {{ $Document->expires_at }}</h5>
            <center><embed src="{{ $Document->url }}"  /></center>

            <div class="row">
                <div class="col-md-6">
                    <form action="{{ route('admin.provider.document.update', [$Document->provider->id, $Document->id]) }}" method="POST">
                        {{ csrf_field() }}
                        {{ method_field('PATCH') }}
                        <button class="btn btn-block btn-primary" type="submit">@lang('admin.provides.approve')</button>
                    </form>
                </div>

                <div class="col-md-6">
                    <form action="{{ route('admin.provider.document.destroy', [$Document->provider->id, $Document->id]) }}" method="POST">
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}
                        <button class="btn btn-block btn-danger" type="submit">@lang('admin.provides.delete')</button>
                    </form>
                </div>
            </div>
        </div>
        
    </div>
</div>
@endsection