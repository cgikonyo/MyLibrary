@extends('layouts.app')

@section('content')
    <div class="container py-5">

        <h1 class="mb-4">Your Reading List</h1>

        <!--  Go to Search Page -->
        <a href="{{ route('books.search') }}" class="btn btn-primary mb-3">
            🔍 Search Books
        </a>

        <!-- Reading List Table -->
        @if($books->isEmpty())
            <p>No books yet.</p>
        @else
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Book No.</th>
                        <th>Title</th>
                        <th>Author</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($books as $book)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $book->title }}</td>
                            <td>{{ $book->author ?? 'N/A' }}</td>

                            <td>
                                <form action="{{ route('books.updateStatus', $book) }}" method="POST">
                                    @csrf
                                    @method('PATCH')

                                    <select name="status" class="form-select" onchange="this.form.submit()">
                                        <option value="pending" {{ $book->status == 'pending' ? 'selected' : '' }}>
                                            Pending
                                        </option>
                                        <option value="started" {{ $book->status == 'started' ? 'selected' : '' }}>
                                            Started
                                        </option>
                                        <option value="completed" {{ $book->status == 'completed' ? 'selected' : '' }}>
                                            Completed
                                        </option>
                                    </select>
                                </form>
                            </td>

                            <td>
                                <form action="{{ route('books.destroy', $book) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger"
                                        onclick="return confirm('Delete this book?');">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif

    </div>
@endsection
