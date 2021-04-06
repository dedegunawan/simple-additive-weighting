@extends('adminlte::page')

@section('title', 'User Management')

@section('content_header')
    <h3>Mahasiswa</h3>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            @livewire('mahasiswa-component')
        </div>
    </div>
@stop
