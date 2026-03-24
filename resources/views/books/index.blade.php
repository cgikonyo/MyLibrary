@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <div class="row">

            <!--LEFT SIDE: READING LIST-->
            <div class="col-md-8">
                <h2 class="mb-3">Your Reading List</h2>

                <a href="{{ route('books.search') }}" class="btn btn-primary mb-3">
                    <i class="bi bi-search"></i> Search Books
                </a>

                @if($books->isEmpty())
                    <p class="text-muted">No Books Yet.</p>
                @else
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Book No.</th>
                                <th>Title</th>
                                <th>Author</th>
                                <th>Status</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($books as $book)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $book->title }}</td>
                                    <td>{{ $book->author ?? 'N/A' }}</td>
                                    <td>
                                        <form action="{{ route('books.updateStatus', $book->id) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <select name="status" class="form-select-sm" onchange="this.form.submit()">
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
                                    <!--Delete Icon-->
                                    <td>
                                        <form action="{{ route('books.destroy', $book->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-link text-danger p-0"
                                                onclick="return confirm('Delete this book?')">
                                                <i class="bi bi-trash fs-5" style="cursor:pointer;"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>

            <!--RIGHT SIDE: Recommendations -->
            <div class="col-md-4">
                <h4 class="mb-3">📚 Recommendations</h4>

                @foreach($recommendations as $rec)
                    <div class="card mb-3 shadow-sm">
                        <div class="row g-0 align-items-center">
                            <!--Cover-->
                            <div class="col-4">
                                @if(isset($rec['cover_i']))
                                    <img src="https://covers.openlibrary.org/b/id/{{ $rec['cover_i'] }}-M.jpg"
                                        class="img-fluid rounded-start">
                                @endif
                            </div>

                            <!-- Info -->
                            <div class="col-8">
                                <div class="card-body p-2">
                                    <h6 class="card-title mb-1">
                                        {{ $rec['title'] ?? 'No Title'}}
                                    </h6>

                                    <p class="text-muted small mb-2">
                                        {{ $rec['author_name'][0] ?? 'Unknown'}}
                                    </p>

                                    <form action="{{ route('books.store') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="title" value="{{ $rec['title'] ?? '' }}">
                                        <input type="hidden" name="author" value="{{ $rec['author_name'][0] ?? 'Unknown' }}">
                                        <input type="hidden" name="status" value="pending">
                                        <input type="hidden" name="cover_i" value="{{ $rec['cover_i'] ?? '' }}">

                                        <button class="btn btn-sm btn-success">
                                            Want To Read
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

        </div>
    </div>
@endsection