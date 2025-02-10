<!-- navbar -->
<div class="bg-white mb-auto">
    <div class="d-flex gap-3 bg-primary p-3">
        <a href="{{ route('home') }}" class="text-white">
            <i class="bi bi-arrow-left fs-5"></i>
        </a>
        <div>
            <h6 class="fw-bold text-white m-0">{{ $title }}</h6>
            <p class="text-white-50 m-0">{{ $subtitle }}</p>
        </div>
        {{--
            <div class="d-flex align-items-center gap-2 ms-auto">
            <a href="profile.html" class="link-dark">
            <div class="bg-dark bg-opacity-75 rounded-circle user-icon">
            <i class="bi bi-person d-flex m-0 h4 text-white"></i>
            </div>
            </a>
            <a class="toggle" href="#">
            <b class="bg-dark bg-opacity-75 rounded-circle user-icon">
            <i class="bi bi-list d-flex m-0 h4 text-white"></i>
            </b>
            </a>
            </div>
        --}}
    </div>
</div>
