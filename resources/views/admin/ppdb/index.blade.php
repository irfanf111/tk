<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen PPDB — Admin TK Puspitasari</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        :root { --primary: #4CAF93; --primary-dark: #3a9478; }
        body { background: #f4f7f9; font-family: 'Segoe UI', sans-serif; }

        /* Sidebar */
        .sidebar {
            width: 240px; min-height: 100vh; background: #1a2332;
            position: fixed; top: 0; left: 0; z-index: 100;
        }
        .sidebar-brand {
            padding: 20px 16px; border-bottom: 1px solid rgba(255,255,255,.1);
        }
        .sidebar-brand h4 { color:#fff; font-weight:700; margin:0; font-size:15px; }
        .sidebar-brand p  { color:rgba(255,255,255,.5); font-size:11px; margin:0; }
        .sidebar-nav { padding: 12px 0; }
        .sidebar-nav .nav-link {
            color: rgba(255,255,255,.7); padding: 10px 20px;
            font-size: 13px; display:flex; align-items:center; gap:10px;
            transition: all .2s; border-left: 3px solid transparent;
        }
        .sidebar-nav .nav-link:hover,
        .sidebar-nav .nav-link.active {
            color:#fff; background:rgba(76,175,147,.15);
            border-left-color: var(--primary);
        }
        .sidebar-nav .nav-link .bi { font-size: 16px; }

        /* Main */
        .main-content { margin-left: 240px; min-height: 100vh; }
        .topbar {
            background:#fff; padding: 14px 28px; border-bottom: 1px solid #e8edf2;
            display:flex; align-items:center; justify-content:space-between;
            position:sticky; top:0; z-index:50;
        }
        .topbar h5 { margin:0; font-weight:700; font-size:16px; color:#1a2332; }

        /* Cards summary */
        .stat-card {
            background:#fff; border-radius:12px; padding:18px 20px;
            box-shadow: 0 1px 8px rgba(0,0,0,.06); border-left:4px solid transparent;
        }
        .stat-card .number { font-size:28px; font-weight:800; }
        .stat-card .label  { font-size:12px; color:#888; margin:0; }

        /* Table */
        .table-card {
            background:#fff; border-radius:12px;
            box-shadow: 0 1px 8px rgba(0,0,0,.06); overflow:hidden;
        }
        .table thead th {
            background:#f8f9fa; font-size:12px; font-weight:700;
            text-transform:uppercase; letter-spacing:.5px; color:#555;
            border-bottom: 2px solid #e8edf2; padding: 12px 16px;
        }
        .table td { padding: 12px 16px; vertical-align:middle; font-size:14px; }
        .table tbody tr:hover { background:#fafcfb; }

        /* Badge status */
        .badge-status {
            padding: 4px 12px; border-radius:20px; font-size:11px; font-weight:600;
            display:inline-block; white-space:nowrap;
        }
        .badge-draft        { background:#f0f0f0; color:#666; }
        .badge-submitted    { background:#fff3cd; color:#856404; }
        .badge-verified     { background:#cce5ff; color:#004085; }
        .badge-rejected     { background:#f8d7da; color:#721c24; }
        .badge-accepted     { background:#d4edda; color:#155724; }
        .badge-not_accepted { background:#e2e3e5; color:#383d41; }

        /* Filter tabs */
        .filter-tabs { display:flex; gap:8px; flex-wrap:wrap; }
        .filter-tab {
            padding:6px 16px; border-radius:20px; font-size:12px; font-weight:600;
            border:1px solid #dee2e6; background:#fff; color:#666;
            text-decoration:none; transition:all .2s;
        }
        .filter-tab:hover, .filter-tab.active {
            background: var(--primary); color:#fff; border-color: var(--primary);
        }
    </style>
</head>
<body>

<!-- ===== SIDEBAR ===== -->
<div class="sidebar">
    <div class="sidebar-brand">
        <h4>TK Puspitasari</h4>
        <p>Admin Panel</p>
    </div>
    <nav class="sidebar-nav">
        <a href="/admin" class="nav-link"><i class="bi bi-speedometer2"></i> Dashboard</a>
        <a href="{{ route('admin.ppdb.index') }}" class="nav-link active">
            <i class="bi bi-clipboard-check"></i> Manajemen PPDB
        </a>
        <a href="/admin/users" class="nav-link"><i class="bi bi-people"></i> Data Pengguna</a>
        <hr style="border-color:rgba(255,255,255,.1); margin:8px 16px;">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="nav-link w-100 text-start border-0" style="background:none; cursor:pointer;">
                <i class="bi bi-box-arrow-left"></i> Keluar
            </button>
        </form>
    </nav>
</div>

<!-- ===== MAIN CONTENT ===== -->
<div class="main-content">

    <!-- Topbar -->
    <div class="topbar">
        <h5><i class="bi bi-clipboard-check me-2" style="color:var(--primary);"></i>Manajemen PPDB</h5>
        <div class="d-flex align-items-center gap-3">
            <span class="text-muted" style="font-size:13px;">{{ auth()->user()->name }}</span>
        </div>
    </div>

    <div class="p-4">

        {{-- Flash Messages --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show d-flex align-items-center gap-2" role="alert">
                <i class="bi bi-check-circle-fill"></i>
                {{ session('success') }}
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center gap-2" role="alert">
                <i class="bi bi-exclamation-triangle-fill"></i>
                {{ session('error') }}
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- Summary Cards --}}
        <div class="row g-3 mb-4">
            <div class="col-6 col-md-3 col-lg-2">
                <div class="stat-card" style="border-left-color:#ffc107;">
                    <div class="number text-warning">{{ $summary[App\Models\Registration::STATUS_SUBMITTED] ?? 0 }}</div>
                    <p class="label">Menunggu Verifikasi</p>
                </div>
            </div>
            <div class="col-6 col-md-3 col-lg-2">
                <div class="stat-card" style="border-left-color:#0d6efd;">
                    <div class="number text-primary">{{ $summary[App\Models\Registration::STATUS_VERIFIED] ?? 0 }}</div>
                    <p class="label">Terverifikasi</p>
                </div>
            </div>
            <div class="col-6 col-md-3 col-lg-2">
                <div class="stat-card" style="border-left-color:#dc3545;">
                    <div class="number text-danger">{{ $summary[App\Models\Registration::STATUS_REJECTED] ?? 0 }}</div>
                    <p class="label">Dikembalikan</p>
                </div>
            </div>
            <div class="col-6 col-md-3 col-lg-2">
                <div class="stat-card" style="border-left-color:#4CAF93;">
                    <div class="number" style="color:#4CAF93;">{{ $summary[App\Models\Registration::STATUS_ACCEPTED] ?? 0 }}</div>
                    <p class="label">Diterima</p>
                </div>
            </div>
            <div class="col-6 col-md-3 col-lg-2">
                <div class="stat-card" style="border-left-color:#6c757d;">
                    <div class="number text-secondary">{{ $summary[App\Models\Registration::STATUS_NOT_ACCEPTED] ?? 0 }}</div>
                    <p class="label">Tidak Diterima</p>
                </div>
            </div>
        </div>

        {{-- Filter Tabs --}}
        <div class="d-flex align-items-center justify-content-between mb-3 flex-wrap gap-2">
            <div class="filter-tabs">
                <a href="{{ route('admin.ppdb.index') }}"
                   class="filter-tab {{ !$filterStatus ? 'active' : '' }}">
                    Semua
                </a>
                @foreach([
                    'submitted'    => 'Menunggu Verifikasi',
                    'verified'     => 'Terverifikasi',
                    'rejected'     => 'Dikembalikan',
                    'accepted'     => 'Diterima',
                    'not_accepted' => 'Tidak Diterima',
                    'draft'        => 'Draft',
                ] as $status => $label)
                    <a href="{{ route('admin.ppdb.index', ['status' => $status]) }}"
                       class="filter-tab {{ $filterStatus === $status ? 'active' : '' }}">
                        {{ $label }}
                    </a>
                @endforeach
            </div>
            <span class="text-muted" style="font-size:13px;">
                Total: {{ $registrations->total() }} pendaftar
            </span>
        </div>

        {{-- Data Table --}}
        <div class="table-card">
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama Lengkap</th>
                            <th>No. HP</th>
                            <th>Terakhir Diperbarui</th>
                            <th>Status</th>
                            <th>Diverifikasi Oleh</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($registrations as $i => $reg)
                            <tr>
                                <td class="text-muted">{{ $registrations->firstItem() + $i }}</td>
                                <td>
                                    <div style="font-weight:600; color:#1a2332;">
                                        {{ $reg->student?->nama_lengkap ?? '—' }}
                                    </div>
                                    <div style="font-size:12px; color:#888;">
                                        {{ $reg->student?->nama_panggilan ? '(' . $reg->student->nama_panggilan . ')' : '' }}
                                    </div>
                                </td>
                                <td>{{ $reg->student?->no_hp ?? '—' }}</td>
                                <td>
                                    <div style="font-size:13px;">{{ $reg->updated_at->translatedFormat('d M Y') }}</div>
                                    <div style="font-size:11px; color:#aaa;">{{ $reg->updated_at->diffForHumans() }}</div>
                                </td>
                                <td>
                                    @php
                                        $badgeClass = match($reg->status) {
                                            'submitted'    => 'badge-submitted',
                                            'verified'     => 'badge-verified',
                                            'rejected'     => 'badge-rejected',
                                            'accepted'     => 'badge-accepted',
                                            'not_accepted' => 'badge-not_accepted',
                                            default        => 'badge-draft',
                                        };
                                    @endphp
                                    <span class="badge-status {{ $badgeClass }}">
                                        {{ $reg->status_label }}
                                    </span>
                                </td>
                                <td style="font-size:13px;">
                                    {{ $reg->verifier?->name ?? '—' }}
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('admin.ppdb.show', $reg->id) }}"
                                       class="btn btn-sm btn-outline-primary"
                                       style="border-radius:8px; font-size:12px;">
                                        <i class="bi bi-eye me-1"></i> Cek Detail
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5 text-muted">
                                    <i class="bi bi-inbox" style="font-size:32px; display:block; margin-bottom:8px;"></i>
                                    Tidak ada data pendaftaran
                                    {{ $filterStatus ? 'dengan status "' . $filterStatus . '"' : '' }}.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if($registrations->hasPages())
                <div class="px-4 py-3 border-top">
                    {{ $registrations->links() }}
                </div>
            @endif
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
