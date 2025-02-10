
<div class="homepage-navbar bg-light shadow p-3 bg-primary position-relative">

    <div class="d-flex align-items-center">
        <div
            class="link-dark text-truncate d-flex align-items-center gap-2"
            data-bs-toggle="offcanvas"
            data-bs-target="#store"
            aria-controls="store"
        >
            <i class="icofont-location-arrow fs-2 text-white"></i>
            <div class="flex-grow-1">
                <h6 class="fw-bold text-white mb-0 d-flex align-items-center">
                   Select Location
                    <i class="bi bi-chevron-down ms-2"></i>
                </h6>
                <p
                    class="text-white-50 mb-0"
                    style="
                        width: 280px;
                        white-space: nowrap;
                        overflow: hidden;
                        text-overflow: ellipsis;
                    "
                >
                {{ session()->get('userLocationDetail')['store_location']??''}}
                </p>
            </div>
        </div>
        <div class="d-flex align-items-center gap-2 ms-auto">
            <a   data-bs-toggle="offcanvas"
            data-bs-target="#manualOrderCanvas"
            aria-controls="manualOrderCanvas" href="#">
                <b class="bg-dark bg-opacity-75 rounded-circle user-icon">
                    <i class="bi bi-plus d-flex m-0 h4 text-white"></i>
                </b>
            </a>
            <a class="toggle" href="#">
                <b class="bg-dark bg-opacity-75 rounded-circle user-icon">
                    <i class="bi bi-list d-flex m-0 h4 text-white"></i>
                </b>
            </a>
        </div>
    </div>
    <div class="pt-3">
        <!-- search -->
        <a @if (!Route::is('store')) href="{{ route('store') }}" @endif>
            <div class="input-group bg-white rounded-3 shadow-sm py-1">
                <input
                    type="text"
                    class="form-control bg-transparent border-0 rounded-0 px-3"
                    placeholder="Search for grocey, dairy product, meat item and more"
                    aria-label="Search for grocey, dairy product, meat item and more"
                    aria-describedby="search"
                    id="searchproduct"
                />
                <span class="input-group-text bg-transparent border-0 rounded-0 pe-3" id="search">
                    <i class="icofont-search-1"></i>
                </span>
            </div>
        </a>
    </div>
</div>
