@extends('layouts.main')

@section('container')
    <div class="row">
        <div class="col-lg-12 text-center mt-3">
            <h3>FORM CRITERIA</h3>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 mt-3">
            <div class="card">
                <div class="card-header">
                    <button type="button" class="btn btn-sm btn-warning"
                        onclick="window.location='{{ url('creteria') }}'">Kembali</button>
                </div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <strong> {{ session('success') }}</strong>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    <form action="{{ url('creteria/' . $data->id) }}" method="POST" onsubmit="return formGudang()">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <div class="row">
                                <div class="col-lg-6 mb-3">
                                    <label for="txtnama" class="form-label">Nama</label>
                                    <input type="text"
                                        class="form-control @error('txtnama') is-invalid
                                        
                                    @enderror"
                                        id="txtnama" autocomplete="off" autofocus name="txtnama"
                                        value="{{ $data->nama }}" required>
                                    @error('txtnama')
                                        <div id="validationServerUsernameFeedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-lg-6 mb-3">
                                    <label class="form-label">Type</label>
                                    <select class="form-select"
                                        aria-label="Default select example  @error('type') is-invalid
                                        
                                    @enderror"d
                                        id="txttype" name="txttype" required>
                                        <option value="">Pilih</option>
                                        <option value="COST" {{ $data->type == 'COST' ? 'selected' : '' }}>COST
                                        </option>
                                        <option value="BENEFIT" {{ $data->type == 'BENEFIT' ? 'selected' : '' }}>BENEFIT
                                        </option>

                                    </select>
                                    @error('txttype')
                                        <div id="validationServerUsernameFeedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 mb-3">
                                    <label for="txtbobot" class="form-label">Bobot</label>
                                    <input type="number"
                                        class="form-control @error('txtbobot') is-invalid
                                        
                                    @enderror"
                                        id="txtbobot" autocomplete="off" autofocus name="txtbobot"
                                        value="{{ $data->bobot }}" required>
                                    @error('txtbobot')
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
