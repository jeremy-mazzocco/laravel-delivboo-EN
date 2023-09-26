@extends('dashboard.dashboard')

@section('dashboardSection')
    <div class="card-header">
        <h1>Statistics</h1>
        <p class="text-light text-center"><small>Income August 2023</small></p>
    </div>

    <canvas id="myChart" width="400" height="200"></canvas>

    <script>
        const daysOfMonth = Array.from({
            length: 31
        }, (_, index) => index + 1);

        const dailyTotals = @json($dailyTotals);
        const dates = Object.keys(dailyTotals);
        const totals = Object.values(dailyTotals);

        const ctx = document.getElementById('myChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: dates,
                datasets: [{
                    label: 'Orders p/day',
                    data: totals,
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1,
                    fill: false
                }]
            },
            options: {
                scales: {
                    x: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Day of the Month'
                        },
                    },
                    y: {
                        beginAtZero: true,

                        title: {
                            display: true,
                            text: 'Value (€)'
                        },
                        ticks: {
                            callback: function(value, index, values) {
                                return value + '€';
                            }
                        }
                    }
                }
            }
        });
    </script>
@endsection
