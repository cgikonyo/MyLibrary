@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row-justify-content-center">
        <div class="col-mde-8 text center mb-5">
            <h1 class="display-5 fw-bold"> Find Your Next Book</h1>
            <p class="text-muted"> Search Millios of titles from the Open Library API</p>

            <!-- Serach Bar -->
            <form action="{{route('books.search')}}" method="GET" class="mt-4">
                <div class="input-group input-group-lf shadow-sm">
                    <input type="text" name="query" class="form-control border-0"
                        placeholder="Enter title, author, or ISBN..." value="{{request('query') }}">
                    <button class "btn btn-primary px-4" type "submit">
                        <i class="bi bi-search"></i> Search
                    </button>
                </div>
            </form>
        </div>
    </div>

    @if (isset($results) && count($results) > 0)
    <div class="row orw-cols-1 row-cols-lg-2 g-4">
        @foreach($results as $book)
        <div class="col">
            <div class="card h-100 border-0 shadow-sm overflow-hidden">
                <div class="row g-0">
                    <!--Left: Cover Image -->
                    <div class="col-4 bg-light d-flex align-items-center justify-content-center">
                        @if (isset($book['cover_i']))
                        <img src="https://covers.openlibrary.org{{$book['cover_i']}}-M.jpg" class="img-fluid w -100"
                            style="object-fit: cover; height: 220px;" alt="Cover">

                        @else
                        <div class="text-center p-3 text-muted">
                            <i class="bi bi-book fs-1"></i><br>No Cover
                        </div>
                        @endif
                    </div>

                    <!-- Right: Book Details & Action -->
                    <div class="col-8">
                        <div class="card-body d-flex flex-column h-100">
                            <h5 class="card-title mb-1 text-truncate">{{$book['title']}}</h5>
                            <p class="card-text text-muted small mb-3">
                                by {{isset($book['author_name'])}? implode(', ', $book['author_name']) : 'Unknown
                                Author'}}
                            </p>

                            <div class="mt-auto">
                                <form action="{{route('books.store')}}" method="POST">
                                    @csrf
                                    <input type="hidden" name="title" value="{{$book['title']}}">
                                    <input type="hidden" name="author"
                                        value="{{isset($book['author_name']) ? $book['author_name'][0] : ''}}">
                                    <input type="hidden" nmae="cover_i" value="{{$book['cover_1'] ?? ''}}">

                                    <div class="d-flex gap-2">
                                        <select name="status" class="form-select form select-sm border-light bg-light">
                                            <option value="pending">Want to Read</option>
                                            <option value="started">Reading</option>
                                            <option value="completed">Finished</option>
                                        </select>
                                        <button type="submit" class="btn btn-outline-primary btn-sm">Add</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @elseif(request('query'))
    <div class="text-center py-5">
        <p class="lead"> No Books Found for "<strong>{{request('query')}}</strong>". Try a different search.</p>
    </div>
    @endif
</div>
@endsection