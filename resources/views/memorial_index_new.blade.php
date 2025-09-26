@extends('layouts.app')
<!--@section('body-class', 'bg-floral')-->

@section('body-class', 'bg-memories')
@section('no-wrapper', true)
@section('content')
<style>
/* === Styles adapted from your example (trimmed a bit for brevity) === */
*{box-sizing:border-box}

body.bg-floral {
  min-height:100dvh;
  background: linear-gradient(180deg, #f6ebe7 0%, #f8f1ee 40%, #f4e7e2 100%); /* warm fallback */
  background-image: url('/memorial/public/uploads/bg-floral-new22.png');
  background-size: cover;
  background-position: center;
  background-repeat: no-repeat;
  color:#2c3e50;  
  background-attachment: scroll;
  background-attachment: fixed;
}
/* Kill Breeze/Tailwind page wrapper background so body shows through */
body.bg-floral .min-h-screen,
body.bg-floral .bg-gray-100,
body.bg-floral .dark\:bg-gray-900 {
  background-color: transparent !important;
}
.container-mem {max-width: 720px; margin: 0 auto; padding: 30px 16px;}
.header {text-align:center;margin-bottom:32px}
.header h1{font-size:32px;color:#1a365d;font-weight:600;margin-bottom:12px;position:relative;display:inline-block}
.header h1::after{content:"";position:absolute;bottom:-8px;left:50%;transform:translateX(-50%);width:80px;height:3px;background:linear-gradient(90deg,#3182ce,#63b3ed);border-radius:2px}
.tagline{font-size:16px;color:#718096;max-width:520px;margin:0 auto;line-height:1.6}

.testimonial{margin-bottom:16px;background: rgba(255,255,255, 0.3);backdrop-filter: blur(30px);border-radius:10px;overflow:hidden;box-shadow:0 4px 10px rgba(0,0,0,.05);position:relative;transition:transform .25s}
.testimonial:hover{transform:translateY(-2px)}
.testimonial-header{padding:16px 18px;cursor:pointer;display:flex;align-items:center;justify-content:space-between;border-bottom:1px solid transparent;position:relative;z-index:1}
.testimonial.active .testimonial-header{border-bottom-color:#e2e8f0}
.thc{display:flex;align-items:center;gap:14px;flex:1}
.avatar{width:48px;height:48px;border-radius:50%;object-fit:cover;border:2px solid #e2e8f0;transition:transform .25s}
.testimonial.active .avatar{transform:scale(1.06);border-color:#3182ce}
.meta{flex:1;min-width:0}
.name{font-weight:700;font-size:15px;color:#2d3748}
.pos{font-size:12px;color:#718096}
.summary{font-size:14px;color:#4a5568;margin-top:6px;line-height:1.45;font-style:italic;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}

.toggle{width:24px;height:24px;position:relative}
.toggle::before,.toggle::after{content:"";position:absolute;background:#3182ce;transition:all .2s}
.toggle::before{width:2px;height:14px;top:5px;left:11px;opacity:1}
.toggle::after{width:14px;height:2px;top:11px;left:5px}
.testimonial.active .toggle::before{opacity:0;transform:rotate(90deg)}

.content{max-height:0;overflow:hidden;transition:max-height .45s cubic-bezier(.4,0,.2,1);background:#fff;padding:0 18px;background: rgba(255,255,255, 0.3);
  backdrop-filter: blur(30px);}
.inner{padding:16px 0 20px;opacity:0;transform:translateY(6px);transition:opacity .25s,transform .25s}
.testimonial.active .inner{opacity:1;transform:translateY(0)}

.quote{font-size:15px;line-height:1.7;color:#4a5568;margin-bottom:14px;position:relative;padding-left:16px;border-left:3px solid #3182ce;white-space:pre-wrap}

.media-wrap{margin-top:10px}
.media-wrap img{max-width:100%;height:auto;border-radius:8px;box-shadow:0 6px 18px rgba(0,0,0,.06)}
.media-wrap video{max-width:100%;border-radius:8px;box-shadow:0 6px 18px rgba(0,0,0,.06)}

.badge-soft{display:inline-block;background:rgba(49,130,206,.1);color:#3182ce;font-size:12px;padding:4px 10px;border-radius:20px;font-weight:600;margin-right:6px}
.time{font-size:12px;color:#718096;margin-top:8px}

@media (max-width: 600px){
  .container-mem{padding:20px 12px}
  .avatar{width:42px;height:42px}
  .summary{display:none}
}

/* base: closed state animates nicely */
.content{
  max-height: 0;
  overflow: hidden;
  transition: max-height .45s cubic-bezier(.4,0,.2,1);
}

/* when we cap long ones, allow internal scroll */
.content.scrollable{
  overflow: auto;
  overscroll-behavior: contain;
  -webkit-overflow-scrolling: touch;
  padding-right: 4px;        /* avoid text under scrollbar on desktop */
  border-radius: 8px;
}

/* (optional) slim scrollbar */
.content.scrollable::-webkit-scrollbar{ width: 8px; }
.content.scrollable::-webkit-scrollbar-thumb{
  background: rgba(0,0,0,.2);
  border-radius: 8px;
}


</style>

<div class="container-mem">
  <div class="header">
    <h1>Amintiri de la cei dragi</h1>
    <p class="tagline">Mesaje, gânduri și fotografii încărcate de prieteni și familie pentru Dana.</p>
  </div>
  <a href="{{ route('homepage') }}" class="home-icon" title="Înapoi la pagina principală" style="font-size: 25px;
  text-align: center;
  margin: 0 auto;
  display: table;">
      <i class="fas fa-home"></i>
    </a>

  @forelse($memories as $memory)
    @php
      $isImage = $memory->media_mime && str_starts_with($memory->media_mime, 'image/');
      $isVideo = $memory->media_mime && str_starts_with($memory->media_mime, 'video/');
      $mediaUrl = $memory->media_path ? asset('storage/'.$memory->media_path) : null;
      $initial = strtoupper(mb_substr($memory->name ?: 'Anonim', 0, 1));
      $shortSummary = \Illuminate\Support\Str::limit($memory->message, 90);
    @endphp

    <div class="testimonial">
      <div class="testimonial-header">
        <div class="thc">
          {{-- Avatar: uploaded image if available & image file, else generated initials circle --}}
          @if($isImage && $mediaUrl)
            <img src="{{ $mediaUrl }}" class="avatar" alt="foto {{ $memory->name ?? 'anonim' }}">
          @else
            <div class="avatar d-flex align-items-center justify-content-center"
                 style="background:#ebf8ff;color:#2b6cb0;font-weight:800;">
              {{ $initial }}
            </div>
          @endif

          <div class="meta">
            <div class="name">{{ $memory->name ?: 'Anonim' }}</div>
            <div class="pos">
              {{ $memory->relation }}
            </div>
            <div class="summary">“{{ $shortSummary }}”</div>
          </div>
        </div>
        <div class="toggle"></div>
      </div>

      <div class="content">
        <div class="inner">
          <div class="quote">“{{ $memory->message }}”</div>

          {{-- Media full view (prefer: if image was used as avatar, show it here too but larger; if video, show player) --}}
          @if($mediaUrl)
            <div class="media-wrap">
              @if($isImage)
                <img src="{{ $mediaUrl }}" alt="Media atașată">
              @elseif($isVideo)
                <video src="{{ $mediaUrl }}" controls preload="metadata"></video>
              @else
                <a href="{{ $mediaUrl }}" target="_blank" rel="noopener">Deschide fișierul atașat</a>
              @endif
            </div>
          @endif

          <div class="time">
            Publicat pe {{ $memory->created_at->format('d.m.Y H:i') }}
           
          </div>
        </div>
      </div>
    </div>
  @empty
    <div class="alert alert-info">Încă nu există amintiri publicate.</div>
  @endforelse

  <div class="mt-3">
    
  </div>
</div>

<script>
// document.addEventListener('DOMContentLoaded', () => {
//   const cards = document.querySelectorAll('.testimonial');
//   cards.forEach(card => {
//     const header = card.querySelector('.testimonial-header');
//     const content = card.querySelector('.content');
//     const inner = card.querySelector('.inner');

//     // start collapsed
//     content.style.maxHeight = '0px';

//     header.addEventListener('click', () => {
//       const isActive = card.classList.contains('active');

//       // close others
//       cards.forEach(c => {
//         if (c !== card) {
//           c.classList.remove('active');
//           const cc = c.querySelector('.content');
//           if (cc) cc.style.maxHeight = '0px';
//         }
//       });

//       if (!isActive) {
//         card.classList.add('active');
//         // Wait next frame to read correct height
//         requestAnimationFrame(() => {
//           content.style.maxHeight = inner.offsetHeight + 'px';
//         });
//       } else {
//         card.classList.remove('active');
//         content.style.maxHeight = '0px';
//       }
//     });
//   });
// });

// content.style.maxHeight = inner.offsetHeight + 'px';


// document.addEventListener('DOMContentLoaded', () => {
//   const cards = document.querySelectorAll('.testimonial');

//   cards.forEach(card => {
//     const header  = card.querySelector('.testimonial-header');
//     const content = card.querySelector('.content');
//     const inner   = card.querySelector('.inner');

//     content.style.maxHeight = '0px';

//     header.addEventListener('click', (e) => {
//       if (e.target.closest('.admin-actions')) return; // ignore clicks on buttons

//       const isActive = card.classList.contains('active');

//       // close others
//       cards.forEach(c => {
//         if (c !== card) {
//           c.classList.remove('active');
//           const cc = c.querySelector('.content');
//           if (cc) { cc.style.maxHeight = '0px'; cc.classList.remove('scrollable'); }
//         }
//       });

//       if (!isActive) {
//         card.classList.add('active');

//         // cap height to 70% of viewport so page doesn't stretch
//         requestAnimationFrame(() => {
//           const cap = Math.floor(window.innerHeight * 0.7);
//           const desired = inner.offsetHeight;
//           const maxH = Math.min(desired, cap);
//           content.style.maxHeight = maxH + 'px';
//           content.classList.toggle('scrollable', desired > cap);
//         });
//       } else {
//         card.classList.remove('active');
//         content.style.maxHeight = '0px';
//         content.classList.remove('scrollable');
//       }
//     });
//   });
// });


</script>

<script>
document.addEventListener('DOMContentLoaded', () => {
  const cards = document.querySelectorAll('.testimonial');

  function closeCard(card){
    const content = card.querySelector('.content');
    if (!content) return;
    card.classList.remove('active');
    content.style.maxHeight = '0px';
    content.classList.remove('scrollable');
  }

  function openCard(card){
    const content = card.querySelector('.content');
    if (!content) return;

    card.classList.add('active');

    // Let the browser lay out the content once before measuring
    requestAnimationFrame(() => {
      const cap = Math.floor(window.innerHeight * 0.7);     // 70% viewport cap
      const desired = content.scrollHeight;                  // reliable full height
      const maxH = Math.min(desired, cap);

      content.style.maxHeight = maxH + 'px';
      content.classList.toggle('scrollable', desired > cap);
    });
  }

  cards.forEach(card => {
    const header  = card.querySelector('.testimonial-header');
    const content = card.querySelector('.content');

    if (content) content.style.maxHeight = '0px';

    if (!header) return;
    header.addEventListener('click', (e) => {
      // ignore clicks on admin buttons/links
      if (e.target.closest('.admin-actions')) return;

      const isActive = card.classList.contains('active');

      // close others
      cards.forEach(c => { if (c !== card) closeCard(c); });

      // toggle current
      if (isActive) closeCard(card);
      else openCard(card);
    });
  });

  // Recalculate height for the one that's open on resize
  window.addEventListener('resize', () => {
    const open = document.querySelector('.testimonial.active .content');
    if (!open) return;
    const cap = Math.floor(window.innerHeight * 0.7);
    const desired = open.scrollHeight;
    open.style.maxHeight = Math.min(desired, cap) + 'px';
    open.classList.toggle('scrollable', desired > cap);
  });
});
</script>

@endsection
