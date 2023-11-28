@extends('layouts.main')

@section('container')
    <div class="row">
        <div class="col-lg-12 text-center">
            <h3>TOPSIS RESULT</h3>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-block">
                    <h3>{{ __('Matrix') }}</h3>
                    <span>Tahap <code>Pertama</code> Matriks Awal</span>
                </div>
                <div class="card-body p-0 table-border-style">
                    <div class="table-responsive p-4">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{ __('First Name') }}</th>
                                    @foreach ($criterias as $criteria)
                                        <th>{{ 'C' . $loop->index + 1 }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($matrix as $data)
                                    <tr>
                                        <th scope="row">{{ $loop->index + 1 }}</th>
                                        <td> {{ $data['name'] }} </td>
                                        @foreach ($data['values'] as $data)
                                            <td>{{ $data }}</td>
                                        @endforeach
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endsection
