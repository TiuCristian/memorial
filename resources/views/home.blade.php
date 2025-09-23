@extends('layouts.app')
{{-- Page background + glass card --}}
<div class="memorial-bg"></div>

<div class="container d-flex align-items-center justify-content-center min-vh-100 py-5">
  <div class="memorial-card shadow-lg">
    <div class="p-4 p-md-5">
      <h2 class="fw-bold text-center mb-2">Adaugă o amintire</h2>
      <p class="text-center text-muted mb-4">Împărtășește un gând, o poveste sau o fotografie video despre Dana.</p>

      @if (session('status'))
        <div class="alert alert-success text-center rounded-pill shadow-sm mb-4">{{ session('status') }}</div>
      @endif

      <form method="POST" action="{{ route('memories.store') }}" enctype="multipart/form-data" class="form-modern" novalidate>
        @csrf

        {{-- Nume si prenume (floating label style) --}}
        <div class="form-floating mb-3">
          <input type="text" class="form-control form-control-lg glass-input @error('name') is-invalid @enderror"
                 id="name" name="name" placeholder="Ex: Maria Popescu" value="{{ old('name') }}">
          <label for="name">Nume și prenume</label>
          @error('name') <div class="invalid-feedback d-block">{{ $message }}</div> @else
          <div class="form-text">Poți folosi și doar prenumele, dacă preferi.</div>
          @enderror
        </div>

        {{-- Relatie (floating) --}}
        <div class="form-floating mb-3">
          <input type="text" class="form-control form-control-lg glass-input @error('relation') is-invalid @enderror"
                 id="relation" name="relation" placeholder="Ex: prietenă, colegă, verișoară" value="{{ old('relation') }}">
          <label for="relation">Relația ta cu Dana</label>
          @error('relation') <div class="invalid-feedback d-block">{{ $message }}</div> @else
          <div class="form-text">Ex: prieten(ă), coleg(ă) de serviciu, verișoară, vecin(ă)</div>
          @enderror
        </div>

        {{-- Mesaj (floating textarea) --}}
        <div class="form-floating mb-3">
          <textarea class="form-control glass-input @error('message') is-invalid @enderror" placeholder="Scrie aici…"
                    id="message" name="message" style="height: 150px">{{ old('message') }}</textarea>
          <label for="message">Gândurile sau amintirea ta</label>
          @error('message') <div class="invalid-feedback d-block">{{ $message }}</div> @else
          <div class="form-text">Ce îți amintești cu drag despre Dana?</div>
          @enderror
        </div>

        {{-- Upload (custom file) --}}
        <div class="mb-3">
          <label for="media" class="form-label fw-semibold">Fotografie sau video (opțional)</label>
          <input class="form-control glass-input @error('media') is-invalid @enderror" type="file" id="media" name="media"
                 accept=".jpg,.jpeg,.png,.webp,.mp4,.mov,.avi">
          <div class="form-text">Acceptăm .jpg, .png, .webp, .mp4 (max 10MB).</div>
          @error('media') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
        </div>

        {{-- Consent --}}
        <div class="form-check mb-4">
          <input class="form-check-input" type="checkbox" value="1" id="consent" name="consent" {{ old('consent') ? 'checked' : '' }}>
          <label class="form-check-label" for="consent">
            Sunt de acord ca mesajul și fișierul atașat să fie publicate pe pagina memorială.
          </label>
          @error('consent') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
        </div>

        {{-- Submit --}}
        <button type="submit" class="btn btn-memorial w-100">
          Trimite amintirea <span class="btn-icon">→</span>
        </button>

        <p class="text-muted small text-center mt-3 mb-0">Amintirile apar după aprobare.</p>
      </form>
    </div>
  </div>
</div>
