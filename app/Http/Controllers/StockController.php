<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Stock;
use Illuminate\Http\Request;

class StockController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        // Validate input
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity'   => 'required|integer|min:1',
            'type'       => 'required|in:add,subtract',
            'remarks'    => 'nullable|string',
        ]);

        // Fetch the product
        $product = Product::findOrFail($validated['product_id']);

        // Update the product's quantity
        if ($validated['type'] === 'add') {
            $product->quantity += $validated['quantity']; // Add to product quantity
        } elseif ($validated['type'] === 'subtract') {
            // Check if subtracting exceeds the available quantity
            if ($product->quantity < $validated['quantity']) {
                return response()->json([
                    'success' => false,
                    'message' => 'Not enough quantity to subtract.'
                ], 422);
            }
            
            $product->quantity -= $validated['quantity']; // Subtract from product quantity
        }

        // Save the updated product quantity
        $product->save();
        // Create the stock record
        Stock::create($validated);
        // Return success response
        return response()->json([
            'success' => true,
            'message' => 'Stock record created successfully!',
            'product_quantity' => $product->quantity
        ]);
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
