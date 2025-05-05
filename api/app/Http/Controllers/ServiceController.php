<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::all();
        return response()->json($services);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'business_name' => 'required|string|max:255',
            'location' => 'nullable|string|max:255',
            'price' => 'required|numeric|min:0',
            'available_from' => 'required|date',
            'available_to' => 'required|date|after:available_from',
        ]);

        $service = Service::create($request->all());

        return response()->json([
            'message' => 'Service created successfully',
            'service' => $service
        ], 201);
    }

    public function show(Service $service)
    {
        return response()->json($service);
    }

    public function update(Request $request, Service $service)
    {
        $request->validate([
            'name' => 'sometimes|string|max:255',
            'description' => 'nullable|string',
            'business_name' => 'sometimes|string|max:255',
            'location' => 'nullable|string|max:255',
            'price' => 'sometimes|numeric|min:0',
            'available_from' => 'sometimes|date',
            'available_to' => 'sometimes|date|after:available_from',
        ]);

        $service->update($request->all());

        return response()->json([
            'message' => 'Service updated successfully',
            'service' => $service
        ]);
    }

    public function destroy(Service $service)
    {
        $service->delete();

        return response()->json([
            'message' => 'Service deleted successfully'
        ]);
    }
}