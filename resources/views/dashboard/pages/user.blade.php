@extends('dashboard.layouts.app')

@section('content')

@livewire('dashboard.user-data',['title' => $title])

@endsection
