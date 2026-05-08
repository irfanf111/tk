<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pendaftar — Admin TK Puspitasari</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        :root { --primary: #4CAF93; --primary-dark: #3a9478; }
        body { background: #f4f7f9; font-family: 'Segoe UI', sans-serif; }
        .sidebar { width:240px; min-height:100vh; background:#1a2332; position:fixed; top:0; left:0; z-index:100; }
        .sidebar-brand { padding:20px 16px; border-bottom:1px solid rgba(255,255,255,.1); }
        .sidebar-brand h4 { color:#fff; font-weight:700; margin:0; font-size:15px; }
        .sidebar-brand p  { color:rgba(255,255,255,.5); font-size:11px; margin:0; }
        .sidebar-nav .nav-link { color:rgba(255,255,255,.7); padding:10px 20px; font-size:13px; display:flex; align-items:center; gap:10px; transition:all .2s; border-left:3px solid transparent; }
        .sidebar-nav .nav-link:hover, .sidebar-nav .nav-link.active { color:#fff; background:rgba(76,175,147,.15); border-left-color:var(--primary); }
        .main-content { margin-left:240px; min-height:100vh; }
        .topbar { background:#fff; padding:14px 28px; border-bottom:1px solid #e8edf2; display:flex; align-items:center; justify-content:space-between; position:sticky; top:0; z-index:50; }

        /* Cards */
        .info-card { background:#fff; border-radius:12px; box-shadow:0 1px 8px rgba(0,0,0,.06); overflow:hidden; margin-bottom:20px; }
        .info-card .card-header-custom { padding:14px 20px; border-bottom:1px solid #f0f0f0; display:flex; align-items:center; gap:10px; }
        .info-card .card-header-custom h6 { margin:0; font-weight:700; font-size:14px; color:#1a2332; }
        .info-card .card-header-custom .bi { color:var(--primary); font-size:18px; }
        .info-card .card-body-custom { padding:20px; }

        /* Field rows */
        .field-row { display:flex; border-bottom:1px solid #f8f8f8; padding:8px 0; font-size:13.5px; }
        .field-row:last-child { border-bottom:none; }
        .field-label { width:200px; flex-shrink:0; color:#888; font-weight:500; }
        .field-value { color:#1a2332; font-weight:600; flex:1; }

        /* Badge status */
        .badge-status { padding:5px 14px; border-radius:20px; font-size:12px; font-weight:700; display:inline-block; }
        .badge-submitted    { background:#fff3cd; color:#856404; }
        .badge-verified     { background:#cce5ff; color:#004085; }
        .badge-rejected     { background:#f8d7da; color:#721c24; }
        .badge-accepted     { background:#d4edda; color:#155724; }
        .badge-not_accepted { background:#e2e3e5; color:#383d41; }
        .badge-draft        { background:#f0f0f0; color:#666; }

        /* Document items */
        .doc-item { display:flex; align-items:center; justify-content:space-between; padding:12px 16px; border:1px solid #e8edf2; border-radius:10px; margin-bottom:10px; }
        .doc-item .doc-name { font-size:13px; font-weight:600; color:#1a2332; display:flex; align-items:center; gap:8px; }
        .doc-item .doc-name .bi { color:var(--primary); }
        .doc-status-badge { font-size:11px; padding:3px 10px; border-radius:20px; font-weight:600; }
        .doc-uploaded   { background:#d4edda; color:#155724; }
        .doc-missing    { background:#f8d7da; color:#721c24; }

        /* Action area */
        .action-card { background:#fff; border-radius:12px; box-shadow:0 1px 8px rgba(0,0,0,.06); padding:24px; margin-bottom:20px; border-left:4px solid var(--primary); }
        .action-card.danger { border-left-color:#dc3545; }
        .action-card.success { border-left-color:#198754; }
        .action-card h6 { font-weight:700; margin:0 0 16px; color:#1a2332; }

        .btn-approve { background:var(--primary); border:none; color:#fff; padding:9px 24px; border-radius:8px; font-weight:600; font-size:13px; }
        .btn-approve:hover { background:var(--primary-dark); color:#fff; }
        .btn-reject  { background:#dc3545; border:none; color:#fff; padding:9px 24px; border-radius:8px; font-weight:600; font-size:13px; }
        .btn-reject:hover { background:#bb2d3b; color:#fff; }
        .btn-accept  { background:#198754; border:none; color:#fff; padding:9px 24px; border-radius:8px; font-weight:600; font-size:13px; }
        .btn-decline { background:#6c757d; border:none; color:#fff; padding:9px 24px; border-radius:8px; font-weight:600; font-size:13px; }

        @media(max-width:768px) { .sidebar{display:none;} .main-content{margin-left:0;} .field-row{flex-direction:column;} .field-label{width:100%; margin-bottom:2px;} }
    </style>
</head>
<body>

<!-- SIDEBAR -->
<div class="sidebar">
    <div class="sidebar-brand">
        <h4>TK Puspitasari</h4>
        <p>Admin Panel</p>
    </div>
    <nav class="sidebar-nav">
        <a href="/admin" class="nav-link"><i class="bi bi-speedometer2"></i> Dashboard</a>
        <a href="{{ route('admin.ppdb.index') }}" class="nav-link active"><i class="bi bi-clipboard-check"></i> Manajemen PPDB</a>
        <hr style="border-color:rgba(255,255,255,.1); margin:8px 16px;">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="nav-link w-100 text-start border-0" style="background:none; cursor:pointer;">
                <i class="bi bi-box-arrow-left"></i> Keluar
            </button>
        </form>
    </nav>
</div>

<!-- MAIN CONTENT -->
<div class="main-content">

    <!-- Topbar -->
    <div class="topbar">
        <div class="d-flex align-items-center gap-3">
            <a href="{{ route('admin.ppdb.index') }}" class="btn btn-sm btn-outline-secondary" style="border-radius:8px;">
                <i class="bi bi-arrow-left me-1"></i> Kembali
            </a>
            <h5 style="margin:0; font-weight:700; font-size:16px; color:#1a2332;">
                Detail Pendaftaran: {{ $student?->nama_lengkap ?? '—' }}
            </h5>
        </div>
        <div>
            @php
                $badgeClass = match($registration->status) {
                    'submitted'    => 'badge-submitted',
                    'verified'     => 'badge-verified',
                    'rejected'     => 'badge-rejected',
                    'accepted'     => 'badge-accepted',
                    'not_accepted' => 'badge-not_accepted',
                    default        => 'badge-draft',
                };
            @endphp
            <span class="badge-status {{ $badgeClass }}">{{ $registration->status_label }}</span>
        </div>
    </div>

    <div class="p-4">

        {{-- Flash Messages --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- Catatan Admin (jika ada) --}}
        @if($registration->notes)
            <div class="alert alert-warning d-flex gap-2" role="alert">
                <i class="bi bi-chat-left-text-fill mt-1 flex-shrink-0"></i>
                <div>
                    <strong>Catatan Admin:</strong><br>
                    {{ $registration->notes }}
                </div>
            </div>
        @endif

        <div class="row g-4">

            <!-- KOLOM KIRI: Data Siswa + Ortu + Dokumen -->
            <div class="col-lg-7">

                <!-- Card: Data Siswa -->
                <div class="info-card">
                    <div class="card-header-custom">
                        <i class="bi bi-person-fill"></i>
                        <h6>Data Siswa</h6>
                    </div>
                    <div class="card-body-custom">
                        @if($student)
                            <div class="field-row"><span class="field-label">Nama Lengkap</span><span class="field-value">{{ $student->nama_lengkap ?? '—' }}</span></div>
                            <div class="field-row"><span class="field-label">Nama Panggilan</span><span class="field-value">{{ $student->nama_panggilan ?? '—' }}</span></div>
                            <div class="field-row"><span class="field-label">Jenis Kelamin</span><span class="field-value">{{ $student->jenis_kelamin === 'L' ? 'Laki-laki' : ($student->jenis_kelamin === 'P' ? 'Perempuan' : '—') }}</span></div>
                            <div class="field-row"><span class="field-label">Tempat, Tgl Lahir</span><span class="field-value">{{ $student->tempat_lahir ?? '—' }}, {{ $student->tanggal_lahir?->translatedFormat('d F Y') ?? '—' }}</span></div>
                            <div class="field-row"><span class="field-label">Agama</span><span class="field-value">{{ $student->agama ?? '—' }}</span></div>
                            <div class="field-row"><span class="field-label">Kewarganegaraan</span><span class="field-value">{{ $student->kewarganegaraan ?? '—' }}</span></div>
                            <div class="field-row"><span class="field-label">Anak Ke</span><span class="field-value">{{ $student->anak_ke ?? '—' }}</span></div>
                            <div class="field-row"><span class="field-label">Saudara Kandung</span><span class="field-value">{{ $student->jumlah_saudara_kandung ?? 0 }} orang</span></div>
                            <div class="field-row"><span class="field-label">Saudara Tiri</span><span class="field-value">{{ $student->jumlah_saudara_tiri ?? 0 }} orang</span></div>
                            <div class="field-row"><span class="field-label">Saudara Angkat</span><span class="field-value">{{ $student->jumlah_saudara_angkat ?? 0 }} orang</span></div>
                            <div class="field-row"><span class="field-label">Bahasa Sehari-hari</span><span class="field-value">{{ $student->bahasa_sehari_hari ?? '—' }}</span></div>
                            <div class="field-row"><span class="field-label">Berat / Tinggi Badan</span><span class="field-value">{{ $student->berat_badan ?? '—' }} kg / {{ $student->tinggi_badan ?? '—' }} cm</span></div>
                            <div class="field-row"><span class="field-label">Golongan Darah</span><span class="field-value">{{ $student->golongan_darah ?? '—' }}</span></div>
                            <div class="field-row"><span class="field-label">Riwayat Penyakit</span><span class="field-value">{{ $student->riwayat_penyakit ?? 'Tidak ada' }}</span></div>
                            <div class="field-row"><span class="field-label">Alamat</span><span class="field-value">{{ $student->alamat ?? '—' }}</span></div>
                            <div class="field-row"><span class="field-label">No. HP</span><span class="field-value">{{ $student->no_hp ?? '—' }}</span></div>
                            <div class="field-row"><span class="field-label">Tinggal Bersama</span><span class="field-value">{{ ucwords(str_replace('_', ' ', $student->tinggal_bersama ?? '—')) }}</span></div>
                        @else
                            <p class="text-muted text-center py-3">Data siswa belum tersedia.</p>
                        @endif
                    </div>
                </div>

                <!-- Card: Data Orang Tua / Wali -->
                <div class="info-card">
                    <div class="card-header-custom">
                        <i class="bi bi-people-fill"></i>
                        <h6>Data Orang Tua / Wali</h6>
                    </div>
                    <div class="card-body-custom">
                        @if($parent)
                            <p class="fw-bold mb-2" style="font-size:13px; color:var(--primary);">— Ayah —</p>
                            <div class="field-row"><span class="field-label">Nama Ayah</span><span class="field-value">{{ $parent->nama_ayah ?? '—' }}</span></div>
                            <div class="field-row"><span class="field-label">Tempat, Tgl Lahir</span><span class="field-value">{{ $parent->tempat_lahir_ayah ?? '—' }}, {{ $parent->tanggal_lahir_ayah?->translatedFormat('d F Y') ?? '—' }}</span></div>
                            <div class="field-row"><span class="field-label">Pendidikan</span><span class="field-value">{{ $parent->pendidikan_ayah ?? '—' }}</span></div>
                            <div class="field-row"><span class="field-label">Pekerjaan</span><span class="field-value">{{ $parent->pekerjaan_ayah ?? '—' }}</span></div>

                            <p class="fw-bold mb-2 mt-3" style="font-size:13px; color:var(--primary);">— Ibu —</p>
                            <div class="field-row"><span class="field-label">Nama Ibu</span><span class="field-value">{{ $parent->nama_ibu ?? '—' }}</span></div>
                            <div class="field-row"><span class="field-label">Tempat, Tgl Lahir</span><span class="field-value">{{ $parent->tempat_lahir_ibu ?? '—' }}, {{ $parent->tanggal_lahir_ibu?->translatedFormat('d F Y') ?? '—' }}</span></div>
                            <div class="field-row"><span class="field-label">Pendidikan</span><span class="field-value">{{ $parent->pendidikan_ibu ?? '—' }}</span></div>
                            <div class="field-row"><span class="field-label">Pekerjaan</span><span class="field-value">{{ $parent->pekerjaan_ibu ?? '—' }}</span></div>

                            @if($parent->nama_wali)
                                <p class="fw-bold mb-2 mt-3" style="font-size:13px; color:var(--primary);">— Wali —</p>
                                <div class="field-row"><span class="field-label">Nama Wali</span><span class="field-value">{{ $parent->nama_wali }}</span></div>
                                <div class="field-row"><span class="field-label">Hubungan</span><span class="field-value">{{ $parent->hubungan_wali ?? '—' }}</span></div>
                                <div class="field-row"><span class="field-label">Pendidikan</span><span class="field-value">{{ $parent->pendidikan_wali ?? '—' }}</span></div>
                                <div class="field-row"><span class="field-label">Pekerjaan</span><span class="field-value">{{ $parent->pekerjaan_wali ?? '—' }}</span></div>
                            @endif
                        @else
                            <p class="text-muted text-center py-3">Data orang tua belum tersedia.</p>
                        @endif
                    </div>
                </div>

                <!-- Card: Dokumen -->
                <div class="info-card">
                    <div class="card-header-custom">
                        <i class="bi bi-folder2-open"></i>
                        <h6>Dokumen Persyaratan</h6>
                    </div>
                    <div class="card-body-custom">
                        @php
                            $docs = [
                                ['field' => 'akta_kelahiran', 'label' => 'Akta Kelahiran',    'icon' => 'bi-file-earmark-text', 'required' => true],
                                ['field' => 'kartu_keluarga', 'label' => 'Kartu Keluarga',    'icon' => 'bi-house-heart',       'required' => true],
                                ['field' => 'ijazah_tk',      'label' => 'Ijazah TK/PAUD',    'icon' => 'bi-award',             'required' => false],
                            ];
                        @endphp

                        @foreach($docs as $d)
                            @php $path = $doc?->{$d['field']}; @endphp
                            <div class="doc-item">
                                <div class="doc-name">
                                    <i class="{{ $d['icon'] }}"></i>
                                    {{ $d['label'] }}
                                    @if($d['required'])
                                        <span style="font-size:10px; color:#dc3545;">*Wajib</span>
                                    @endif
                                </div>
                                <div class="d-flex align-items-center gap-2">
                                    @if($path)
                                        <span class="doc-status-badge doc-uploaded"><i class="bi bi-check2 me-1"></i>Sudah Upload</span>
                                        <a href="{{ Storage::url($path) }}" target="_blank"
                                           class="btn btn-sm btn-outline-primary" style="border-radius:6px; font-size:11px;">
                                            <i class="bi bi-eye me-1"></i>Lihat
                                        </a>
                                        <a href="{{ Storage::url($path) }}" download
                                           class="btn btn-sm btn-outline-secondary" style="border-radius:6px; font-size:11px;">
                                            <i class="bi bi-download"></i>
                                        </a>
                                    @else
                                        <span class="doc-status-badge doc-missing"><i class="bi bi-x me-1"></i>Belum Upload</span>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

            </div>

            <!-- KOLOM KANAN: Form Aksi Admin -->
            <div class="col-lg-5">

                <!-- Info verifikasi sebelumnya -->
                @if($registration->verified_at)
                    <div class="info-card mb-3">
                        <div class="card-body-custom">
                            <p class="mb-1" style="font-size:12px; color:#888;">Diproses oleh</p>
                            <p class="mb-0 fw-bold" style="font-size:14px;">{{ $registration->verifier?->name ?? '—' }}</p>
                            <p class="mb-0" style="font-size:12px; color:#aaa;">{{ $registration->verified_at->translatedFormat('d F Y, H:i') }}</p>
                        </div>
                    </div>
                @endif

                {{-- ======================================================= --}}
                {{-- FORM A: VERIFIKASI BERKAS                                 --}}
                {{-- Hanya tampil jika status 'submitted'                      --}}
                {{-- ======================================================= --}}
                @if($registration->status === \App\Models\Registration::STATUS_SUBMITTED)
                    <div class="action-card">
                        <h6><i class="bi bi-shield-check me-2" style="color:var(--primary);"></i>Verifikasi Berkas</h6>
                        <p style="font-size:13px; color:#666;">Periksa kelengkapan dan kebenaran data serta dokumen pendaftar, lalu putuskan.</p>

                        <form method="POST" action="{{ route('admin.ppdb.verify', $registration->id) }}" id="form-verify">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label class="form-label" style="font-size:13px; font-weight:600;">Catatan Revisi <span style="color:#888; font-weight:400;">(wajib diisi jika menolak)</span></label>
                                <textarea name="notes" id="notes-textarea" class="form-control @error('notes') is-invalid @enderror"
                                    rows="4" placeholder="Tulis catatan untuk pendaftar jika ada yang perlu diperbaiki..."
                                    style="font-size:13px; resize:none; border-radius:8px;">{{ old('notes', $registration->notes) }}</textarea>
                                @error('notes')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            @error('action')
                                <div class="alert alert-danger py-2" style="font-size:13px;">{{ $message }}</div>
                            @enderror

                            <div class="d-flex gap-2">
                                {{-- Tombol Approve: set action=verified, kosongkan textarea --}}
                                <button type="submit" name="action" value="verified"
                                    class="btn-approve flex-fill"
                                    onclick="return confirm('Setujui pendaftaran ini? Berkas dinyatakan lengkap dan valid.')">
                                    <i class="bi bi-check-circle me-1"></i> Setujui
                                </button>

                                {{-- Tombol Reject: set action=rejected, textarea wajib diisi --}}
                                <button type="submit" name="action" value="rejected"
                                    class="btn-reject flex-fill"
                                    onclick="
                                        const notes = document.getElementById('notes-textarea').value.trim();
                                        if (!notes) {
                                            alert('Isi catatan revisi terlebih dahulu sebelum menolak pendaftaran.');
                                            return false;
                                        }
                                        return confirm('Kembalikan pendaftaran ini dengan catatan revisi?');
                                    ">
                                    <i class="bi bi-x-circle me-1"></i> Kembalikan
                                </button>
                            </div>
                        </form>
                    </div>
                @endif

                {{-- ======================================================= --}}
                {{-- FORM B: KEPUTUSAN AKHIR PENERIMAAN                       --}}
                {{-- HANYA muncul jika status 'verified'                       --}}
                {{-- ======================================================= --}}
                @if($registration->status === \App\Models\Registration::STATUS_VERIFIED)
                    <div class="action-card success">
                        <h6><i class="bi bi-award me-2" style="color:#198754;"></i>Keputusan Penerimaan</h6>
                        <p style="font-size:13px; color:#666;">Berkas sudah terverifikasi. Tentukan keputusan akhir penerimaan peserta didik baru ini.</p>

                        <form method="POST" action="{{ route('admin.ppdb.decide', $registration->id) }}" id="form-decide">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label class="form-label" style="font-size:13px; font-weight:600;">Catatan Keputusan <span style="color:#888; font-weight:400;">(opsional)</span></label>
                                <textarea name="notes" class="form-control" rows="3"
                                    placeholder="Contoh: Selamat, Anda diterima. Harap hadir pada orientasi tanggal..."
                                    style="font-size:13px; resize:none; border-radius:8px;">{{ old('notes') }}</textarea>
                                @error('notes')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            @error('decision')
                                <div class="alert alert-danger py-2" style="font-size:13px;">{{ $message }}</div>
                            @enderror

                            <div class="d-flex gap-2">
                                <button type="submit" name="decision" value="accepted"
                                    class="btn-accept flex-fill"
                                    onclick="return confirm('Terima pendaftar ini sebagai peserta didik baru?')">
                                    <i class="bi bi-person-check me-1"></i> Terima
                                </button>
                                <button type="submit" name="decision" value="not_accepted"
                                    class="btn-decline flex-fill"
                                    onclick="return confirm('Tidak menerima pendaftar ini? Keputusan ini bersifat final.')">
                                    <i class="bi bi-person-x me-1"></i> Tidak Terima
                                </button>
                            </div>
                        </form>
                    </div>
                @endif

                {{-- Status final: tampilkan info saja --}}
                @if(in_array($registration->status, [\App\Models\Registration::STATUS_ACCEPTED, \App\Models\Registration::STATUS_NOT_ACCEPTED]))
                    <div class="action-card {{ $registration->status === 'accepted' ? 'success' : 'danger' }}">
                        <h6>
                            <i class="bi {{ $registration->status === 'accepted' ? 'bi-check-circle-fill text-success' : 'bi-x-circle-fill text-danger' }} me-2"></i>
                            Keputusan Telah Ditetapkan
                        </h6>
                        <p style="font-size:13px; color:#555; margin:0;">
                            Pendaftaran ini telah diputuskan sebagai
                            <strong>{{ $registration->status_label }}</strong>.
                            Hubungi pengembang jika perlu mengubah keputusan.
                        </p>
                    </div>
                @endif

                {{-- Draft: belum submit --}}
                @if($registration->status === \App\Models\Registration::STATUS_DRAFT)
                    <div class="action-card" style="border-left-color:#6c757d;">
                        <h6><i class="bi bi-hourglass me-2 text-secondary"></i>Menunggu Pengiriman</h6>
                        <p style="font-size:13px; color:#666; margin:0;">Pendaftar belum mengirimkan formulir ini. Tidak ada aksi yang tersedia saat ini.</p>
                    </div>
                @endif

            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
