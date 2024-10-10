@extends('admin/index')
@section('title', 'Create/Edit User')
@section('content')

<div>
    <!-- Dropdown to select daily, weekly, monthly, yearly -->
    <form method="GET" action="{{ route('revenue.chart') }}" id="filterForm">
        <select name="filter" id="filter">
            <option value="daily" {{ $option == 'daily' ? 'selected' : '' }}>Daily</option>
            <option value="weekly" {{ $option == 'weekly' ? 'selected' : '' }}>Weekly</option>
            <option value="monthly" {{ $option == 'monthly' ? 'selected' : '' }}>Monthly</option>
            <option value="yearly" {{ $option == 'yearly' ? 'selected' : '' }}>Yearly</option>
        </select>
    </form>
</div>

<div style="width: 40%">
    <canvas id="revenueChart"></canvas>
</div>

<script>
    // Get the labels and data from Laravel for chart.js
    const labels = {!! json_encode($data->pluck($option == 'daily' ? 'date' : ($option == 'weekly' ? 'week' : ($option == 'monthly' ? 'month' : 'year')))) !!};
    const values = {!! json_encode($data->pluck('total')) !!};

    // Initialize the chart
    const ctx = document.getElementById('revenueChart').getContext('2d');
    const revenueChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Revenue',
                data: values,
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Trigger the form submit on filter change
    document.getElementById('filter').addEventListener('change', function() {
        document.getElementById('filterForm').submit();
    });
</script>



@endsection
