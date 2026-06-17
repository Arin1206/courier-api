<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Courier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CourierController extends Controller
{
    public function index(Request $request)
    {
        $query = Courier::query();

        if ($request->filled('search')) {
            $keywords = explode(' ', $request->search);

            foreach ($keywords as $keyword) {
                $query->where('name', 'like', "%{$keyword}%");
            }
        }

        if ($request->filled('level')) {
            $levels = explode(',', $request->level);

            $query->whereIn('level', $levels);
        }

        if ($request->get('sort') === 'registered_at') {
            $query->orderBy('registered_at');
        } else {
            $query->orderBy('name');
        }

        return response()->json(
            $query->paginate(10)
        );
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:couriers,email',
            'phone' => 'required|string|unique:couriers,phone',
            'level' => 'required|integer|between:1,5',
            'registered_at' => 'required|date',
            'is_active' => 'nullable|boolean'
        ]);

        $courier = Courier::create($validated);

        Log::info('Courier created successfully', $courier->toArray());

        return response()->json($courier, 201);
    }

    public function show(Courier $courier)
    {
        return response()->json($courier);
    }

    public function update(Request $request, Courier $courier)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:couriers,email,' . $courier->id,
            'phone' => 'required|string|unique:couriers,phone,' . $courier->id,
            'level' => 'required|integer|between:1,5',
            'registered_at' => 'required|date',
            'is_active' => 'nullable|boolean'
        ]);

        $courier->update($validated);

        Log::info('Courier updated successfully', [
            'id' => $courier->id,
            'data' => $courier->toArray()
        ]);

        return response()->json($courier);
    }

    public function destroy(Courier $courier)
    {
        $id = $courier->id;

        $courier->delete();

        Log::info('Courier deleted successfully', [
            'id' => $id
        ]);

        return response()->json([
            'message' => 'Courier deleted successfully'
        ]);
    }
}
