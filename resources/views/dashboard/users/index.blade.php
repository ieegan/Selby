@extends('dashboard.layouts.app')
@section('title','Users')
@section('content')
<section class="section">
    <div class="container">
        @include ('layouts.errors')
        @include ('layouts.status')
        <div class="table-container">
            <table class="table is-fullwidth is-striped">
                <thead>
                    <tr>
                        <th><abbr>ID</abbr></th>
                        <th><abbr>Name</abbr></th>
                        <th><abbr>Username</abbr></th>
                        <th><abbr>Email</abbr></th>
                        <th><abbr>Role</abbr></th>
                        <th><abbr>Action</abbr></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                    <tr>
                        <th>{{ $user->id }}</th>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->username }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ implode(', ', $user->getRoleNames()->toArray()) }}</td>
                        <td><a class="is-primary" href="{{ route('user.edit', $user->id) }}">Manage</a></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</section>
@endsection
