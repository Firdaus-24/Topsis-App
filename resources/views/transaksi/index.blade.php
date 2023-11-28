@extends('layouts.main')
@section('container')
    <div class="row">
        <div class="col-lg-12 text-center mt-3 mb-3">
            <h3>TRANSACTIONS</h3>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-5 mb-3">
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#modalTransaksi">
                <i class="bi bi-cloud-plus-fill"></i> Upload
            </button>
        </div>
        <div class="col-lg-7 mb-3">
            <form action="{{ url('transactions') }}">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Cari nama transaksi"
                        aria-label="Cari nama transaksi" aria-describedby="btnSeacrhTrans" name="search-trans"
                        value={{ request('search-trans') }}>
                    <button class="btn btn-secondary" type="submit" id="btnSeacrhTrans"><i
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
                        <th scope="col">Alternatif</th>
                        <th scope="col">Creteria</th>
                        <th scope="col">Value</th>
                        <th scope="col" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $p)
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td>{{ $p->gudangs->nama }}</td>
                            <td>{{ $p->creteria->nama }}</td>
                            <td>{{ $p->value }}</td>
                            <td class="text-center">
                                <div class="btn-group" role="group" aria-label="Basic example">

                                    <button type="button" class="btn p-0"
                                        onclick=window.location="{{ route('transaksiEdit', ['id' => $p->id]) }}"><span
                                            class="badge text-bg-primary"> <i
                                                class="bi bi-pencil-square"></i></span></button>
                                    <form action="{{ route('transaksiDelete', ['id' => $p->id]) }}"
                                        onsubmit="return deleteStatus('{{ $p->gudangs->nama . ' - ' . $p->creteria->nama }}')"
                                        method="post">
                                        @csrf
                                        {{-- @method('DELETE') --}}
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
    <div class="d-flex flex-row-reverse">
        <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-end">
                {{ $data->appends(['search-trans' => request('search-trans')]) }}
            </ul>
        </nav>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="modalTransaksi" tabindex="-1" aria-labelledby="modalTransaksiLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="modalTransaksiLabel">Import data</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('importTransaksi') }}" method="post" enctype="multipart/form-data">
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
