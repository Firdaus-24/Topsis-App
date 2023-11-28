@extends('layouts.main')
@section('container')
    <div class="row">
        <div class="col-lg-12 text-center mt-3">
            <h3>FORM UPDATE GUDANG</h3>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 mt-3">
            <div class="card">
                <div class="card-header">
                    <button type="button" class="btn btn-sm btn-warning"
                        onclick="window.location='{{ url('gudangs') }}'">Kembali</button>
                </div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <strong> {{ session('success') }}</strong>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    <form action="{{ url('gudangs/' . $txtid) }}" method="POST" onsubmit="return formGudang()">
                        @csrf
                        <input type="hidden" class="form-control" id="txtid" autocomplete="off" autofocus
                            name="txtid" value="{{ $txtid }}" required>
                        @method('PUT')
                        <div class="mb-3">
                            <div class="row">
                                <div class="col-lg-6 mb-3">
                                    <label for="txtnama" class="form-label">Nama</label>
                                    <input type="text"
                                        class="form-control @error('txtnama') is-invalid
                                        
                                    @enderror"
                                        id="txtnama" autocomplete="off" autofocus name="txtnama"
                                        value="{{ $txtnama }}" required>
                                    @error('txtnama')
                                        <div id="validationServerUsernameFeedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-lg-6 mb-3">
                                    <label class="form-label">Status</label>
                                    <select class="form-select"
                                        aria-label="Default select example  @error('status') is-invalid
                                        
                                    @enderror"
                                        id="status" name="status" required>
                                        <option value="">Pilih</option>
                                        @foreach ($statuses as $status)
                                            <option value="{{ $status->id }}"
                                                {{ $txtstatus == $status->id ? 'selected' : '' }}>
                                                {{ $status->status_nama }}</option>
                                        @endforeach
                                    </select>
                                    @error('status')
                                        <div id="validationServerUsernameFeedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 mb-3">
                                    <label for="txtkota" class="form-label">Kota</label>
                                    <input type="text"
                                        class="form-control @error('txtkota') is-invalid
                                        
                                    @enderror"
                                        id="txtkota" autocomplete="off" autofocus name="txtkota"
                                        value="{{ $txtkota }}" required>
                                    @error('txtkota')
                                        <div id="validationServerUsernameFeedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-lg-6 mb-3">
                                    <label for="txtkecamatan" class="form-label">Kecamatan</label>
                                    <input type="text"
                                        class="form-control  @error('txtkecamatan') is-invalid
                                        
                                    @enderror"
                                        id="txtkecamatan" autocomplete="off" autofocus name="txtkecamatan"
                                        value="{{ $txtkecamatan }}" required>
                                    @error('txtkecamatan')
                                        <div id="validationServerUsernameFeedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 mb-3">
                                    <label for="txtlong" class="form-label">Longitude</label>
                                    <input type="text"
                                        class="form-control  @error('txtlong') is-invalid
                                        
                                    @enderror"
                                        id="txtlong" autocomplete="off" autofocus name="txtlong"
                                        value="{{ $txtlong }}" required>
                                    @error('txtlong')
                                        <div id="validationServerUsernameFeedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-lg-6 mb-3">
                                    <label for="txtlat" class="form-label">Latitude</label>
                                    <input type="text"
                                        class="form-control  @error('txtlat') is-invalid
                                        
                                    @enderror"
                                        id="txtlat" autocomplete="off" autofocus name="txtlat"
                                        value="{{ $txtlat }}" required>
                                    @error('txtlat')
                                        <div id="validationServerUsernameFeedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 mb-3">
                                    <label for="tglsewa" class="form-label">Tanggal sewa</label>
                                    <input type="date"
                                        class="form-control @error('tglsewa') is-invalid
                                        
                                    @enderror"
                                        id="tglsewa" autocomplete="off" autofocus name="tglsewa"
                                        value="{{ $tglsewa }}" required>
                                    @error('tglsewa')
                                        <div id="validationServerUsernameFeedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-lg-6 d-flex justify-content-end">
                                    <div class="align-self-end p-2">
                                        <button type="submit" class="btn btn-primary">Update</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
