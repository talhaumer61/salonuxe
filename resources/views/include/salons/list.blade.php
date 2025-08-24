<!-- Search Bar -->
<!-- Filter Bar -->
<div class="filter-bar py-4" style="background: #fbe3df;">
    <div class="container">
        <form id="filterForm" method="GET" action="{{ url()->current() }}">
            <div class="row g-3 align-items-end justify-content-center">
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Search Salon</label>
                    <input type="text" name="search" id="search" class="form-control" placeholder="e.g. Blush, Perfect Nail" value="{{ request('search') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Filter by City</label>
                    <select name="city" id="city" class="form-select">
                        <option value="">All Cities</option>
                        @foreach($cities as $city)
                            <option value="{{ $city }}" @if(request('city') == $city) selected @endif>{{ $city }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2 d-flex gap-2 mt-4">
                    <button type="button" id="applyFilters" class="btn btn-primary w-100">Apply</button>
                    <button type="button" id="clearFilters" class="btn btn-outline-secondary w-100">Clear</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Salon Results -->
<div id="salons-section" style="background: #fbe3df;">
    <div class="container">
        <div class="row justify-content-center">
            @forelse($salons as $salon)
                <div class="col-lg-4 col-md-6 col-sm-12 col-12">
                    <div class="news-box my-3 news-box-next wow fade-box animated shadow-sm" style="background: #fff; border-radius: 12px; overflow: hidden; transition: all 0.3s ease;">
                        <img src="{{ asset($salon->salon_logo) }}" alt="{{ $salon->salon_name }}" style="height: 250px; object-fit: cover; width: 100%; border-bottom: 1px solid #eee;">
                        <div class="news-content-wrapper p-3 text-center">
                            <h5 class="mb-2">
                                <a href="{{ url('salon/' . $salon->salon_href) }}" class="text-dark text-decoration-none">{{ $salon->salon_name }}</a>
                            </h5>
                            <a href="{{ url('salon/' . $salon->salon_href) }}" class="read-btn btn btn-outline-primary btn-sm">View Services</a>
                        </div>
                    </div>
                </div>

            @empty
                <div class="col-12 text-center my-5">
                    <h4 class="text-muted">No salons available.</h4>
                </div>
            @endforelse
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('filterForm');
        const section = document.getElementById('salons-section');
        const searchInput = document.getElementById('search');
        const applyBtn = document.getElementById('applyFilters');
        const clearBtn = document.getElementById('clearFilters');

        function fetchFilteredSalons() {
            const formData = new FormData(form);
            const params = new URLSearchParams(formData).toString();

            fetch(`${form.action}?${params}`, {
                method: "GET",
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(res => res.json())
            .then(data => {
                const parser = new DOMParser();
                const parsedDoc = parser.parseFromString(data.html, 'text/html');
                const newSection = parsedDoc.querySelector('#salons-section');
                if (newSection) {
                    section.innerHTML = newSection.innerHTML;
                }
            })
            .catch(err => console.error('AJAX Error:', err));
        }

        // 🔍 Real-time search
        let typingTimer;
        searchInput.addEventListener('input', () => {
            clearTimeout(typingTimer);
            typingTimer = setTimeout(fetchFilteredSalons, 400);
        });

        // ✅ City filter on button click
        applyBtn.addEventListener('click', fetchFilteredSalons);

        // ❌ Reset all filters
        clearBtn.addEventListener('click', () => {
            form.reset();
            fetchFilteredSalons();
        });
    });
</script>
