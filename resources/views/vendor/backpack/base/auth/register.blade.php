@extends(backpack_view('layouts.plain'))

@section('content')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />

    <div class="row justify-content-center">
        <div class="col-12 col-md-8 col-lg-4">
            <h3 class="text-center mb-4">{{ trans('backpack::base.register') }}</h3>
            <div class="card">
                <div class="card-body">
                    <form class="col-md-12 p-t-10" role="form" method="POST" action="{{ route('backpack.auth.register') }}">
                        {!! csrf_field() !!}

                        <div class="form-group">
                            <label class="control-label" for="name">{{ trans('backpack::base.name') }}</label>

                            <div>
                                <input type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" id="name" value="{{ old('name') }}">

                                @if ($errors->has('name'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label" for="{{ backpack_authentication_column() }}">{{ config('backpack.base.authentication_column_name') }}</label>

                            <div>
                                <input type="{{ backpack_authentication_column()=='email'?'email':'text'}}" class="form-control{{ $errors->has(backpack_authentication_column()) ? ' is-invalid' : '' }}" name="{{ backpack_authentication_column() }}" id="{{ backpack_authentication_column() }}" value="{{ old(backpack_authentication_column()) }}">

                                @if ($errors->has(backpack_authentication_column()))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first(backpack_authentication_column()) }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label" for="team_confirmation">Team</label>

                            <div>
                                <select name="teams[]"  multiple="multiple" class="select2 form-control{{ $errors->has('team_confirmation') ? ' is-invalid' : '' }}">
                                    @foreach ($teams as $team)
                                        <option value={{ $team->id }}>{{  $team->name  }}</option>
                                    @endforeach       
                                </select>

                                @if ($errors->has('team_confirmation'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('team_confirmation') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>


                        <div class="form-group">
                            <label class="control-label" for="password">{{ trans('backpack::base.password') }}</label>

                            <div>
                                <input type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" id="password">

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label" for="password_confirmation">{{ trans('backpack::base.confirm_password') }}</label>

                            <div>
                                <input type="password" class="form-control{{ $errors->has('password_confirmation') ? ' is-invalid' : '' }}" name="password_confirmation" id="password_confirmation">

                                @if ($errors->has('password_confirmation'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div>
                                <button type="submit" class="btn btn-block btn-primary">
                                    {{ trans('backpack::base.register') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            @if (backpack_users_have_email() && config('backpack.base.setup_password_recovery_routes', true))
                <div class="text-center"><a href="{{ route('backpack.auth.password.reset') }}">{{ trans('backpack::base.forgot_your_password') }}</a></div>
            @endif
            <div class="text-center"><a href="{{ route('backpack.auth.login') }}">{{ trans('backpack::base.login') }}</a></div>
        </div>
    </div>
    
@endsection
@section('after_scripts')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
    $('.select2').select2();
});
</script>
@endsection