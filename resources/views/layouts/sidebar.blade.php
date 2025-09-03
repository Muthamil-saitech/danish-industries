<div class="logo_Section_main_sidebar">
    <a href="{{ route('dashboard') }}" class="logo-wrapper">
        @php
            $photo = isset($whiteLabelInfo->mini_logo)
                ? 'uploads/white_label/' . $whiteLabelInfo->mini_logo
                : 'frequent_changing/images/mini_logo.png';
            
            $logo_lg = isset($whiteLabelInfo->logo)
                ? 'uploads/white_label/' . $whiteLabelInfo->logo
                : 'frequent_changing/images/logo.png';
        @endphp

        <span class="logo-lg">
            <img src="{{ $baseURL . $logo_lg }}" class="img-circle" alt="Logo Image">
        </span>
        <span class="logo-mini">
            <img src="{{ $baseURL . $photo }}" class="img-circle" alt="Logo Image">
        </span>
    </a>
    <a href="#" class="sidebar-toggle set_collapse" data-status="2" data-toggle="push-menu" role="button"
        style="transform: rotate(0deg); transition: 0.7s;">
        <iconify-icon icon="solar:round-alt-arrow-left-broken" width="25"></iconify-icon>
    </a>
</div>
<!-- Admin Logo Part End -->
<section class="sidebar">

    <div id="left_menu_to_scroll">
        <ul class="sidebar-menu ps ps--active-x ps--active-y tree" data-widget="tree">

            {{--<li class="parent-menu treeview2 menu_assign_class menu__cidirp_1{{ request()->is('home') ? ' menu-open active_sub_menu' : '' }}"
                data-menu__cid="irp_1">
                <a href="{{ route('home') }}">
                    <iconify-icon icon="solar:home-broken"></iconify-icon>
                    <span class="match_bold">@lang('index.home')</span>
                </a>
            </li>--}}
            @if (menuPermission('Dashboard'))
                <li class="parent-menu treeview2 menu_assign_class menu__cidirp_1{{ request()->is('dashboard') ? ' menu-open active_sub_menu' : '' }}"
                    data-menu__cid="irp_1">
                    <a href="{{ route('dashboard') }}">
                        <iconify-icon icon="solar:chart-2-broken"></iconify-icon>
                        <span class="match_bold">@lang('index.dashboard')</span>
                    </a>
                </li>
            @endif
            @if (menuPermission('Parties'))
                <li
                    class="parent-menu treeview menu__cidirp_10{{ request()->is('suppliers*') || request()->is('customers*') ? ' menu-open active_sub_menu' : '' }}">
                    <a href="#">
                        <iconify-icon icon="solar:users-group-two-rounded-broken"></iconify-icon>
                        <span class="match_bold">@lang('index.parties')</span>
                    </a>
                    
                    <ul class="treeview-menu">
                        @if (routePermission('customer.create'))
                            <li class="menu_assign_class {{ request()->routeIs('customers.create') ? ' treeMenuActive' : '' }}" data-menu__cid="irp_10"><a
                                    href="{{ route('customers.create') }}">@lang('index.add_customer')</a>
                            </li>
                        @endif
                        @if (routePermission('customer.index'))
                            <li class="menu_assign_class {{ request()->routeIs('customers.index') ? ' treeMenuActive' : '' }}" data-menu__cid="irp_10"><a
                                    href="{{ route('customers.index') }}">@lang('index.list_customer')</a>
                            </li>
                        @endif
                        @if (routePermission('supplier.create'))
                            <li class="menu_assign_class {{ request()->routeIs('suppliers.create') ? ' treeMenuActive' : '' }}" data-menu__cid="irp_10"><a
                                    href="{{ route('suppliers.create') }}">@lang('index.add_supplier')</a>
                            </li>
                        @endif
                        @if (routePermission('supplier.index'))
                            <li class="menu_assign_class {{ request()->routeIs('suppliers.index') ? ' treeMenuActive' : '' }}" data-menu__cid="irp_10"><a
                                    href="{{ route('suppliers.index') }}">@lang('index.list_supplier')</a>
                            </li>
                        @endif
                    </ul>
                </li>
            @endif
            @if (menuPermission('Users'))
                <li class="parent-menu treeview menu__cidirp_10{{ request()->is('user*') || request()->is('role*') ? ' menu-open active_sub_menu' : '' }}">
                    <a href="#">
                        <iconify-icon icon="solar:user-circle-broken"></iconify-icon>
                        <span class="match_bold">@lang('index.user')</span>
                    </a>
                    <ul class="treeview-menu">
                        @if (routePermission('role.create'))
                            <li class="menu_assign_class {{ request()->routeIs('role.create') ? ' treeMenuActive' : '' }}" data-menu__cid="irp_10"><a
                                    href="{{ route('role.create') }}">@lang('index.add_role')</a>
                            </li>
                        @endif
                        @if (routePermission('role.index'))
                            <li class="menu_assign_class {{ request()->routeIs('role.index') ? ' treeMenuActive' : '' }}" data-menu__cid="irp_10"><a
                                    href="{{ route('role.index') }}">@lang('index.list_role')</a>
                            </li>
                        @endif
                        @if (routePermission('user.create'))
                            <li class="menu_assign_class {{ request()->routeIs('user.create') ? ' treeMenuActive' : '' }}" data-menu__cid="irp_10"><a
                                    href="{{ route('user.create') }}">@lang('index.add_user')</a>
                            </li>
                        @endif
                        @if (routePermission('user.index'))
                            <li class="menu_assign_class {{ request()->routeIs('user.index') ? ' treeMenuActive' : '' }}" data-menu__cid="irp_10"><a
                                    href="{{ route('user.index') }}">@lang('index.list_user')</a>
                            </li>
                        @endif
                    </ul>
                </li>
            @endif
            @if (menuPermission('Master'))
                <li class="parent-menu treeview menu__cidirp_10{{ request()->is('units*') || request()->is('productionstages*') || request()->is('drawers*') || request()->is('inspections*') ? ' menu-open active_sub_menu' : '' }}">
                    <a href="#">
                        <iconify-icon icon="solar:settings-broken"></iconify-icon>
                        <span class="match_bold">@lang('index.master')</span>
                    </a>
                    <ul class="treeview-menu">
                        @if (routePermission('units.create'))
                            <li class="menu_assign_class {{ request()->routeIs('units.create') ? ' treeMenuActive' : '' }}" data-menu__cid="irp_10"><a
                                    href="{{ route('units.create') }}">@lang('index.add_unit')</a>
                            </li>
                        @endif
                        @if (routePermission('units.index'))
                            <li class="menu_assign_class {{ request()->routeIs('units.index') ? ' treeMenuActive' : '' }}" data-menu__cid="irp_10"><a
                                    href="{{ route('units.index') }}">@lang('index.list_unit')</a>
                            </li>
                        @endif
                        @if (routePermission('drawers.create'))
                            <li class="menu_assign_class {{ request()->routeIs('drawers.create') ? ' treeMenuActive' : '' }}" data-menu__cid="irp_10"><a
                                    href="{{ route('drawers.create') }}">@lang('index.add_drawer')</a>
                            </li>
                        @endif
                        @if (routePermission('drawers.index'))
                            <li class="menu_assign_class {{ request()->routeIs('drawers.index') ? ' treeMenuActive' : '' }}" data-menu__cid="irp_10"><a
                                    href="{{ route('drawers.index') }}">@lang('index.list_drawer')</a>
                            </li>
                        @endif
                        @if (routePermission('inspections.create'))
                            <li class="menu_assign_class {{ request()->routeIs('inspections.create') ? ' treeMenuActive' : '' }}" data-menu__cid="irp_10"><a
                                    href="{{ route('inspections.create') }}">@lang('index.add_inspection')</a>
                            </li>
                        @endif
                        @if (routePermission('inspections.index'))
                            <li class="menu_assign_class {{ request()->routeIs('inspections.index') ? ' treeMenuActive' : '' }}" data-menu__cid="irp_10"><a
                                    href="{{ route('inspections.index') }}">@lang('index.list_inspection')</a>
                            </li>
                        @endif
                        @if (routePermission('productionstage.create'))
                            <li class="menu_assign_class {{ request()->routeIs('productionstages.create') ? ' treeMenuActive' : '' }}" data-menu__cid="irp_10"><a
                                    href="{{ route('productionstages.create') }}">@lang('index.add_production_stage')</a>
                            </li>
                        @endif
                        @if (routePermission('productionstage.list'))
                            <li class="menu_assign_class {{ request()->routeIs('productionstages.index') ? ' treeMenuActive' : '' }}" data-menu__cid="irp_10"><a
                                    href="{{ route('productionstages.index') }}">@lang('index.list_production_stage')</a>
                            </li>
                        @endif
                    </ul>
                </li>  
            @endif
            @if (menuPermission('Item Setup'))
                <li
                    class="parent-menu treeview menu__cidirp_10{{ request()->is('rmcategories*') || request()->is('rawmaterials*') || request()->is('noninventoryitems*') || request()->is('fpcategories*') || request()->is('finishedproducts*') ? ' menu-open active_sub_menu' : '' }}">
                    <a href="#">
                        <iconify-icon icon="solar:inbox-line-broken"></iconify-icon>
                        <span class="match_bold">@lang('index.item_setup')</span>
                    </a>
                    <ul class="treeview-menu">
                        @if (routePermission('rmcategory.create'))
                            <li class="menu_assign_class {{ request()->routeIs('rmcategories.create') ? ' treeMenuActive' : '' }}" data-menu__cid="irp_10"><a
                                    href="{{ route('rmcategories.create') }}">@lang('index.add_rm_category')</a>
                            </li>
                        @endif
                        @if (routePermission('rmcategory.index'))
                            <li class="menu_assign_class {{ request()->routeIs('rmcategories.index') ? ' treeMenuActive' : '' }}" data-menu__cid="irp_10"><a
                                    href="{{ route('rmcategories.index') }}">@lang('index.rm_category')</a>
                            </li>
                        @endif
                        @if (routePermission('rm.create'))
                            <li class="menu_assign_class {{ request()->routeIs('rawmaterials.create') ? ' treeMenuActive' : '' }}" data-menu__cid="irp_10"><a
                                    href="{{ route('rawmaterials.create') }}">@lang('index.add_raw_material')</a>
                            </li>
                        @endif
                        @if (routePermission('rm.index'))
                            <li class="menu_assign_class {{ request()->routeIs('rawmaterials.index') ? ' treeMenuActive' : '' }}" data-menu__cid="irp_10"><a
                                    href="{{ route('rawmaterials.index') }}">@lang('index.list_raw_material')</a>
                            </li>
                        @endif
                        @if (routePermission('productcategory.create'))
                            <li class="menu_assign_class {{ request()->routeIs('fpcategories.create') ? ' treeMenuActive' : '' }}" data-menu__cid="irp_10"><a
                                    href="{{ route('fpcategories.create') }}">@lang('index.add_product_category')</a>
                            </li>
                        @endif
                        @if (routePermission('productcategory.index'))
                            <li class="menu_assign_class {{ request()->routeIs('fpcategories.index') ? ' treeMenuActive' : '' }}" data-menu__cid="irp_10"><a
                                    href="{{ route('fpcategories.index') }}">@lang('index.list_product_category')</a>
                            </li>
                        @endif
                        @if (routePermission('product.create'))
                            <li class="menu_assign_class {{ request()->routeIs('finishedproducts.create') ? ' treeMenuActive' : '' }}" data-menu__cid="irp_10"><a
                                    href="{{ route('finishedproducts.create') }}">@lang('index.add_product')</a>
                            </li>
                        @endif
                        @if (routePermission('product.index'))
                            <li class="menu_assign_class {{ request()->routeIs('finishedproducts.index') ? ' treeMenuActive' : '' }}" data-menu__cid="irp_10"><a
                                    href="{{ route('finishedproducts.index') }}">@lang('index.list_product')</a>
                            </li>
                        @endif
                    </ul>
                </li>
            @endif
            @if (menuPermission('Purchases'))
                <li
                    class="parent-menu treeview menu__cidirp_10{{ request()->is('rawmaterialpurchases*') || request()->is('purchase-generate') ? ' menu-open active_sub_menu' : '' }}">
                    <a href="#">
                        <iconify-icon icon="solar:cart-check-broken"></iconify-icon>
                        <span class="match_bold">@lang('index.supplier_purchase')</span>
                    </a>
                    <ul class="treeview-menu">
                        @if (routePermission('purchase.create'))
                            <li class="menu_assign_class {{ request()->routeIs('rawmaterialpurchases.create') || request()->routeIs('purchase-generate-customer-order') ? ' treeMenuActive' : '' }}" data-menu__cid="irp_10"><a
                                    href="{{ route('rawmaterialpurchases.create') }}">@lang('index.add_purchase')</a>
                            </li>
                        @endif
                        @if (routePermission('purchase.index'))
                            <li class="menu_assign_class {{ request()->routeIs('rawmaterialpurchases.index') ? ' treeMenuActive' : '' }}" data-menu__cid="irp_10"><a
                                    href="{{ route('rawmaterialpurchases.index') }}">@lang('index.list_purchase')</a>
                            </li>
                        @endif
                    </ul>
                </li>
            @endif
            @if (menuPermission('Material Stock'))
                <li class="parent-menu treeview menu_assign_class menu__cidirp_1{{ request()->is('material_stocks*') || request()->is('getLowStock*') || request()->is('stock-adjustment*') ? ' menu-open active_sub_menu' : '' }}"
                    data-menu__cid="irp_1">
                    <a href="#">
                        <iconify-icon icon="solar:database-broken"></iconify-icon>
                        <span class="match_bold">@lang('index.rm_stocks')</span>
                    </a>
                    <ul class="treeview-menu">
                        @if (routePermission('material_stocks.create'))
                            <li class="menu_assign_class {{ request()->routeIs('material_stocks.create') ? ' treeMenuActive' : '' }}" data-menu__cid="irp_10"><a
                                    href="{{ route('material_stocks.create') }}">@lang('index.add_rm_stock')</a>
                            </li>
                        @endif
                        @if (routePermission('material_stocks.index'))
                            <li class="menu_assign_class {{ request()->routeIs('material_stocks.index') ? ' treeMenuActive' : '' }}" data-menu__cid="irp_10"><a
                                    href="{{ route('material_stocks.index') }}">@lang('index.rm_stocks')</a>
                            </li>
                        @endif
                    </ul>
                </li>
            @endif
            @if (menuPermission('Orders'))
                <li
                    class="parent-menu treeview menu__cidirp_10{{ request()->is('customer-orders*') || request()->is('customer-order-status') ? ' menu-open active_sub_menu' : '' }}">
                    <a href="#">
                        <iconify-icon icon="solar:user-broken"></iconify-icon>
                        <span class="match_bold">@lang('index.orders')</span>
                    </a>
                    
                    <ul class="treeview-menu">
                        
                        @if (routePermission('order.create'))
                            <li class="menu_assign_class {{ request()->routeIs('customer-orders.create') ? ' treeMenuActive' : '' }}" data-menu__cid="irp_10"><a
                                    href="{{ route('customer-orders.create') }}">@lang('index.add_order')</a>
                            </li>
                        @endif
                        @if (routePermission('order.index'))
                            <li class="menu_assign_class {{ request()->routeIs('customer-orders.index') ? ' treeMenuActive' : '' }}" data-menu__cid="irp_10"><a
                                    href="{{ route('customer-orders.index') }}">@lang('index.order_list')</a>
                            </li>
                        @endif
                        @if (routePermission('order-status'))
                            <li class="menu_assign_class {{ request()->routeIs('customer-order-status') ? ' treeMenuActive' : '' }}" data-menu__cid="irp_10"><a
                                    href="{{ route('customer-order-status') }}">@lang('index.order_status')</a>
                            </li>
                        @endif
                    </ul>
                </li>
            @endif
            @if (menuPermission('Production'))
                <li
                    class="parent-menu treeview menu__cidirp_10{{ request()->is('productions*') || request()->is('production-loss*') ? ' menu-open active_sub_menu' : '' }}">
                    <a href="#">
                        <iconify-icon icon="solar:chart-square-broken"></iconify-icon>
                        <span class="match_bold">@lang('index.manufacture')</span>
                    </a>
                    <ul class="treeview-menu">
                        @if (routePermission('manufacture.create'))
                            <li class="menu_assign_class {{ request()->routeIs('productions.create') ? ' treeMenuActive' : '' }}" data-menu__cid="irp_10"><a
                                    href="{{ route('productions.create') }}">@lang('index.add_manufacture')</a>
                            </li>
                        @endif
                        @if (routePermission('manufacture.index'))
                            <li class="menu_assign_class {{ request()->routeIs('productions.index') || request()->is('productions/*/route-card') || request()->is('productions/*/job-card') || request()->is('productions/*/task-track') || request()->is('productions/*/drawer-image') ? ' treeMenuActive' : '' }}" data-menu__cid="irp_10"><a
                                    href="{{ route('productions.index') }}">@lang('index.manufacture_list')</a>
                            </li>
                        @endif
                        {{-- @if (routePermission('production-loss.create'))
                            <li class="menu_assign_class {{ request()->routeIs('production-loss') ? ' treeMenuActive' : '' }}" data-menu__cid="irp_10"><a
                                    href="{{ route('production-loss') }}">@lang('index.add_production_loss')</a>
                            </li>
                        @endif
                        @if (routePermission('production-loss.index'))
                            <li class="menu_assign_class {{ request()->routeIs('production-loss-report') ? ' treeMenuActive' : '' }}" data-menu__cid="irp_10"><a
                                    href="{{ route('production-loss-report') }}">@lang('index.production_loss_list')</a>
                            </li>
                        @endif                       
                        @if (routePermission('demand-forecasting-by-order'))
                            <li class="menu_assign_class {{ request()->routeIs('forecasting.order') ? ' treeMenuActive' : '' }}" data-menu__cid="irp_10"><a
                                    href="{{ route('forecasting.order') }}">@lang('index.demand_forecasting_by_order')</a>
                            </li>
                        @endif
                        @if (routePermission('demand-forecasting-by-product'))
                            <li class="menu_assign_class {{ request()->routeIs('forecasting.product') ? ' treeMenuActive' : '' }}" data-menu__cid="irp_10"><a
                                    href="{{ route('forecasting.product') }}">@lang('index.demand_forecasting_by_product')</a>
                            </li>
                        @endif --}}
                    </ul>
                </li>
            @endif
            <li class="parent-menu treeview2 menu_assign_class menu__cidirp_1{{ request()->is('consumable*') ? ' menu-open active_sub_menu' : '' }}" data-menu__cid="irp_1">
                <a href="{{ route('consumable.index') }}">
                    <iconify-icon icon="solar:inbox-line-broken"></iconify-icon>
                    <span class="match_bold">@lang('index.consumable')</span>
                </a>
            </li>
            @if (menuPermission('Inspection'))
                <li class="parent-menu treeview2 menu_assign_class menu__cidirp_1{{ request()->is('inspection-generate*') ? ' menu-open active_sub_menu' : '' }}"
                    data-menu__cid="irp_1">
                    <a href="{{ route('inspection-generate.index') }}">
                        <iconify-icon icon="solar:checklist-minimalistic-broken"></iconify-icon>
                        <span class="match_bold">@lang('index.inspect_list')</span>
                    </a>
                </li>
            @endif
            @if (menuPermission('Delivery Challan'))
                <li
                    class="parent-menu treeview menu__cidirp_10{{ request()->is('quotation*') ? ' menu-open active_sub_menu' : '' }}">
                    <a href="#">
                        <iconify-icon icon="solar:ruler-pen-broken"></iconify-icon>
                        <span class="match_bold">@lang('index.delivery_challan')</span>
                    </a>
                    
                    <ul class="treeview-menu">
                        @if (routePermission('quotations.create'))
                            <li class="menu_assign_class {{ request()->routeIs('quotation.create') ? ' treeMenuActive' : '' }}" data-menu__cid="irp_10"><a
                                    href="{{ route('quotation.create') }}">@lang('index.add_dc')</a>
                            </li>
                        @endif
                        @if (routePermission('quotations.index'))
                            <li class="menu_assign_class {{ request()->routeIs('quotation.index') ? ' treeMenuActive' : '' }}" data-menu__cid="irp_10"><a
                                    href="{{ route('quotation.index') }}">@lang('index.dc_list')</a>
                            </li>
                        @endif
                    </ul>
                </li>
            @endif
            @if (menuPermission('Customer Receives'))
                <li class="parent-menu treeview2 menu_assign_class menu__cidirp_1{{ request()->is('customer-payment*') ? ' menu-open active_sub_menu' : '' }}"
                    data-menu__cid="irp_1">
                    <a href="{{ route('customer-payment.index') }}">
                        <iconify-icon icon="solar:card-recive-broken"></iconify-icon>
                        <span class="match_bold">@lang('index.customer_receive_list')</span>
                    </a>
                </li>
                {{-- <li
                    class="parent-menu treeview menu__cidirp_10{{ request()->is('customer-payment*') ? ' menu-open active_sub_menu' : '' }}">
                    <a href="#">
                        <iconify-icon icon="solar:card-recive-broken"></iconify-icon>
                        <span class="match_bold">@lang('index.customer_receive')</span>
                    </a>
                    
                    <ul class="treeview-menu">
                        @if (routePermission('cd.create'))
                            <li class="menu_assign_class {{ request()->routeIs('customer-payment.create') ? ' treeMenuActive' : '' }}" data-menu__cid="irp_10"><a
                                    href="{{ route('customer-payment.create') }}">@lang('index.add_customer_receive')</a>
                            </li>
                        @endif
                        @if (routePermission('cd.index'))
                            <li class="menu_assign_class {{ request()->routeIs('customer-payment.index') ? ' treeMenuActive' : '' }}" data-menu__cid="irp_10"><a
                                    href="{{ route('customer-payment.index') }}">@lang('index.customer_receive_list')</a>
                            </li>
                        @endif
                    </ul>
                </li> --}}
            @endif
            @if (menuPermission('Sales'))
                <li
                    class="parent-menu treeview menu__cidirp_10{{ request()->is('sales*') ? ' menu-open active_sub_menu' : '' }}">
                    <a href="#">
                        <iconify-icon icon="solar:cart-large-broken"></iconify-icon>
                        <span class="match_bold">@lang('index.sale')</span>
                    </a>
                    
                    <ul class="treeview-menu">
                        
                        @if (routePermission('sale.create'))
                            <li class="menu_assign_class {{ request()->routeIs('sales.create') ? ' treeMenuActive' : '' }}" data-menu__cid="irp_10"><a
                                    href="{{ route('sales.create') }}">@lang('index.add_sale')</a>
                            </li>
                        @endif
                        @if (routePermission('sale.index'))
                            <li class="menu_assign_class {{ request()->routeIs('sales.index') ? ' treeMenuActive' : '' }}" data-menu__cid="irp_10"><a
                                    href="{{ route('sales.index') }}">@lang('index.sale_list')</a>
                            </li>
                        @endif
                        
                    </ul>
                </li>
            @endif
            @if (menuPermission('Supplier Payment'))
                @if (routePermission('supplier-payment.index'))
                <li class="parent-menu treeview2 menu_assign_class menu__cidirp_1{{ request()->is('supplier-payment*') ? ' menu-open active_sub_menu' : '' }}"
                    data-menu__cid="irp_1">
                    <a href="{{ route('supplier-payment.index') }}">
                        <iconify-icon icon="solar:card-recive-broken"></iconify-icon>
                        <span class="match_bold">@lang('index.supplier_payment_list')</span>
                    </a>
                </li>
                @endif
            @endif
            @if (menuPermission('Expense'))
                <li
                    class="parent-menu treeview menu__cidirp_10{{ request()->is('expense*') || request()->is('expense/*') || request()->is('expense-category*') ? ' menu-open active_sub_menu' : '' }}">
                    <a href="#">
                        <iconify-icon icon="solar:money-bag-broken"></iconify-icon>
                        <span class="match_bold">@lang('index.expense')</span>
                    </a>
                    <ul class="treeview-menu">
                        @if (routePermission('expensecategory.create'))
                            <li class="menu_assign_class {{ request()->routeIs('expense-category.create') ? ' treeMenuActive' : '' }}" data-menu__cid="irp_10"><a
                                    href="{{ route('expense-category.create') }}">@lang('index.add_expense_category')</a>
                            </li>
                        @endif
                        @if (routePermission('expensecategory.index'))
                            <li class="menu_assign_class {{ request()->routeIs('expense-category.index') ? ' treeMenuActive' : '' }}" data-menu__cid="irp_10"><a
                                    href="{{ route('expense-category.index') }}">@lang('index.expense_category_list')</a>
                            </li>
                        @endif
                        @if (routePermission('expense.create'))
                            <li class="menu_assign_class {{ request()->routeIs('expense.create') ? ' treeMenuActive' : '' }}" data-menu__cid="irp_10"><a
                                    href="{{ route('expense.create') }}">@lang('index.add_expense')</a>
                            </li>
                        @endif
                        @if (routePermission('expense.index'))
                            <li class="menu_assign_class {{ request()->routeIs('expense.index') ? ' treeMenuActive' : '' }}" data-menu__cid="irp_10"><a
                                    href="{{ route('expense.index') }}">@lang('index.expense_list')</a>
                            </li>
                        @endif
                    </ul>
                </li>
            @endif
            {{-- @if (menuPermission('Attendance'))
                <li
                    class="parent-menu treeview menu__cidirp_10{{ request()->is('attendance*') ? ' menu-open active_sub_menu' : '' }}">
                    <a href="#">
                        <iconify-icon icon="solar:stopwatch-broken"></iconify-icon>
                        <span class="match_bold">@lang('index.attendance')</span>
                    </a>
                    
                    <ul class="treeview-menu">
                        @if (routePermission('attendance.create'))
                            <li class="menu_assign_class {{ request()->routeIs('attendance.create') ? ' treeMenuActive' : '' }}" data-menu__cid="irp_10"><a
                                    href="{{ route('attendance.create') }}">@lang('index.add_attendance')</a>
                            </li>
                        @endif
                        @if (routePermission('attendance.index'))
                            <li class="menu_assign_class {{ request()->routeIs('attendance.index') ? ' treeMenuActive' : '' }}" data-menu__cid="irp_10"><a
                                    href="{{ route('attendance.index') }}">@lang('index.attendance_list')</a>
                            </li>
                        @endif
                    </ul>
                </li>
            @endif --}}
            @if (menuPermission('Payroll'))
                <li
                    class="parent-menu treeview menu__cidirp_10{{ request()->is('payroll*') ? ' menu-open active_sub_menu' : '' }}">
                    <a href="#">
                        <iconify-icon icon="solar:transmission-broken"></iconify-icon>
                        <span class="match_bold">@lang('index.payroll')</span>
                    </a>                    
                    <ul class="treeview-menu">
                        @if (routePermission('payroll.create'))
                            <li class="menu_assign_class {{ request()->routeIs('payroll.create') ? ' treeMenuActive' : '' }}" data-menu__cid="irp_10"><a
                                    href="{{ route('payroll.create') }}">@lang('index.add_payroll')</a>
                            </li>
                        @endif
                        @if (routePermission('payroll.index'))
                            <li class="menu_assign_class {{ request()->routeIs('payroll.index') ? ' treeMenuActive' : '' }}" data-menu__cid="irp_10"><a
                                    href="{{ route('payroll.index') }}">@lang('index.list_payroll')</a>
                            </li>
                        @endif
                    </ul>
                </li>
            @endif
            {{-- @if (menuPermission('Product Stock'))
                <li class="parent-menu treeview2 menu_assign_class menu__cidirp_1{{ request()->is('product-stock*') ? ' menu-open active_sub_menu' : '' }}"
                    data-menu__cid="irp_1">
                    <a href="{{ route('product-stock') }}">
                        <iconify-icon icon="solar:bag-2-broken"></iconify-icon>
                        <span class="match_bold">@lang('index.product_stocks')</span>
                    </a>
                </li>
            @endif --}}
            @if (menuPermission('Accounting'))
                <li
                    class="parent-menu treeview menu__cidirp_10{{ request()->is('accounts*') || request()->is('deposit*') || request()->is('balance-sheet*') || request()->is('trial-balance*') ? ' menu-open active_sub_menu' : '' }}">
                    <a href="#">
                        <iconify-icon icon="solar:wallet-money-broken"></iconify-icon>
                        <span class="match_bold">@lang('index.accounting')</span>
                    </a>                    
                    <ul class="treeview-menu">
                        {{-- @if (routePermission('account.create'))
                            <li class="menu_assign_class {{ request()->routeIs('accounts.create') ? ' treeMenuActive' : '' }}" data-menu__cid="irp_10"><a
                                    href="{{ route('accounts.create') }}">@lang('index.add_account')</a>
                            </li>
                        @endif
                        @if (routePermission('account.index'))
                            <li class="menu_assign_class {{ request()->routeIs('accounts.index') ? ' treeMenuActive' : '' }}" data-menu__cid="irp_10"><a
                                    href="{{ route('accounts.index') }}">@lang('index.list_account')</a>
                            </li>
                        @endif --}}
                        @if (routePermission('deposit.create'))
                            <li class="menu_assign_class {{ request()->routeIs('deposit.create') ? ' treeMenuActive' : '' }}" data-menu__cid="irp_10"><a
                                    href="{{ route('deposit.create') }}">@lang('index.add_deposit_or_withdraw')</a>
                            </li>
                        @endif
                        @if (routePermission('deposit.index'))
                            <li class="menu_assign_class {{ request()->routeIs('deposit.index') ? ' treeMenuActive' : '' }}" data-menu__cid="irp_10"><a
                                    href="{{ route('deposit.index') }}">@lang('index.list_deposit_or_withdraw')</a>
                            </li>
                        @endif
                        @if (routePermission('balancesheet'))
                            <li class="menu_assign_class {{ request()->routeIs('balance-sheet') ? ' treeMenuActive' : '' }}" data-menu__cid="irp_10"><a
                                    href="{{ route('balance-sheet') }}">@lang('index.balance_sheet')</a>
                            </li>
                        @endif
                        {{-- @if (routePermission('trialbalance'))
                            <li class="menu_assign_class {{ request()->routeIs('trial-balance') ? ' treeMenuActive' : '' }}" data-menu__cid="irp_10"><a
                                    href="{{ route('trial-balance') }}">@lang('index.trial_balance')</a>
                            </li>
                        @endif --}}
                    </ul>
                </li>
            @endif
            <li
                class="parent-menu treeview menu__cidirp_10{{ request()->is('sale-report*') || request()->is('expense-report*') || request()->is('salary-report*') ? ' menu-open active_sub_menu' : '' }}">
                <a href="#">
                    <iconify-icon icon="solar:diagram-down-broken"></iconify-icon>
                    <span class="match_bold">@lang('index.report')</span>
                </a>
                <ul class="treeview-menu">
                    {{-- @if (routePermission('product-price-history')) --}}
                        <li class="menu_assign_class {{ request()->routeIs('report.sales') ? ' treeMenuActive' : '' }}" data-menu__cid="irp_10"><a href="{{ route('report.sales') }}">Sales Report</a>
                        </li>
                    {{-- @endif --}}
                    <li class="menu_assign_class {{ request()->routeIs('expense-report') ? ' treeMenuActive' : '' }}" data-menu__cid="irp_10"><a href="{{ route('expense-report') }}">Expense Report</a></li>
                    <li class="menu_assign_class {{ request()->routeIs('salary-report') ? ' treeMenuActive' : '' }}" data-menu__cid="irp_10"><a href="{{ route('salary-report') }}">Salary Report</a></li>
                </ul>
            </li>
            @if (menuPermission('Settings'))
                <li
                    class="parent-menu treeview menu__cidirp_10{{ request()->is('settings') || request()->is('white-label') || request()->is('taxes') || request()->is('units*') || request()->is('mail-settings') || request()->is('productionstages*') || request()->is('currency*') || request()->is('data-import') ? ' menu-open active_sub_menu' : '' }}">
                    <a href="#">
                        <iconify-icon icon="solar:settings-broken"></iconify-icon>
                        <span class="match_bold">@lang('index.settings')</span>
                    </a>
                    <ul class="treeview-menu">
                        @if (routePermission('settings'))
                            <li class="menu_assign_class {{ request()->routeIs('settings') ? ' treeMenuActive' : '' }}" data-menu__cid="irp_10"><a
                                    href="{{ route('settings') }}">
                                    @lang('index.company_profile')
                                </a>
                            </li>
                        @endif
                        @if (routePermission('taxes'))
                            <li class="menu_assign_class {{ request()->routeIs('taxes') ? ' treeMenuActive' : '' }}" data-menu__cid="irp_10"><a
                                    href="{{ route('taxes') }}">@lang('index.tax_settings')</a>
                            </li>
                        @endif
                        @if (isWhiteLabelChangeAble())
                            @if (routePermission('white-label'))
                                <li class="menu_assign_class {{ request()->routeIs('white-label') ? ' treeMenuActive' : '' }}" data-menu__cid="irp_10"><a
                                        href="{{ route('white-label') }}">@lang('index.white_label')</a>
                                </li>
                            @endif
                        @endif
                        @if (routePermission('data-import'))
                            <li class="menu_assign_class {{ request()->routeIs('data-import') ? ' treeMenuActive' : '' }}" data-menu__cid="irp_10"><a
                                    href="{{ route('data-import') }}">@lang('index.data_import')</a>
                            </li>
                        @endif
                    </ul>
                </li>
            @endif
            <div class="ps__rail-x">
                <div class="ps__thumb-x" tabindex="0"></div>
            </div>
            <div class="ps__rail-y">
                <div class="ps__thumb-y" tabindex="0"></div>
            </div>
        </ul>
    </div>
</section>
