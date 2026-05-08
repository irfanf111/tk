@extends('layouts.app')
@section('title', 'TK Puspitasari Kaliwatubumi')
@section('content')
  @php
    use App\Models\HeroImage;
    use App\Models\Principal;
    use App\Models\Agenda;
    use App\Models\Article;
    use App\Models\Facility;
    use App\Models\Teacher;

    $heroImages = HeroImage::where('is_active', true)->latest()->get();
    $principal = Principal::first();
    $agendas = Agenda::orderBy('event_date', 'asc')->take(5)->get();
    $articles = Article::latest('published_at')->take(4)->get();
    $facilities = Facility::all();
    $teachers = Teacher::orderBy('id')->get();
  @endphp

  <style>
    .home-slider {
      position: relative;
      overflow: hidden;
      height: 480px
    }

    .item-slide {
      position: absolute;
      inset: 0;
      background-size: cover;
      background-position: center;
      display: flex;
      align-items: center;
      opacity: 0;
      transition: opacity 0.8s
    }

    .item-slide.active {
      opacity: 1;
      z-index: 1
    }

    .item-slide .container {
      max-width: 1200px;
      margin: 0 auto;
      padding: 0 20px
    }

    .item-slide h3 {
      font-size: 32px;
      font-weight: 700;
      color: #fff;
      text-shadow: 0 2px 12px rgba(0, 0, 0, .5);
      margin-bottom: 14px
    }

    .item-slide p {
      font-size: 15px;
      color: rgba(255, 255, 255, .9);
      max-width: 600px;
      margin-bottom: 20px;
      text-shadow: 0 1px 6px rgba(0, 0, 0, .4)
    }

    .home-intro {
      background: #fff;
      padding: 40px 0
    }

    .home-intro .wrapper {
      background: #f8fdfb;
      border-radius: 16px;
      padding: 32px;
      box-shadow: 0 2px 20px rgba(0, 0, 0, .06)
    }

    .sambutan {
      display: flex;
      gap: 20px;
      align-items: flex-start
    }

    .foto-sambutan {
      width: 120px;
      height: 120px;
      flex-shrink: 0;
      border-radius: 50%;
      background-size: cover;
      background-position: center;
      border: 4px solid #4CAF93
    }

    .statistik {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 16px;
      margin-top: 16px
    }

    .item-statistik {
      background: #4CAF93;
      border-radius: 12px;
      padding: 20px 10px;
      text-align: center;
      color: #fff
    }

    .item-statistik .total {
      font-size: 36px;
      font-weight: 800
    }

    .item-statistik .title {
      font-size: 13px;
      opacity: .9
    }

    .home-agenda {
      background: #fff;
      padding: 50px 0
    }

    .agenda-item {
      background: #E8F5F1;
      border-radius: 10px;
      padding: 14px 18px;
      margin-bottom: 10px;
      display: flex;
      justify-content: space-between;
      align-items: center
    }

    .agenda-item .wrapper {
      display: flex;
      align-items: center;
      gap: 10px
    }

    .agenda-item .bi {
      font-size: 20px;
      color: #4CAF93
    }

    .agenda-item h5 {
      margin: 0;
      font-size: 14px;
      font-weight: 600
    }

    .agenda-item .tanggal-agenda {
      font-size: 13px;
      color: #666;
      white-space: nowrap;
      margin: 0
    }

    .home-post {
      background: #E8F5F1;
      padding: 50px 0
    }

    .post-list {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 20px
    }

    .post-item .wrapper {
      background: #fff;
      border-radius: 12px;
      overflow: hidden;
      box-shadow: 0 2px 12px rgba(0, 0, 0, .07);
      transition: transform .2s
    }

    .post-item .wrapper:hover {
      transform: translateY(-4px)
    }

    .post-item img {
      width: 100%;
      height: 180px;
      object-fit: cover
    }

    .post-item-info small {
      font-size: 12px;
      color: #888
    }

    .post-item-content h4 {
      font-size: 15px;
      font-weight: 600;
      line-height: 1.4
    }

    .post-item-content a {
      color: #222;
      transition: color .2s
    }

    .post-item-content a:hover {
      color: #4CAF93
    }

    .home-guru {
      background: #fff;
      padding: 50px 0
    }

    .guru-list {
      display: grid;
      grid-template-columns: repeat(2, 1fr);
      gap: 32px;
      max-width: 600px;
      margin: 0 auto;
    }

    .guru-item {
      text-align: center;
      text-decoration: none;
      color: inherit;
      position: relative
    }

    .archive-tendik-item-photo {
      width: 100%;
      padding-top: 125%;
      background-size: cover;
      background-position: center;
      border-radius: 12px;
      position: relative;
      overflow: hidden
    }

    .guru-item h5 {
      margin: 10px 0 4px;
      font-size: 14px;
      font-weight: 600
    }

    .guru-item p {
      font-size: 12px;
      color: #888;
      margin: 0
    }

    .home-fasilitas {
      background: #f8fdfb;
      padding: 50px 0
    }

    .fasilitas-list {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 20px
    }

    .fasilitas-item .wrapper {
      border-radius: 14px;
      overflow: hidden;
      box-shadow: 0 2px 14px rgba(0, 0, 0, .1);
      transition: transform .2s
    }

    .fasilitas-item .wrapper:hover {
      transform: translateY(-3px)
    }

    .fasilitas-image {
      height: 200px;
      background-size: cover;
      background-position: center;
      display: flex;
      align-items: center;
      justify-content: center
    }

    .fasilitas-content {
      background: #4CAF93;
      padding: 14px 18px
    }

    .fasilitas-content h5 {
      color: #fff;
      margin: 0;
      font-size: 15px;
      font-weight: 600
    }

    .home-testimoni {
      background: #fff;
      padding: 50px 0
    }

    .testimoni-list {
      display: grid;
      grid-template-columns: repeat(2, 1fr);
      gap: 20px
    }

    .testimoni-item .wrapper {
      background: #f8fdfb;
      border-radius: 14px;
      padding: 24px;
      box-shadow: 0 2px 12px rgba(0, 0, 0, .06)
    }

    .bi-quote {
      font-size: 32px;
      color: #4CAF93
    }

    .content-testimonial {
      font-size: 14px;
      color: #444;
      line-height: 1.7;
      margin: 8px 0 16px
    }

    .testimoni-info {
      display: flex;
      align-items: center;
      gap: 12px
    }

    .testimoni-user-photo {
      width: 48px;
      height: 48px;
      border-radius: 50%;
      background-size: cover;
      background-position: center;
      flex-shrink: 0
    }

    .testimoni-info h5 {
      margin: 0 0 2px;
      font-size: 14px;
      font-weight: 700
    }

    .testimoni-info-user p {
      margin: 0;
      font-size: 12px;
      color: #888
    }

    .btn-primary {
      background: #4CAF93;
      color: #fff;
      border: none;
      padding: 8px 20px;
      border-radius: 50px;
      font-size: 13px;
      font-weight: 600;
      cursor: pointer;
      transition: background .2s;
      display: inline-flex;
      align-items: center;
      gap: 6px
    }

    .btn-primary:hover {
      background: #3a9478;
      color: #fff
    }

    .section-header {
      display: flex;
      align-items: flex-end;
      justify-content: space-between;
      margin-bottom: 24px
    }

    .section-header h3 {
      font-size: 22px;
      font-weight: 700;
      margin: 0 0 4px
    }

    .section-header p {
      font-size: 14px;
      color: #666;
      margin: 0
    }

    /* ===== TABLET / iPad (max-width: 768px) ===== */
    @media (max-width: 768px) {
      .post-list,
      .fasilitas-list,
      .testimoni-list {
        grid-template-columns: repeat(2, 1fr);
      }

      .guru-list {
        grid-template-columns: repeat(2, 1fr);
        max-width: 100%;
      }

      .statistik {
        grid-template-columns: repeat(3, 1fr);
        gap: 10px;
      }

      .item-statistik {
        padding: 14px 6px;
      }

      .item-statistik .total {
        font-size: 28px;
      }

      .item-statistik .title {
        font-size: 11px;
      }

      .sambutan {
        flex-direction: column;
        align-items: center;
        text-align: center;
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
        height: 300px;
      }

      .item-slide h3 {
        font-size: 22px;
      }

      .sambutan {
        flex-direction: column;
        align-items: center;
        text-align: center;
      }

      .home-intro {
        padding: 30px 0;
      }

      .home-agenda,
      .home-post,
      .home-guru,
      .home-fasilitas,
      .home-testimoni {
        padding: 30px 0;
      }

      .home-intro .wrapper {
        padding: 20px 16px;
      }

      .section-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 12px;
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
            <a href="/register-student" class="btn-primary">Daftar Sekarang <i class="bi bi-arrow-right-circle"></i></a>
          </div>
        </div>
      @endforeach
    @else
      <div class="item-slide active" style="background:linear-gradient(135deg,#2d6a4f,#4CAF93);">
        <div class="container">
          <h3>Selamat Datang di TK Puspitasari</h3>
          <p>Cerdas, Taqwa, dan Kreatif bersama kami di Kaliwatubumi</p>
          <a href="/register-student" class="btn-primary">Daftar Sekarang <i class="bi bi-arrow-right-circle"></i></a>
        </div>
      </div>
      <div class="item-slide" style="background:linear-gradient(135deg,#1a4a6b,#4CAF93);">
        <div class="container">
          <h3>PSB {{ date('Y') }}/{{ date('Y') + 1 }} Dibuka</h3>
          <p>Daftarkan putra-putri Anda sekarang dan bergabunglah bersama keluarga besar TK Puspitasari.</p>
          <a href="/register-student" class="btn-primary">Daftar Sekarang <i class="bi bi-arrow-right-circle"></i></a>
        </div>
      </div>
      <div class="item-slide" style="background:linear-gradient(135deg,#5a2d82,#4CAF93);">
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
                <h4 style="font-size:15px;font-weight:600;color:#4CAF93;margin:0 0 8px;">
                  {{ $principal->name ?? 'Kepala Sekolah TK Puspitasari' }}
                </h4>
                <p style="font-size:13px;color:#555;line-height:1.7;margin:0 0 12px;">
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
                <div class="total">{{ \App\Models\Student::count() ?: 120 }}</div>
                <div class="title">Siswa</div>
              </div>
              <div class="item-statistik">
                <div class="total">{{ \App\Models\Classroom::count() ?: 6 }}</div>
                <div class="title">Rombel</div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  {{-- AGENDA --}}
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

      <!-- BOOTSTRAP GRID UNTUK AGENDA -->
      <div class="row">
        @forelse($agendas as $ag)
          <div class="col-md-4 mb-4">
            <div
              style="background:#E8F5F1; border-radius:10px; padding:20px; height:100%; display:flex; flex-direction:column; box-shadow:0 2px 8px rgba(0,0,0,0.05);">
              <div style="display:flex; align-items:flex-start; margin-bottom:15px;">
                <div style="background:#fff; padding:8px; border-radius:8px; margin-right:12px;">
                  <i class="bi bi-calendar-check" style="font-size:24px; color:#4CAF93;"></i>
                </div>
                <h5 style="margin:0; font-size:14px; font-weight:700; color:#333; line-height:1.4;">{{ $ag->title }}</h5>
              </div>
              <div style="margin-top:auto; padding-top:12px; border-top:1px solid rgba(76,175,147,0.2);">
                <p style="margin:0; font-size:13px; color:#555; font-weight:600;">
                  {{ \Carbon\Carbon::parse($ag->event_date)->translatedFormat('d F Y') }}
                </p>
              </div>
            </div>
          </div>
        @empty
          <!-- Data Dummy Jika Database Kosong -->
          <div class="col-md-4 mb-4">
            <div
              style="background:#E8F5F1; border-radius:10px; padding:20px; height:100%; display:flex; flex-direction:column; box-shadow:0 2px 8px rgba(0,0,0,0.05);">
              <div style="display:flex; align-items:flex-start; margin-bottom:15px;">
                <div style="background:#fff; padding:8px; border-radius:8px; margin-right:12px;">
                  <i class="bi bi-calendar-check" style="font-size:24px; color:#4CAF93;"></i>
                </div>
                <h5 style="margin:0; font-size:14px; font-weight:700; color:#333; line-height:1.4;">Libur Akhir Semester TA
                  2024-2025</h5>
              </div>
              <div style="margin-top:auto; padding-top:12px; border-top:1px solid rgba(76,175,147,0.2);">
                <p style="margin:0; font-size:13px; color:#555; font-weight:600;">30 Juni - 12 Juli 2025</p>
              </div>
            </div>
          </div>

          <div class="col-md-4 mb-4">
            <div
              style="background:#E8F5F1; border-radius:10px; padding:20px; height:100%; display:flex; flex-direction:column; box-shadow:0 2px 8px rgba(0,0,0,0.05);">
              <div style="display:flex; align-items:flex-start; margin-bottom:15px;">
                <div style="background:#fff; padding:8px; border-radius:8px; margin-right:12px;">
                  <i class="bi bi-calendar-check" style="font-size:24px; color:#4CAF93;"></i>
                </div>
                <h5 style="margin:0; font-size:14px; font-weight:700; color:#333; line-height:1.4;">Pembagian Raport
                  Semester 2 TA 2024-2025</h5>
              </div>
              <div style="margin-top:auto; padding-top:12px; border-top:1px solid rgba(76,175,147,0.2);">
                <p style="margin:0; font-size:13px; color:#555; font-weight:600;">28 Juni 2025</p>
              </div>
            </div>
          </div>

          <div class="col-md-4 mb-4">
            <div
              style="background:#E8F5F1; border-radius:10px; padding:20px; height:100%; display:flex; flex-direction:column; box-shadow:0 2px 8px rgba(0,0,0,0.05);">
              <div style="display:flex; align-items:flex-start; margin-bottom:15px;">
                <div style="background:#fff; padding:8px; border-radius:8px; margin-right:12px;">
                  <i class="bi bi-calendar-check" style="font-size:24px; color:#4CAF93;"></i>
                </div>
                <h5 style="margin:0; font-size:14px; font-weight:700; color:#333; line-height:1.4;">Pekan Ceria Semester 2
                  TA 2024-2025</h5>
              </div>
              <div style="margin-top:auto; padding-top:12px; border-top:1px solid rgba(76,175,147,0.2);">
                <p style="margin:0; font-size:13px; color:#555; font-weight:600;">16-20 Juni 2025</p>
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
        <a href="#informasi" class="btn-primary" style="padding:6px 14px;font-size:12px;"><i
            class="bi bi-arrow-right"></i></a>
      </div>
      <div class="post-list">
        @forelse($articles as $article)
          <div class="post-item">
            <div class="wrapper">
              @if($article->image)
                <a href="#"><img src="{{ asset('storage/' . $article->image) }}" alt="{{ $article->title }}"></a>
              @else
                <a href="#">
                  <div
                    style="height:180px;background:linear-gradient(135deg,#4CAF93,#2d6a4f);display:flex;align-items:center;justify-content:center;">
                    <i class="bi bi-newspaper" style="font-size:48px;color:rgba(255,255,255,0.5);"></i>
                  </div>
                </a>
              @endif
              <div class="post-item-info px-3 pt-3">
                <small>{{ \Carbon\Carbon::parse($article->published_at)->translatedFormat('d F Y') }}</small>
              </div>
              <div class="post-item-content px-3 pt-2 pb-4">
                <h4><a href="#">{{ $article->title }}</a></h4>
              </div>
            </div>
          </div>
        @empty
          <div class="post-item">
            <div class="wrapper">
              <div
                style="height:180px;background:linear-gradient(135deg,#4CAF93,#2d6a4f);display:flex;align-items:center;justify-content:center;">
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
              <div
                style="height:180px;background:linear-gradient(135deg,#2d6a4f,#4CAF93);display:flex;align-items:center;justify-content:center;">
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
              <div
                style="height:180px;background:linear-gradient(135deg,#1a4a6b,#4CAF93);display:flex;align-items:center;justify-content:center;">
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
              <div
                style="height:180px;background:linear-gradient(135deg,#5a2d82,#4CAF93);display:flex;align-items:center;justify-content:center;">
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

            {{-- FOTO: jika ada photo, tampilkan gambar asli; jika tidak, fallback inisial --}}
            @if($teacher->photo)
              {{-- Foto dari FileUpload Filament (disk public, folder teachers-photos) --}}
              <div class="archive-tendik-item-photo" style="position:relative;">
                <img
                  src="{{ asset('storage/' . $teacher->photo) }}"
                  alt="{{ $teacher->nama }}"
                  style="
                    position: absolute;
                    inset: 0;
                    width: 100%;
                    height: 100%;
                    object-fit: cover;
                    border-radius: 12px;
                  "
                >
              </div>
            @else
              {{-- Fallback: kotak inisial dengan background-image dari ui-avatars --}}
              <div
                class="archive-tendik-item-photo"
                style="background-image:url('{{ 'https://ui-avatars.com/api/?name=' . urlencode($teacher->nama) . '&background=4CAF93&color=fff&size=200' }}');">
              </div>
            @endif

            <h5>{{ $teacher->nama }}</h5>
            <p>{{ $teacher->jabatan ?? 'Staf Pengajar' }}</p>
          </a>
        @empty
          {{-- Fallback jika tabel teachers kosong --}}
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
              <div class="fasilitas-content">
                <h5>Ruang Kelas</h5>
              </div>
            </div>
          </a>
          <a href="#" class="fasilitas-item">
            <div class="wrapper">
              <div class="fasilitas-image" style="background:linear-gradient(135deg,#2d6a4f,#4CAF93);"><i
                  class="bi bi-lightning" style="font-size:64px;color:rgba(255,255,255,0.4);"></i></div>
              <div class="fasilitas-content">
                <h5>Taman Bermain</h5>
              </div>
            </div>
          </a>
          <a href="#" class="fasilitas-item">
            <div class="wrapper">
              <div class="fasilitas-image" style="background:linear-gradient(135deg,#1a4a6b,#4CAF93);"><i class="bi bi-book"
                  style="font-size:64px;color:rgba(255,255,255,0.4);"></i></div>
              <div class="fasilitas-content">
                <h5>Perpustakaan</h5>
              </div>
            </div>
          </a>
        @endforelse
      </div>
    </div>
  </div>

  {{-- TESTIMONI --}}
  <div class="home-testimoni" id="kontak">
    <div class="container">
      <h3 style="font-size:22px;font-weight:700;text-align:center;margin:0 0 6px;">Testimoni</h3>
      <p style="text-align:center;font-size:14px;color:#666;margin:0 0 28px;">Testimoni dari orang tua dan alumni mengenai
        sekolah kami</p>
      <div class="testimoni-list">
        <div class="testimoni-item">
          <div class="wrapper">
            <div><i class="bi bi-quote" style="font-size:32px;color:#4CAF93;"></i>
              <p class="content-testimonial">"Alhamdulillah anak saya banyak berkembang di sini. Kepercayaan diri,
                kemandirian, dan kemampuan bersosialisasinya meningkat pesat."</p>
              <div class="testimoni-info">
                <div class="testimoni-user-photo"
                  style="background-image:url('https://ui-avatars.com/api/?name=Orang+Tua&background=4CAF93&color=fff');">
                </div>
                <div class="testimoni-info-user">
                  <h5>Ibu Siti Aminah</h5>
                  <p>Orang Tua Siswa Angkatan 2023</p>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="testimoni-item">
          <div class="wrapper">
            <div><i class="bi bi-quote" style="font-size:32px;color:#4CAF93;"></i>
              <p class="content-testimonial">"TK Puspitasari bukan hanya mengajar akademik, tapi membentuk karakter anak
                dengan nilai-nilai Islami yang luar biasa. Sangat recommended!"</p>
              <div class="testimoni-info">
                <div class="testimoni-user-photo"
                  style="background-image:url('https://ui-avatars.com/api/?name=Bapak+Ahmad&background=2d6a4f&color=fff');">
                </div>
                <div class="testimoni-info-user">
                  <h5>Bapak Ahmad Fauzi</h5>
                  <p>Orang Tua Siswa Angkatan 2022</p>
                </div>
              </div>
            </div>
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
      function show(n) { slides.forEach(function (s, i) { s.classList.toggle("active", i === n); }) }
      setInterval(function () { cur = (cur + 1) % slides.length; show(cur); }, 5000);
    })();
  </script>
@endsection