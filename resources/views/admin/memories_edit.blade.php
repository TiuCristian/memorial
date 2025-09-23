@extends('layouts.app')

@section('content')
<div class="container py-4" style="max-width:760px;">
  <h3 class="mb-3">Editează amintire</h3>

  <form method="POST" action="{{ route('admin.memories.update', $memory) }}" enctype="multipart/form-data" class="card p-4 shadow-sm">
    @csrf @method('PUT')

    <div class="mb-3">
      <label class="form-label">Nume și prenume</label>
      <input type="text" class="form-control" name="name" value="{{ old('name', $memory->name) }}">
    </div>

    <div class="mb-3">
      <label class="form-label">Relația</label>
      <input type="text" class="form-control" name="relation" value="{{ old('relation', $memory->relation) }}" required>
      @error('relation') <div class="text-danger small">{{ $message }}</div> @enderror
    </div>

    <div class="mb-3">
      <label class="form-label">Mesaj</label>
      <textarea class="form-control" rows="5" name="message" required>{{ old('message', $memory->message) }}</textarea>
      @error('message') <div class="text-danger small">{{ $message }}</div> @enderror
    </div>

    <div class="mb-3">
      <label class="form-label">Status</label>
      <select class="form-select" name="status" required>
        @foreach (['pending','approved','rejected'] as $s)
          <option value="{{ $s }}" @selected(old('status', $memory->status)===$s)>{{ $s }}</option>
        @endforeach
      </select>
    </div>

    @if($memory->media_path)
      <div class="mb-3">
        <label class="form-label d-block">Media curentă</label>
        @if($memory->media_mime && str_starts_with($memory->media_mime, 'image/'))
          <img src="{{ asset('storage/'.$memory->media_path) }}" class="img-fluid rounded mb-2" style="max-height:220px" alt="media">
        @elseif($memory->media_mime && str_starts_with($memory->media_mime, 'video/'))
          <video src="{{ asset('storage/'.$memory->media_path) }}" controls class="w-100 rounded mb-2" style="max-height:260px"></video>
        @else
          <a href="{{ asset('storage/'.$memory->media_path) }}" target="_blank" rel="noopener">Deschide fișierul</a>
        @endif

        <div class="form-check mt-2">
          <input class="form-check-input" type="checkbox" name="remove_media" value="1" id="rm">
          <label for="rm" class="form-check-label">Șterge media existentă</label>
        </div>
      </div>
    @endif

    <div class="mb-4">
      <label class="form-label">Înlocuiește cu nouă media (opțional)</label>
      <input type="file" class="form-control" name="media" accept=".jpg,.jpeg,.png,.webp,.mp4,.mov,.avi">
      <div class="form-text">Max 10MB</div>
    </div>

    <div class="d-flex gap-2">
      <button class="btn btn-primary">Salvează</button>
      <a href="{{ route('admin.memories.index') }}" class="btn btn-outline-secondary">Înapoi</a>
    </div>
  </form>
</div>
@endsection
