<nav id="sidebar" class="sidebar" style="overflow-y: visible !important">
    <div class="sidebar-content js-simplebar">
        <a class="sidebar-brand" href="{{ route('admin.dashboard') }}">
            <span class="align-middle">
                <img src="{{ getImage(cms('logo')) }}" alt="" width="40" height="40" />

            </span>
        </a>

        <li class="sidebar-item">
            <a class="sidebar-link" href="{{ route('admin.dashboard') }}">
                <i class="fas fa-th"></i>
                <span class="align-middle">Dashboard</span>
            </a>
        </li>
        <ul class="sidebar-nav">
            <li class="sidebar-header">Manage Inventory</li>

          @can(['category:view','category:create','category:edit','category:delete'])
          <li class="sidebar-item">
            <a class="sidebar-link" href="{{ route('admin.categories.index') }}">
                <i class="fas fa-shopping-cart"></i>
                <span class="align-middle">Category</span>
            </a>
        </li>
          @endcan

          @can(['subcategory:view','subcategory:create','subcategory:edit','subcategory:delete'])
          <li class="sidebar-item">
            <a class="sidebar-link" href="{{ route('admin.subcategories.index') }}">
                <i class="fas fa-cart-arrow-down"></i>
                <span class="align-middle">Subcategory</span>
            </a>
        </li>
          @endcan

          @can('product:view')

            <li class="sidebar-item">
                <a class="sidebar-link" href="{{ route('admin.products.index') }}">
                    <i class="fas fa-shopping-basket"></i>
                    <span class="align-middle">Product</span>
                </a>
            </li>
            @endcan

            @can(['order:view', 'order:edit'])
                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ route('admin.orders.index') }}">
                        <i class="fas fa-truck"></i>
                        <span class="align-middle">Orders</span>
                    </a>
                </li>
            @endcan

            @can(['customer:view','kyc:view','payment:view'])

            <li class="sidebar-header">CRM</li>

            <li class="sidebar-item">
                <a class="sidebar-link" href="{{ route('admin.users.index') }}">
                    <i class="fas fa-users"></i>
                    <span class="align-middle">Customers</span>
                </a>
            </li>

            <li class="sidebar-item">
                <a class="sidebar-link" href="{{ route('admin.kycs.index') }}">
                    <i class="fas fa-user-check"></i>
                    <span class="align-middle">Kyc</span>
                </a>
            </li>

            <li class="sidebar-item">
                <a class="sidebar-link" href="{{ route('admin.payments.index') }}">
                    <i class="fas fa-money-bill-wave-alt"></i>
                    <span class="align-middle">Payment</span>
                </a>
            </li>
            @endcan

            <li class="sidebar-header">General</li>

            @can('blog:view')
            <li class="sidebar-item">
                <a class="sidebar-link" href="{{ route('admin.blogs.index') }}">
                    <i class="fas fa-copy"></i>
                    <span class="align-middle">Blog</span>
                </a>
            </li>
            @endcan

            @can('page:view')
            <li class="sidebar-item">
                <a class="sidebar-link" href="{{ route('admin.pages.index') }}">
                    <i class="far fa-calendar-minus"></i>
                    <span class="align-middle">Pages</span>
                </a>
            </li>
            @endcan

            @can('cms:view')
            <li class="sidebar-item">
                <a class="sidebar-link" href="{{ route('admin.cms.edit', 1) }}">
                    <i class="far fa-copy"></i>
                    <span class="align-middle">Cms</span>
                </a>
            </li>
            @endcan

            @can('testimonial:view')
            <li class="sidebar-item">
                <a class="sidebar-link" href="{{ route('admin.testimonials.index') }}">
                    <i class="fas fa-users"></i>
                    <span class="align-middle">Testimonial</span>
                </a>
            </li>
            @endcan

        </ul>
    </div>
</nav>
