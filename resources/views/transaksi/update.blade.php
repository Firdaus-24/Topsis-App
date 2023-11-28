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
                        onclick="window.location='{{ url('transactions') }}'">Kembali</button>
                </div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <strong> {{ session('success') }}</strong>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    <form action="{{ route('transaksiUpdate', ['id' => $data->id]) }}" method="POST"
                        onsubmit="return formGudang()">
                        @csrf
                        {{-- @method('PUT') --}}
                        <input type="hidden" class="form-control" id="txtid" autocomplete="off" autofocus
                            name="txtid" value="{{ $data->id }}" required>
                        <div class="mb-3">
                            <div class="row">
                                <div class="col-lg-6 mb-3">
                                    <label for="txtgudangid" class="form-label">Gudang</label>
                                    <select
                                        class="form-select @error('txtgudangid') is-invalid
                                        
                                    @enderror"
                                        aria-label="Default select example" name="txtgudangid" id="txtgudangid" required>
                                        <option value="">Pilih</option>
                                        @foreach ($gudang as $g)
                                            <option value="{{ $g->id }}"
                                                {{ $data->gudangs_id == $g->id ? 'selected' : '' }}>{{ $g->nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('txtgudangid')
                                        <div id="validationServerUsernameFeedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-lg-6 mb-3">
                                    <label class="form-label">Criteria</label>
                                    <select class="form-select"
                                        aria-label="Default select example  @error('txtcreteria') is-invalid
                                        
                                    @enderror"
                                        id="txtcreteria" name="txtcreteria" required>
                                        <option value="">Pilih</option>
                                        @foreach ($creteria as $c)
                                            <option value="{{ $c->id }}"
                                                {{ $data->creterias_id == $c->id ? 'selected' : '' }}>
                                                {{ $c->nama }}</option>
                                        @endforeach
                                    </select>
                                    @error('txtcreteria')
                                        <div id="validationServerUsernameFeedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 mb-3">
                                    <label for="txtvalue" class="form-label">Value</label>
                                    <input type="text"
                                        class="form-control @error('txtvalue') is-invalid
                                        
                                    @enderror"
                                        id="txtvalue" autocomplete="off" autofocus name="txtvalue"
                                        value="{{ $data->value }}" required>
                                    @error('txtvalue')
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
