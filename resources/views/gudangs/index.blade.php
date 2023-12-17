@extends('layouts.main')

@section('container')
    <div class="row">
        <div class="col-lg-12 mt-3 mb-3 text-center">
            <h3>MASTER GUDANGS</h3>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-5 mb-3">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalStatus"
                onclick="window.location.href =('{{ url('gudangs/add') }}')">
                <i class="bi bi-plus"></i>Tambah
            </button>
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#modalImportGudang">
                <i class="bi bi-cloud-plus-fill"></i> Upload
            </button>
        </div>
        <div class="col-lg-7 mb-3">
            <form action="{{ url('gudangs') }}">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Cari nama gudang" aria-label="Cari nama gudang"
                        aria-describedby="btnSeacrhGudang" name="search-gudang" value={{ request('search-gudang') }}>
                    <button class="btn btn-secondary" type="submit" id="btnSeacrhGudang"><i
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
                        <th scope="col">Status</th>
                        <th scope="col">Kota</th>
                        <th scope="col">Kecamatan</th>
                        <th scope="col">Mulai sewa</th>
                        <th scope="col">Longitude</th>
                        <th scope="col">Latitude</th>
                        <th scope="col" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $p)
                        <tr>
                            <td> {{ ($data->currentPage() - 1) * $data->perPage() + $loop->iteration }}</td>
                            <td>{{ $p->nama }}</td>
                            <td>{{ $p->statuses->status_nama }}</td>
                            <td>{{ $p->kota }}</td>
                            <td>{{ $p->kecamatan }}</td>
                            <td>{{ $p->mulai_sewa }}</td>
                            <td>{{ $p->longitude }}</td>
                            <td>{{ $p->latitude }}</td>

                            <td class="text-center">
                                <div class="btn-group" role="group" aria-label="Basic example">
                                    <button type="button" class="btn p-0"
                                        onclick=window.location="{{ url('gudangs/' . $p->id) }}"><span
                                            class="badge text-bg-primary"><i
                                                class="bi bi-pencil-square"></i></span></button>
                                    <form action="{{ url('gudangs/' . $p->id) }}"
                                        onsubmit="return deleteStatus('{{ $p->nama }}')" method="post">
                                        @csrf
                                        @method('DELETE')
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
    <nav aria-label="Page navigation example">
        <ul class="pagination justify-content-end">
            {{ $data->appends(['search-gudang' => request('search-gudang')]) }}
        </ul>
    </nav>
    </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="modalImportGudang" tabindex="-1" aria-labelledby="modalImportGudangLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="modalImportGudangLabel">Import data</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ url('import-gudangs') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="formFile" class="form-label">Upload File Excel</label>
                            <input class="form-control" type="file" id="file" name="file" required>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Import</button>
                </div>
                </form>
            </div>
        </div>
    </div>
@endsection
