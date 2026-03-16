@extends('layouts.app')

@section('content')
    <div class="container py-5">

        <h1 class="mb-4">Your Reading List</h1>

        <!-- Search -->
        <form class="d-flex mb-4" action="{{ route('books.search') }}" method="GET">
            <input class="form-control me-2" type="search" placeholder="Search books" name="query"
                value="{{ request('query') }}">
            <button class="btn btn-outline-success" type="submit"><i class="bi bi-search"></i></button>
        </form>

        <!-- Add book -->
        <div class="card mb-4">
            <div class="card-body">
                <form action="{{ route('books.store') }}" method="POST">
                    @csrf
                    <div class="row g-2">
                        <div class="col-md-5">
                            <input type="text" name="title" class="form-control" placeholder="Book Title" required>
                        </div>
                        <div class="col-md-5">
                            <input type="text" name="author" class="form-control" placeholder="Author (optional)">
                        </div>
                        <div class="col-md-2">
                            <select name="status" class="form-select">
                                <option value="pending">Pending</option>
                                <option value="started">Started</option>
                                <option value="completed">Completed</option>
                            </select>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary mt-2">Add Book</button>
                </form>
            </div>
        </div>

        <!-- Reading List Table -->
        @if($books->isEmpty())
            <p>No books yet.</p>
        @else
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th>Author</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($books as $book)
                        <tr>
                            <td>{{ $book->book_number }}</td>
                            <td>{{ $book->title }}</td>
                            <td>{{ $book->author ?? 'N/A' }}</td>
                            <td>{{ ucfirst($book->status) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection