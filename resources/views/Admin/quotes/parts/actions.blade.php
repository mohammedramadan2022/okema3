<div class="d-flex">
    {{-- Edit Button --}}
    <button class="editBtn btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1" data-id="{{ $quote->id }}">
    <span class="svg-icon svg-icon-3">
    <svg xmlns="http://www.w3.org/2000/svg" height="20px" viewBox="0 -960 960 960" width="20px" fill="#2f5bdd">
    <path
        d="M144-144v-153l498-498q11-11 24-16t27-5q14 0 27 5t24 16l51 51q11 11 16 24t5 27q0 14-5 27t-16 24L297-144H144Zm549-498 51-51-51-51-51 51 51 51Z"/>
            </svg>
        </span>
    </button>

    {{-- Delete Button --}}
    <button class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm delete me-1" data-id="{{ $quote->id }}">
    <span class="svg-icon svg-icon-3">
    <svg xmlns="http://www.w3.org/2000/svg" height="20px" viewBox="0 -960 960 960" width="20px" fill="#f44336">
    <path
        d="M312-144q-29.7 0-50.85-21.15Q240-186.3 240-216v-480h-48v-72h192v-48h192v48h192v72h-48v479.57Q720-186 698.85-165T648-144H312Zm72-144h72v-336h-72v336Zm120 0h72v-336h-72v336Z"/>
            </svg>
        </span>
    </button>

    {{-- PDF Download Button --}}
    <a href="{{ route('quotes.pdf', $quote) }}" target="_blank"
       class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm">
    <span class="svg-icon svg-icon-3">
    <svg xmlns="http://www.w3.org/2000/svg" height="20px" viewBox="0 0 24 24" width="20px" fill="#4CAF50">
    <path
        d="M14 2H6c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V8l-6-6zm2 16H8v-2h8v2zm0-4H8v-2h8v2zm-3-5V3.5L18.5 9H13z"/>
            </svg>
        </span>
    </a>

    @if($quote->status == 0)


    <a href="{{ route('quotes.convert-to-invoice' , $quote) }}" target="_blank"
       class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm">
    <span class="svg-icon svg-icon-3">
        <svg xmlns="http://www.w3.org/2000/svg" height="20px" viewBox="0 0 24 24" width="20px" fill="#2196F3">
            <path d="M0 0h24v24H0z" fill="none"/>
            <path d="M8 9h8V6l4 4-4 4v-3H8v3l-4-4 4-4v3zM4 18h16v2H4v-2z"/>
        </svg>
    </span>
    </a>

    @endif

</div>
