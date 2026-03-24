@extends('layouts.app')

@section('content')
<div class ="container py-5">
    <h1>Edit Profile</h1>
    @if(session('success'))
    <div class="alert- alert-success">
        {{ session('success') }}
    </div>
    @endif

    <form action="{{ route('profile.update') }}" method="POST">
        @csrf
        @method('PATCH')

        <div class="mb-3">
            <label>Name</label>
            <input type="text" name="name" class="form-control"
            value="{{ auth()->user()->name }}">
        </div>

        <div class="mb-3">
            <label>Email</label>
            <input type="email"name="email" class="form-control"
            value="{{ auth()->user()->email }}">
        </div>

        <button class="btn btn-primary">Update Profile</button>
        <div class="mb-3 text-center">
            <img
            src="{{ auth()->user()->avatar
            ? asset('storage/' . auth()->user()->avatar)
            : 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name)}}"
            width="100" height="100"
            class="rounded-circle mb-2"
            >
        </div>
    </form>
</div>
@endsection
