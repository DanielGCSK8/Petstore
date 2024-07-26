<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pet;

class PetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pets = Pet::all();
        return response()->json($pets);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $pet = new Pet();
            $pet->category = $request->category;
            $pet->name = $request->name;
            $pet->photoUrls = json_encode($request->photoUrls);
            $pet->tags = json_encode($request->tags);
            $pet->status = $request->status;
            $pet->save();

            return response()->json([
                'success' => true,
                'data' => $pet
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error creating Pet',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $pet = Pet::find($id);
        if ($pet) {
            return response()->json([
                'success' => true,
                'data' => $pet
            ], 200);
        } else {
            return response()->json([
                "message" => "El Registro no se encuentra."
            ], 404);
        }
    }

    public function findByStatus(Request $request)
    {
        try {
            $statuses = explode(',', $request->status);
            $pets = Pet::whereIn('status', $statuses)->get();

            return response()->json([
                'success' => true,
                'data' => $pets
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error retrieving Pets by statuses',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $pet = Pet::findOrFail($id);
            $pet->name = $request->name;
            $pet->status = $request->status;
            $pet->save();
            return response()->json([
                'success' => true,
                'data' => $pet
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating Pet',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function updatePet(Request $request) {
        try {
            $pet = Pet::findOrFail($request->id);
            $pet->category = $request->category;
            $pet->name = $request->name;
            $pet->photoUrls = json_encode($request->photoUrls);
            $pet->tags = json_encode($request->tags);
            $pet->status = $request->status;
            $pet->save();

            return response()->json([
                'success' => true,
                'data' => $pet
            ], 200);

        } catch(\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating Pet',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        // Verificar la api_key en los encabezados de la solicitud
        $apiKey = $request->header('api_key');
        if (!$apiKey || $apiKey !== 'abc1234') {  // Reemplaza 'your_api_key' con la clave API correcta
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized: Invalid API key'
            ], 401);
        }

        try {
            $pet = Pet::findOrFail($id);
            $pet->delete();

            return response()->json([
                'success' => true,
                'message' => 'Pet deleted successfully'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting Pet',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
