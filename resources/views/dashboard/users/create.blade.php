@extends('dashboard.layouts.app')
@section('title', 'Create new user')
@section('content')
<section class="section">
    <div class="container">
        @include ('layouts.errors')
        @include ('layouts.status')
        <form action="{{ route('user.store') }}" method="POST" class="form">
            @csrf

            <div class="field">
                <label class="label">Name</label>
                <div class="control">
                    <input name="name" class="input" type="text" required>
                </div>
            </div>

            <div class="field">
                <label class="label">Username</label>
                <div class="control">
                    <input name="username" class="input" type="text" required>
                </div>
            </div>

            <div class="field">
                <label class="label">Email</label>
                <div class="control">
                    <input name="email" class="input" type="text">
                </div>
            </div>

            <div class="field">
                <label class="label">Password</label>
                <div class="control">
                    <input name="password" class="input" type="password">
                </div>
            </div>

            <div class="field">
                <label class="label">Role</label>
                <div class="control is-expanded">
                    <div class="select is-fullwidth">
                        <select name="role">
                            <option value="">No role</option>
                            @foreach ($roles as $role)
                            <option value="{{ $role->id }}">{{ ucfirst($role->name) }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="field is-grouped">
                <div class="control">
                    <button class="button is-primary">Create</button>
                </div>
                <div class="control">
                <a class="button is-text" href="{{ route('user.index') }}">Cancel</a>
                </div>
            </div>
        </form>
    </div>
</section>
@endsection
