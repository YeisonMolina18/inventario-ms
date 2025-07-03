<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\JsonResponse;

class ProductController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(ProductResource::collection(Product::all()));
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'nombre' => 'required|string|max:255',
            'disponibles' => 'required|integer|min:0',
        ]);

        $product = Product::create($data);

        return response()->json(new ProductResource($product), 201);
    }

    public function show(Product $product): JsonResponse
    {
        return response()->json(new ProductResource($product));
    }

    public function update(Request $request, Product $product): JsonResponse
    {
        $data = $request->validate([
            'nombre' => 'sometimes|string|max:255',
            'disponibles' => 'sometimes|integer|min:0',
        ]);

        $product->update($data);

        return response()->json(new ProductResource($product));
    }

    public function destroy(Product $product): JsonResponse
    {
        $product->delete();
        return response()->json(null, 204);
    }

    // ✅ Nuevo método: Inventario consulta a Ventas
    public function getSales(Product $product): JsonResponse
    {
        $ventasApiUrl = env('VENTAS_API_URL');
        $response = Http::get("{$ventasApiUrl}/ventas", [
            'producto_id' => $product->id,
        ]);

        if ($response->failed()) {
            return response()->json(['message' => 'No se pudo contactar al servicio de ventas.'], 503);
        }

        return response()->json($response->json());
    }
}
