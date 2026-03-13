@extends('layouts.app')

@section('content')
    <h1>Your Books</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('books.create') }}" class="btn btn-primary mb-3">Add New Book</a>

    @if($books->isEmpty())
        <p>No books yet.</p>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Book Title</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($books as $book)
                    <tr>
                        <td>{{ $book->book_number }}</td>
                        <td>{{ $book->description }}</td>
                        <td>{{ $book->status }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
@endsection