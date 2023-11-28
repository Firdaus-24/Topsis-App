@extends('layouts.main')
@section('container')
    <div class="row">
        <div class="col-lg-12  text-center mt-3 mb-3">
            <h3>MASTER STATUS</h3>
        </div>
    </div>
    @error('txtnama')
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>{{ $message }}</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @enderror
    @if (session('success'))
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <strong> {{ session('success') }}</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <div class="row">
        <div class="col-lg-2 mb-3">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalStatus"
                onclick="tambahStatus('{{ route('statuses.store') }}')">
                <i class="bi bi-plus"></i>Tambah
            </button>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <table class="table table-hover table-bordered">
                <thead>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Nama</th>
                        <th scope="col">Update time</th>
                        <th scope="col" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $p)
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td>{{ $p->status_nama }}</td>
                            <td>{{ $p->created_at }}</td>

                            <td class="text-center">
                                <div class="btn-group" role="group" aria-label="Basic example">
                                    <form action="{{ route('statuses.delete', ['id' => $p->id]) }}" method="POST"
                                        onsubmit="return deleteStatus('{{ $p->status_nama }}')">
                                        <button type="button" class="btn p-0 btn-primary"
                                            onclick="getStatus('{{ route('statuses.update', ['id' => $p->id]) }}', '{{ $p->id }}')"
                                            data-bs-toggle="modal" data-bs-target="#modalStatus">
                                            <span class="badge text-bg-primary"> <i class="bi bi-pencil-square"></i></span>
                                        </button>

                                        @csrf

                                        <button type="submit" class="btn p-0">
                                            <span
                                                class="badge @if ($p->is_active == 1) text-bg-danger @else text-bg-warning @endif ">
                                                @if ($p->is_active == 1)
                                                    <i class="bi bi-trash"></i>
                                                @else
                                                    <i class="bi bi-arrow-repeat"></i>
                                                @endif
                                            </span>
                                        </button>

                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal modalStatus fade" id="modalStatus" tabindex="-1" aria-labelledby="modalStatusLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="modalStatusLabel">Modal Status</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="#" method="POST" id="formStatus">
                        @csrf
                        <div class="mb-3">
                            <label for="txtnama" class="form-label">Nama</label>
                            <input type="hidden" class="form-control" id="txtid" name="txtid" autocomplete="off"
                                required>
                            <input type="text" class="form-control" id="txtnama" name="txtnama" autocomplete="off"
                                autofocus required>

                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
