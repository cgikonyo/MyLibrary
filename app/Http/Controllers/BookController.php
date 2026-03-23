<?php

namespace App\Http\Controllers;

use App\Models\Book;
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
        return view('book.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'author' => 'nullable|string',
            'status' => 'required|in:pending,started,completed',
            'cover_i' => 'nullable|string',
        ]);

        auth()->user()->books()->create([
            'title' => $request->title,
            'author' => $request->author,
            'status' => $request->status,
            'cover_i' => $request->cover_i,
        ]);

        return redirect()->route('books.index')->with('success', 'Book added to your library!');
    }

    public function show($isbn)
    {
        $response = Http::withoutVerifying()
            ->withHeaders([
                'User-Agent' => 'MyLibraryApp (email@example.com)'
            ])->get("https://openlibrary.org/api/books", [
                    'bibkeys' => "ISBN:$isbn",
                    'format' => 'json',
                    'jscmd' => 'data',
                ]);

        $bookData = $response->json()["ISBN:$isbn"] ?? null;
        return view('book.show', ['book' => $bookData]);
    }

    public function update(Request $request, Book $book)
    {
        if ($book->user_id !== auth()->id()) {
            abort(403);
        }

        $request->validate([
            'status' => 'required|in:pending,started,completed',
        ]);

        $book->update([
            'status' => $request->status
        ]);

        return redirect()->back()->with('success', 'Status updated!');
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $results = [];

        if ($query) {
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

    public function destroy(Book $book)
    {
        if ($book->user_id !== auth()->id()) {
            abort(403);
        }

        $book->delete();

        return redirect()->route('books.index')
            ->with('success', 'Book deleted successfully!');
    }

    public function updateStatus(Request $request, Book $book)
    {

        $request->validate([
            'status' => 'required|in:pending,started,completed'
        ]);
        $book->status = $request->status;
        $book->save();

        return back();
    }


}
