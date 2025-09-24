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
/* keep actions compact on all sizes */
.admin-actions {
  display:flex;
  gap:8px;
  flex-wrap:wrap;
}
.admin-actions .btn{
  padding:.35rem .6rem;
  font-size:.9rem;
  border-radius:999px; /* pills */
}

/* mobile layout */
@media (max-width: 560px){
  .testimonial-header{
    display:flex;
    align-items:flex-start;
    flex-wrap:wrap;             /* allow lines */
    row-gap:.25rem;
  }
  .thc{ order:1; min-width:0; } /* avatar + meta first */
  .toggle{ order:2; margin-left:auto; }

  /* move actions under meta, full width */
  .admin-actions{
    order:3;
    width:100%;
    justify-content:flex-start;
    margin-top:.5rem;
    gap:.5rem;
  }
  .admin-actions .btn{
    font-size:.9rem;
    padding:.4rem .7rem;
  }

  /* optional: calm the header on tiny screens */
  .summary{ display:none; }            /* hide the teaser line */
  .avatar{ width:42px; height:42px; }  /* slightly smaller avatar */
}

/* ultra small phones */
@media (max-width: 380px){
  .admin-actions .btn{
    flex:1 1 auto;         /* let buttons share the row */
    text-align:center;
  }
}

.badge-soft{display:inline-block;background:rgba(49,130,206,.1);color:#3182ce;font-size:12px;padding:4px 10px;border-radius:20px;font-weight:600;margin-left:6px}
.container-mem {width: 100%; margin: 0 auto; padding: 24px 16px;}
.testimonial{margin-bottom:16px;background:#fff;border-radius:10px;overflow:hidden;box-shadow:0 4px 10px rgba(0,0,0,.05);position:relative;transition:transform .25s}
.testimonial:hover{transform:translateY(-2px)}
.testimonial-header{padding:16px 18px;cursor:pointer;display:flex;align-items:center;justify-content:space-between;border-bottom:1px solid transparent;position:relative}
.testimonial.active .testimonial-header{border-bottom-color:#e2e8f0}
.thc{display:flex;align-items:center;gap:14px;flex:1}
.avatar{width:48px;height:48px;border-radius:50%;object-fit:cover;border:2px solid #e2e8f0}
.meta{flex:1;min-width:0}
.name{font-weight:700;font-size:15px;color:#2d3748}
.pos{font-size:12px;color:#718096}
.summary{font-size:14px;color:#4a5568;margin-top:6px;line-height:1.45;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
.toggle{width:24px;height:24px;position:relative}
.toggle::before,.toggle::after{content:"";position:absolute;background:#3182ce}
.toggle::before{width:2px;height:14px;top:5px;left:11px}
.toggle::after{width:14px;height:2px;top:11px;left:5px}
.testimonial.active .toggle::before{opacity:0}
.content{max-height:0;overflow:hidden;transition:max-height .45s cubic-bezier(.4,0,.2,1);background:#fff;padding:0 18px}
.inner{padding:16px 0 20px;opacity:0;transform:translateY(6px);transition:opacity .25s,transform .25s}
.testimonial.active .inner{opacity:1;transform:translateY(0)}
.quote{font-size:15px;line-height:1.7;color:#4a5568;margin-bottom:14px;position:relative;padding-left:16px;border-left:3px solid #3182ce;white-space:pre-wrap}
.media-wrap img, .media-wrap video{max-width:100%;border-radius:8px;box-shadow:0 6px 18px rgba(0,0,0,.06)}
.status-dot{width:8px;height:8px;border-radius:50%;display:inline-block;margin-right:6px}
.status-pending{background:#eab308}
.status-approved{background:#16a34a}
.status-rejected{background:#ef4444}
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

<div class="container-mem">
<div class="topbar">
      <button class="toggle-btn" aria-label="Deschide meniul" onclick="toggleSidebar(true)">☰</button>
      <div>
        <h1 class="panou-ttl fw-bold m-0">📊 Panou Administrare</h1>
        <small class="text-muted">Bun venit! Aici poți aproba, edita și gestiona amintirile.</small>
      </div>
    </div>
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="mb-0">Moderare amintiri</h3>
    <a href="{{ route('memories.index') }}" class="btn btn-outline-secondary">Vezi pagina publică</a>
  </div>

  @if (session('status'))
    <div class="alert alert-success">{{ session('status') }}</div>
  @endif

  @forelse($memories as $memory)
    @php
      $isImage = $memory->media_mime && str_starts_with($memory->media_mime, 'image/');
      $isVideo = $memory->media_mime && str_starts_with($memory->media_mime, 'video/');
      $mediaUrl = $memory->media_path ? asset('storage/'.$memory->media_path) : null;
      $initial = strtoupper(mb_substr($memory->name ?: 'Anonim', 0, 1));
      $shortSummary = \Illuminate\Support\Str::limit($memory->message, 50);
      $dotClass = $memory->status === 'approved' ? 'status-approved' : ($memory->status === 'rejected' ? 'status-rejected' : 'status-pending');
    @endphp

    <div class="testimonial">
      <div class="testimonial-header">
        <div class="thc">
          @if($isImage && $mediaUrl)
            <img src="{{ $mediaUrl }}" class="avatar" alt="foto {{ $memory->name ?? 'anonim' }}">
          @else
            <div class="avatar d-flex align-items-center justify-content-center" style="background:#ebf8ff;color:#2b6cb0;font-weight:800;">
              {{ $initial }}
            </div>
          @endif

          <div class="meta">
            <div class="name">
              {{ $memory->name ?: 'Anonim' }}
              <span class="badge-soft">
                <span class="status-dot {{ $dotClass }}"></span>{{ $memory->status }}
              </span>
            </div>
            <div class="pos">{{ $memory->relation }}</div>
            <div class="summary">“{{ $shortSummary }}”</div>
          </div>
        </div>

        <div class="admin-actions">
          @if($memory->status !== 'approved')
            <form method="POST" action="{{ route('admin.memories.approve', $memory) }}">
              @csrf @method('PATCH')
              <button class="btn btn-success btn-sm">Approve</button>
            </form>
          @endif

          <a class="btn btn-primary btn-sm" href="{{ route('admin.memories.edit', $memory) }}">Edit</a>

          <form method="POST" action="{{ route('admin.memories.destroy', $memory) }}" onsubmit="return confirm('Ștergi această amintire?');">
            @csrf @method('DELETE')
            <button class="btn btn-danger btn-sm">Delete</button>
          </form>
        </div>

        <div class="toggle"></div>
      </div>

      <div class="content">
        <div class="inner">
          <div class="quote">“{{ $memory->message }}”</div>
          @if($mediaUrl)
            <div class="media-wrap mb-2">
              @if($isImage)
                <img src="{{ $mediaUrl }}" alt="Media atașată">
              @elseif($isVideo)
                <video src="{{ $mediaUrl }}" controls preload="metadata"></video>
              @else
                <a href="{{ $mediaUrl }}" target="_blank" rel="noopener">Deschide fișierul atașat</a>
              @endif
            </div>
          @endif
          <div class="text-muted small">IP: {{ $memory->ip ?? 'n/a' }} · {{ $memory->created_at->format('d.m.Y H:i') }}</div>
        </div>
      </div>
    </div>
  @empty
    <div class="alert alert-info">Nu există amintiri.</div>
  @endforelse

  <div class="mt-3">
    {{ $memories->links() }}
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded',()=> {
  const cards = document.querySelectorAll('.testimonial');
  cards.forEach(card=>{
    const header = card.querySelector('.testimonial-header');
    const content = card.querySelector('.content');
    const inner = card.querySelector('.inner');
    content.style.maxHeight = '0px';
    header.addEventListener('click', (e)=>{
      // ignore clicks on admin buttons
      if (e.target.closest('.admin-actions')) return;
      const isActive = card.classList.contains('active');
      cards.forEach(c=>{
        if (c!==card){ c.classList.remove('active'); c.querySelector('.content').style.maxHeight='0px'; }
      });
      if (!isActive){ card.classList.add('active'); requestAnimationFrame(()=>{ content.style.maxHeight = inner.offsetHeight+'px'; }); }
      else { card.classList.remove('active'); content.style.maxHeight='0px'; }
    });
  });
});


  function toggleSidebar(open){
    const sb=document.getElementById('sidebar');
    const bd=document.getElementById('sidebarBackdrop');
    const willOpen=(open===true)?true:(open===false?false:!sb.classList.contains('open'));
    sb.classList.toggle('open', willOpen); bd.classList.toggle('show', willOpen);
  }
  document.addEventListener('keydown', e => { if (e.key==='Escape') toggleSidebar(false); });

</script>
@endsection
