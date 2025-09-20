<section class="grid gap-6">
  {{-- กราฟเส้น: จำนวนรายการใหม่รายเดือน --}}
  <div class="bg-white rounded-xl shadow p-4">
    <h2 class="font-medium mb-3">จำนวนรายการใหม่รายเดือน (ตัวอย่างข้อมูล)</h2>
    <div class="h-72"><canvas id="ex-line"></canvas></div>
  </div>

  {{-- แถวล่าง: โดนัท + แท่งแนวนอน --}}
  <div class="grid md:grid-cols-2 gap-6">
    <div class="bg-white rounded-xl shadow p-4">
      <h2 class="font-medium mb-3">สัดส่วนประเภททรัพย์สินทางปัญญา (ตัวอย่างข้อมูล)</h2>
      <div class="h-72"><canvas id="ex-donut"></canvas></div>
    </div>

    <div class="bg-white rounded-xl shadow p-4">
      <h2 class="font-medium mb-3">ชุมชนที่มีรายการวัฒนธรรมมากสุด (ตัวอย่างข้อมูล)</h2>
      <div class="h-72"><canvas id="ex-bar"></canvas></div>
    </div>
  </div>
</section>

@push('scripts')
  {{-- Chart.js CDN (หากมีผ่าน Vite อยู่แล้ว ตัดส่วนนี้ทิ้งได้) --}}
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script>
    // ====== ตัวอย่างข้อมูล (Mock Data) ======
    const EX_LABELS = ['2024-09','2024-10','2024-11','2024-12','2025-01','2025-02','2025-03','2025-04','2025-05','2025-06','2025-07','2025-08'];
    const EX_LINE = {
      cultural: [3,5,4,7,6,5,8,9,7,6,10,12],
      research: [1,2,1,2,3,2,3,4,3,5,4,6],
      ip:       [0,1,1,1,2,1,2,2,3,2,3,3],
      innov:    [0,0,1,1,1,2,2,3,2,3,3,4],
      places:   [2,3,2,4,3,4,5,6,5,6,7,8],
    };
    const EX_IP_TYPES = { GI: 6, copyright: 10, trademark: 4, patent: 3, petty_patent: 2, TK: 5 };
    const EX_TOP_COMMUNITIES = [
      {name:'บางยี่เรือ', count:18},
      {name:'บางขุนเทียน', count:15},
      {name:'วัดอรุณ', count:13},
      {name:'คลองสาน', count:11},
      {name:'ตลาดพลู', count:9},
    ];

    // ====== กราฟเส้น ======
    new Chart(document.getElementById('ex-line'), {
      type: 'line',
      data: {
        labels: EX_LABELS,
        datasets: [
          { label: 'วัฒนธรรม', data: EX_LINE.cultural },
          { label: 'งานวิจัย', data: EX_LINE.research },
          { label: 'ทรัพย์สินทางปัญญา', data: EX_LINE.ip },
          { label: 'นวัตกรรม', data: EX_LINE.innov },
          { label: 'สถานที่', data: EX_LINE.places },
        ]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        interaction: { mode: 'index', intersect: false },
        plugins: { legend: { position: 'bottom' } },
        scales: { y: { beginAtZero: true, ticks: { precision:0 } } }
      }
    });

    // ====== โดนัท IP Types ======
    const ipLabels = Object.keys(EX_IP_TYPES);
    const ipValues = Object.values(EX_IP_TYPES);
    new Chart(document.getElementById('ex-donut'), {
      type: 'doughnut',
      data: { labels: ipLabels, datasets: [{ data: ipValues }] },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: { legend: { position: 'bottom' } }
      }
    });

    // ====== แท่งแนวนอน Top Communities ======
    new Chart(document.getElementById('ex-bar'), {
      type: 'bar',
      data: {
        labels: EX_TOP_COMMUNITIES.map(x => x.name),
        datasets: [{ label: 'จำนวนรายการ', data: EX_TOP_COMMUNITIES.map(x => x.count) }]
      },
      options: {
        indexAxis: 'y',
        responsive: true,
        maintainAspectRatio: false,
        scales: { x: { beginAtZero: true, ticks: { precision:0 } } },
        plugins: { legend: { display: false } }
      }
    });
  </script>
@endpush
