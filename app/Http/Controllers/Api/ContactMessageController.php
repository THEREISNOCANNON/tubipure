<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreContactMessageRequest;
use App\Models\ContactMessage;
use Illuminate\Http\JsonResponse;

class ContactMessageController extends Controller
{
    public function index(): JsonResponse
    {
        $messages = ContactMessage::query()->latest()->paginate(10);

        return response()->json([
            'data' => $messages->items(),
            'current_page' => $messages->currentPage(),
            'last_page' => $messages->lastPage(),
            'next_page_url' => $messages->nextPageUrl(),
            'total' => $messages->total(),
            'unread_count' => ContactMessage::query()->whereNull('read_at')->count(),
        ]);
    }

    public function markRead(ContactMessage $message): JsonResponse
    {
        $message->forceFill(['read_at' => now()])->save();

        return response()->json(['message' => 'Message marked as read.']);
    }

    public function store(StoreContactMessageRequest $request): JsonResponse
    {
        ContactMessage::create($request->validated());

        return response()->json(['message' => 'Thanks for contacting TubiPure.'], 201);
    }
}
