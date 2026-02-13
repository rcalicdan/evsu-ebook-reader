@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <script>
        function documentUploadsChart() {
            return {
                chart: null,
                init() {
                    const labels = [];
                    const data = [];
                    const today = new Date();

                    const staticData = [3, 5, 2, 7, 4, 6, 8, 3, 5, 9, 4, 6, 7, 5, 8, 3, 6, 4, 9, 7, 5, 8, 6, 4, 7, 9, 5, 8,
                        6, 10
                    ];

                    for (let i = 29; i >= 0; i--) {
                        const date = new Date(today);
                        date.setDate(date.getDate() - i);
                        labels.push(date.toLocaleDateString('en-US', {
                            month: 'short',
                            day: 'numeric'
                        }));
                        data.push(staticData[29 - i]);
                    }

                    const ctx = this.$refs.chartCanvas.getContext('2d');

                    this.chart = new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: labels,
                            datasets: [{
                                label: 'Documents Uploaded',
                                data: data,
                                borderColor: 'rgb(185, 28, 28)',
                                backgroundColor: 'rgba(185, 28, 28, 0.1)',
                                tension: 0.4,
                                fill: true,
                                pointRadius: 2,
                                pointHoverRadius: 5,
                                borderWidth: 2
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    display: false
                                },
                                tooltip: {
                                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                                    padding: 12,
                                    titleColor: '#fff',
                                    bodyColor: '#fff',
                                    borderColor: 'rgba(255, 255, 255, 0.1)',
                                    borderWidth: 1,
                                    displayColors: false,
                                    callbacks: {
                                        title: function(context) {
                                            return context[0].label;
                                        },
                                        label: function(context) {
                                            return context.parsed.y + ' documents uploaded';
                                        }
                                    }
                                }
                            },
                            scales: {
                                x: {
                                    grid: {
                                        display: false
                                    },
                                    ticks: {
                                        maxRotation: 45,
                                        minRotation: 45,
                                        font: {
                                            size: 10
                                        }
                                    }
                                },
                                y: {
                                    beginAtZero: true,
                                    grid: {
                                        color: 'rgba(0, 0, 0, 0.05)'
                                    },
                                    ticks: {
                                        stepSize: 2,
                                        font: {
                                            size: 11
                                        }
                                    }
                                }
                            }
                        }
                    });
                }
            }
        }
    </script>
@endpush
