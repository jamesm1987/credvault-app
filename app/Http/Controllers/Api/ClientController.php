<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreClientRequest;
use App\Http\Requests\UpdateClientRequest;
use App\Http\Resources\ClientResource;
use App\Models\Client;
// /use App\Models\Environment;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        $sortColumn = $request->input('sort', 'name');
        $direction = strtolower((string) $request->input('direction', 'asc')) === 'desc' ? 'desc' : 'asc';

        $allowedSorts = ['name', 'created_at'];
        if (! in_array($sortColumn, $allowedSorts, true)) {
            $sortColumn = 'name';
        }

        $perPage = min(max((int) ($request->input('per_page', 25)), 1), 100);

        $clients = Client::query()
            ->when($request->search, fn ($q, $s) => $q->where('name', 'like', "%{$s}%"))
            ->orderBy($sortColumn, $direction)
            ->paginate($perPage);

        return ClientResource::collection($clients);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreClientRequest $request): ClientResource
    {
        $validated = $request->validated();

        $client = new Client(['name' => $validated['name']]);
        // $client->environment()->associate(Environment::findOrFail($validated['environment_id']));
        $client->save();
        // $client->loadCount('credentials');

        return new ClientResource($client);
    }

    /**
     * Display the specified resource.
     */
    public function show(Client $client): ClientResource
    {
        // $client->load([
        //     'credentials.category',
        //     'credentials.environment',
        // ])->loadCount('credentials');

        return new ClientResource($client);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateClientRequest $request, Client $client): ClientResource
    {
        $client->update($request->validated());

        return new ClientResource($client);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Client $client): Response
    {
        $client->delete();

        return response()->noContent();
    }
}
