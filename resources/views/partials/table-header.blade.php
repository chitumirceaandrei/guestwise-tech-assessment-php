@props(['headerTitle', 'sort', 'sortBy', 'orderBy'])
<a href="{{ route('campaigns.index', array_merge(request()->all(), ['sort' => $sort, 'order' => $orderBy == 'asc' ? 'desc' : 'asc'])) }}">
    {{ $headerTitle }}
</a>
<a href="{{ route('campaigns.index', array_merge(request()->all(), ['sort' => $sort, 'order' => 'asc'])) }}" class="@if($sortBy === $sort && $orderBy === 'asc') text-primary @else text-dark @endif">
    <i class="bi @if($sortBy === $sort && $orderBy === 'asc') bi-caret-up-fill @else bi-caret-up @endif"></i>
</a>
<a href="{{ route('campaigns.index', array_merge(request()->all(), ['sort' => $sort, 'order' => 'desc'])) }}" class="@if($sortBy === $sort && $orderBy === 'desc') text-primary @else text-dark @endif">
    <i class="bi @if($sortBy === $sort && $orderBy === 'desc') bi-caret-down-fill @else bi-caret-down @endif"></i>
</a>