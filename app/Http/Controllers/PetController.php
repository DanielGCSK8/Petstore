<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pet;
use App\Models\Category;
use App\Models\Tag;
use App\Models\ApiResponse;

class PetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pets = Pet::with('category', 'tags')->get();
        $category = Category::all();
        $tags = Tag::all();

        return response()->json([
            'pets' => $pets,
            'category' => $category,
            'tags' => $tags
        ]);
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
            if (!is_array($request->photoUrls)) {
                $pet->photoUrls = json_encode(array_map('trim', explode(',', $request->photoUrls)));
            } else {
                $pet->photoUrls = json_encode($request->photoUrls);
            }
            $pet->tags = $request->tags;
            $pet->status = $request->status;
            $pet->save();

            $this->storeApiResponse(201, 'success', 'Pet created successfully');

            return response()->json([
                'success' => true,
                'data' => $pet
            ], 201);
        } catch (\Exception $e) {

            $this->storeApiResponse(500, 'error', $e->getMessage());
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
        $pet = Pet::with('category', 'tags')->find($id);
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
        $validStatuses = ['available', 'pending', 'sold'];

        $statuses = array_map('trim', explode(',', $request->status));
        $invalidStatuses = array_diff($statuses, $validStatuses);

        if (!empty($invalidStatuses)) {
            $this->storeApiResponse(400, 'Invalid', 'Invalid statuses');
            return response()->json([
                'success' => false,
                'message' => 'Estados inválidos: ' . implode(', ', $invalidStatuses),
            ], 400);
        }
        try {
            $statuses = array_map('trim', explode(',', $request->status));
            $pets = Pet::whereIn('status', $statuses)->get();
            $this->storeApiResponse(200, 'success', 'Pets');
            return response()->json([
                'success' => true,
                'data' => $pets
            ], 200);
        } catch (\Exception $e) {
            $this->storeApiResponse(500, 'error', 'Error retrieving Pets by statuses');
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
            $pet = Pet::find($id);
            if ($pet) {
                $pet->category = $request->category;
                $pet->name = $request->name;

                if ($request->photoUrls) {
                    if (!is_array($request->photoUrls)) {
                        $pet->photoUrls = json_encode(array_map('trim', explode(',', $request->photoUrls)));
                    } else {
                        $pet->photoUrls = json_encode($request->photoUrls);
                    }
                }
                if ($request->tags) {
                    $pet->tags = $request->tags;
                }

                $pet->status = $request->status;
                $pet->save();
                $this->storeApiResponse(200, 'success', 'Pet updated successfully');
                return response()->json([
                    'success' => true,
                    'data' => $pet
                ], 200);
            } else {
                $this->storeApiResponse(404, 'false', 'Pet not found');
                return response()->json([
                    'success' => false,
                    'message' => 'Pet not found'
                ], 404);
            }
        } catch (\Exception $e) {
            $this->storeApiResponse(500, 'error', 'Error updating pet');
            return response()->json([
                'success' => false,
                'message' => 'Error updating Pet',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function updatePet(Request $request)
    {
        try {
            $pet = Pet::find($request->id);
            if ($pet) {
                $pet->category = $request->category;
                $pet->name = $request->name;
                if (!is_array($request->photoUrls)) {
                    $pet->photoUrls = json_encode(array_map('trim', explode(',', $request->photoUrls)));
                } else {
                    $pet->photoUrls = json_encode($request->photoUrls);
                }
                $pet->tags = $request->tags;
                $pet->status = $request->status;
                $pet->save();

                $this->storeApiResponse(200, 'success', 'Pet updated successfully');

                return response()->json([
                    'success' => true,
                    'data' => $pet
                ], 200);
            } else {
                $this->storeApiResponse(404, 'false', 'Pet not found');
                return response()->json([
                    'success' => false,
                    'message' => 'Pet not found'
                ], 404);
            }
        } catch (\Exception $e) {
            $this->storeApiResponse(500, 'error', 'Error updating pet');
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
        $apiKey = $request->header('api_key');
        if (!$apiKey || $apiKey !== 'abc1234') {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized: Invalid API key'
            ], 401);
        }

        try {
            $pet = Pet::find($id);
            if ($pet) {
                $pet->delete();

                $this->storeApiResponse(200, 'success', 'Pet deleted successfully');
                return response()->json([
                    'success' => true,
                    'message' => 'Pet deleted successfully'
                ], 200);
            } else {
                $this->storeApiResponse(404, 'false', 'Pet not found');
                return response()->json([
                    'success' => false,
                    'message' => 'Pet not found'
                ], 404);
            }
        } catch (\Exception $e) {
            $this->storeApiResponse(500, 'error', 'Error deleting Pet');
            return response()->json([
                'success' => false,
                'message' => 'Error deleting Pet',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    protected function storeApiResponse($code, $type, $message)
    {
        $apiResponse = new ApiResponse();
        $apiResponse->code = $code;
        $apiResponse->type = $type;
        $apiResponse->message = $message;
        $apiResponse->save();
    }
}
