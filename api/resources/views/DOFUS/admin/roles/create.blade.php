@extends('layouts.admin.admin')
@section('title') Roles @endsection
@section('page-title') Roles : Create @endsection
@section('header')
    {{ Html::style('css/jquery.bootstrap-touchspin.min.css') }}
@endsection
@section('content')
        <!-- Start content -->
        <div class="content">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card-box">
                            <div class="m-b-30">
                                <a href="{{ route('admin.roles') }}" class="btn btn-primary waves-effect waves-light btn-lg m-b-5"><i class="zmdi zmdi-long-arrow-return"></i> Return to list</a>
                            </div>
                            {!! Form::open(['route' => ['admin.role.store']]) !!}
                            <div class="row">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="col-sm-12">
                                            <div class="form-group {{ $errors->has('id') ? ' has-error' : '' }}">
                                                <label for="Message">Id:</label>
                                                {!! Form::text('id', $id, ['class' => 'form-control', 'id' => 'id']) !!}
                                                @if ($errors->has('id'))
                                                    <span class="help-block">
                                                                        <strong>{{ $errors->first('id') }}</strong>
                                                                    </span>
                                                @endif
                                            </div>
                                            <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
                                                <label for="Message">Name:</label>
                                                {!! Form::text('name', null, ['class' => 'form-control', 'id' => 'name']) !!}
                                                @if ($errors->has('name'))
                                                    <span class="help-block">
                                                                        <strong>{{ $errors->first('name') }}</strong>
                                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                                {!! Form::submit('Create', ['class' => 'btn btn-info btn-block']) !!}
                                {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection

@section('bottom')
           {{ Html::script('js/admin/jquery.bootstrap-touchspin.min.js') }}
<script>
    // Touchspin initialize
    $(document).ready(function () {
                    $("input[name='id']").TouchSpin({
                        min: 1,
                        max: 999999999999999999999999,
                        step: 1,
                        decimals: 0,
                        boostat: 5,
                        maxboostedstep: 10,
                        buttondown_class: "btn btn-success",
                        buttonup_class: "btn btn-warning",
                        postfix: 'Id'
                    });
    });
</script>
@endsection