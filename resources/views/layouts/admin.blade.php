@extends('layouts.app')

@section('content')
<style>
  /* Layout */
  .admin-layout{display:flex;min-height:100vh;background:#f8fafc}
  /* Sidebar */
  .sidebar{
    width:260px;background:#0f172a;color:#fff;flex-shrink:0;
    display:flex;flex-direction:column;transition:transform .3s;min-height:100vh
  }
  .nav-link{font-size:20px;}
  .sidebar-header{display:flex;align-items:center;gap:.5rem;padding:1rem 1.25rem;
    font-weight:700;background:#111827;border-right:1px solid rgba(255,255,255,.05);font-size:25px;}
  .sidebar .nav-link,.sidebar button.nav-link{
    display:flex;align-items:center;gap:.6rem;padding:.65rem 1rem;color:#fff!important;
    text-decoration:none;width:100%;border:0;background:transparent;border-radius:.5rem;margin:.15rem .5rem
  }
  .sidebar .nav-link:hover,.sidebar button.nav-link:hover{background:#1e293b}
  .sidebar .nav-link.active{background:#334155}

  /* Content */
  .content{flex:1;padding:1rem}
  .topbar{display:flex;align-items:center;gap:.75rem;margin-bottom:1rem}
  .toggle-btn{display:none;border:0;background:#0f172a;color:#fff;border-radius:.5rem;padding:.5rem .75rem;font-size:1.1rem}

  /* Mobile */
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
  {{-- Sidebar --}}
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

  {{-- Backdrop for mobile --}}
  <div class="backdrop" id="sidebarBackdrop" onclick="toggleSidebar(false)"></div>

  {{-- Content --}}
  <main class="content">
    <div class="topbar">
      <button class="toggle-btn" aria-label="Deschide meniul" onclick="toggleSidebar(true)">☰</button>
      <div>
        <h1 class="fw-bold m-0">@yield('admin-title','📊 Panou Administrare')</h1>
        <small class="text-muted">@yield('admin-subtitle','Bun venit! Aici poți aproba, edita și gestiona amintirile.')</small>
      </div>
    </div>

    @yield('admin-content')
  </main>
</div>

<script>
  function toggleSidebar(open){
    const sb=document.getElementById('sidebar');
    const bd=document.getElementById('sidebarBackdrop');
    const willOpen=(open===true)?true:(open===false?false:!sb.classList.contains('open'));
    sb.classList.toggle('open', willOpen);
    bd.classList.toggle('show', willOpen);
  }
  document.addEventListener('keydown', e => { if (e.key==='Escape') toggleSidebar(false); });
</script>
@endsection
