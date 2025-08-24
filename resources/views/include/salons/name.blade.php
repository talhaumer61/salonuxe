<div class="inner-page-wrapper float-left">
    <div class="inner-head">
        <h1>{{ $salon->salon_name ?? 'Salons' }}</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-center">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ url('salons') }}">Salons</a></li>
                <li class="breadcrumb-item active" aria-current="page">
                    {{ $salon->salon_name ?? 'Salon' }}
                </li>
            </ol>
        </nav>
    </div>
</div>
