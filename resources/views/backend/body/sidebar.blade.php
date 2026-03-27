<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('home') }}" class="brand-link fruitspage-brand">
        <div class="brand-logo">
            <i class="fas fa-apple-alt"></i>
        </div>
        <span class="brand-text">FruitsPage</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ Auth::user()->profile_photo_url ?? asset('backend/dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="{{ route('profile.edit') }}" class="d-block">{{ Auth::user()->name }}</a>
                <span class="badge bg-success">{{ Auth::user()->getRoleNames()->first() ?? 'User' }}</span>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Dashboard -->
                <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->is('admin/dashboard*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                                @canany(['view categories', 'create categories', 'edit categories', 'delete categories'])
                <!-- Categories -->
                <li class="nav-item {{ request()->is('admin/categories*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->is('admin/categories*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tags"></i>
                        <p>
                            Categories
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.categories.index') }}" class="nav-link {{ request()->is('admin/categories') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>All Categories</p>
                            </a>
                        </li>
                        @can('create categories')
                        <li class="nav-item">
                            <a href="{{ route('admin.categories.create') }}" class="nav-link {{ request()->is('admin/categories/create') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Add New</p>
                            </a>
                        </li>
                        @endcan
                    </ul>
                </li>
                @endcanany

                <!-- Blog Management -->
                <li class="nav-item {{ request()->is('admin/blog*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->is('admin/blog*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-newspaper"></i>
                        <p>
                            Blog Management
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.blog.posts.index') }}" class="nav-link {{ request()->is('admin/blog/posts*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Blog Posts</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.blog.categories.index') }}" class="nav-link {{ request()->is('admin/blog/categories*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Categories</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.blog.tags.index') }}" class="nav-link {{ request()->is('admin/blog/tags*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Tags</p>
                            </a>
                        </li>
                    </ul>
                </li>

                @canany(['view products', 'create products', 'edit products', 'delete products'])
                <!-- Products -->
                <li class="nav-item {{ request()->is('admin/products*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->is('admin/products*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-apple-alt"></i>
                        <p>
                            Products
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.products.index') }}" class="nav-link {{ request()->is('admin/products') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>All Products</p>
                            </a>
                        </li>
                        @can('create products')
                        <li class="nav-item">
                            <a href="{{ route('admin.products.create') }}" class="nav-link {{ request()->is('admin/products/create') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Add New</p>
                            </a>
                        </li>
                        @endcan
                    </ul>
                </li>
                @endcanany

                @canany(['view orders', 'edit orders', 'delete orders'])
                <!-- Orders -->
                <li class="nav-item {{ request()->is('admin/orders*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->is('admin/orders*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-shopping-cart"></i>
                        <p>
                            Orders
                            <i class="right fas fa-angle-left"></i>
                            @php
                                $pendingOrders = \App\Models\Order::where('status', 'pending')->count();
                            @endphp
                            @if($pendingOrders > 0)
                                <span class="badge badge-danger right">{{ $pendingOrders }}</span>
                            @endif
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.orders.index') }}" class="nav-link {{ request()->is('admin/orders') && !request()->is('admin/orders/pending') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>All Orders</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.orders.pending') }}" class="nav-link {{ request()->is('admin/orders/pending') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Pending Orders</p>
                                @if($pendingOrders > 0)
                                    <span class="badge badge-warning right">{{ $pendingOrders }}</span>
                                @endif
                            </a>
                        </li>
                    </ul>
                </li>
                @endcanany

                <!-- Special Orders -->
                <li class="nav-item">
                    <a href="{{ route('admin.special-orders.index') }}" class="nav-link {{ request()->is('admin/special-orders*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-star"></i>
                        <p>
                            Special Orders
                            @php
                                $pendingSpecialOrders = \App\Models\SpecialOrder::where('status', 'pending')->count();
                            @endphp
                            @if($pendingSpecialOrders > 0)
                                <span class="badge badge-danger right">{{ $pendingSpecialOrders }}</span>
                            @endif
                        </p>
                    </a>
                </li>

                @canany(['view users', 'create users', 'edit users', 'delete users'])
                <!-- Users -->
                <li class="nav-item {{ request()->is('admin/users*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->is('admin/users*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-users"></i>
                        <p>
                            User Management
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.users.index') }}" class="nav-link {{ request()->is('admin/users') || request()->is('admin/users?*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>All Users</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.users.admins') }}" class="nav-link {{ request()->is('admin/users/admins') || request()->is('admin/users/admins?*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Administrators</p>
                            </a>
                        </li>
                    </ul>
                </li>
                @endcanany

                <!-- Contacts -->
                <li class="nav-item {{ request()->is('admin/contacts*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->is('admin/contacts*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-envelope"></i>
                        <p>
                            Contact Messages
                            <i class="right fas fa-angle-left"></i>
                            @php
                                $pendingContacts = \App\Models\Contact::where('status', 'pending')->count();
                            @endphp
                            @if($pendingContacts > 0)
                                <span class="badge badge-danger right">{{ $pendingContacts }}</span>
                            @endif
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.contacts.index') }}" class="nav-link {{ request()->is('admin/contacts') && !request()->is('admin/contacts/*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>All Messages</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.contacts.index', ['status' => 'pending']) }}" class="nav-link {{ request()->is('admin/contacts') && request('status') == 'pending' ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Pending</p>
                                @if($pendingContacts > 0)
                                    <span class="badge badge-warning right">{{ $pendingContacts }}</span>
                                @endif
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.contacts.index', ['status' => 'read']) }}" class="nav-link {{ request()->is('admin/contacts') && request('status') == 'read' ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Read</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.contacts.index', ['status' => 'replied']) }}" class="nav-link {{ request()->is('admin/contacts') && request('status') == 'replied' ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Replied</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Sliders -->
                <li class="nav-item {{ request()->is('admin/sliders*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->is('admin/sliders*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-sliders-h"></i>
                        <p>
                            Sliders
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.sliders.index') }}" class="nav-link {{ request()->is('admin/sliders') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>All Sliders</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.sliders.create') }}" class="nav-link {{ request()->is('admin/sliders/create') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Add New</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Contact Info Management -->
                <li class="nav-item {{ request()->is('admin/contact-info*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->is('admin/contact-info*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-info-circle"></i>
                        <p>
                            Contact Info
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.contact-info.index') }}" class="nav-link {{ request()->is('admin/contact-info') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Manage Info</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.contact-info.create') }}" class="nav-link {{ request()->is('admin/contact-info/create') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Add New</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- FAQ Management -->
                <li class="nav-item {{ request()->is('admin/faqs*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->is('admin/faqs*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-question-circle"></i>
                        <p>
                            FAQs
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.faqs.index') }}" class="nav-link {{ request()->is('admin/faqs') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>All FAQs</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.faqs.create') }}" class="nav-link {{ request()->is('admin/faqs/create') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Add New</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Reviews -->
                <li class="nav-item {{ request()->is('admin/reviews*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->is('admin/reviews*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-star"></i>
                        <p>
                            Reviews
                            <i class="right fas fa-angle-left"></i>
                            @php
                                $pendingCount = \App\Models\Review::where('is_approved', false)->count();
                            @endphp
                            @if($pendingCount > 0)
                                <span class="badge badge-danger right">{{ $pendingCount }}</span>
                            @endif
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.reviews.index') }}" class="nav-link {{ request()->is('admin/reviews') && !request()->is('admin/reviews/pending') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>All Reviews</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.reviews.pending') }}" class="nav-link {{ request()->is('admin/reviews/pending') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Pending Reviews</p>
                                @if($pendingCount > 0)
                                    <span class="badge badge-warning right">{{ $pendingCount }}</span>
                                @endif
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Footer -->
                <li class="nav-item {{ request()->is('admin/footers*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->is('admin/footers*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-info-circle"></i>
                        <p>
                            Footer Management
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.footers.index') }}" class="nav-link {{ request()->is('admin/footers') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>All Footers</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.footers.create') }}" class="nav-link {{ request()->is('admin/footers/create') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Add New Footer</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- About Us -->
                <li class="nav-item {{ request()->is('admin/about-us*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->is('admin/about-us*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-building"></i>
                        <p>
                            About Us
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.about-us.index') }}" class="nav-link {{ request()->is('admin/about-us') && !request()->is('admin/about-us/team*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Content Management</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.about-us.team.index') }}" class="nav-link {{ request()->is('admin/about-us/team*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Team Members</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Privacy Policy -->
                <li class="nav-item">
                    <a href="{{ route('admin.privacy-policy.index') }}" class="nav-link {{ request()->is('admin/privacy-policy*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-shield-alt"></i>
                        <p>Privacy Policy</p>
                    </a>
                </li>

                <!-- Terms & Conditions -->
                <li class="nav-item">
                    <a href="{{ route('admin.terms-conditions.index') }}" class="nav-link {{ request()->is('admin/terms-conditions*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-file-contract"></i>
                        <p>Terms & Conditions</p>
                    </a>
                </li>

                <!-- Shipping Policy -->
                <li class="nav-item">
                    <a href="{{ route('admin.shipping-policy.index') }}" class="nav-link {{ request()->is('admin/shipping-policy*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-shipping-fast"></i>
                        <p>Shipping Policy</p>
                    </a>
                </li>

                <!-- Return Policy -->
                <li class="nav-item">
                    <a href="{{ route('admin.return-policy.index') }}" class="nav-link {{ request()->is('admin/return-policy*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-undo"></i>
                        <p>Return Policy</p>
                    </a>
                </li>

                <!-- Courier Services -->
                <li class="nav-item {{ request()->is('admin/courier-services*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->is('admin/courier-services*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-truck"></i>
                        <p>
                            Courier Services
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.courier-services.index') }}" class="nav-link {{ request()->is('admin/courier-services') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>All Courier Services</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.courier-services.create') }}" class="nav-link {{ request()->is('admin/courier-services/create') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Add New Service</p>
                            </a>
                        </li>
                    </ul>
                </li>

            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
