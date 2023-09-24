<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\EventRequest;
use App\Models\Event;

class EventController extends Controller
{
    public function index()
    {
        return response()->json(Event::all());
    }

    public function store(EventRequest $eventRequest): \Illuminate\Http\JsonResponse
    {
        $data = $eventRequest->validated();
        $data['user_id'] = auth()->id();
        Event::query()->create($data);
        $result = ['error' => null, 'result' => ['message' => 'Event Saved']];

        return response()->json($result);
    }

    public function partake($id): \Illuminate\Http\JsonResponse
    {
        $event = Event::query()->findOrFail($id);
        $event->users()->attach(auth()->id());
        $result = ['error' => null, 'result' => ['message' => 'Event participation']];

        return response()->json($result);
    }

    public function destroyPartake($id)
    {
        $event = Event::query()->findOrFail($id);
        $event->users()->detach(auth()->id());
        $result = ['error' => null, 'result' => ['message' => 'Delete event participation']];

        return response()->json($result);
    }

    public function destroy($id)
    {
        $event = Event::query()->findOrFail($id);
        $event->delete();
        $result = ['error' => null, 'result' => ['message' => 'Delete event']];

        return response()->json($result);
    }
}
