<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Memory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;


class HomeController extends Controller
{
    //
    public function homepage()
    {
        return view('welcome_memorial'); // new Blade view for the homepage
    }
    public function index()
    {
        return view('home'); // this is the form page
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'     => ['nullable', 'string', 'max:100'],
            'relation' => ['required', 'string', 'max:100'],
            'message'  => ['required', 'string', 'min:10', 'max:2000'],
            'media'    => ['nullable', 'file', 'max:10240', 'mimetypes:image/jpeg,image/png,image/webp,video/mp4,video/quicktime,video/x-msvideo'],
            'consent'  => ['accepted'],
        ], [
            'relation.required' => 'Te rugăm să ne spui relația ta cu Dana.',
            'message.required'  => 'Te rugăm să scrii un mesaj.',
            'message.min'       => 'Mesajul este prea scurt.',
            'media.max'         => 'Fișierul este prea mare (max 10MB).',
            'consent.accepted'  => 'Este necesar acordul tău pentru publicare.',
        ]);

        $mediaPath = null;
        $mediaMime = null;

        if ($request->hasFile('media')) {
            // salvează în storage/app/public/memories
            $mediaPath = $request->file('media')->store('memories', 'public');
            $mediaMime = $request->file('media')->getClientMimeType();
        }

        Memory::create([
            'name'       => $validated['name'] ?? null,
            'relation'   => $validated['relation'],
            'message'    => $validated['message'],
            'media_path' => $mediaPath,
            'media_mime' => $mediaMime,
            'consent'    => true,
            'status'     => 'pending', // pentru moderare ulterioară
            'ip'         => $request->ip(),
        ]);

        return back()->with('status', 'Mulțumim! Amintirea ta a fost trimisă și va fi vizibilă după aprobare.');
    }

    public function testimonials()
    {
        $countAll = Memory::count();
        $countPending = Memory::whereRaw('TRIM(LOWER(status)) = ?', ['pending'])->count();
        $sample = Memory::select('id', 'name', 'status', 'created_at')->latest()->take(3)->get();

        Log::info('memories debug', compact('countAll', 'countPending', 'sample'));
        // show only approved ones; for now, you can switch to 'pending' while testing
        $memories = Memory::whereRaw('TRIM(LOWER(status)) = ?', ['pending'])
            ->latest()
            ->paginate(10);
        // $memories = Memory::where('status', 'pending')->latest()->paginate(10);
        return view('memories_index', compact('memories'));
        // return view('memories_index', compact('memories'));
    }


    public function adminIndex()
    {
        // Pending first, then approved, then rejected; newest first within each status
        $memories = Memory::orderByRaw("FIELD(status,'pending','approved','rejected')")
            ->latest()
            ->paginate(12);

        return view('admin.memories_index', compact('memories'));
    }

    public function approve(Memory $memory)
    {
        $memory->update(['status' => 'approved']);
        return back()->with('status', 'Amintirea a fost aprobată.');
    }

    public function edit(Memory $memory)
    {
        return view('admin.memories_edit', compact('memory'));
    }

    public function update(Request $request, Memory $memory)
    {
        $validated = $request->validate([
            'name'     => ['nullable', 'string', 'max:100'],
            'relation' => ['required', 'string', 'max:100'],
            'message'  => ['required', 'string', 'min:10', 'max:2000'],
            'status'   => ['required', 'in:pending,approved,rejected'],
            'media'    => ['nullable', 'file', 'max:10240', 'mimetypes:image/jpeg,image/png,image/webp,video/mp4,video/quicktime,video/x-msvideo'],
            'remove_media' => ['nullable', 'boolean'],
        ]);

        // Remove media
        if ($request->boolean('remove_media') && $memory->media_path) {
            Storage::disk('public')->delete($memory->media_path);
            $memory->media_path = null;
            $memory->media_mime = null;
        }

        // Replace media
        if ($request->hasFile('media')) {
            if ($memory->media_path) {
                Storage::disk('public')->delete($memory->media_path);
            }
            $path = $request->file('media')->store('memories', 'public');
            $memory->media_path = $path;
            $memory->media_mime = $request->file('media')->getClientMimeType();
        }

        $memory->name = $validated['name'] ?? null;
        $memory->relation = $validated['relation'];
        $memory->message = $validated['message'];
        $memory->status = $validated['status'];
        $memory->save();

        return redirect()->route('admin.memories.index')->with('status', 'Amintirea a fost actualizată.');
    }

    public function destroy(Memory $memory)
    {
        if ($memory->media_path) {
            Storage::disk('public')->delete($memory->media_path);
        }
        $memory->delete();
        return back()->with('status', 'Amintirea a fost ștearsă.');
    }
}
