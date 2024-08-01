@extends('layout.app')

@section('content')
<div class="container mb-5">
    <form method="get">
        <div class="row">
            <div class="col-lg-4 col-md-6">
                <label for="" class="fw-bold">Choose Station</label>
                <select name="station" class="form-control" onchange="this.form.submit()">
                    <option value="">--select station--</option>
                    @foreach ($stations as $station)
                        <option value="{{ $station['code'] }}" {{ $selected_station == $station['code'] ? 'selected' : '' }}>{{ $station['namen']['lang'] }}</option>
                    @endforeach
                </select>
                @if(isset($error))
                    <div class="alert alert-danger">{{ $error }}</div>
                @endif
            </div>
        </div>
    </form>
</div>

<div class="container mb-3">
    <h3>Arrivals</h3>
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>Origin</th>
                    <th>Name</th>
                    <th>Time</th>
                    <th>Category</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($arrivals as $arrival)
                    <tr>
                        <td>{{ $arrival['origin'] }}</td>
                        <td>{{ $arrival['name'] }}</td>
                        <td>{{ \Carbon\Carbon::parse($arrival['plannedDateTime'])->format('d M Y H:i:s') }}</td>
                        <td>{{ $arrival['trainCategory'] }}</td>
                        <td>{{ $arrival['cancelled'] ? 'Cancelled' : 'Scheduled' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">No data found!</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="container">
    <h3>Departures</h3>
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>Direction</th>
                    <th>Name</th>
                    <th>Time</th>
                    <th>Category</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($departures as $departure)
                    <tr>
                        <td>{{ $departure['direction'] }}</td>
                        <td>{{ $departure['name'] }}</td>
                        <td>{{ \Carbon\Carbon::parse($departure['plannedDateTime'])->format('d M Y H:i:s') }}</td>
                        <td>{{ $departure['trainCategory'] }}</td>
                        <td>{{ $departure['cancelled'] ? 'Cancelled' : 'Scheduled' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">No data found!</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
