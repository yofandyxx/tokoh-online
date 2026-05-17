@extends('admin.layout.app')
@section('title', 'Daftar User')
@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3>Daftar User</h3>
            <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Tambah User
            </a>
        </div>
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th width="180px">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $u)
                    <tr>
                        <td>{{ $loop->iteration + ($users->currentPage() - 1) * $users->perPage() }}</td>
                        <td>{{ $u->name }}</td>
                        <td>{{ $u->email }}</td>
                        <td>{{ ucfirst($u->role) }}</td>
                        <td>
                            <a href="{{ route('admin.users.edit', $u->id) }}" class="btn btn-warning btn-sm">
                                <i class="bi bi-pencil-square"></i> Edit
                            </a>
                            <form action="{{ route('admin.users.destroy', $u->id) }}" method="POST" class="d-inline"
                                onsubmit="return confirm('Yakin ingin menghapus user ini?');">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm">
                                    <i class="bi bi-trash"></i> Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">Belum ada user</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="d-flex justify-content-end">
            {{ $users->links() }}
        </div>
    </div>
@endsection