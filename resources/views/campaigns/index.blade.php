@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">
        Campaign List
    </h2>

   <form action="{{ route('campaigns.index') }}" method="GET">
        <div class="row mb-4">
            <div class="col-md-3">
                <label for="brand">Brand</label>
                <select name="brand" id="brand" class="form-control">
                    <option value="">All Brands</option>
                    @foreach($brands as $brand)
                        <option value="{{ $brand->id }}" {{ request('brand') == $brand->id ? 'selected' : '' }}>
                            {{ $brand->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label for="start_date">Start Date</label>
                <input type="date" name="start_date" id="start_date" class="form-control" value="{{ $startDate }}">
            </div>
            <div class="col-md-3">
                <label for="end_date">End Date</label>
                <input type="date" name="end_date" id="end_date" class="form-control" value="{{ $endDate }}">
            </div>
            <div class="col-md-3 pt-5">
                <button type="submit" class="btn btn-primary mt-1">Search</button>
            </div>
        </div>
    </form>


    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">
                        @include('partials.table-header', ['headerTitle' => 'Campaign Name', 'sort' => 'name', 'order' => $orderBy])
                    </th>
                    <th scope="col">
                        @include('partials.table-header', ['headerTitle' => 'Brand Name', 'sort' => 'brand', 'order' => $orderBy])
                    </th>
                    <th scope="col">
                        @include('partials.table-header', ['headerTitle' => 'Impressions', 'sort' => 'impressions', 'order' => $orderBy])
                    </th>
                    <th scope="col">
                        @include('partials.table-header', ['headerTitle' => 'Interactions', 'sort' => 'interactions', 'order' => $orderBy])
                    </th>
                    <th scope="col">
                        @include('partials.table-header', ['headerTitle' => 'Conversions', 'sort' => 'conversions', 'order' => $orderBy])
                    </th>
                    <th scope="col">
                        @include('partials.table-header', ['headerTitle' => 'Conversion Rate %', 'sort' => 'conversion_rate', 'order' => $orderBy])
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach($campaigns as $campaign)
                <tr>
                    <td>{{ $campaign->name }}</td>
                    <td>{{ $campaign->brand->name }}</td>
                    <td>{{ $campaign->total_impressions_count }}</td>
                    <td>{{ $campaign->total_interactions_count }}</td>
                    <td>{{ $campaign->total_conversions_count }}</td>
                    <td>
                        @if($campaign->total_interactions_count > 0)
                            {{ round(($campaign->total_conversions_count / $campaign->total_interactions_count) * 100, 2) }}%
                        @else
                            N/A
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="my-5">
        {{ $campaigns->links() }}
    </div>
</div>
@endsection
