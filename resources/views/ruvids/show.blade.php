@extends('layouts.app')

@section('title', __('ruvid.detail'))

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">{{ __('ruvid.detail') }}</div>
            <div class="card-body">
                <table class="table table-sm">
                    <tbody>
                        <tr><td>Name</td><td>{{ $ruvid->name }}</td></tr>
                        <tr><td>Alamat</td><td>{{ $ruvid->address }}</td></tr>
                        <tr><td>Latitude</td><td>{{ $ruvid->latitude }}</td></tr>
                        <tr><td>Longitude</td><td>{{ $ruvid->longitude }}</td></tr>
                        <tr><td>Url</td><td>{{ $ruvid->link }}</td></tr>
                        <tr><td>Phone</td><td>{{ $ruvid->phone }}</td></tr>
                        <tr><td>RITNDV</td><td>{{ $ruvid->RITNDV }}</td></tr>
                        <tr><td>RITNTV</td><td>{{ $ruvid->RITNTV }}</td></tr>
                        <tr><td>RINFTV</td><td>{{ $ruvid->RINFTV }}</td></tr>
                        <tr><td>KOC</td><td>{{ $ruvid->KOC }}</td></tr>
                        <tr><td>IGDC</td><td>{{ $ruvid->IGDC }}</td></tr>
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                @can('update', $ruvid)
                    <a href="{{ route('ruvids.edit', $ruvid) }}" id="edit-ruvid-{{ $ruvid->id }}" class="btn btn-warning">{{ __('ruvid.edit') }}</a>
                @endcan
                <a href="{{ route('ruvids.index') }}" class="btn btn-link">{{ __('ruvid.back_to_index') }}</a>
            </div>
        </div>
    </div>
</div>
@endsection
