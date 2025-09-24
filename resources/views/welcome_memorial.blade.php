@extends('layouts.app')
@section('body-class', 'no-scroll')
@section('content')
<style>
h2 {
  font-family: 'Cormorant Garamond', serif;
  font-weight: 600;
  font-size: 2rem;
}
p {
  font-family: 'Cormorant Garamond', serif;
  font-weight: 400;
}
</style>
<div class="wrapper-slider">
  <div class="swiper main-slider">
    <div class="swiper-wrapper">
      <div class="swiper-slide">
        <div class="item">
          <video autoplay loop muted playsinline poster="">
              <source src="https://codeforgestack.com/memorial/uploads/h52PPf2Z.mp4" type="video/mp4">
              Browserul tău nu suportă video.
            </video>
          <div class="parent-text">
            <div class="info-text">
              <h2>În memoria Danei</h2>
              <p>O pagină dedicată amintirii și poveștilor celor dragi.</p>
               <div class="cta-row">
                <a href="{{ route('memories.form') }}">Adaugă o amintire</a>
                <a href="{{ route('memories.index') }}">Vezi ce au spus alții</a>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="swiper-slide">
        <div class="item">
          <div class="video">
           <video autoplay loop muted playsinline poster="">
              <source src="https://codeforgestack.com/memorial/uploads/KNaJnnbL.mp4" type="video/mp4">
              Browserul tău nu suportă video.
            </video>
          </div>
          <div class="parent-text">
            <div class="info-text">
              <h2>În memoria Danei</h2>
              <p>O pagină dedicată amintirii și poveștilor celor dragi.</p>
              <div class="cta-row">
                <a href="{{ route('memories.form') }}">Adaugă o amintire</a>
                <a href="{{ route('memories.index') }}">Vezi ce au spus alții</a>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="swiper-slide">
        <div class="item">
          <video autoplay loop muted playsinline poster="">
              <source src="https://codeforgestack.com/memorial/uploads/h52PPf2Z.mp4" type="video/mp4">
              Browserul tău nu suportă video.
            </video>
          <div class="parent-text">
            <div class="info-text">
               <h2>În memoria Danei</h2>
              <p>O pagină dedicată amintirii și poveștilor celor dragi.</p>
              <div class="cta-row">
                <a href="{{ route('memories.form') }}">Adaugă o amintire</a>
                <a href="{{ route('memories.index') }}">Vezi ce au spus alții</a>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="swiper-slide">
        <div class="item">
           <video autoplay loop muted playsinline poster="">
              <source src="https://codeforgestack.com/memorial/uploads/KNaJnnbL.mp4" type="video/mp4">
              Browserul tău nu suportă video.
            </video>
          <div class="parent-text">
            <div class="info-text">
               <h2>În memoria Danei</h2>
              <p>O pagină dedicată amintirii și poveștilor celor dragi.</p>
              <div class="cta-row">
                <a href="{{ route('memories.form') }}">Adaugă o amintire</a>
                <a href="{{ route('memories.index') }}">Vezi ce au spus alții</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="swiper-pagination"></div>
  </div>
</div>

{{-- <div class="container py-5"> --}}

    {{-- Section with picture/slider --}}
    {{-- <div class="text-center mb-5">
        <h1 class="display-4">În memoria Danei</h1>
        <p class="lead">O pagină dedicată amintirii și poveștilor celor dragi.</p>
    </div> --}}
{{-- 
    <div id="memorialCarousel" class="carousel slide mb-5" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="{{ asset('images/dana1.jpg') }}" class="d-block w-100 rounded shadow" alt="Dana">
            </div>
            <div class="carousel-item">
                <img src="{{ asset('images/dana2.jpg') }}" class="d-block w-100 rounded shadow" alt="Dana">
            </div>
            <div class="carousel-item">
                <img src="{{ asset('images/dana3.jpg') }}" class="d-block w-100 rounded shadow" alt="Dana">
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#memorialCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#memorialCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
        </button>
    </div> --}}

    {{-- Button to go to form --}}
    {{-- <div class="text-center">
        <a href="{{ route('memories.form') }}" class="btn btn-primary btn-lg">
            Adaugă o amintire
        </a>
    </div> --}}
{{-- </div> --}}
@endsection


