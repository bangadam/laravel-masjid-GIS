@extends('layouts.app')

@section('title', __('ruvid.list'))

@section('content')
<div class="mb-3">
    <div class="float-right">
        @can('create', new App\Models\Ruvid)
            <a href="{{ route('ruvids.create') }}" class="btn btn-success">{{ __('ruvid.create') }}</a>
        @endcan
    </div>
    <h1 class="page-title">{{ __('ruvid.list') }} <small>{{ __('app.total') }} : {{ $ruvids->total() }} {{ __('ruvid.ruvid') }}</small></h1>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <form method="GET" action="" accept-charset="UTF-8" class="form-inline">
                    <div class="form-group">
                        <label for="q" class="form-label">{{ __('ruvid.search') }}</label>
                        <input placeholder="{{ __('ruvid.search_text') }}" name="q" type="text" id="q" class="form-control mx-sm-2" value="{{ request('q') }}">
                    </div>
                    <input type="submit" value="{{ __('ruvid.search') }}" class="btn btn-secondary">
                    <a href="{{ route('ruvids.index') }}" class="btn btn-link">{{ __('app.reset') }}</a>
                </form>
            </div>
            <table class="table table-sm table-responsive-sm table-hover">
                <thead>
                    <tr>
                        <th class="text-center">{{ __('app.table_no') }}</th>
                        <th>Nama</th>
                        <th>Alamat</th>
                        <th class="text-center">{{ __('app.action') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($ruvids as $key => $ruvid)
                    <tr>
                        <td class="text-center">{{ $ruvids->firstItem() + $key }}</td>
                        <td>{!! $ruvid->title_link !!}</td>
                        <td>{{ $ruvid->address }}</td>
                        <td class="text-center">
                            @can('view', $ruvid)
                                <a href="{{ route('ruvids.show', $ruvid) }}" id="show-ruvid-{{ $ruvid->id }}">{{ __('app.show') }}</a>
                            @endcan
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="card-body">{{ $ruvids->appends(Request::except('page'))->render() }}</div>
        </div>
    </div>
</div>
@endsection
