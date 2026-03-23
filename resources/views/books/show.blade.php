@extends('layouts.app')

@section('content')

    <div class="container">

        <h2>{{ $book['title'] ?? 'Book Details' }}</h2>

        @if($book)

            <p><strong>Title:</strong> {{ $book['title'] ?? 'N/A' }}</p>

            <p><strong>Authors:</strong>
                {{ isset($book['authors']) ? collect($book['authors'])->pluck('name')->join(', ') : 'Unknown' }}
            </p>

        @endif

        <a href="{{ route('books.index') }}" class="btn btn-secondary mt-3">
            Back to Library
        </a>

    </div>

@endsection
