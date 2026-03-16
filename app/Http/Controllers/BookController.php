<?php

namespace App\Http\Controllers;

use App\Models\Books;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class BookController extends Controller
{
    public function index()
    {
        $books = auth()->user()->books;
        return view('books.index', compact('books'));
    }

    public function create()
    {
        return view('books.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'author' => 'nullable|string',
            'status' => 'required|in:pending,started,completed',
            'cover_i' => 'nullable|string',
        ]);

        $user = auth()->user();

        // Logic to get the next number in the user's personal list
        $nextBookNumber = ($user->books()->max('book_number') ?? 0) + 1;

        $user->books()->create([
            'title' => $request->title,
            'author' => $request->author,
            'status' => $request->status,
            'cover_i' => $request->cover_i, // Now saving the cover ID
            'book_number' => $nextBookNumber,
        ]);

        return redirect()->route('books.index')->with('success', 'Book added to your library!');
    }

    public function show($isbn)
    {
        // FIXED: Endpoint URL updated to include /api/books
        $response = Http::withoutVerifying()
            ->withHeaders([
                'User-Agent' => 'MyLibraryApp (email@example.com)'
            ])->get("https://openlibrary.org/api/books", [
                    'bibkeys' => "ISBN:$isbn",
                    'format' => 'json',
                    'jscmd' => 'data',
                ]);

        $bookData = $response->json()["ISBN:$isbn"] ?? null;
        return view('books.show', ['book' => $bookData]);
    }

    public function update(Request $request, Books $books)
    {
        if ($books->user_id !== auth()->id()) {
            abort(403);
        }

        $request->validate([
            'status' => 'required|in:pending,started,completed',
        ]);

        $books->update(['status' => $request->status]);

        return redirect()->back()->with('success', 'Status updated!');
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $results = [];

        if ($query) {
            // FIXED: Endpoint URL updated to include /search.json
            $response = Http::withoutVerifying()
                ->withHeaders([
                    'User-Agent' => 'MyLibraryApp (email@example.com)'
                ])->get("https://openlibrary.org/search.json", [
                        'q' => $query,
                        'limit' => 12,
                        'fields' => 'key,title,author_name,cover_i'
                    ]);

            $results = $response->json()['docs'] ?? [];
        }

        return view('books.search', compact('results'));
    }
}
