@extends('layouts.app')

@section('title', 'Politica de confidențialitate')

@section('content')
<div class="container py-5" style="max-width: 900px;">
  <h1 class="mb-3">Politica de confidențialitate</h1>
  <p class="text-muted">Ultima actualizare: {{ now()->format('d.m.Y') }}</p>

  <h2 class="h5 mt-4">1. Cine suntem</h2>
  <p>Acest site („Memorial Dana”) este o pagină memorială unde prietenii și familia pot împărtăși amintiri, mesaje și fotografii.</p>

  <h2 class="h5 mt-4">2. Ce date colectăm</h2>
  <ul>
    <li><strong>Date furnizate de tine</strong>: nume (sau pseudonim), relația cu persoana comemorată, mesajul tău, opțional imagine/video.</li>
    <li><strong>Date tehnice</strong>: adresa IP, tipul dispozitivului/navigatorului, paginile vizitate (în scop de securitate și funcționare).</li>
  </ul>

  <h2 class="h5 mt-4">3. Scopurile prelucrării</h2>
  <ul>
    <li>Publicarea amintirilor pe pagina memorială (după aprobare).</li>
    <li>Moderare și prevenirea abuzurilor.</li>
    <li>Asigurarea funcționării site-ului (ex. autentificare, protecție CSRF, sesiune).</li>
  </ul>

  <h2 class="h5 mt-4">4. Temeiul legal</h2>
  <ul>
    <li><strong>Consimțământ</strong> – pentru publicarea mesajului și a fișierelor încărcate.</li>
    <li><strong>Interes legitim</strong> – pentru securitate, moderare și funcționarea site-ului.</li>
  </ul>

  <h2 class="h5 mt-4">5. Cookie-uri & stocări locale</h2>
  <p>Folosim cookie-uri strict necesare și stocare locală pentru funcționare și pentru reținerea opțiunii tale privind cookie-urile.</p>
  <div class="table-responsive">
    <table class="table">
      <thead><tr><th>Nume</th><th>Tip</th><th>Scop</th><th>Durată</th></tr></thead>
      <tbody>
        <tr><td>laravel_session</td><td>Cookie necesar</td><td>Menține sesiunea utilizatorului</td><td>pe durata sesiunii</td></tr>
        <tr><td>XSRF-TOKEN</td><td>Cookie necesar</td><td>Protecție CSRF la formulare</td><td>pe durata sesiunii</td></tr>
        <tr><td>cookiesChoice</td><td>localStorage</td><td>Memorează Accept/Refuz pentru bannerul GDPR</td><td>până la ștergerea manuală</td></tr>
      </tbody>
    </table>
  </div>
  <p>Putem folosi resurse terțe încărcate de pe CDN (ex. Bootstrap/Swiper/Google Fonts). Acestea pot primi adresa ta IP pentru a livra fișierele.</p>

  <h2 class="h5 mt-4">6. Stocarea și securitatea datelor</h2>
  <p>Fișierele încărcate sunt stocate în infrastructura serverului nostru. Aplicăm măsuri tehnice rezonabile (limitarea accesului, actualizări, loguri). Totuși, nicio platformă nu poate garanta securitate 100%.</p>

  <h2 class="h5 mt-4">7. Perioada de păstrare</h2>
  <ul>
    <li>Mesaje/fișiere publicate: pe durata existenței paginii memoriale sau până la solicitarea de ștergere.</li>
    <li>Date tehnice/loguri: perioadă limitată, necesară pentru securitate și diagnostic.</li>
  </ul>

  <h2 class="h5 mt-4">8. Drepturile tale (GDPR)</h2>
  <ul>
    <li>Dreptul de acces, rectificare, ștergere.</li>
    <li>Restricționare/opoziție la prelucrare, acolo unde este cazul.</li>
    <li>Retragerea consimțământului pentru publicarea conținutului.</li>
    <li>Plângere la ANSPDCP, dacă consideri necesar.</li>
  </ul>

  <h2 class="h5 mt-4">9. Cum poți exercita drepturile</h2>
  <p>Ne poți contacta la <a href="mailto:hello@codeforgestack.com">hello@codeforgestack.com</a>. Pentru solicitările legate de ștergerea conținutului, te rugăm să indici mesajul/fișierul și motivul.</p>

  <h2 class="h5 mt-4">10. Modificări</h2>
  <p>Putem actualiza această politică periodic. Versiunea curentă este disponibilă permanent pe această pagină.</p>

  <hr class="my-4">
  <p class="small text-muted">Această pagină are scop informativ și nu reprezintă consultanță juridică.</p>
</div>
@endsection
