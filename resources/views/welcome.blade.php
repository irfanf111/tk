@extends('layouts.app')
@section('title', 'TK Puspitasari Kaliwatubumi')
@section('content')
  @php
    use App\Models\HeroImage;
    use App\Models\Principal;
    use App\Models\Agenda;
    use App\Models\Article;
    use App\Models\Facility;
    use App\Models\Staff;

    $heroImages = HeroImage::where('is_active', true)->latest()->get();
    $principal = Principal::first();
    $agendas = Agenda::orderBy('event_date', 'asc')->take(5)->get();
    $articles = Article::latest('published_at')->take(4)->get();
    $facilities = Facility::all();
    $teachers = Staff::where('is_active', true)->orderBy('id')->get();
  @endphp

  <style>
    .keunggulan-card {
      transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .keunggulan-card:hover {
      transform: translateY(-8px);
      box-shadow: 0 16px 48px rgba(76, 175, 147, 0.18) !important;
      border-color: var(--color-primary) !important;
      background: linear-gradient(135deg, #fff 0%, #f8fdfb 100%) !important;
    }

    .home-slider {
      position: relative;
      overflow: hidden;
      height: 520px;
      border-radius: 0;
    }

    .home-slider::before {
      content: '';
      position: absolute;
      inset: 0;
      background: linear-gradient(135deg, rgba(26, 35, 50, 0.3) 0%, rgba(76, 175, 147, 0.1) 100%);
      z-index: 2;
      pointer-events: none;
    }

    .item-slide {
      position: absolute;
      inset: 0;
      background-size: cover;
      background-position: center;
      display: flex;
      align-items: center;
      opacity: 0;
      transition: opacity 1s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .item-slide.active {
      opacity: 1;
      z-index: 1;
    }

    .item-slide .container {
      max-width: 1200px;
      margin: 0 auto;
      padding: 0 20px;
      position: relative;
      z-index: 3;
    }

    .item-slide h3 {
      font-size: 48px;
      font-weight: 800;
      color: #fff;
      text-shadow: 0 4px 16px rgba(0, 0, 0, 0.4);
      margin-bottom: 20px;
      animation: slideInUp 0.8s ease 0.2s backwards;
    }

    .item-slide p {
      font-size: 16px;
      color: rgba(255, 255, 255, 0.95);
      max-width: 600px;
      margin-bottom: 28px;
      text-shadow: 0 2px 8px rgba(0, 0, 0, 0.3);
      animation: slideInUp 0.8s ease 0.4s backwards;
    }

    .item-slide .btn-primary {
      animation: slideInUp 0.8s ease 0.6s backwards;
    }

    @keyframes slideInUp {
      from {
        opacity: 0;
        transform: translateY(30px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .home-intro {
      background: linear-gradient(180deg, #ffffff 0%, #f8f9fa 100%);
      padding: 60px 0;
    }

    .home-intro .wrapper {
      background: linear-gradient(135deg, #ffffff 0%, #f8fdfb 100%);
      border-radius: 20px;
      padding: 40px;
      box-shadow: 0 8px 32px rgba(0, 0, 0, 0.08);
      border: 1px solid rgba(76, 175, 147, 0.1);
    }

    .sambutan {
      display: flex;
      gap: 28px;
      align-items: flex-start;
    }

    .foto-sambutan {
      width: 140px;
      height: 140px;
      flex-shrink: 0;
      border-radius: 16px;
      background-size: cover;
      background-position: center;
      border: 4px solid var(--color-primary);
      box-shadow: 0 8px 24px rgba(76, 175, 147, 0.25);
      transition: transform 0.3s ease;
    }

    .foto-sambutan:hover {
      transform: scale(1.05);
    }

    .statistik {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 20px;
      margin-top: 24px;
    }

    .item-statistik {
      background: linear-gradient(135deg, var(--color-primary), var(--color-primary-dark));
      border-radius: 16px;
      padding: 28px 16px;
      text-align: center;
      color: #fff;
      box-shadow: 0 8px 20px rgba(76, 175, 147, 0.2);
      transition: all 0.3s ease;
    }

    .item-statistik:hover {
      transform: translateY(-6px);
      box-shadow: 0 16px 32px rgba(76, 175, 147, 0.3);
    }

    .item-statistik .total {
      font-size: 42px;
      font-weight: 800;
      margin-bottom: 8px;
    }

    .item-statistik .title {
      font-size: 13px;
      opacity: 0.95;
      font-weight: 500;
    }

    .home-agenda {
      background: linear-gradient(180deg, #f8f9fa 0%, #ffffff 100%);
      padding: 60px 0;
    }

    .agenda-card {
      background: linear-gradient(135deg, #E8F5F1 0%, #f0f9f7 100%);
      border-radius: 14px;
      padding: 24px;
      height: 100%;
      display: flex;
      flex-direction: column;
      box-shadow: 0 4px 12px rgba(0,0,0,0.06);
      border: 1px solid rgba(76,175,147,0.1);
      transition: all 0.3s ease;
    }

    .agenda-card:hover {
      transform: translateY(-6px);
      box-shadow: 0 12px 28px rgba(76,175,147,0.15);
    }

    .home-post {
      background: linear-gradient(135deg, var(--color-primary-light) 0%, #e8f5f1 100%);
      padding: 60px 0;
    }

    .post-list {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 24px;
    }

    .post-item .wrapper {
      background: #fff;
      border-radius: 16px;
      overflow: hidden;
      box-shadow: 0 4px 16px rgba(0, 0, 0, 0.08);
      transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
      border: 1px solid rgba(76, 175, 147, 0.1);
    }

    .post-item .wrapper:hover {
      transform: translateY(-8px);
      box-shadow: 0 12px 32px rgba(76, 175, 147, 0.15);
    }

    .post-item img {
      width: 100%;
      height: 200px;
      object-fit: cover;
      transition: transform 0.3s ease;
    }

    .post-item .wrapper:hover img {
      transform: scale(1.05);
    }

    .post-item-info small {
      font-size: 12px;
      color: #888;
      font-weight: 500;
    }

    .post-item-content h4 {
      font-size: 15px;
      font-weight: 700;
      line-height: 1.5;
      color: var(--color-text);
    }

    .post-item-content a {
      color: var(--color-text);
      transition: color 0.3s ease;
    }

    .post-item-content a:hover {
      color: var(--color-primary);
    }

    .home-guru {
      background: linear-gradient(180deg, #ffffff 0%, #f8f9fa 100%);
      padding: 60px 0;
    }

    .guru-list {
      display: grid;
      grid-template-columns: repeat(2, 1fr);
      gap: 40px;
      max-width: 700px;
      margin: 0 auto;
    }

    .guru-item {
      text-align: center;
      text-decoration: none;
      color: inherit;
      position: relative;
      transition: all 0.3s ease;
    }

    .guru-item:hover {
      transform: translateY(-4px);
    }

    .archive-tendik-item-photo {
      width: 100%;
      padding-top: 125%;
      background-size: cover;
      background-position: center;
      border-radius: 16px;
      position: relative;
      overflow: hidden;
      box-shadow: 0 8px 24px rgba(76, 175, 147, 0.15);
    }

    .guru-item h5 {
      margin: 16px 0 6px;
      font-size: 15px;
      font-weight: 700;
      color: var(--color-text);
    }

    .guru-item p {
      font-size: 13px;
      color: #888;
      margin: 0;
      font-weight: 500;
    }

    .home-fasilitas {
      background: linear-gradient(135deg, #f8fdfb 0%, #ffffff 100%);
      padding: 60px 0;
    }

    .fasilitas-list {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 24px;
    }

    .fasilitas-item .wrapper {
      border-radius: 16px;
      overflow: hidden;
      box-shadow: 0 4px 16px rgba(0, 0, 0, 0.08);
      transition: all 0.3s ease;
      border: 1px solid rgba(76, 175, 147, 0.1);
    }

    .fasilitas-item .wrapper:hover {
      transform: translateY(-8px);
      box-shadow: 0 12px 32px rgba(76, 175, 147, 0.15);
    }

    .fasilitas-image {
      height: 220px;
      background-size: cover;
      background-position: center;
      display: flex;
      align-items: center;
      justify-content: center;
      transition: transform 0.3s ease;
      overflow: hidden;
    }

    .fasilitas-item .wrapper:hover .fasilitas-image {
      transform: scale(1.05);
    }

    .fasilitas-content {
      background: linear-gradient(135deg, var(--color-primary), var(--color-primary-dark));
      padding: 18px 20px;
    }

    .fasilitas-content h5 {
      color: #fff;
      margin: 0;
      font-size: 15px;
      font-weight: 700;
    }

    .home-testimoni {
      background: linear-gradient(180deg, #ffffff 0%, #f8f9fa 100%);
      padding: 60px 0;
    }

    .testimoni-list {
      display: grid;
      grid-template-columns: repeat(2, 1fr);
      gap: 28px;
    }

    .testimoni-item .wrapper {
      background: linear-gradient(135deg, #ffffff 0%, #f8fdfb 100%);
      border-radius: 16px;
      padding: 28px;
      box-shadow: 0 4px 16px rgba(0, 0, 0, 0.08);
      border: 1px solid rgba(76, 175, 147, 0.1);
      transition: all 0.3s ease;
    }

    .testimoni-item .wrapper:hover {
      transform: translateY(-6px);
      box-shadow: 0 12px 32px rgba(76, 175, 147, 0.15);
    }

    .bi-quote {
      font-size: 38px;
      color: var(--color-primary);
      opacity: 0.8;
    }

    .content-testimonial {
      font-size: 14px;
      color: var(--color-text);
      line-height: 1.8;
      margin: 12px 0 18px;
      font-weight: 500;
    }

    .testimoni-info {
      display: flex;
      align-items: center;
      gap: 14px;
      padding-top: 18px;
      border-top: 1px solid rgba(76, 175, 147, 0.1);
    }

    .testimoni-user-photo {
      width: 52px;
      height: 52px;
      border-radius: 50%;
      background-size: cover;
      background-position: center;
      flex-shrink: 0;
      box-shadow: 0 4px 12px rgba(76, 175, 147, 0.2);
    }

    .testimoni-info h5 {
      margin: 0 0 4px;
      font-size: 14px;
      font-weight: 700;
      color: var(--color-text);
    }

    .testimoni-info-user p {
      margin: 0;
      font-size: 12px;
      color: #888;
      font-weight: 500;
    }

    .btn-primary {
      background: linear-gradient(135deg, var(--color-primary), var(--color-primary-dark));
      color: #fff;
      border: none;
      padding: 10px 24px;
      border-radius: 50px;
      font-size: 14px;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.3s ease;
      display: inline-flex;
      align-items: center;
      gap: 6px;
      box-shadow: 0 4px 15px rgba(76, 175, 147, 0.25);
    }

    .btn-primary:hover {
      transform: translateY(-3px);
      box-shadow: 0 8px 25px rgba(76, 175, 147, 0.35);
      color: #fff;
    }

    /* ===== TABLET / iPad (max-width: 768px) ===== */
    @media (max-width: 768px) {

      .post-list,
      .fasilitas-list {
        grid-template-columns: repeat(2, 1fr);
      }

      .testimoni-list {
        grid-template-columns: 1fr;
      }

      .guru-list {
        grid-template-columns: repeat(2, 1fr);
        max-width: 100%;
      }

      .statistik {
        grid-template-columns: repeat(3, 1fr);
        gap: 12px;
      }

      .item-statistik {
        padding: 20px 12px;
      }

      .item-statistik .total {
        font-size: 32px;
      }

      .item-statistik .title {
        font-size: 11px;
      }

      .sambutan {
        flex-direction: column;
        align-items: center;
        text-align: center;
      }

      .item-slide h3 {
        font-size: 36px;
      }
    }

    /* ===== MOBILE / HP (max-width: 576px) ===== */
    @media (max-width: 576px) {

      .post-list,
      .guru-list,
      .fasilitas-list,
      .testimoni-list,
      .statistik {
        grid-template-columns: 1fr;
        gap: 16px;
      }

      .guru-list {
        max-width: 100%;
      }

      .home-slider {
        height: 360px;
      }

      .item-slide h3 {
        font-size: 24px;
        margin-bottom: 14px;
      }

      .item-slide p {
        font-size: 14px;
      }

      .sambutan {
        flex-direction: column;
        align-items: center;
        text-align: center;
      }

      .home-intro {
        padding: 40px 0;
      }

      .home-intro .wrapper {
        padding: 24px;
      }

      .home-agenda,
      .home-post,
      .home-guru,
      .home-fasilitas,
      .home-testimoni,
      .home-keunggulan {
        padding: 40px 0;
      }

      .section-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 12px;
      }

      .section-header h3 {
        font-size: 22px;
      }
    }
  </style>

  {{-- HERO SLIDER --}}
  <div class="home-slider" id="beranda">
    @if($heroImages->isNotEmpty())
      @foreach($heroImages as $i => $img)
        <div class="item-slide {{ $i === 0 ? 'active' : '' }}"
          style="background-image:url('{{ asset('storage/' . $img->image) }}');">
          <div class="container">
            <h3>{{ $img->alt_text ?? 'TK Puspitasari Kaliwatubumi' }}</h3>
            <a href="{{ route('ppdb.user.index') }}" class="btn-primary">Daftar Sekarang <i
                class="bi bi-arrow-right-circle"></i></a>
          </div>
        </div>
      @endforeach
    @else
      <div class="item-slide active" style="background:linear-gradient(135deg,#1a3a2a,#2d6a4f,#4CAF93);">
        <div class="container">
          <h3>TK Puspitasari Kaliwatubumi</h3>
          <p>Cerdas, Taqwa, dan Kreatif bersama kami di Kaliwatubumi</p>
          <a href="{{ url('/portal/ppdb') }}" class="btn-primary">Daftar Sekarang <i class="bi bi-arrow-right-circle"></i></a>
        </div>
      </div>
      <div class="item-slide" style="background:linear-gradient(135deg,#1a2332,#1a4a6b,#4CAF93);">
        <div class="container">
          <h3>PSB {{ date('Y') }}/{{ date('Y') + 1 }} Dibuka</h3>
          <p>Daftarkan putra-putri Anda sekarang dan bergabunglah bersama keluarga besar TK Puspitasari.</p>
          <a href="{{ url('/portal/ppdb') }}" class="btn-primary">Daftar Sekarang <i class="bi bi-arrow-right-circle"></i></a>
        </div>
      </div>
      <div class="item-slide" style="background:linear-gradient(135deg,#2d1a4a,#5a2d82,#4CAF93);">
        <div class="container">
          <h3>Lingkungan Belajar yang Menyenangkan</h3>
          <p>Fasilitas lengkap dan tenaga pengajar berpengalaman untuk mendukung tumbuh kembang anak.</p>
          <a href="#fasilitas" class="btn-primary">Lihat Fasilitas <i class="bi bi-arrow-right-circle"></i></a>
        </div>
      </div>
    @endif
  </div>

  {{-- SAMBUTAN KEPALA SEKOLAH --}}
  <div class="home-intro" id="profil">
    <div class="container">
      <div class="wrapper">
        <div class="row">
          <div class="col-lg-6 mb-4 mb-lg-0">
            <div class="sambutan">
              @php
                $principalPhoto = ($principal && $principal->image)
                  ? asset('storage/' . $principal->image)
                  : 'https://ui-avatars.com/api/?name=' . urlencode($principal->name ?? 'Kepala Sekolah') . '&background=4CAF93&color=fff&size=200';
              @endphp
              <div class="foto-sambutan" style="background-image:url('{{ $principalPhoto }}');"></div>
              <div>
                <h3 style="font-size:18px;font-weight:700;margin:0 0 6px;">Sambutan Kepala Sekolah</h3>
                <h4 style="font-size:15px;font-weight:600;color:var(--color-primary);margin:0 0 8px;">
                  {{ $principal->name ?? 'Kepala Sekolah TK Puspitasari' }}
                </h4>
                <p style="font-size:13px;color:#666;line-height:1.7;margin:0 0 12px;">
                  {{ $principal ? Str::limit($principal->message, 200) : 'Assalamualaikum Wr. Wb. Selamat datang di TK Puspitasari Kaliwatubumi. Kami berkomitmen memberikan pendidikan terbaik bagi anak usia dini dengan landasan nilai-nilai Islami yang kuat...' }}
                </p>
              </div>
            </div>
          </div>
          <div class="col-lg-6">
            <h3 style="font-size:18px;font-weight:700;margin:0 0 16px;text-align:center;">Statistik Data Sekolah</h3>
            <div class="statistik">
              <div class="item-statistik">
                <div class="total">2</div>
                <div class="title">Guru &amp; Staf</div>
              </div>
              <div class="item-statistik">
                <div class="total">{{ \App\Models\Student::count() ?: 20 }}</div>
                <div class="title">Siswa</div>
              </div>
              <div class="item-statistik">
                <div class="total">{{ \App\Models\Classroom::count() ?: 2 }}</div>
                <div class="title">Rombel</div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  {{-- AGENDA --}}
  <div class="home-agenda" id="agenda">
    <div class="container">
      <div class="section-header">
        <div>
          <h3>Agenda</h3>
          <p>Agenda kegiatan dan aktifitas sesuai dengan kalender pendidikan</p>
        </div>
        <a href="/agenda" class="btn-primary" style="padding:6px 14px;font-size:12px;">
          <span style="margin-right:4px;">Selengkapnya</span><i class="bi bi-arrow-right"></i>
        </a>
      </div>

      <div class="row">
        @forelse($agendas as $ag)
          <div class="col-md-4 mb-4">
            <div class="agenda-card">
              <div style="display:flex; align-items:flex-start; margin-bottom:16px;">
                <div style="background:linear-gradient(135deg, var(--color-primary), var(--color-primary-dark)); padding:10px; border-radius:10px; margin-right:14px; display:flex; align-items:center; justify-content:center; width:44px; height:44px; flex-shrink:0;">
                  <i class="bi bi-calendar-check" style="font-size:22px; color:#fff;"></i>
                </div>
                <h5 style="margin:0; font-size:15px; font-weight:700; color:var(--color-text); line-height:1.4;">{{ $ag->title }}</h5>
              </div>
              @if($ag->description)
                <p style="margin: 0 0 16px 58px; font-size: 13px; color: #555; line-height: 1.5; text-align: left;">
                  {{ Str::limit($ag->description, 120) }}
                </p>
              @endif
              <div style="margin-top:auto; padding-top:14px; border-top:1px solid rgba(76,175,147,0.15);">
                <p style="margin:0; font-size:13px; color:#666; font-weight:600;">
                  @if($ag->end_date)
                    {{ \Carbon\Carbon::parse($ag->event_date)->translatedFormat('d M Y') }} - {{ \Carbon\Carbon::parse($ag->end_date)->translatedFormat('d M Y') }}
                  @else
                    {{ \Carbon\Carbon::parse($ag->event_date)->translatedFormat('d F Y') }}
                  @endif
                </p>
              </div>
            </div>
          </div>
        @empty
          <div class="col-md-4 mb-4">
            <div class="agenda-card">
              <div style="display:flex; align-items:flex-start; margin-bottom:16px;">
                <div style="background:linear-gradient(135deg, var(--color-primary), var(--color-primary-dark)); padding:10px; border-radius:10px; margin-right:14px; display:flex; align-items:center; justify-content:center; width:44px; height:44px; flex-shrink:0;">
                  <i class="bi bi-calendar-check" style="font-size:22px; color:#fff;"></i>
                </div>
                <h5 style="margin:0; font-size:15px; font-weight:700; color:var(--color-text); line-height:1.4;">Libur Akhir Semester TA 2024-2025</h5>
              </div>
              <div style="margin-top:auto; padding-top:14px; border-top:1px solid rgba(76,175,147,0.15);">
                <p style="margin:0; font-size:13px; color:#666; font-weight:600;">30 Juni - 12 Juli 2025</p>
              </div>
            </div>
          </div>
          <div class="col-md-4 mb-4">
            <div class="agenda-card">
              <div style="display:flex; align-items:flex-start; margin-bottom:16px;">
                <div style="background:linear-gradient(135deg, var(--color-primary), var(--color-primary-dark)); padding:10px; border-radius:10px; margin-right:14px; display:flex; align-items:center; justify-content:center; width:44px; height:44px; flex-shrink:0;">
                  <i class="bi bi-calendar-check" style="font-size:22px; color:#fff;"></i>
                </div>
                <h5 style="margin:0; font-size:15px; font-weight:700; color:var(--color-text); line-height:1.4;">Pembagian Raport Semester 2 TA 2024-2025</h5>
              </div>
              <div style="margin-top:auto; padding-top:14px; border-top:1px solid rgba(76,175,147,0.15);">
                <p style="margin:0; font-size:13px; color:#666; font-weight:600;">28 Juni 2025</p>
              </div>
            </div>
          </div>
          <div class="col-md-4 mb-4">
            <div class="agenda-card">
              <div style="display:flex; align-items:flex-start; margin-bottom:16px;">
                <div style="background:linear-gradient(135deg, var(--color-primary), var(--color-primary-dark)); padding:10px; border-radius:10px; margin-right:14px; display:flex; align-items:center; justify-content:center; width:44px; height:44px; flex-shrink:0;">
                  <i class="bi bi-calendar-check" style="font-size:22px; color:#fff;"></i>
                </div>
                <h5 style="margin:0; font-size:15px; font-weight:700; color:var(--color-text); line-height:1.4;">Pekan Ceria Semester 2 TA 2024-2025</h5>
              </div>
              <div style="margin-top:auto; padding-top:14px; border-top:1px solid rgba(76,175,147,0.15);">
                <p style="margin:0; font-size:13px; color:#666; font-weight:600;">16-20 Juni 2025</p>
              </div>
            </div>
          </div>
        @endforelse
      </div>
    </div>
  </div>

  {{-- BERITA / ARTIKEL --}}
  <div class="home-post" id="informasi">
    <div class="container">
      <div class="section-header">
        <div>
          <h3>Berita, Artikel &amp; Informasi</h3>
          <p>Berita dan informasi terbaru sekolah kami</p>
        </div>
        <a href="/artikel" class="btn-primary" style="padding:6px 14px;font-size:12px;"><i
            class="bi bi-arrow-right"></i></a>
      </div>
      <div class="post-list">
        @forelse($articles as $article)
          <div class="post-item">
            <div class="wrapper">
              @if($article->image)
                <a href="/artikel/{{ $article->slug }}"><img src="{{ asset('storage/' . $article->image) }}" alt="{{ $article->title }}"></a>
              @else
                <a href="/artikel/{{ $article->slug }}">
                  <div
                    style="height:200px;background:linear-gradient(135deg,#4CAF93,#2d6a4f);display:flex;align-items:center;justify-content:center;">
                    <i class="bi bi-newspaper" style="font-size:48px;color:rgba(255,255,255,0.5);"></i>
                  </div>
                </a>
              @endif
              <div class="post-item-info px-3 pt-3">
                <small>{{ \Carbon\Carbon::parse($article->published_at)->translatedFormat('d F Y') }}</small>
              </div>
              <div class="post-item-content px-3 pt-2 pb-4">
                <h4><a href="/artikel/{{ $article->slug }}">{{ $article->title }}</a></h4>
              </div>
            </div>
          </div>
        @empty
          <div class="post-item">
            <div class="wrapper">
              <div style="height:200px;background:linear-gradient(135deg,#4CAF93,#2d6a4f);display:flex;align-items:center;justify-content:center;">
                <i class="bi bi-newspaper" style="font-size:48px;color:rgba(255,255,255,0.5);"></i>
              </div>
              <div class="post-item-info px-3 pt-3"><small>8 Maret 2025</small></div>
              <div class="post-item-content px-3 pt-2 pb-4">
                <h4><a href="#">Kegiatan Outing Class Siswa TK Puspitasari</a></h4>
              </div>
            </div>
          </div>
          <div class="post-item">
            <div class="wrapper">
              <div style="height:200px;background:linear-gradient(135deg,#2d6a4f,#4CAF93);display:flex;align-items:center;justify-content:center;">
                <i class="bi bi-people" style="font-size:48px;color:rgba(255,255,255,0.5);"></i>
              </div>
              <div class="post-item-info px-3 pt-3"><small>15 Februari 2025</small></div>
              <div class="post-item-content px-3 pt-2 pb-4">
                <h4><a href="#">Program Hafalan Asmaul Husna Semester 2</a></h4>
              </div>
            </div>
          </div>
          <div class="post-item">
            <div class="wrapper">
              <div style="height:200px;background:linear-gradient(135deg,#1a4a6b,#4CAF93);display:flex;align-items:center;justify-content:center;">
                <i class="bi bi-book" style="font-size:48px;color:rgba(255,255,255,0.5);"></i>
              </div>
              <div class="post-item-info px-3 pt-3"><small>3 Januari 2025</small></div>
              <div class="post-item-content px-3 pt-2 pb-4">
                <h4><a href="#">Peringatan Hari Pendidikan Nasional 2025</a></h4>
              </div>
            </div>
          </div>
          <div class="post-item">
            <div class="wrapper">
              <div style="height:200px;background:linear-gradient(135deg,#5a2d82,#4CAF93);display:flex;align-items:center;justify-content:center;">
                <i class="bi bi-star" style="font-size:48px;color:rgba(255,255,255,0.5);"></i>
              </div>
              <div class="post-item-info px-3 pt-3"><small>20 Desember 2024</small></div>
              <div class="post-item-content px-3 pt-2 pb-4">
                <h4><a href="#">Pentas Seni &amp; Perpisahan Semester 1</a></h4>
              </div>
            </div>
          </div>
        @endforelse
      </div>
    </div>
  </div>

  {{-- STAF PENGAJAR --}}
  <div class="home-guru" id="program">
    <div class="container">
      <div class="section-header">
        <div>
          <h3>Staf Pengajar</h3>
          <p>Tenaga pengajar profesional sekolah kami</p>
        </div>
      </div>
      <div class="guru-list">
        @forelse($teachers as $teacher)
          <a class="guru-item" href="#">
            @if($teacher->image)
              <div class="archive-tendik-item-photo" style="position:relative;">
                <img src="{{ asset('storage/' . $teacher->image) }}" alt="{{ $teacher->name }}" style="
                                       position: absolute;
                                       inset: 0;
                                       width: 100%;
                                       height: 100%;
                                       object-fit: cover;
                                       border-radius: 16px;
                                     ">
              </div>
            @else
              <div class="archive-tendik-item-photo"
                style="background-image:url('{{ 'https://ui-avatars.com/api/?name=' . urlencode($teacher->name) . '&background=4CAF93&color=fff&size=200' }}');">
              </div>
            @endif
            <h5>{{ $teacher->name }}</h5>
            <p>{{ $teacher->position ?? 'Staf Pengajar' }}</p>
          </a>
        @empty
          <a class="guru-item" href="#">
            <div class="archive-tendik-item-photo"
              style="background-image:url('https://ui-avatars.com/api/?name=Staf+Pengajar&background=4CAF93&color=fff&size=200');">
            </div>
            <h5>Staf Pengajar</h5>
            <p>TK Puspitasari</p>
          </a>
        @endforelse
      </div>
    </div>
  </div>

  {{-- FASILITAS --}}
  <div class="home-fasilitas" id="fasilitas">
    <div class="container">
      <div class="section-header">
        <div>
          <h3>Fasilitas Sekolah</h3>
          <p>Fasilitas lengkap yang kami miliki</p>
        </div>
      </div>
      <div class="fasilitas-list">
        @forelse($facilities as $fas)
          <a href="#" class="fasilitas-item">
            <div class="wrapper">
              <div class="fasilitas-image"
                style="{{ $fas->image ? 'background-image:url(\'' . asset('storage/' . $fas->image) . '\');' : 'background:linear-gradient(135deg,#4CAF93,#2d6a4f);' }}">
                @unless($fas->image)<i class="bi bi-building"
                style="font-size:64px;color:rgba(255,255,255,0.4);"></i>@endunless
              </div>
              <div class="fasilitas-content">
                <h5>{{ $fas->name }}</h5>
              </div>
            </div>
          </a>
        @empty
          <a href="#" class="fasilitas-item">
            <div class="wrapper">
              <div class="fasilitas-image" style="background:linear-gradient(135deg,#4CAF93,#2d6a4f);"><i
                  class="bi bi-building" style="font-size:64px;color:rgba(255,255,255,0.4);"></i></div>
              <div class="fasilitas-content"><h5>Ruang Kelas</h5></div>
            </div>
          </a>
          <a href="#" class="fasilitas-item">
            <div class="wrapper">
              <div class="fasilitas-image" style="background:linear-gradient(135deg,#2d6a4f,#4CAF93);"><i
                  class="bi bi-lightning" style="font-size:64px;color:rgba(255,255,255,0.4);"></i></div>
              <div class="fasilitas-content"><h5>Taman Bermain</h5></div>
            </div>
          </a>
          <a href="#" class="fasilitas-item">
            <div class="wrapper">
              <div class="fasilitas-image" style="background:linear-gradient(135deg,#1a4a6b,#4CAF93);"><i class="bi bi-book"
                  style="font-size:64px;color:rgba(255,255,255,0.4);"></i></div>
              <div class="fasilitas-content"><h5>Perpustakaan</h5></div>
            </div>
          </a>
        @endforelse
      </div>
    </div>
  </div>

  {{-- MENGAPA MEMILIH KAMI? --}}
  <div class="home-keunggulan" id="keunggulan" style="background:linear-gradient(180deg, #ffffff 0%, #f8f9fa 100%); padding:60px 0;">
    <div class="container">
      <h3 style="font-size:28px;font-weight:800;text-align:center;margin:0 0 8px; background: linear-gradient(135deg, var(--color-primary), var(--color-primary-dark)); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">Mengapa Memilih Kami?</h3>
      <p style="text-align:center;font-size:14px;color:#888;margin:0 0 48px;">
        Komitmen kami untuk memberikan pengasuhan dan pendidikan anak usia dini terbaik di Kaliwatubumi
      </p>

      <div class="row">
        <!-- Keunggulan 1 -->
        <div class="col-md-3 mb-4">
          <div class="keunggulan-card" style="background:linear-gradient(135deg, #ffffff 0%, #f8fdfb 100%); border:1px solid rgba(76,175,147,0.15); border-radius:16px; padding:28px; text-align:center; height:100%; box-shadow:0 4px 16px rgba(0,0,0,0.05);">
            <div style="background:linear-gradient(135deg, var(--color-primary-light), #d4efe8); width:64px; height:64px; border-radius:50%; display:flex; align-items:center; justify-content:center; margin:0 auto 18px;">
              <i class="bi bi-book" style="font-size:26px; color:var(--color-primary);"></i>
            </div>
            <h5 style="font-size:15px; font-weight:700; color:var(--color-text); margin-bottom:12px;">Nilai Islami &amp; Karakter</h5>
            <p style="font-size:13px; color:#666; line-height:1.7; margin:0;">
              Menanamkan fondasi karakter yang akhlakul karimah, kejujuran, dan pembiasaan ibadah sehari-hari sejak usia dini.
            </p>
          </div>
        </div>

        <!-- Keunggulan 2 -->
        <div class="col-md-3 mb-4">
          <div class="keunggulan-card" style="background:linear-gradient(135deg, #ffffff 0%, #f8fdfb 100%); border:1px solid rgba(76,175,147,0.15); border-radius:16px; padding:28px; text-align:center; height:100%; box-shadow:0 4px 16px rgba(0,0,0,0.05);">
            <div style="background:linear-gradient(135deg, var(--color-primary-light), #d4efe8); width:64px; height:64px; border-radius:50%; display:flex; align-items:center; justify-content:center; margin:0 auto 18px;">
              <i class="bi bi-people" style="font-size:26px; color:var(--color-primary);"></i>
            </div>
            <h5 style="font-size:15px; font-weight:700; color:var(--color-text); margin-bottom:12px;">Pendidik Berpengalaman</h5>
            <p style="font-size:13px; color:#666; line-height:1.7; margin:0;">
              Dibimbing oleh guru-guru profesional yang ramah, penyayang, penyabar, serta berpengalaman di dunia PAUD.
            </p>
          </div>
        </div>

        <!-- Keunggulan 3 -->
        <div class="col-md-3 mb-4">
          <div class="keunggulan-card" style="background:linear-gradient(135deg, #ffffff 0%, #f8fdfb 100%); border:1px solid rgba(76,175,147,0.15); border-radius:16px; padding:28px; text-align:center; height:100%; box-shadow:0 4px 16px rgba(0,0,0,0.05);">
            <div style="background:linear-gradient(135deg, var(--color-primary-light), #d4efe8); width:64px; height:64px; border-radius:50%; display:flex; align-items:center; justify-content:center; margin:0 auto 18px;">
              <i class="bi bi-emoji-smile" style="font-size:26px; color:var(--color-primary);"></i>
            </div>
            <h5 style="font-size:15px; font-weight:700; color:var(--color-text); margin-bottom:12px;">Belajar Sambil Bermain</h5>
            <p style="font-size:13px; color:#666; line-height:1.7; margin:0;">
              Menerapkan metode aktif, kreatif, dan menyenangkan yang memicu rasa ingin tahu serta potensi motorik anak.
            </p>
          </div>
        </div>

        <!-- Keunggulan 4 -->
        <div class="col-md-3 mb-4">
          <div class="keunggulan-card" style="background:linear-gradient(135deg, #ffffff 0%, #f8fdfb 100%); border:1px solid rgba(76,175,147,0.15); border-radius:16px; padding:28px; text-align:center; height:100%; box-shadow:0 4px 16px rgba(0,0,0,0.05);">
            <div style="background:linear-gradient(135deg, var(--color-primary-light), #d4efe8); width:64px; height:64px; border-radius:50%; display:flex; align-items:center; justify-content:center; margin:0 auto 18px;">
              <i class="bi bi-shield-check" style="font-size:26px; color:var(--color-primary);"></i>
            </div>
            <h5 style="font-size:15px; font-weight:700; color:var(--color-text); margin-bottom:12px;">Lingkungan yang Aman</h5>
            <p style="font-size:13px; color:#666; line-height:1.7; margin:0;">
              Fasilitas bermain luar dan dalam ruangan yang bersih, asri, nyaman, dan terjaga keamanannya bagi anak-anak.
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script>
    (function () {
      var slides = document.querySelectorAll("#beranda .item-slide");
      if (!slides.length) return;
      var cur = 0;
      function show(n) {
        slides.forEach(function (s, i) {
          s.classList.toggle("active", i === n);
        });
      }
      setInterval(function () {
        cur = (cur + 1) % slides.length;
        show(cur);
      }, 5000);
    })();
  </script>
@endsection