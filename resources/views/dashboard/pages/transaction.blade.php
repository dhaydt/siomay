@extends('dashboard.layouts.app')

@section('content')

@livewire('dashboard.transaction-data',['title' => $title])

@endsection
