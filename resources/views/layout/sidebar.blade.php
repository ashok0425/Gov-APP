<nav id="sidebar" class="sidebar" style="overflow-y: visible !important">
    <div class="sidebar-content js-simplebar">
        <a class="sidebar-brand" href="{{ route('dashboard') }}">
            <span class="align-middle">
                <img src="{{ getImage(cms('logo')) }}" alt="" width="40" height="40" />

            </span>
        </a>

        <li class="sidebar-item">
            <a class="sidebar-link" href="{{ route('dashboard') }}">
                <i class="fas fa-th"></i>
                <span class="align-middle">Dashboard</span>
            </a>
        </li>
        @can('do:anything')
        <li class="sidebar-item">
            <a class="sidebar-link" href="{{ route('business.index') }}">
                <i class="fas fa-home"></i>
                <span class="align-middle">Wards</span>
            </a>
        </li>

       @endcan

       @can('banners:view')
       <li class="sidebar-item">
           <a class="sidebar-link" href="{{ route('banners.index') }}">
               <i class="fas fa-images"></i>
               <span class="align-middle">Banner</span>
           </a>
       </li>
      @endcan
       @can('user:view')
       <li class="sidebar-item">
           <a class="sidebar-link" href="{{ route('access.index') }}">
               <i class="fas fa-users"></i>
               <span class="align-middle">Users</span>
           </a>
       </li>
       @endcan

        <ul class="sidebar-nav">
            <li class="sidebar-header">Manage Post</li>

          @can('do:anything')
          <li class="sidebar-item">
            <a class="sidebar-link" href="{{ route('categories.index') }}">
                <i class="fas fa-shopping-cart"></i>
                <span class="align-middle">Category</span>
            </a>
        </li>
        @endcan


        @can(['blog:view','blog:create','blog:edit','blog:delete'])
        <li class="sidebar-item">
            <a class="sidebar-link" href="{{ route('blogs.index') }}">
                <i class="fas fa-photo-video"></i>
                <span class="align-middle">Post</span>
            </a>
        </li>
          @endcan

          <li class="sidebar-header">General</li>
            @can('do:anything')
            <li class="sidebar-item">
                <a class="sidebar-link" href="{{ route('pages.index') }}">
                    <i class="far fa-calendar-minus"></i>
                    <span class="align-middle">Pages</span>
                </a>
            </li>
            @endcan

            @can('do:anything')
            <li class="sidebar-item">
                <a class="sidebar-link" href="{{ route('cms.edit', 1) }}">
                    <i class="fas fa-images"></i>
                    <span class="align-middle">Cms</span>
                </a>
            </li>
            @endcan


        </ul>
    </div>
</nav>
