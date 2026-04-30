<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard Klinik
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- GREETING -->
            <div class="bg-gradient-to-r from-blue-500 to-blue-700 text-white p-6 rounded-lg shadow mb-6">
                <h3 class="text-lg font-semibold">
                    Selamat datang, {{ Auth::user()->name }} 👋
                </h3>
                <p class="text-sm mt-1">
                    Sistem Manajemen Klinik
                </p>
            </div>

            <!-- STATS CARDS -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">

                <div class="bg-white shadow rounded-lg p-5">
                    <p class="text-gray-500 text-sm">Pasien</p>
                    <p class="text-2xl font-bold text-blue-600" id="pasien">0</p>
                </div>

                <div class="bg-white shadow rounded-lg p-5">
                    <p class="text-gray-500 text-sm">Obat</p>
                    <p class="text-2xl font-bold text-green-600" id="obat">0</p>
                </div>

                <div class="bg-white shadow rounded-lg p-5">
                    <p class="text-gray-500 text-sm">Tindakan</p>
                    <p class="text-2xl font-bold text-purple-600" id="tindakan">0</p>
                </div>

                <div class="bg-white shadow rounded-lg p-5">
                    <p class="text-gray-500 text-sm">Transaksi Hari Ini</p>
                    <p class="text-2xl font-bold text-red-600" id="transaksi">0</p>
                </div>

            </div>

            <!-- INCOME CARD -->
            <div class="mt-6 bg-white shadow rounded-lg p-6">
                <h3 class="font-semibold text-lg mb-4">Income 7 Hari Terakhir</h3>

                <canvas id="incomeChart"></canvas>
            </div>
            <div class="mt-4 bg-white shadow rounded-lg p-5">
                <p class="text-gray-500 text-sm">Income Hari Ini</p>
                <p class="text-3xl font-bold text-green-600" id="income">
                    Rp 0
                </p>
            </div>

            <div class="mt-6 bg-white shadow rounded-lg p-6">
                <h3 class="font-semibold text-lg mb-4">Top 5 Obat Terlaris</h3>

                <canvas id="obatPie"></canvas>
            </div>

            <div class="mt-6 bg-white shadow rounded-lg p-5">
                <h3 class="font-bold text-red-600">⚠ Stok Menipis</h3>

                <ul id="stokList"></ul>
            </div>

            <div class="mt-6 bg-white shadow rounded-lg p-5">
                <h3 class="font-bold">Top Obat Terlaris</h3>

                <ul id="topObat"></ul>
            </div>

            <div class="mt-6 bg-white shadow rounded-lg p-5">
                <h3 class="font-bold">Transaksi Terbaru</h3>

                <ul id="latestTransaksi"></ul>
            </div>

            <!-- QUICK ACTION -->
            <div class="mt-6 bg-white shadow rounded-lg p-6">
                <h3 class="font-semibold text-lg mb-4">Quick Action</h3>

                <div class="flex flex-wrap gap-3">

                    <a href="/pasien/create"
                       class="bg-blue-500 text-white px-4 py-2 rounded">
                        + Tambah Pasien
                    </a>

                    <a href="/obat/create"
                       class="bg-green-500 text-white px-4 py-2 rounded">
                        + Tambah Obat
                    </a>

                    <a href="/tindakan/create"
                       class="bg-purple-500 text-white px-4 py-2 rounded">
                        + Tambah Tindakan
                    </a>

                    <a href="/transaksi/create"
                       class="bg-red-500 text-white px-4 py-2 rounded">
                        + Transaksi Baru
                    </a>

                </div>
            </div>

        </div>
    </div>

    <!-- REALTIME SCRIPT -->
    <script>
        function loadDashboard() {
            fetch('/dashboard/data')
                .then(res => res.json())
                .then(data => {

                    document.getElementById('pasien').innerText = data.pasien ?? 0;
                    document.getElementById('obat').innerText = data.obat ?? 0;
                    document.getElementById('tindakan').innerText = data.tindakan ?? 0;
                    document.getElementById('transaksi').innerText = data.transaksi ?? 0;

                    document.getElementById('income').innerText =
                        'Rp ' + (data.income ?? 0).toLocaleString('id-ID');

                });
        }

        loadDashboard();
        setInterval(loadDashboard, 3000);
    </script>
<script>
    let ctx = document.getElementById('incomeChart').getContext('2d');

    fetch('/dashboard/chart')
        .then(res => res.json())
        .then(data => {

            let labels = data.map(item => item.date);
            let values = data.map(item => item.total);

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Income',
                        data: values,
                        borderColor: 'rgb(34, 197, 94)',
                        backgroundColor: 'rgba(34, 197, 94, 0.2)',
                        fill: true,
                        tension: 0.4
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: true
                        }
                    }
                }
            });

        });
</script>
<script>
let pieChart;

function loadPie() {
    fetch('/dashboard/pie-obat')
        .then(res => res.json())
        .then(data => {

            let labels = data.map(item => item.nama_obat);
            let values = data.map(item => item.total);

            let colors = data.map((_, i) => {
                return `hsl(${i * 35}, 70%, 60%)`;
            });

            // 🔥 destroy chart lama biar update realtime
            if (pieChart) {
                pieChart.destroy();
            }

            pieChart = new Chart(document.getElementById('obatPie'), {
                type: 'pie',
                data: {
                    labels: labels.map((label, i) => {
                        return `${label} (${values[i]} terjual)`;
                    }),
                    datasets: [{
                        data: values,
                        backgroundColor: colors
                    }]
                },
                options: {
                    plugins: {
                        legend: {
                            position: 'right'
                        }
                    }
                }
            });
        });
}

// pertama kali load
loadPie();

// 🔥 realtime update tiap 5 detik
setInterval(loadPie, 5000);
</script>

<script>
function loadAdvanced() {
    fetch('/dashboard/advanced')
        .then(res => res.json())
        .then(data => {

            // 🔥 STOK MENIPIS
            let stokHtml = '';
            data.stok_menipis.forEach(item => {
                stokHtml += `<li style="color:red">${item.nama_obat} (stok: ${item.stok})</li>`;
            });
            document.getElementById('stokList').innerHTML = stokHtml;

            // 🔥 TOP OBAT
            let topHtml = '';
            data.top_obat.forEach(item => {
                topHtml += `<li>${item.nama_obat} - ${item.total} terjual</li>`;
            });
            document.getElementById('topObat').innerHTML = topHtml;

            // 🔥 TRANSAKSI TERBARU
            let latestHtml = '';
            data.latest.forEach(item => {
                latestHtml += `<li>${item.invoice} - ${item.pasien.nama}</li>`;
            });
            document.getElementById('latestTransaksi').innerHTML = latestHtml;

        });
}

loadAdvanced();
setInterval(loadAdvanced, 5000);
</script>
</x-app-layout>