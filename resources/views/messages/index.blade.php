@extends('layouts.app')

@php
    // dd($messages);
@endphp

@section('content')
<div class="container">

    {{-- Success messages --}}
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    {{-- Display error messages --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>{{ $errors->first() }}</strong>
        </div>
        <hr>
    @endif

    {{-- Pagination Links --}}
    {{ $messages->links() }}

    {{-- Display messages --}}
    @foreach ($messages as $message)
    <div class="card" style="margin-bottom: 1em;">
        <div class="card-body">
            <h6 class="card-subtitle mb-2 text-muted">
                <strong>{{ $message->user->name }}</strong>
                {{ $message->user->email }}
                <i style="font-size: .9em">{{ $message->updated_at->format('F j, Y') }}</i>
            </h6>
            <p class="card-text">{!! $message->content !!}</p>
            @if ($message->user->id === Auth::user()->id)
                <a href="/messages/{{ $message->id }}/edit" class="card-link">Edit Message</a>
                <a href="javascript:;" @click="deleteMessage({{ $message->id }})" class="card-link">Delete Message</a>
                <form method="POST" id="deleteMessage{{ $message->id }}" action="/messages/{{ $message->id }}">
                    @csrf
                    @method('DELETE')
                </form>
            @endif
        </div>
    </div>
    @endforeach

    {{-- Pagination Links --}}
    {{ $messages->links() }}

</div>
@endsection
