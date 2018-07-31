@extends('layouts.app')

@section('content')
<div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Create a message') }}</div>

                    <div class="card-body">
                        <form method="POST" action="/messages/{{ $message->id }}" aria-label="{{ __('Message') }}">
                            @csrf
                            @method('PUT')

                            <div class="form-group row">
                                <label for="email" class="col-sm-4 col-form-label text-md-right">{{ __('Message content') }}</label>

                                <div class="col-md-6">
                                    <textarea
                                        id="email"
                                        type="email"
                                        class="form-control{{ $errors->has('content') ? ' is-invalid' : '' }}"
                                        name="content"
                                        required
                                        autofocus
                                    >{{ $message->content }}</textarea>

                                    @if ($errors->has('content'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('content') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Save message') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
