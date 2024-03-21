@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container-fluid">
    <div class="py-4">
        @include('dashboard.partials.metrics')
        @include('dashboard.partials.job_posts')
    </div>
</div>
@endsection
