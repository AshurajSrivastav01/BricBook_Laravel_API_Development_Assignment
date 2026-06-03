<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreBookRequest;
use App\Models\Book;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;
        $limit = $request->limit ?? 2;

        $query = Book::where('_deleted', 0);

        if (!empty($search)) {
            $query->where('title', 'like', '%' . $search . '%')->orWhere('author', 'like', '%' . $search . '%');
        }

        $books = $query->paginate($limit);

        return response()->json([
            'success' => true,
            'total_books' => $books->total(),
            'current_page' => $books->currentPage(),
            'per_page' => $books->perPage(),
            'last_page' => $books->lastPage(),
            'data' => $books->items()
        ]);
    }

    public function show($id)
    {
        $book = Book::findOrFail($id);

        return response()->json($book);
    }

    public function store(StoreBookRequest $request)
    {
        $validated = $request->validated();

        $bookExists = Book::where('title', $validated['title'])->exists();
        if ($bookExists) {
            return response()->json([
                'success' => false,
                'message' => 'Book already exists'
            ], 409);
        }
        $book = Book::create([
            'title' => $validated['title'],
            'author' => $validated['author'],
            'cover_image' => $validated['cover_image'],
            'price' => $validated['price'],
            'published_date' => $validated['published_date']
        ]);

        return response()->json([
            'message' => 'Book Created',
            'data' => $book
        ]);
    }

    public function update(Request $request,$id)
    {
        $book = Book::findOrFail($id);

        $book->update([
            'title' => $request->title,
            'author' => $request->author,
            'cover_image' => $request->cover_image,
            'price' => $request->price,
            'published_date' => $request->published_date
        ]);

        return response()->json([
            'message' => 'Book Updated',
            'data' => $book
        ]);
    }

    public function destroy($id)
    {
        $book = Book::findOrFail($id);

        $book->_deleted = 1;

        $book->save();

        return response()->json([
            'message' => 'Book Deleted Successfully'
        ]);
    }
}
