@extends('adminlte::page')
@section('title','ทรัพย์สินทางปัญญา')

@section('content_header')
  <div class="d-flex justify-content-between align-items-center">
    <h1>ทรัพย์สินทางปัญญา</h1>
    <a href="{{ route('admin.ip.create') }}" class="btn btn-primary">+ เพิ่มข้อมูล</a>
  </div>
@endsection

@section('content')
<div class="mb-3">
  <div class="input-group">
    <input type="text" id="search-input" value="{{ request('q') }}" class="form-control" placeholder="ค้นหาชื่อ/เลขที่คำขอ/ผู้ขอ...">
    <button class="btn btn-outline-secondary" id="clear-search" style="display: none;">
      <i class="fas fa-times"></i>
    </button>
  </div>
</div>

<div class="card">
  <div class="table-responsive">
    <table class="table table-hover align-middle">
      <thead>
        <tr>
          <th>เลขที่คำขอ</th><th>ชื่อเรื่อง</th><th>ผู้ขอ</th><th>ประเภท</th><th>สถานะ</th><th>ปี</th><th></th>
        </tr>
      </thead>
      <tbody id="table-body">
        @foreach($items as $it)
          <tr>
            <td>{{ $it->application_no }}</td>
            <td class="fw-semibold">{{ $it->title }}</td>
            <td>{{ $it->applicant_name }}</td>
            <td>{{ $it->type }}</td>
            <td>{{ $it->status }}</td>
            <td>{{ $it->budget_year }}</td>
            <td class="text-end">
              <a href="{{ route('admin.ip.edit',$it) }}" class="btn btn-sm btn-warning">แก้ไข</a>
              <form action="{{ route('admin.ip.destroy',$it) }}" method="post" class="d-inline"
                    onsubmit="return confirm('ยืนยันลบข้อมูลนี้?')">
                @csrf @method('delete')
                <button class="btn btn-sm btn-danger">ลบ</button>
              </form>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
  <div class="card-footer" id="pagination-container">{{ $items->links() }}</div>
</div>

@push('js')
<script>
let searchTimeout;
const searchInput = document.getElementById('search-input');
const clearBtn = document.getElementById('clear-search');
const tableBody = document.getElementById('table-body');
const paginationContainer = document.getElementById('pagination-container');

searchInput.addEventListener('input', function() {
  clearTimeout(searchTimeout);
  const query = this.value.trim();
  
  // Show/hide clear button
  clearBtn.style.display = query ? 'block' : 'none';
  
  searchTimeout = setTimeout(() => {
    performSearch(query);
  }, 500);
});

clearBtn.addEventListener('click', function() {
  searchInput.value = '';
  clearBtn.style.display = 'none';
  performSearch('');
});

function performSearch(query) {
  const url = new URL(window.location.href);
  if (query) {
    url.searchParams.set('q', query);
  } else {
    url.searchParams.delete('q');
  }
  
  // Update URL without reload
  history.pushState({}, '', url);
  
  // Fetch results
  fetch(url, {
    headers: {
      'X-Requested-With': 'XMLHttpRequest'
    }
  })
  .then(response => response.text())
  .then(html => {
    const parser = new DOMParser();
    const doc = parser.parseFromString(html, 'text/html');
    
    // Update table body
    const newTableBody = doc.getElementById('table-body');
    if (newTableBody) {
      tableBody.innerHTML = newTableBody.innerHTML;
    }
    
    // Update pagination
    const newPagination = doc.getElementById('pagination-container');
    if (newPagination) {
      paginationContainer.innerHTML = newPagination.innerHTML;
    }
  })
  .catch(error => console.error('Search error:', error));
}
</script>
@endpush
@endsection
