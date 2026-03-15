<?php

namespace App\Http\Controllers;

use App\Models\Books;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class BookController extends Controller
{
    // fetches all books from the database and returns the view
    public function index()
    {
        // We fetch ALL books as a collection called $books
        $books = auth()->user()->books;

        return view('books.index', compact('books'));
    }
    //shows the form to add a new book
    public function create()
    {
        return view('books.create');
    }
    //handles actual adding of a new book
    public function store(Request $request)
    {
        // 1. Validate
        $request->validate([
            'description' => 'required|string|max:255',
            'status' => 'required|in:pending,started,completed',
        ]);

        // 2. Save using the User relationship
        // make sure a user is authenticated before trying to access the relation
        $user = auth()->user();
        if (!$user) {
            // this shouldn't happen if your routes are protected by auth middleware
            abort(403, 'Unauthenticated');
        }

        // get the next book number for this user
        $nextBookNumber = $user->books()->max('book_number') + 1;

        $user->books()->create([
            'description' => $request->description,
            'status' => $request->status,
            'book_number' => $nextBookNumber,
        ]);

        // 3. Redirect back
        return redirect()->back()->with('success', 'Book added!');
    }


    //Displays details for a specific task
    public function show(Books $books)
    {
        return view('books.show', compact('books'));
    }

    /**
     * Update the specified task (mainly status changes).
     */
    public function update(Request $request, Books $books)
    {
        // ensure the authenticated user owns the task
        if ($books->user_id !== auth()->id()) {
            abort(403);
        }

        $request->validate([
            'status' => 'required|in:pending,started,completed',
        ]);

        $books->update(['status' => $request->status]);

        return redirect()->back()->with('success', 'List updated!');
    }

    public function show($isbn)
    {
        $response = Http::withHeaders(([
            'User-Agent' => 'MyLibraryApp(email@example.com)'

        ]))->get("https://openlibrary.org/api/books?bibkeys=ISBN:$isbn&format=json&jscmd=data", [
                    'bibkeys' => "ISBN:$isbn",
                    'format' => 'json',
                    'jscmd' => 'data',
                ]);
        $bookData = $response->json()["ISBN:$isbn"] ?? null;
        return view('books.show', ['book' => $bookData]);
    }
}
