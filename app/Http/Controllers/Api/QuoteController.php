<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\QuoteResource;
use App\Quote;
use Illuminate\Http\Request;

class QuoteController extends Controller
{
    public function index()
    {
        // $quotes = Quote::latest()->get(); //Ini untuk menampilkan semua quote secara ascending
        $quotes = Quote::latest()->paginate(10); //ini untuk menampilkan 10 quote dalam 1 page

        return QuoteResource::collection($quotes);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'message' => 'required',
        ]);

        $quote = Quote::create([
            'user_id' => auth()->id(),
            'message' => $request->message,
        ]);

        return new QuoteResource($quote);
    }

    public function show(Quote $quote)
    {
        return new QuoteResource($quote);
    }

    //Tanpa Route Model Binding
    // public function show($id)
    // {
    //     $quote = Quote::find($id);

    //     return new QuoteResource($quote);
    // }

    public function update(Request $request, Quote $quote)
    {
        $this->authorize('update', $quote);

        $quote->update([
            'message' => $request->message,
        ]);

        return new QuoteResource($quote);
    }

    public function destroy(Quote $quote)
    {
        $this->authorize('delete', $quote);

        $quote->delete();

        return response()->json([
            'message' => 'Quote Deleted',
        ]);
    }
}
