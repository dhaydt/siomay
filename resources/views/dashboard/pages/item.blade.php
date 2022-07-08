@extends('dashboard.layouts.app')

@section('content')

@livewire('dashboard.item-data',['title' => $title])

@endsection
