@extends('dashboard.layouts.app')

@section('content')
@livewire('dashboard.kasir-data', ['title' => $title])
@endsection
