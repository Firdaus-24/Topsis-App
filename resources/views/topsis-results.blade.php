@extends('layouts.main')

@section('container')
    <div class="row">
        <div class="col-lg-12 mt-3 mb-3 text-center">
            <h3>TOPSIS RESULT</h3>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 mb-3">
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
                                    <th>No</th>
                                    <th>{{ __('Gudang') }}</th>
                                    @foreach ($criterias as $criteria)
                                        <th>{{ 'C' . $loop->index + 1 }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($matrix as $data)
                                    <tr>
                                        <th scope="row">{{ $loop->index + 1 }}</th>
                                        <td> {{ $data['nama'] }} </td>
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
        </div>
    </div>
    {{-- normalized Matrix --}}
    <div class="row">
        <div class="col-lg-12 mt-3 ">
            <div class="card">
                <div class="card-header d-block">
                    <h3>{{ __('Nomalisasi Matrix') }}</h3>
                    <span>Tahap <code>Kedua</code> Normalisasi Matrix</span>
                </div>
                <div class="card-body p-0 table-border-style">
                    <div class="table-responsive p-4">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>{{ __('Gudang') }}</th>
                                    @foreach ($criterias as $criteria)
                                        <th>{{ 'C' . $loop->index + 1 }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($normalizedMatrix as $matrixNormalized)
                                    <tr>
                                        <th scope="row">{{ $loop->index + 1 }}</th>
                                        <td> {{ $matrixNormalized['nama'] }} </td>
                                        @foreach ($matrixNormalized['values'] as $data)
                                            <td>{{ $data }}</td>
                                        @endforeach
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 mt-3">
            {{-- Weighted Matrix --}}
            <div class="card">
                <div class="card-header d-block">
                    <h3>{{ __('Weight Matrix') }}</h3>
                    <span>Tahap <code>Ke tiga</code> Pembobotan Matrix</span>

                </div>
                <div class="card-body p-0 table-border-style">
                    <div class="table-responsive p-4">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>{{ __('Name') }}</th>
                                    @foreach ($criterias as $criteria)
                                        <th scope="col">
                                            {{ 'C' . $loop->index + 1 }}
                                            <br />
                                            ({{ $criteria['type'] }})
                                        </th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($weightedMatrix as $wighted)
                                    <tr>
                                        <th scope="row">{{ $loop->index + 1 }}</th>
                                        <td> {{ $wighted['nama'] }} </td>
                                        @foreach ($wighted['values'] as $data)
                                            <td>{{ $data['value'] }}</td>
                                        @endforeach
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 mt-3">
            {{-- Ideal Positive --}}
            <div class="card">
                <div class="card-header d-block">
                    <h3>Matrix Solusi Ideal </h3>
                    <span>Tahap <code>Keempat</code> Matrix Solusi Ideal</span>

                </div>
                <div class="card-body p-0 table-border-style">
                    <div class="table-responsive p-4">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>{{ __('Gudang') }}</th>
                                    @foreach ($criterias as $criteria)
                                        <th scope="col" class="text-center">
                                            {{ 'C' . $loop->index + 1 }}
                                            <br />
                                            ({{ $criteria['type'] }})
                                        </th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($idealSolution['MatrixIdealSolutions'] as $dataIdealSolution)
                                    <tr>
                                        <th scope="row">{{ $loop->index + 1 }}</th>
                                        <td> {{ $dataIdealSolution['nama'] }} </td>
                                        @foreach ($dataIdealSolution['values'] as $data)
                                            <td class="text-center">{{ $data['value'] }}</td>
                                        @endforeach
                                    </tr>
                                @endforeach

                                <tr class="">
                                    <th scope="row" colspan="2" class="text-center">MAX</th>
                                    @foreach ($idealSolution['MAX'] as $item)
                                        <td class="text-center">{{ $item }}</td>
                                    @endforeach
                                </tr>

                                <tr class="">
                                    <th scope="row" colspan="2" class="text-center">MIN</th>
                                    @foreach ($idealSolution['MIN'] as $item)
                                        <td class="text-center">{{ $item }}</td>
                                    @endforeach
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 mt-3">
            {{-- Distance --}}
            <div class="card">
                <div class="card-header d-block">
                    <h3>{{ __('Distances Matrix') }}</h3>
                    <span>Solusi Ideal<code> Positive</code> </span>
                </div>
                <div class="card-body p-0 table-border-style">
                    <div class="table-responsive p-4">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{ __('Name') }}</th>
                                    @foreach ($criterias as $criteria)
                                        <th scope="col">
                                            {{ 'C' . $loop->index + 1 }}
                                        </th>
                                    @endforeach
                                    <th scope="col"> D+ </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($distances['DistancePositive'] as $distancePositive)
                                    <tr>
                                        <th scope="row">{{ $loop->index + 1 }}</th>
                                        <td> {{ $distancePositive['nama'] }} </td>
                                        @foreach ($distancePositive['dataMatrix'] as $data)
                                            <td>{{ $data['value'] }}</td>
                                        @endforeach
                                        <td>{{ $distancePositive['dPositive'] }}</td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 mt-3">
            <div class="card">
                <div class="card-header d-block">
                    <h3>{{ __('Distances Matrix') }}</h3>
                    <span>Solusi Ideal<code>Negative</code> </span>
                </div>
                <div class="card-body p-0 table-border-style">
                    <div class="table-responsive p-4">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>{{ __('Gudang') }}</th>
                                    @foreach ($criterias as $criteria)
                                        <th scope="col">
                                            {{ 'C' . $loop->index + 1 }}
                                        </th>
                                    @endforeach
                                    <th scope="col"> D- </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($distances['DistanceNegative'] as $dNegative)
                                    <tr>
                                        <th scope="row">{{ $loop->index + 1 }}</th>
                                        <td> {{ $dNegative['name'] }} </td>
                                        @foreach ($dNegative['dataMatrix'] as $data)
                                            <td>{{ $data['value'] }}</td>
                                        @endforeach
                                        <td>{{ $dNegative['dNegative'] }}</td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 mt-3">
            {{-- reference --}}
            <div class="card">
                <div class="card-header d-block">
                    <h3>{{ __('Result Pereference') }}</h3>
                    <span>Tahap <code>Keenam</code> Mencari Hasil Reference</span>
                </div>
                <div class="card-body p-0 table-border-style">
                    <div class="table-responsive p-4">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>{{ __('Gudang') }}</th>
                                    <th scope="col">D+</th>
                                    <th scope="col">D-</th>
                                    <th scope="col">V</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($resultPreference as $result)
                                    <tr>
                                        <th scope="row">{{ $loop->index + 1 }}</th>
                                        <td> {{ $result['nama'] }} </td>
                                        <td> {{ $result['DPositive_value'] }} </td>
                                        <td> {{ $result['DNegative_value'] }} </td>
                                        <td> {{ $result['result'] }} </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 mt-3">
            {{-- Rank --}}
            <div class="card">
                <div class="card-header d-block">
                    <h3>{{ __('Rank Result') }}</h3>
                    <span>Tahap <code>Ke 7</code> Perankingan</span>

                </div>
                <div class="card-body p-0 table-border-style">
                    <div class="table-responsive p-4">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>{{ __('Gudang') }}</th>
                                    <th>{{ __('D+') }}</th>
                                    <th>{{ __('D-') }}</th>
                                    <th>{{ __('V') }}</th>
                                    <th>{{ __('Rank') }}</th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($rankedAlternatives as $result)
                                    <tr>
                                        <th scope="row">{{ $loop->index + 1 }}</th>
                                        <td> {{ $result['nama'] }} </td>
                                        <td> {{ $result['DPositive_value'] }} </td>
                                        <td> {{ $result['DNegative_value'] }} </td>
                                        <td> {{ $result['result'] }} </td>
                                        <td> {{ $result['rank'] }} </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
