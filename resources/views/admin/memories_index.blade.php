@extends('layouts.app')

@section('content')
<style>
/* Small, clean admin actions on top-right of each testimonial */
.admin-actions{
  display:flex; gap:8px; z-index:2;
}
.admin-actions form{ display:inline; }
.admin-actions .btn{
  padding:.3rem .55rem; font-size:.85rem; border-radius:8px;
}
.badge-soft{display:inline-block;background:rgba(49,130,206,.1);color:#3182ce;font-size:12px;padding:4px 10px;border-radius:20px;font-weight:600;margin-left:6px}
.container-mem {max-width: 960px; margin: 0 auto; padding: 24px 16px;}
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

<div class="container-mem">
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
      $shortSummary = \Illuminate\Support\Str::limit($memory->message, 90);
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
</script>
@endsection
