@extends('layouts.app')

@section('content')
<style>
  .admin-layout{display:flex;min-height:100vh;background:#f8fafc}
  .sidebar{width:260px;background:#0f172a;color:#fff;flex-shrink:0;display:flex;flex-direction:column;transition:transform .3s;min-height:100vh}
  .nav-link{font-size:20px}
  .sidebar-header{display:flex;align-items:center;gap:.5rem;padding:1rem 1.25rem;font-weight:700;background:#111827;border-right:1px solid rgba(255,255,255,.05);font-size:25px}
  .sidebar .nav-link,.sidebar button.nav-link{display:flex;align-items:center;gap:.6rem;padding:.65rem 1rem;color:#fff!important;text-decoration:none;width:100%;border:0;background:transparent;border-radius:.5rem;margin:.15rem .5rem}
  .sidebar .nav-link:hover,.sidebar button.nav-link:hover{background:#1e293b}
  .sidebar .nav-link.active{background:#334155}
  .content{flex:1;padding:1rem}
  .topbar{display:flex;align-items:center;gap:.75rem;margin-bottom:1rem}
  .toggle-btn{display:none;border:0;background:#0f172a;color:#fff;border-radius:.5rem;padding:.5rem .75rem;font-size:1.1rem}
  @media (max-width: 992px){
    .sidebar{position:fixed;top:0;left:0;height:100vh;z-index:1050;transform:translateX(-100%)}
    .sidebar.open{transform:translateX(0)}
    .backdrop{position:fixed;inset:0;background:rgba(0,0,0,.35);z-index:1040;display:none}
    .backdrop.show{display:block}
    .toggle-btn{display:inline-flex}
    .content{padding-top:.5rem}
  }
</style>
<div class="admin-layout">
  <aside class="sidebar" id="sidebar">
    <div class="sidebar-header"><span>⚙️</span><span>Panou Admin</span></div>
    <nav class="mt-2">
      <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">🏠 Dashboard</a>
      <a href="{{ route('admin.memories.index') }}" class="nav-link {{ request()->routeIs('admin.memories.*') ? 'active' : '' }}">📖 Amintiri</a>
      <form method="POST" action="{{ route('logout') }}" class="m-0">
        @csrf
        <button type="submit" class="nav-link">🚪 Delogare</button>
      </form>
    </nav>
  </aside>

  <div class="backdrop" id="sidebarBackdrop" onclick="toggleSidebar(false)"></div>

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
