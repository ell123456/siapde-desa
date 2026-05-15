@extends('layouts.admin')

@section('content')
<div class="container-fluid py-4" style="background-color: #f4f7f6; min-height: 100vh;">
    <div class="row justify-content-center">
        <div class="col-md-11">

            <div style="background: white; border: 1px solid #d1d3e2; border-radius: 4px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); overflow: hidden;">

                <div style="background-color: #4e73df; padding: 15px; text-align: center !important;">
                    <h5 style="color: white !important; margin: 0 !important; font-weight: bold; text-transform: uppercase; letter-spacing: 2px;">
                        Daftar Pengguna Sistem (Admin & Kepdes)
                    </h5>
                </div>

                <div style="padding: 20px;">

                    {{-- Bagian Atas: Tombol Tambah & Alert --}}
                    <div style="display: flex; justify-content:建设者; align-items: center; margin-bottom: 20px;">
                        <div style="flex-grow: 1;">
                            @if(session('success'))
                            <div style="background-color: #d1e7dd; color: #0f5132; padding: 10px; border-radius: 4px; font-size: 13px; margin: 0;">
                                <i class="fas fa-check-circle"></i> {{ session('success') }}
                            </div>
                            @endif
                        </div>

                        {{-- TOMBOL TAMBAH USER --}}
                        <div style="margin-left: 15px;">
                            <a href="{{ route('user.create') }}" class="btn-add-classic">
                                <i class="fas fa-user-plus"></i> TAMBAH PENGGUNA BARU
                            </a>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table-classic">
                            <thead>
                                <tr>
                                    <th width="50">NO</th>
                                    <th>NAMA LENGKAP</th>
                                    <th>USERNAME</th>
                                    <th width="150">ROLE</th>
                                    <th width="120">STATUS</th>
                                    <th width="150">AKSI</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $index => $u)
                                <tr>
                                    <td style="text-align: center;">{{ $index + 1 }}</td>
                                    <td style="font-weight: bold; color: #4e73df;">{{ strtoupper($u->name) }}</td>
                                    <td>{{ $u->username }}</td>
                                    <td style="text-align: center;">
                                        <span class="badge-role {{ $u->role == 'admin' ? 'role-admin' : 'role-kepdes' }}">
                                            {{ strtoupper($u->role) }}
                                        </span>
                                    </td>
                                    <td style="text-align: center;">
                                        <b style="color: {{ $u->status == 'aktif' ? '#1cc88a' : '#e74a3b' }};">
                                            {{ strtoupper($u->status) }}
                                        </b>
                                    </td>
                                    <td style="text-align: center;">
                                        <a href="{{ route('user.edit', $u->id_user) }}" class="btn-edit-classic">
                                            <i class="fas fa-edit"></i> EDIT
                                        </a>
                                        @if($u->id_user != auth()->user()->id_user)
                                        <form action="{{ route('user.destroy', $u->id_user) }}" method="POST" style="display:inline;" onsubmit="return confirm('Hapus user ini?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn-delete-classic">HAPUS</button>
                                        </form>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* CSS Tabel Classic */
    .table-classic {
        width: 100%;
        border-collapse: collapse;
        margin-top: 10px;
    }

    .table-classic th {
        background-color: #f8f9fc;
        color: #4e73df;
        font-weight: bold;
        padding: 12px;
        border: 1px solid #e3e6f0;
        text-align: center;
        font-size: 12px;
        text-transform: uppercase;
    }

    .table-classic td {
        padding: 12px;
        border: 1px solid #e3e6f0;
        font-size: 13px;
        color: #5a5c69;
        vertical-align: middle;
    }

    /* Tombol Tambah Baru */
    .btn-add-classic {
        background-color: #1cc88a;
        color: white;
        padding: 10px 18px;
        border-radius: 4px;
        text-decoration: none;
        font-weight: bold;
        font-size: 12px;
        transition: 0.3s;
        display: inline-block;
        border: none;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .btn-add-classic:hover {
        background-color: #17a673;
        color: white;
        text-decoration: none;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }

    /* Badge Role */
    .badge-role {
        padding: 5px 10px;
        border-radius: 20px;
        font-size: 10px;
        font-weight: bold;
        color: white;
    }

    .role-admin {
        background-color: #4e73df;
    }

    .role-kepdes {
        background-color: #36b9cc;
    }

    /* Tombol Aksi */
    .btn-edit-classic {
        background-color: #f6c23e;
        color: white;
        padding: 6px 12px;
        border-radius: 4px;
        text-decoration: none;
        font-weight: bold;
        font-size: 11px;
    }

    .btn-delete-classic {
        background-color: #e74a3b;
        color: white;
        padding: 5px 10px;
        border: none;
        border-radius: 4px;
        font-weight: bold;
        font-size: 11px;
        cursor: pointer;
    }

    .btn-edit-classic:hover {
        background-color: #dda20a;
        color: white;
    }
</style>
@endsection