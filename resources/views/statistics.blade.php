<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Statistics') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h3 class="font-semibold text-lg text-gray-800">Income vs Expense</h3>
                            <canvas id="incomeExpenseChart"></canvas>
                        </div>
                        <div>
                            <h3 class="font-semibold text-lg text-gray-800">Weekly Activity</h3>
                            <canvas id="weeklyActivityChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const incomeExpenseCtx = document.getElementById('incomeExpenseChart').getContext('2d');
            new Chart(incomeExpenseCtx, {
                type: 'doughnut',
                data: {
                    labels: ['Income', 'Expenses'],
                    datasets: [{
                        data: [{{ auth()->user()->accounts()->first()->transactions()->where('type', 'deposit')->sum('amount') }}, {{ auth()->user()->accounts()->first()->transactions()->where('type', '!=', 'deposit')->sum('amount') }}],
                        backgroundColor: ['#10b981', '#ef4444'],
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                    }
                }
            });

            const weeklyActivityCtx = document.getElementById('weeklyActivityChart').getContext('2d');
            new Chart(weeklyActivityCtx, {
                type: 'bar',
                data: {
                    labels: ['Week 1', 'Week 2', 'Week 3', 'Week 4'], // Placeholder labels
                    datasets: [{
                        label: 'Income',
                        data: [1200, 1900, 3000, 5000], // Placeholder data
                        backgroundColor: '#10b981',
                    }, {
                        label: 'Expenses',
                        data: [800, 1200, 2500, 4000], // Placeholder data
                        backgroundColor: '#ef4444',
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        x: {
                            stacked: true,
                        },
                        y: {
                            stacked: true
                        }
                    }
                }
            });
        });
    </script>
</x-app-layout>
