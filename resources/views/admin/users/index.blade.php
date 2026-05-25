@extends('layouts.admin')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700;800&display=swap" rel="stylesheet">

<style>
    .siapde-container-full {
        font-family: 'Poppins', sans-serif !important;
        background-color: white;
        margin: 0 !important;
        padding: 0 !important;
        min-height: 100vh;
        display: flex;
        flex-direction: column;
        box-sizing: border-box;
    }

    .header-siapde-paten {
        height: 85px;
        background: var(--sidebar-primary);
        border-bottom: 3px solid var(--sidebar-accent);
        width: 100%;
        display: flex;
        align-items: center;
        padding: 0 20px;
        box-sizing: border-box;
        color: white;
    }

    .header-siapde-paten h4 {
        margin: 0 !important;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 2px;
        font-size: 18px;
        line-height: 1;
    }

    .table-classic {
        width: 100%;
        border-collapse: collapse;
    }

    .table-classic th {
        background-color: #f8f9fc;
        color: var(--sidebar-primary);
        font-weight: 800;
        padding: 14px 16px;
        border-bottom: 2px solid var(--sidebar-accent);
        text-align: center;
        font-size: 11.5px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .table-classic td {
        padding: 14px 16px;
        border-bottom: 1px solid #f1f3f9;
        font-size: 13px;
        color: #5a5c69;
        vertical-align: middle;
    }

    .table-classic tr:hover td {
        background-color: #f8f9fc;
    }

    .btn-add-classic {
        background-color: var(--sidebar-accent);
        color: white;
        padding: 10px 20px;
        border-radius: 50px;
        text-decoration: none;
        font-weight: 800;
        font-size: 12px;
        transition: 0.2s;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        border: none;
        box-shadow: 0 4px 10px rgba(46, 134, 193, 0.25);
    }

    .btn-add-classic:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(46, 134, 193, 0.35);
        color: white;
        text-decoration: none;
    }

    .badge-role {
        padding: 5px 14px;
        border-radius: 20px;
        font-size: 10px;
        font-weight: 800;
        color: white;
        display: inline-block;
        letter-spacing: 0.5px;
    }

    .role-admin {
        background-color: var(--sidebar-primary);
    }

    .role-kepdes {
        background-color: var(--sidebar-accent);
    }

    .btn-edit-classic {
        background-color: #f6c23e;
        color: white;
        padding: 6px 14px;
        border-radius: 6px;
        text-decoration: none;
        font-weight: 800;
        font-size: 11px;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        transition: 0.2s;
    }

    .btn-edit-classic:hover {
        background-color: #dda20a;
        color: white;
        text-decoration: none;
        transform: scale(1.05);
    }

    .btn-delete-classic {
        background-color: #e74a3b;
        color: white;
        padding: 6px 14px;
        border: none;
        border-radius: 6px;
        font-weight: 800;
        font-size: 11px;
        cursor: pointer;
        transition: 0.2s;
    }

    .btn-delete-classic:hover {
        background-color: #c0392b;
        transform: scale(1.05);
    }
</style>

<div class="siapde-container-full">
    {{-- HEADER --}}
    <div class="header-siapde-paten">
        <h4>DAFTAR PENGGUNA SISTEM (ADMIN & KEPDES)</h4>
    </div>

    {{-- ACTION BAR --}}
    <div style="background: #f8f9fc; padding: 15px 20px; border-bottom: 1px solid #eaecf4; display: flex; justify-content: flex-end; align-items: center; box-sizing: border-box;">
        @if(session('success'))
        <div style="flex-grow: 1; background-color: #d1fae5; color: #065f46; padding: 10px 16px; border-radius: 8px; font-size: 13px; font-weight: 600; margin-right: 15px;">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
        @endif
        <a href="{{ route('user.create') }}" class="btn-add-classic">
            <i class="fas fa-user-plus"></i> TAMBAH PENGGUNA BARU
        </a>
    </div>

    {{-- TABEL --}}
    <div style="padding: 20px 20px 40px 20px;">
        <div style="background: white; border: 1px solid #eaecf4; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.03);">
            <div class="table-responsive">
                <table class="table-classic">
                    <thead>
                        <tr>
                            <th style="width: 50px;">NO</th>
                            <th style="text-align: left;">NAMA LENGKAP</th>
                            <th style="text-align: left;">USERNAME</th>
                            <th style="width: 150px;">ROLE</th>
                            <th style="width: 120px;">STATUS</th>
                            <th style="width: 160px;">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $index => $u)
                        <tr>
                            <td style="text-align: center; font-weight: 700; color: #b7b9cc;">{{ $index + 1 }}</td>
                            <td style="font-weight: 700; color: var(--sidebar-primary);">{{ strtoupper($u->name) }}</td>
                            <td style="font-family: 'Consolas', monospace; font-weight: 600; color: var(--sidebar-accent);">{{ $u->username }}</td>
                            <td style="text-align: center;">
                                <span class="badge-role {{ $u->role == 'admin' ? 'role-admin' : 'role-kepdes' }}">
                                    {{ strtoupper($u->role) }}
                                </span>
                            </td>
                            <td style="text-align: center;">
                                <b style="color: {{ $u->status == 'aktif' ? '#1cc88a' : '#e74a3b' }}; font-size: 12px;">
                                    {{ strtoupper($u->status) }}
                                </b>
                            </td>
                            <td style="text-align: center;">
                                <div style="display: flex; gap: 6px; justify-content: center;">
                                    <a href="{{ route('user.edit', $u->id_user) }}" class="btn-edit-classic">
                                        <i class="fas fa-edit"></i> EDIT
                                    </a>
                                    @if($u->id_user != auth()->user()->id_user)
                                    <form action="{{ route('user.destroy', $u->id_user) }}" method="POST" style="display:inline;" onsubmit="return confirm('Hapus user ini?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn-delete-classic">HAPUS</button>
                                    </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection