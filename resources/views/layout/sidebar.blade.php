<nav id="sidebar" class="sidebar" style="overflow-y: visible !important">
    <div class="sidebar-content js-simplebar">
        <a class="sidebar-brand" href="{{ route('dashboard') }}">
            <span class="align-middle">
                <img src="{{ getImage(cms()->logo) }}" alt="" width="40" height="40" />
            </span>
        </a>

        <li class="sidebar-item">
            <a class="sidebar-link {{Request::is('dashboard','dashboard/*')?'text-light':' '}}" href="{{ route('dashboard') }}">
                <i class="fas fa-th"></i>
                <span class="align-middle">Dashboard</span>
            </a>
        </li>

        @can('palika:view')
        <li class="sidebar-item">
            <a class="sidebar-link {{Request::is('palikas','palikas/*','palika-reorder')?'text-light':' '}}" href="{{ route('palika.index') }}">
                <i class="fas fa-home"></i>
                <span class="align-middle">Palika</span>
            </a>
        </li>
        @endcan

@can('banners:view')
<li class="sidebar-item">
    <a href="javascript:void(0);" class="sidebar-link d-flex justify-between align-items-center {{Request::is('banners','banners/*')?'text-light':' '}}" data-toggle="banner-dropdown">
        <span>
            <i class="fas fa-images"></i>
            <span class="align-middle">Banners</span>
        </span>
        <i class="fas fa-chevron-down toggle-icon"></i>
    </a>
    <ul class="submenu {{Request::is('banners','banners/*')?'d-block':' d-none'}}" id="banner-dropdown" >
        <li class="submenu-item">
            <a href="{{ route('banners.index',['type'=>1]) }}" class="sidebar-link">Notice Banner</a>
        </li>
        <li class="submenu-item">
            <a href="{{ route('banners.index',['type'=>2]) }}" class="sidebar-link">Rep Banner</a>
        </li>
    </ul>
</li>
@endcan

 <li class="sidebar-item">
           <a target="_blank" class="sidebar-link {{Request::is('attachments','attachments/*')?'text-light':' '}}" href="{{ route('attachments.index') }}">
               <i class="fas fa-copy"></i>
               <span class="align-middle">Attachment</span>
           </a>
       </li>

       @can('user:view')
       <li class="sidebar-item">
           <a class="sidebar-link {{Request::is('manage-access','manage-access/*')?'text-light':' '}}" href="{{ route('access.index') }}">
               <i class="fas fa-users"></i>
               <span class="align-middle">Employee</span>
           </a>
       </li>
       @endcan

       {{-- @can('do:anthing')
       <li class="sidebar-item">
           <a class="sidebar-link {{Request::is('users','users/*')?'text-light':' '}}" href="{{ route('users') }}">
               <i class="fas fa-users"></i>
               <span class="align-middle">Users</span>
           </a>
       </li>
       @endcan --}}

        <ul class="sidebar-nav">
            <li class="sidebar-header">Manage Post</li>

          @can('do:anything')
          <li class="sidebar-item">
            <a class="sidebar-link {{Request::is('categories','categories/*')?'text-light':' '}}" href="{{ route('categories.index') }}">
                <i class="fas fa-shopping-cart"></i>
                <span class="align-middle">Category</span>
            </a>
        </li>

        <li class="sidebar-item">
            <a class="sidebar-link {{Request::is('subcategories','subcategories/*')?'text-light':' '}}" href="{{ route('subcategories.index') }}">
                <i class="fas fa-sitemap"></i>
                <span class="align-middle">Subcategory</span>
            </a>
        </li>
        @endcan


        @canAny(['post:view','post:create','post:edit','post:delete'])
        <li class="sidebar-item">
            <a class="sidebar-link {{Request::is('blogs','blogs/*')?'text-light':' '}}" href="{{ route('blogs.index') }}">
                <i class="fas fa-photo-video"></i>
                <span class="align-middle">Post</span>
            </a>
        </li>
          @endcanAny

            @can('do:anything')
          <li class="sidebar-header">General</li>

            <li class="sidebar-item">
                <a class="sidebar-link {{Request::is('pages','pages/*')?'text-light':' '}}" href="{{ route('pages.index') }}">
                    <i class="far fa-calendar-minus"></i>
                    <span class="align-middle">Pages</span>
                </a>
            </li>

            <li class="sidebar-item">
                <a class="sidebar-link {{Request::is('websites','websites/*')?'text-light':' '}}" href="{{ route('cms.edit', 1) }}">
                    <i class="fas fa-images"></i>
                    <span class="align-middle">Cms</span>
                </a>
            </li>
            @endcan


        </ul>
    </div>
</nav>

