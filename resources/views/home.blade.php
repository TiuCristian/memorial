@extends('layouts.app')
@section('body-class', 'bg-form')
<style>
/* ===== Palette =====
   Soft floral: peony/rose + cream + dusty blue accents */
:root{
  --rose-50:#fff7f8;
  --rose-100:#ffe9ec;
  --rose-200:#ffd5db;
  --rose-300:#ffbac4;
  --rose-400:#ff99ab;
  --rose-500:#f16e86;
  --rose-600:#d4546d;

  --cream-50:#fffdf9;
  --ink:#2c3e50;
  --muted:#6b7a8c;
  --leaf:#6aa492;
  --sky:#b7cde3;
}

/* ===== Background canvas with subtle floral pattern ===== */
.memorial-bg{
  min-height:100vh;
  background:
    radial-gradient(1200px 600px at 120% -10%, rgba(255,255,255,.6) 0%, transparent 70%),
    radial-gradient(900px 500px at -10% 110%, rgba(255,255,255,.6) 0%, transparent 70%),
    linear-gradient(180deg, var(--cream-50), var(--rose-50));
  position:relative;
  display:flex; align-items:flex-start;
  padding:32px 0 64px;
}

/* tiny watercolor florals as a super-light repeating pattern (data-URI SVG) */
.memorial-bg::before{
  content:"";
  position:fixed; inset:0; z-index:-1; opacity:.18;
  background-image:url("data:image/svg+xml,%3Csvg width='200' height='200' viewBox='0 0 200 200' xmlns='http://www.w3.org/2000/svg'%3E%3Cdefs%3E%3Cg id='f'%3E%3Cpath d='M26 22c8 3 12 12 9 20-4 10-17 11-24 5-8-7-6-21 4-25 3-1 7-1 11 0z' fill='%23ffd5db'/%3E%3Ccircle cx='14' cy='14' r='3' fill='%23f16e86'/%3E%3C/g%3E%3C/defs%3E%3Cuse href='%23f' x='10' y='8'/%3E%3Cuse href='%23f' x='110' y='20' transform='scale(0.9)'/%3E%3Cuse href='%23f' x='60' y='120' transform='scale(1.1)'/%3E%3C/svg%3E");
  background-size:220px 220px;
}

/* floating petals layer */
.petals{
  pointer-events:none; position:fixed; inset:0; z-index:0; opacity:.12;
  background:
    radial-gradient(20px 12px at 10% 20%, var(--rose-300), transparent 60%),
    radial-gradient(16px 10px at 80% 40%, var(--rose-200), transparent 60%),
    radial-gradient(24px 14px at 30% 70%, var(--rose-300), transparent 60%),
    radial-gradient(18px 12px at 70% 85%, var(--rose-200), transparent 60%);
  filter: blur(10px);
  animation: petalsFloat 16s ease-in-out infinite alternate;
}
@keyframes petalsFloat{
  from{ transform: translateY(0) }
  to  { transform: translateY(-10px) }
}

/* ===== Section container ===== */
.memorial-form{ position:relative; z-index:1; max-width:860px; }
.mf-header{ margin-bottom:18px }
.mf-badge{
  display:inline-block; font-weight:700; letter-spacing:.04em;
  background:linear-gradient(90deg, var(--rose-100), var(--rose-200));
  color:var(--rose-700, #a33d52); padding:.35rem .75rem; border-radius:999px;
  border:1px solid rgba(241,110,134,.25);
}
.mf-title{
  margin:10px 0 4px; font-size:clamp(1.5rem, 1.2rem + 1.5vw, 2.25rem);
  font-family: "Cormorant Garamond", serif;
  color:var(--ink); font-weight:600; letter-spacing:.01em;
}
.mf-sub{ color:var(--muted); max-width:46ch; margin-inline:auto }

/* ===== Card with floral corners ===== */
.mf-card{ border:0; border-radius:18px; background:rgba(255,255,255,.85); backdrop-filter: blur(6px) }
.mf-card .card-body{ position:relative }
.mf-corner{
  position:absolute; width:96px; height:96px; opacity:.25;
  background-size:contain; background-repeat:no-repeat;
}
.mf-corner--tl{ top:-6px; left:-6px;
  background-image:url("data:image/svg+xml,%3Csvg viewBox='0 0 120 120' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M6 80 C15 45 35 28 70 20 62 34 60 48 78 66 54 64 36 72 18 96 12 90 9 86 6 80z' fill='%23b7cde3'/%3E%3C/svg%3E");
}
.mf-corner--br{ bottom:-6px; right:-6px; transform:rotate(180deg);
  background-image:url("data:image/svg+xml,%3Csvg viewBox='0 0 120 120' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M6 80 C15 45 35 28 70 20 62 34 60 48 78 66 54 64 36 72 18 96 12 90 9 86 6 80z' fill='%23ffd5db'/%3E%3C/svg%3E");
}

/* ===== Inputs (Bootstrap-compatible) ===== */
.mf-card .form-label{ color:var(--ink); font-weight:600 }
.mf-card .form-control{
  background:#fff; border-radius:12px; border:1px solid #e6e9ef;
  box-shadow:none; transition:border-color .2s, box-shadow .2s;
}
.mf-card .form-control:focus{
  border-color:var(--rose-400);
  box-shadow:0 0 0 .25rem rgba(241,110,134,.15);
}
.mf-card textarea.form-control{ min-height:140px }
.mf-card .form-text{ color:#8393a6 }

/* ===== Buttons ===== */
.btn-rose{
  --bg: var(--rose-500);
  --bg-hover: var(--rose-600);
  background:var(--bg); border:0; color:#fff; padding:.75rem 1.25rem; border-radius:12px;
  box-shadow: 0 8px 16px rgba(241,110,134,.25);
}
.btn-rose:hover{ background:var(--bg-hover); color:#fff }
.btn-outline-rose{
  border:2px solid var(--rose-400); color:var(--rose-600); padding:.7rem 1.2rem; border-radius:12px; background:transparent;
}
.btn-outline-rose:hover{ background:var(--rose-100); color:var(--rose-600) }

/* consent checkbox spacing */
.mf-card .form-check-input:focus{ box-shadow:0 0 0 .2rem rgba(241,110,134,.15) }
.mf-card .form-check-label{ color:var(--muted) }

/* spacing tweaks on small screens */
@media (max-width: 576px){
  .memorial-bg{ padding:20px 0 40px }
  .mf-card{ border-radius:14px }
}

</style>
<div class="memorial-bg">
  <div class="petals"></div>

  <section class="memorial-form container">
    <header class="mf-header text-center">
      <span class="mf-badge">În memoria Danei</span>
      <h1 class="mf-title">Lasă un gând sau o amintire</h1>
      <p class="mf-sub">Un colț cald pentru povești, fotografii și mesaje din partea celor dragi.</p>
    </header>

    <div class="card mf-card shadow-lg">
      <div class="mf-corner mf-corner--tl" aria-hidden="true"></div>
      <div class="mf-corner mf-corner--br" aria-hidden="true"></div>

      <div class="card-body p-4 p-md-5">

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
    {{-- your existing form ENDS here --}}
      </div>
    </div>
  </section>
</div>