@if (session()->has('msg'))
    <style>
        /* Force white icons inside the notification */
        #sessionMsg .fa,
        #sessionMsg .fas,
        #sessionMsg .far,
        #sessionMsg .fal,
        #sessionMsg .fad,
        #sessionMsg .fa-solid,
        #sessionMsg svg {
            color: #fff !important;
            fill: #fff !important; /* for FA6 SVGs */
        }
        /* Make the close (X) white + visible on dark bg */
        #sessionMsg .btn-close {
            filter: invert(1) grayscale(100%) brightness(200%);
            opacity: .9;
        }
    </style>

    <script>
        window.onload = function () {
            // Auto-hide after 3 seconds
            setTimeout(function () {
                const notifyEl = document.getElementById("sessionMsg");
                if (notifyEl) {
                    notifyEl.classList.add("fade");
                    setTimeout(() => notifyEl.remove(), 500);
                }
            }, 3000);
        };
    </script>

    <div id="sessionMsg" 
         class="d-flex align-items-center rounded shadow position-fixed top-0 end-0 m-3 p-3"
         style="z-index:1055; min-width: 320px; color:#fff;
                background-color:
                    @if(session('msg.type') == 'success') #28a745
                    @elseif(session('msg.type') == 'danger' || session('msg.type') == 'error') #dc3545
                    @elseif(session('msg.type') == 'warning') #ffc107
                    @else #17a2b8 @endif;">

        {{-- Big Icon --}}
        <div class="me-3">
            @if(session('msg.type') == 'success')
                <img src="{{ asset('images/icons/check.png') }}" alt="Success" style="width:40px; height:40px;">
            @elseif(session('msg.type') == 'danger' || session('msg.type') == 'error')
                <img src="{{ asset('images/icons/error.png') }}" alt="Error" style="width:40px; height:40px;">
            @elseif(session('msg.type') == 'warning')
                <img src="{{ asset('images/icons/warning.png') }}" alt="Warning" style="width:40px; height:40px;">
            @else
                <img src="{{ asset('images/icons/info.png') }}" alt="Info" style="width:40px; height:40px;">
            @endif
        </div>

        {{-- Text --}}
        <div class="flex-grow-1">
            {{-- <h5 class="mb-1 fw-bold">{{ session('msg.title') }}</h5> --}}
            <p class="mb-0 text-white">{{ session('msg.text') }}</p>
        </div>

        {{-- Close button --}}
        <button type="button" class="btn-close ms-2" aria-label="Close"
                onclick="document.getElementById('sessionMsg').remove();"></button>
    </div>

    @php
        session()->forget('msg');
    @endphp
@endif
