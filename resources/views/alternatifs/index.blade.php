@extends('layouts.main')
@section('container')
    <div class="row">
        <div class="col-lg-12 mt-3 mb-3 text-center">
            <h3>MASTER ALTERNATIF</h3>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-5 mb-3">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalAlternatif"
                onclick="return tambahAlternatif('{{ route('storeAlternatif') }}')">
                <i class="bi bi-plus"></i>Tambah
            </button>

        </div>
        <div class="col-lg-7 mb-3">
            <form action="{{ url('alternatif') }}">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Cari nama alternatif"
                        aria-label="Cari nama alternatif" aria-describedby="btnSeacrhalternatif" name="search-alternatif"
                        value={{ request('search-alternatif') }}>
                    <button class="btn btn-secondary" type="submit" id="btnSeacrhalternatif"><i
                            class="bi bi-search"></i></button>
                </div>
            </form>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            @if (session('success'))
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong>Success</strong> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <table class="table table-hover table-bordered overflow-x-scroll">
                <thead>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Nama</th>
                        <th scope="col" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $p)
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td>{{ $p->nama }}</td>
                            <td class="text-center">
                                <div class="btn-group" role="group" aria-label="Basic example">

                                    <button type="button" class="btn p-0"
                                        onclick=" return updateAlternatif('{{ route('updateAlternatif', ['id' => $p->id]) }}', '{{ $p->id }}', '{{ $p->nama }}')"
                                        data-bs-toggle="modal" data-bs-target="#modalAlternatif"><span
                                            class="badge text-bg-primary"> <i
                                                class="bi bi-pencil-square"></i></span></button>
                                    <form action="{{ route('deleteAlternatif', ['id' => $p->id]) }}" method="POST"
                                        onsubmit="return deleteStatus('{{ $p->nama }}')">
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
    <div class="modal fade" id="modalAlternatif" tabindex="-1" aria-labelledby="modalAlternatifLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="modalAlternatifLabel">Form Alternatif</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ url('alternatif') }}" method="post" enctype="multipart/form-data"
                        id="form-alternatif">
                        @csrf
                        <div class="mb-3">
                            <label for="txtnama" class="form-label">Keterangan Alternatif</label>
                            <input class="form-control" type="hidden" id="txtid" name="txtid">
                            <input class="form-control" type="text" id="txtnama" name="txtnama" required>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary btn-alternatif">Save</button>
                </div>
                </form>
            </div>
        </div>
    </div>
@endsection
