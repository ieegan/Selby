@extends('layouts.app')
@section('title','Sign in')
@section('content')
<div class="facade">
    <section class="section">
        <div class="container">
            <div class="columns">
                <div class="column is-6 is-offset-3">
                    <h1 class="title">Sign in</h1>
                    <div class="box">
                        <form method="POST" action="{{ route('login') }}">
                            {{ csrf_field() }}
                            <div class="field">
                                <label class="label">Username</label>
                                <p class="control has-icons-left has-icons-right">
                                    <input id="username" type="username"
                                        class="input{{ $errors->has('username') ? ' is-danger' : '' }}" name="username"
                                        value="{{ old('username') }}" placeholder="hello@example.com" required autofocus>
                                    <span class="icon is-small is-left">
                                        <i class="fa fa-envelope"></i>
                                    </span>
                                    @if ($errors->has('username'))
                                    <span class="icon is-small is-right">
                                        <i class="fa fa-warning"></i>
                                    </span>
                                    @endif
                                </p>
                                @if ($errors->has('username'))
                                <p class="help is-danger">{{ $errors->first('username') }}</p>
                                @endif
                            </div>
                            <div class="field">
                                <label class="label">Password</label>
                                <p class="control has-icons-left">
                                    <input id="password" type="password"
                                        class="input{{ $errors->has('password') ? ' is-danger' : '' }}" name="password"
                                        placeholder="Password" required>
                                    <span class="icon is-small is-left">
                                        <i class="fa fa-lock"></i>
                                    </span>
                                </p>
                                @if ($errors->has('password'))
                                <p class="help is-danger">{{ $errors->first('password') }}</p>
                                @endif
                            </div>
                            <div class="field">
                                <label class="checkbox">
                                    <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                                    Remember me
                                </label>
                            </div>
                            <div class="field is-grouped is-grouped-multiline">
                                <div class="control">
                                    <button type="submit" class="button is-primary">Sign in</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
