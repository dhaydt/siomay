@extends('dashboard.layouts.app')

@section('content')

@livewire('dashboard.stock-data',['title' => $title])

@endsection
