<div class="accordion3-wrapper tab-three-accordion tab-accordion float-start w-100 mb-3">
    <div class="container p-3">
        <div>
            <h3 class="text-center">FAQ's</h3>
            <div class="row justify-content-center">
                <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="accordions" id="thirdAccordion">
                        @foreach($faqs as $index => $faq)
                            @php
                                $headingId = 'heading' . $index;
                                $collapseId = 'collapse' . $index;
                            @endphp
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="{{ $headingId }}">
                                    <button class="accordion-button {{ $index !== 0 ? 'collapsed' : '' }}" type="button"
                                        data-bs-toggle="collapse"
                                        data-bs-target="#{{ $collapseId }}"
                                        aria-expanded="{{ $index === 0 ? 'true' : 'false' }}"
                                        aria-controls="{{ $collapseId }}">
                                        {{ $faq->question }}
                                    </button>
                                </h2>
                                <div id="{{ $collapseId }}" class="accordion-collapse collapse {{ $index === 0 ? 'show' : '' }}"
                                    aria-labelledby="{{ $headingId }}"
                                    data-bs-parent="#thirdAccordion">
                                    <div class="accordion-body">
                                        {!! $faq->answer !!}
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        @if($faqs->isEmpty())
                            <div class="text-center py-4">
                                <p class="text-danger">No FAQs found.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
