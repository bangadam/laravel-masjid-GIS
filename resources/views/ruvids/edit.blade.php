@extends('layouts.app')

@section('title', __('ruvid.edit'))

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        @if (request('action') == 'delete' && $ruvid)
        @can('delete', $ruvid)
            <div class="card">
                <div class="card-header">{{ __('ruvid.delete') }}</div>
                <div class="card-body">
                    <label class="form-label text-primary">{{ __('ruvid.title') }}</label>
                    <p>{{ $ruvid->title }}</p>
                    <label class="form-label text-primary">{{ __('ruvid.description') }}</label>
                    <p>{{ $ruvid->address }}</p>
                    {!! $errors->first('ruvid_id', '<span class="invalid-feedback" role="alert">:message</span>') !!}
                </div>
                <hr style="margin:0">
                <div class="card-body text-danger">{{ __('ruvid.delete_confirm') }}</div>
                <div class="card-footer">
                    <form method="POST" action="{{ route('ruvids.destroy', $ruvid) }}" accept-charset="UTF-8" onsubmit="return confirm(&quot;{{ __('app.delete_confirm') }}&quot;)" class="del-form float-right" style="display: inline;">
                        {{ csrf_field() }} {{ method_field('delete') }}
                        <input name="ruvid_id" type="hidden" value="{{ $ruvid->id }}">
                        <button type="submit" class="btn btn-danger">{{ __('app.delete_confirm_button') }}</button>
                    </form>
                    <a href="{{ route('ruvids.edit', $ruvid) }}" class="btn btn-link">{{ __('app.cancel') }}</a>
                </div>
            </div>
        @endcan
        @else
        <div class="card">
            <div class="card-header">{{ __('ruvid.edit') }}</div>
            <form method="POST" action="{{ route('ruvids.update', $ruvid) }}" accept-charset="UTF-8">
                {{ csrf_field() }} {{ method_field('patch') }}
                <div class="card-body">
                    <div class="form-group">
                        <label for="title" class="form-label">{{ __('ruvid.title') }} <span class="form-required">*</span></label>
                        <input id="title" type="text" class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}" name="title" value="{{ old('title', $ruvid->title) }}" required>
                        {!! $errors->first('title', '<span class="invalid-feedback" role="alert">:message</span>') !!}
                    </div>
                    <div class="form-group">
                        <label for="description" class="form-label">{{ __('ruvid.description') }}</label>
                        <textarea id="description" class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}" name="description" rows="4">{{ old('description', $ruvid->description) }}</textarea>
                        {!! $errors->first('description', '<span class="invalid-feedback" role="alert">:message</span>') !!}
                    </div>
                </div>
                <div class="card-footer">
                    <input type="submit" value="{{ __('ruvid.update') }}" class="btn btn-success">
                    <a href="{{ route('ruvids.show', $ruvid) }}" class="btn btn-link">{{ __('app.cancel') }}</a>
                    @can('delete', $ruvid)
                        <a href="{{ route('ruvids.edit', [$ruvid, 'action' => 'delete']) }}" id="del-ruvid-{{ $ruvid->id }}" class="btn btn-danger float-right">{{ __('app.delete') }}</a>
                    @endcan
                </div>
            </form>
        </div>
    </div>
</div>
@endif
@endsection