<script>
document.addEventListener('DOMContentLoaded', function () {
  const sliders = document.querySelectorAll('.main-slider');

  sliders.forEach((sliderEl) => {
    const parent = sliderEl.closest('.wrapper-slider');
    const paginationEl = parent.querySelector('.swiper-pagination');

    let progress = 0;
    const duration = 6000; // ms per slide
    let isPlaying = true;
    let startTime;
    let rafId;
    let swiper;

    const playSVG = `<svg xmlns="http://www.w3.org/2000/svg" class="svg-icon" viewBox="0 0 24 24" width="18" height="18"><path fill="currentColor" d="M8 5v14l11-7z"/></svg>`;
    const pauseSVG = `<svg xmlns="http://www.w3.org/2000/svg" class="svg-icon" viewBox="0 0 24 24" width="18" height="18"><path fill="currentColor" d="M6 19h4V5H6zm8-14v14h4V5h-4z"/></svg>`;

    swiper = new Swiper(sliderEl, {
      effect: 'fade',
      speed: 1000,
      loop: true,
      fadeEffect: { crossFade: true },
      pagination: {
        el: paginationEl,
        clickable: true,
        renderBullet: function (index, className) {
          return `<span class="${className}" data-index="${index}">
                    <span class="number">${index + 1}</span>
                  </span>`;
        }
      },
      on: {
        init(sw) {
          swiper = sw;
          startCustomAutoplay();
          resetLoaders();
        },
        slideChangeTransitionStart() {
          progress = 0;
          startTime = performance.now();
          resetLoaders();
        }
      }
    });

    function startCustomAutoplay() {
      startTime = performance.now();
      loop();
    }

    function loop(now) {
      if (!isPlaying) return;
      if (!startTime) startTime = now || performance.now();
      const elapsed = (now || performance.now()) - startTime;
      progress = Math.min((elapsed / duration) * 100, 100);
      updateLoader(swiper.realIndex, Math.round(progress));
      if (progress >= 100) {
        swiper.slideNext();
        progress = 0;
        startTime = performance.now();
      }
      rafId = requestAnimationFrame(loop);
    }

    function pauseAutoplay() {
      isPlaying = false;
      cancelAnimationFrame(rafId);
    }

    function resumeAutoplay() {
      isPlaying = true;
      startTime = performance.now() - (progress / 100) * duration;
      loop();
    }

    function resetLoaders() {
      const bullets = paginationEl.querySelectorAll('.swiper-pagination-bullet');
      bullets.forEach((bullet, i) => {
        const isActive = bullet.classList.contains('swiper-pagination-bullet-active');
        if (isActive) {
          bullet.innerHTML = `
            <div class="bullet-content" style="position:relative; display:flex; align-items:center; justify-content:center;">
              <button type="button" class="playpause-btn" style="position:absolute; z-index:2; background:transparent; border:0; color:#fff; cursor:pointer;">
                ${isPlaying ? pauseSVG : playSVG}
              </button>
              <div class="percentage show" style="--p: ${progress}%"></div>
            </div>
          `;
          const btn = bullet.querySelector('.playpause-btn');
          btn.addEventListener('click', (e) => {
            e.stopPropagation();
            if (isPlaying) {
              pauseAutoplay(); btn.innerHTML = playSVG;
            } else {
              resumeAutoplay(); btn.innerHTML = pauseSVG;
            }
          });
        } else {
          const index = bullet.dataset.index;
          bullet.innerHTML = `<span class="number">${parseInt(index, 10) + 1}</span>`;
        }
      });
    }

    function updateLoader(index, percent) {
      const bullet = paginationEl.querySelectorAll('.swiper-pagination-bullet')[index];
      if (!bullet) return;
      const ring = bullet.querySelector('.percentage');
      if (ring) ring.style.setProperty('--p', `${percent}%`);
    }
  });
});
</script>
