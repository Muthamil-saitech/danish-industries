<div class="logo_Section_main_sidebar">
    <a href="<?php echo e(route('dashboard')); ?>" class="logo-wrapper">
        <?php
            $photo = isset($whiteLabelInfo->mini_logo)
                ? 'uploads/white_label/' . $whiteLabelInfo->mini_logo
                : 'frequent_changing/images/mini_logo.png';
            
            $logo_lg = isset($whiteLabelInfo->logo)
                ? 'uploads/white_label/' . $whiteLabelInfo->logo
                : 'frequent_changing/images/logo.png';
        ?>

        <span class="logo-lg">
            <img src="<?php echo e($baseURL . $logo_lg); ?>" class="img-circle" alt="Logo Image">
        </span>
        <span class="logo-mini">
            <img src="<?php echo e($baseURL . $photo); ?>" class="img-circle" alt="Logo Image">
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

            
            <?php if(menuPermission('Dashboard')): ?>
                <li class="parent-menu treeview2 menu_assign_class menu__cidirp_1<?php echo e(request()->is('dashboard') ? ' menu-open active_sub_menu' : ''); ?>"
                    data-menu__cid="irp_1">
                    <a href="<?php echo e(route('dashboard')); ?>">
                        <iconify-icon icon="solar:chart-2-broken"></iconify-icon>
                        <span class="match_bold"><?php echo app('translator')->get('index.dashboard'); ?></span>
                    </a>
                </li>
            <?php endif; ?>
            <?php if(menuPermission('Parties')): ?>
                <li
                    class="parent-menu treeview menu__cidirp_10<?php echo e(request()->is('suppliers*') || request()->is('customers*') ? ' menu-open active_sub_menu' : ''); ?>">
                    <a href="#">
                        <iconify-icon icon="solar:users-group-two-rounded-broken"></iconify-icon>
                        <span class="match_bold"><?php echo app('translator')->get('index.parties'); ?></span>
                    </a>
                    
                    <ul class="treeview-menu">
                        <?php if(routePermission('customer.create')): ?>
                            <li class="menu_assign_class <?php echo e(request()->routeIs('customers.create') ? ' treeMenuActive' : ''); ?>" data-menu__cid="irp_10"><a
                                    href="<?php echo e(route('customers.create')); ?>"><?php echo app('translator')->get('index.add_customer'); ?></a>
                            </li>
                        <?php endif; ?>
                        <?php if(routePermission('customer.index')): ?>
                            <li class="menu_assign_class <?php echo e(request()->routeIs('customers.index') ? ' treeMenuActive' : ''); ?>" data-menu__cid="irp_10"><a
                                    href="<?php echo e(route('customers.index')); ?>"><?php echo app('translator')->get('index.list_customer'); ?></a>
                            </li>
                        <?php endif; ?>
                        <?php if(routePermission('supplier.create')): ?>
                            <li class="menu_assign_class <?php echo e(request()->routeIs('suppliers.create') ? ' treeMenuActive' : ''); ?>" data-menu__cid="irp_10"><a
                                    href="<?php echo e(route('suppliers.create')); ?>"><?php echo app('translator')->get('index.add_supplier'); ?></a>
                            </li>
                        <?php endif; ?>
                        <?php if(routePermission('supplier.index')): ?>
                            <li class="menu_assign_class <?php echo e(request()->routeIs('suppliers.index') ? ' treeMenuActive' : ''); ?>" data-menu__cid="irp_10"><a
                                    href="<?php echo e(route('suppliers.index')); ?>"><?php echo app('translator')->get('index.list_supplier'); ?></a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </li>
            <?php endif; ?>
            <?php if(menuPermission('Users')): ?>
                <li class="parent-menu treeview menu__cidirp_10<?php echo e(request()->is('user*') || request()->is('role*') ? ' menu-open active_sub_menu' : ''); ?>">
                    <a href="#">
                        <iconify-icon icon="solar:user-circle-broken"></iconify-icon>
                        <span class="match_bold"><?php echo app('translator')->get('index.user'); ?></span>
                    </a>
                    <ul class="treeview-menu">
                        <?php if(routePermission('role.create')): ?>
                            <li class="menu_assign_class <?php echo e(request()->routeIs('role.create') ? ' treeMenuActive' : ''); ?>" data-menu__cid="irp_10"><a
                                    href="<?php echo e(route('role.create')); ?>"><?php echo app('translator')->get('index.add_role'); ?></a>
                            </li>
                        <?php endif; ?>
                        <?php if(routePermission('role.index')): ?>
                            <li class="menu_assign_class <?php echo e(request()->routeIs('role.index') ? ' treeMenuActive' : ''); ?>" data-menu__cid="irp_10"><a
                                    href="<?php echo e(route('role.index')); ?>"><?php echo app('translator')->get('index.list_role'); ?></a>
                            </li>
                        <?php endif; ?>
                        <?php if(routePermission('user.create')): ?>
                            <li class="menu_assign_class <?php echo e(request()->routeIs('user.create') ? ' treeMenuActive' : ''); ?>" data-menu__cid="irp_10"><a
                                    href="<?php echo e(route('user.create')); ?>"><?php echo app('translator')->get('index.add_user'); ?></a>
                            </li>
                        <?php endif; ?>
                        <?php if(routePermission('user.index')): ?>
                            <li class="menu_assign_class <?php echo e(request()->routeIs('user.index') ? ' treeMenuActive' : ''); ?>" data-menu__cid="irp_10"><a
                                    href="<?php echo e(route('user.index')); ?>"><?php echo app('translator')->get('index.list_user'); ?></a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </li>
            <?php endif; ?>
            <?php if(menuPermission('Master')): ?>
                <li class="parent-menu treeview menu__cidirp_10<?php echo e(request()->is('units*') || request()->is('productionstages*') || request()->is('drawers*') || request()->is('inspections*') ? ' menu-open active_sub_menu' : ''); ?>">
                    <a href="#">
                        <iconify-icon icon="solar:settings-broken"></iconify-icon>
                        <span class="match_bold"><?php echo app('translator')->get('index.master'); ?></span>
                    </a>
                    <ul class="treeview-menu">
                        <?php if(routePermission('units.create')): ?>
                            <li class="menu_assign_class <?php echo e(request()->routeIs('units.create') ? ' treeMenuActive' : ''); ?>" data-menu__cid="irp_10"><a
                                    href="<?php echo e(route('units.create')); ?>"><?php echo app('translator')->get('index.add_unit'); ?></a>
                            </li>
                        <?php endif; ?>
                        <?php if(routePermission('units.index')): ?>
                            <li class="menu_assign_class <?php echo e(request()->routeIs('units.index') ? ' treeMenuActive' : ''); ?>" data-menu__cid="irp_10"><a
                                    href="<?php echo e(route('units.index')); ?>"><?php echo app('translator')->get('index.list_unit'); ?></a>
                            </li>
                        <?php endif; ?>
                        <?php if(routePermission('drawers.create')): ?>
                            <li class="menu_assign_class <?php echo e(request()->routeIs('drawers.create') ? ' treeMenuActive' : ''); ?>" data-menu__cid="irp_10"><a
                                    href="<?php echo e(route('drawers.create')); ?>"><?php echo app('translator')->get('index.add_drawer'); ?></a>
                            </li>
                        <?php endif; ?>
                        <?php if(routePermission('drawers.index')): ?>
                            <li class="menu_assign_class <?php echo e(request()->routeIs('drawers.index') ? ' treeMenuActive' : ''); ?>" data-menu__cid="irp_10"><a
                                    href="<?php echo e(route('drawers.index')); ?>"><?php echo app('translator')->get('index.list_drawer'); ?></a>
                            </li>
                        <?php endif; ?>
                        <?php if(routePermission('inspections.create')): ?>
                            <li class="menu_assign_class <?php echo e(request()->routeIs('inspections.create') ? ' treeMenuActive' : ''); ?>" data-menu__cid="irp_10"><a
                                    href="<?php echo e(route('inspections.create')); ?>"><?php echo app('translator')->get('index.add_inspection'); ?></a>
                            </li>
                        <?php endif; ?>
                        <?php if(routePermission('inspections.index')): ?>
                            <li class="menu_assign_class <?php echo e(request()->routeIs('inspections.index') ? ' treeMenuActive' : ''); ?>" data-menu__cid="irp_10"><a
                                    href="<?php echo e(route('inspections.index')); ?>"><?php echo app('translator')->get('index.list_inspection'); ?></a>
                            </li>
                        <?php endif; ?>
                        <?php if(routePermission('productionstage.create')): ?>
                            <li class="menu_assign_class <?php echo e(request()->routeIs('productionstages.create') ? ' treeMenuActive' : ''); ?>" data-menu__cid="irp_10"><a
                                    href="<?php echo e(route('productionstages.create')); ?>"><?php echo app('translator')->get('index.add_production_stage'); ?></a>
                            </li>
                        <?php endif; ?>
                        <?php if(routePermission('productionstage.list')): ?>
                            <li class="menu_assign_class <?php echo e(request()->routeIs('productionstages.index') ? ' treeMenuActive' : ''); ?>" data-menu__cid="irp_10"><a
                                    href="<?php echo e(route('productionstages.index')); ?>"><?php echo app('translator')->get('index.list_production_stage'); ?></a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </li>  
            <?php endif; ?>
            <?php if(menuPermission('Item Setup')): ?>
                <li
                    class="parent-menu treeview menu__cidirp_10<?php echo e(request()->is('rmcategories*') || request()->is('rawmaterials*') || request()->is('noninventoryitems*') || request()->is('fpcategories*') || request()->is('finishedproducts*') ? ' menu-open active_sub_menu' : ''); ?>">
                    <a href="#">
                        <iconify-icon icon="solar:inbox-line-broken"></iconify-icon>
                        <span class="match_bold"><?php echo app('translator')->get('index.item_setup'); ?></span>
                    </a>
                    <ul class="treeview-menu">
                        <?php if(routePermission('rmcategory.create')): ?>
                            <li class="menu_assign_class <?php echo e(request()->routeIs('rmcategories.create') ? ' treeMenuActive' : ''); ?>" data-menu__cid="irp_10"><a
                                    href="<?php echo e(route('rmcategories.create')); ?>"><?php echo app('translator')->get('index.add_rm_category'); ?></a>
                            </li>
                        <?php endif; ?>
                        <?php if(routePermission('rmcategory.index')): ?>
                            <li class="menu_assign_class <?php echo e(request()->routeIs('rmcategories.index') ? ' treeMenuActive' : ''); ?>" data-menu__cid="irp_10"><a
                                    href="<?php echo e(route('rmcategories.index')); ?>"><?php echo app('translator')->get('index.rm_category'); ?></a>
                            </li>
                        <?php endif; ?>
                        <?php if(routePermission('rm.create')): ?>
                            <li class="menu_assign_class <?php echo e(request()->routeIs('rawmaterials.create') ? ' treeMenuActive' : ''); ?>" data-menu__cid="irp_10"><a
                                    href="<?php echo e(route('rawmaterials.create')); ?>"><?php echo app('translator')->get('index.add_raw_material'); ?></a>
                            </li>
                        <?php endif; ?>
                        <?php if(routePermission('rm.index')): ?>
                            <li class="menu_assign_class <?php echo e(request()->routeIs('rawmaterials.index') ? ' treeMenuActive' : ''); ?>" data-menu__cid="irp_10"><a
                                    href="<?php echo e(route('rawmaterials.index')); ?>"><?php echo app('translator')->get('index.list_raw_material'); ?></a>
                            </li>
                        <?php endif; ?>
                        <?php if(routePermission('productcategory.create')): ?>
                            <li class="menu_assign_class <?php echo e(request()->routeIs('fpcategories.create') ? ' treeMenuActive' : ''); ?>" data-menu__cid="irp_10"><a
                                    href="<?php echo e(route('fpcategories.create')); ?>"><?php echo app('translator')->get('index.add_product_category'); ?></a>
                            </li>
                        <?php endif; ?>
                        <?php if(routePermission('productcategory.index')): ?>
                            <li class="menu_assign_class <?php echo e(request()->routeIs('fpcategories.index') ? ' treeMenuActive' : ''); ?>" data-menu__cid="irp_10"><a
                                    href="<?php echo e(route('fpcategories.index')); ?>"><?php echo app('translator')->get('index.list_product_category'); ?></a>
                            </li>
                        <?php endif; ?>
                        <?php if(routePermission('product.create')): ?>
                            <li class="menu_assign_class <?php echo e(request()->routeIs('finishedproducts.create') ? ' treeMenuActive' : ''); ?>" data-menu__cid="irp_10"><a
                                    href="<?php echo e(route('finishedproducts.create')); ?>"><?php echo app('translator')->get('index.add_product'); ?></a>
                            </li>
                        <?php endif; ?>
                        <?php if(routePermission('product.index')): ?>
                            <li class="menu_assign_class <?php echo e(request()->routeIs('finishedproducts.index') ? ' treeMenuActive' : ''); ?>" data-menu__cid="irp_10"><a
                                    href="<?php echo e(route('finishedproducts.index')); ?>"><?php echo app('translator')->get('index.list_product'); ?></a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </li>
            <?php endif; ?>
            <?php if(menuPermission('Purchases')): ?>
                <li
                    class="parent-menu treeview menu__cidirp_10<?php echo e(request()->is('rawmaterialpurchases*') || request()->is('purchase-generate') ? ' menu-open active_sub_menu' : ''); ?>">
                    <a href="#">
                        <iconify-icon icon="solar:cart-check-broken"></iconify-icon>
                        <span class="match_bold"><?php echo app('translator')->get('index.supplier_purchase'); ?></span>
                    </a>
                    <ul class="treeview-menu">
                        <?php if(routePermission('purchase.create')): ?>
                            <li class="menu_assign_class <?php echo e(request()->routeIs('rawmaterialpurchases.create') || request()->routeIs('purchase-generate-customer-order') ? ' treeMenuActive' : ''); ?>" data-menu__cid="irp_10"><a
                                    href="<?php echo e(route('rawmaterialpurchases.create')); ?>"><?php echo app('translator')->get('index.add_purchase'); ?></a>
                            </li>
                        <?php endif; ?>
                        <?php if(routePermission('purchase.index')): ?>
                            <li class="menu_assign_class <?php echo e(request()->routeIs('rawmaterialpurchases.index') ? ' treeMenuActive' : ''); ?>" data-menu__cid="irp_10"><a
                                    href="<?php echo e(route('rawmaterialpurchases.index')); ?>"><?php echo app('translator')->get('index.list_purchase'); ?></a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </li>
            <?php endif; ?>
            <?php if(menuPermission('Material Stock')): ?>
                <li class="parent-menu treeview menu_assign_class menu__cidirp_1<?php echo e(request()->is('material_stocks*') || request()->is('getLowStock*') || request()->is('stock-adjustment*') ? ' menu-open active_sub_menu' : ''); ?>"
                    data-menu__cid="irp_1">
                    <a href="#">
                        <iconify-icon icon="solar:database-broken"></iconify-icon>
                        <span class="match_bold"><?php echo app('translator')->get('index.rm_stocks'); ?></span>
                    </a>
                    <ul class="treeview-menu">
                        <?php if(routePermission('material_stocks.create')): ?>
                            <li class="menu_assign_class <?php echo e(request()->routeIs('material_stocks.create') ? ' treeMenuActive' : ''); ?>" data-menu__cid="irp_10"><a
                                    href="<?php echo e(route('material_stocks.create')); ?>"><?php echo app('translator')->get('index.add_rm_stock'); ?></a>
                            </li>
                        <?php endif; ?>
                        <?php if(routePermission('material_stocks.index')): ?>
                            <li class="menu_assign_class <?php echo e(request()->routeIs('material_stocks.index') ? ' treeMenuActive' : ''); ?>" data-menu__cid="irp_10"><a
                                    href="<?php echo e(route('material_stocks.index')); ?>"><?php echo app('translator')->get('index.rm_stocks'); ?></a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </li>
            <?php endif; ?>
            <?php if(menuPermission('Orders')): ?>
                <li
                    class="parent-menu treeview menu__cidirp_10<?php echo e(request()->is('customer-orders*') || request()->is('customer-order-status') ? ' menu-open active_sub_menu' : ''); ?>">
                    <a href="#">
                        <iconify-icon icon="solar:user-broken"></iconify-icon>
                        <span class="match_bold"><?php echo app('translator')->get('index.orders'); ?></span>
                    </a>
                    
                    <ul class="treeview-menu">
                        
                        <?php if(routePermission('order.create')): ?>
                            <li class="menu_assign_class <?php echo e(request()->routeIs('customer-orders.create') ? ' treeMenuActive' : ''); ?>" data-menu__cid="irp_10"><a
                                    href="<?php echo e(route('customer-orders.create')); ?>"><?php echo app('translator')->get('index.add_order'); ?></a>
                            </li>
                        <?php endif; ?>
                        <?php if(routePermission('order.index')): ?>
                            <li class="menu_assign_class <?php echo e(request()->routeIs('customer-orders.index') ? ' treeMenuActive' : ''); ?>" data-menu__cid="irp_10"><a
                                    href="<?php echo e(route('customer-orders.index')); ?>"><?php echo app('translator')->get('index.order_list'); ?></a>
                            </li>
                        <?php endif; ?>
                        <?php if(routePermission('order-status')): ?>
                            <li class="menu_assign_class <?php echo e(request()->routeIs('customer-order-status') ? ' treeMenuActive' : ''); ?>" data-menu__cid="irp_10"><a
                                    href="<?php echo e(route('customer-order-status')); ?>"><?php echo app('translator')->get('index.order_status'); ?></a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </li>
            <?php endif; ?>
            <?php if(menuPermission('Production')): ?>
                <li
                    class="parent-menu treeview menu__cidirp_10<?php echo e(request()->is('productions*') || request()->is('production-loss*') ? ' menu-open active_sub_menu' : ''); ?>">
                    <a href="#">
                        <iconify-icon icon="solar:chart-square-broken"></iconify-icon>
                        <span class="match_bold"><?php echo app('translator')->get('index.manufacture'); ?></span>
                    </a>
                    <ul class="treeview-menu">
                        <?php if(routePermission('manufacture.create')): ?>
                            <li class="menu_assign_class <?php echo e(request()->routeIs('productions.create') ? ' treeMenuActive' : ''); ?>" data-menu__cid="irp_10"><a
                                    href="<?php echo e(route('productions.create')); ?>"><?php echo app('translator')->get('index.add_manufacture'); ?></a>
                            </li>
                        <?php endif; ?>
                        <?php if(routePermission('manufacture.index')): ?>
                            <li class="menu_assign_class <?php echo e(request()->routeIs('productions.index') || request()->is('productions/*/route-card') || request()->is('productions/*/job-card') || request()->is('productions/*/task-track') || request()->is('productions/*/drawer-image') ? ' treeMenuActive' : ''); ?>" data-menu__cid="irp_10"><a
                                    href="<?php echo e(route('productions.index')); ?>"><?php echo app('translator')->get('index.manufacture_list'); ?></a>
                            </li>
                        <?php endif; ?>
                        
                    </ul>
                </li>
            <?php endif; ?>
            <li class="parent-menu treeview2 menu_assign_class menu__cidirp_1<?php echo e(request()->is('consumable*') ? ' menu-open active_sub_menu' : ''); ?>" data-menu__cid="irp_1">
                <a href="<?php echo e(route('consumable.index')); ?>">
                    <iconify-icon icon="solar:inbox-line-broken"></iconify-icon>
                    <span class="match_bold"><?php echo app('translator')->get('index.consumable'); ?></span>
                </a>
            </li>
            <?php if(menuPermission('Inspection')): ?>
                <li class="parent-menu treeview2 menu_assign_class menu__cidirp_1<?php echo e(request()->is('inspection-generate*') ? ' menu-open active_sub_menu' : ''); ?>"
                    data-menu__cid="irp_1">
                    <a href="<?php echo e(route('inspection-generate.index')); ?>">
                        <iconify-icon icon="solar:checklist-minimalistic-broken"></iconify-icon>
                        <span class="match_bold"><?php echo app('translator')->get('index.inspect_list'); ?></span>
                    </a>
                </li>
            <?php endif; ?>
            <?php if(menuPermission('Delivery Challan')): ?>
                <li
                    class="parent-menu treeview menu__cidirp_10<?php echo e(request()->is('quotation*') ? ' menu-open active_sub_menu' : ''); ?>">
                    <a href="#">
                        <iconify-icon icon="solar:ruler-pen-broken"></iconify-icon>
                        <span class="match_bold"><?php echo app('translator')->get('index.delivery_challan'); ?></span>
                    </a>
                    
                    <ul class="treeview-menu">
                        <?php if(routePermission('quotations.create')): ?>
                            <li class="menu_assign_class <?php echo e(request()->routeIs('quotation.create') ? ' treeMenuActive' : ''); ?>" data-menu__cid="irp_10"><a
                                    href="<?php echo e(route('quotation.create')); ?>"><?php echo app('translator')->get('index.add_dc'); ?></a>
                            </li>
                        <?php endif; ?>
                        <?php if(routePermission('quotations.index')): ?>
                            <li class="menu_assign_class <?php echo e(request()->routeIs('quotation.index') ? ' treeMenuActive' : ''); ?>" data-menu__cid="irp_10"><a
                                    href="<?php echo e(route('quotation.index')); ?>"><?php echo app('translator')->get('index.dc_list'); ?></a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </li>
            <?php endif; ?>
            <?php if(menuPermission('Customer Receives')): ?>
                <li class="parent-menu treeview2 menu_assign_class menu__cidirp_1<?php echo e(request()->is('customer-payment*') ? ' menu-open active_sub_menu' : ''); ?>"
                    data-menu__cid="irp_1">
                    <a href="<?php echo e(route('customer-payment.index')); ?>">
                        <iconify-icon icon="solar:card-recive-broken"></iconify-icon>
                        <span class="match_bold"><?php echo app('translator')->get('index.customer_receive_list'); ?></span>
                    </a>
                </li>
                
            <?php endif; ?>
            <?php if(menuPermission('Sales')): ?>
                <li
                    class="parent-menu treeview menu__cidirp_10<?php echo e(request()->is('sales*') ? ' menu-open active_sub_menu' : ''); ?>">
                    <a href="#">
                        <iconify-icon icon="solar:cart-large-broken"></iconify-icon>
                        <span class="match_bold"><?php echo app('translator')->get('index.sale'); ?></span>
                    </a>
                    
                    <ul class="treeview-menu">
                        
                        <?php if(routePermission('sale.create')): ?>
                            <li class="menu_assign_class <?php echo e(request()->routeIs('sales.create') ? ' treeMenuActive' : ''); ?>" data-menu__cid="irp_10"><a
                                    href="<?php echo e(route('sales.create')); ?>"><?php echo app('translator')->get('index.add_sale'); ?></a>
                            </li>
                        <?php endif; ?>
                        <?php if(routePermission('sale.index')): ?>
                            <li class="menu_assign_class <?php echo e(request()->routeIs('sales.index') ? ' treeMenuActive' : ''); ?>" data-menu__cid="irp_10"><a
                                    href="<?php echo e(route('sales.index')); ?>"><?php echo app('translator')->get('index.sale_list'); ?></a>
                            </li>
                        <?php endif; ?>
                        
                    </ul>
                </li>
            <?php endif; ?>
            <?php if(menuPermission('Supplier Payment')): ?>
                <?php if(routePermission('supplier-payment.index')): ?>
                <li class="parent-menu treeview2 menu_assign_class menu__cidirp_1<?php echo e(request()->is('supplier-payment*') ? ' menu-open active_sub_menu' : ''); ?>"
                    data-menu__cid="irp_1">
                    <a href="<?php echo e(route('supplier-payment.index')); ?>">
                        <iconify-icon icon="solar:card-recive-broken"></iconify-icon>
                        <span class="match_bold"><?php echo app('translator')->get('index.supplier_payment_list'); ?></span>
                    </a>
                </li>
                <?php endif; ?>
            <?php endif; ?>
            <?php if(menuPermission('Expense')): ?>
                <li
                    class="parent-menu treeview menu__cidirp_10<?php echo e(request()->is('expense*') || request()->is('expense/*') || request()->is('expense-category*') ? ' menu-open active_sub_menu' : ''); ?>">
                    <a href="#">
                        <iconify-icon icon="solar:money-bag-broken"></iconify-icon>
                        <span class="match_bold"><?php echo app('translator')->get('index.expense'); ?></span>
                    </a>
                    <ul class="treeview-menu">
                        <?php if(routePermission('expensecategory.create')): ?>
                            <li class="menu_assign_class <?php echo e(request()->routeIs('expense-category.create') ? ' treeMenuActive' : ''); ?>" data-menu__cid="irp_10"><a
                                    href="<?php echo e(route('expense-category.create')); ?>"><?php echo app('translator')->get('index.add_expense_category'); ?></a>
                            </li>
                        <?php endif; ?>
                        <?php if(routePermission('expensecategory.index')): ?>
                            <li class="menu_assign_class <?php echo e(request()->routeIs('expense-category.index') ? ' treeMenuActive' : ''); ?>" data-menu__cid="irp_10"><a
                                    href="<?php echo e(route('expense-category.index')); ?>"><?php echo app('translator')->get('index.expense_category_list'); ?></a>
                            </li>
                        <?php endif; ?>
                        <?php if(routePermission('expense.create')): ?>
                            <li class="menu_assign_class <?php echo e(request()->routeIs('expense.create') ? ' treeMenuActive' : ''); ?>" data-menu__cid="irp_10"><a
                                    href="<?php echo e(route('expense.create')); ?>"><?php echo app('translator')->get('index.add_expense'); ?></a>
                            </li>
                        <?php endif; ?>
                        <?php if(routePermission('expense.index')): ?>
                            <li class="menu_assign_class <?php echo e(request()->routeIs('expense.index') ? ' treeMenuActive' : ''); ?>" data-menu__cid="irp_10"><a
                                    href="<?php echo e(route('expense.index')); ?>"><?php echo app('translator')->get('index.expense_list'); ?></a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </li>
            <?php endif; ?>
            
            <?php if(menuPermission('Payroll')): ?>
                <li
                    class="parent-menu treeview menu__cidirp_10<?php echo e(request()->is('payroll*') ? ' menu-open active_sub_menu' : ''); ?>">
                    <a href="#">
                        <iconify-icon icon="solar:transmission-broken"></iconify-icon>
                        <span class="match_bold"><?php echo app('translator')->get('index.payroll'); ?></span>
                    </a>                    
                    <ul class="treeview-menu">
                        <?php if(routePermission('payroll.create')): ?>
                            <li class="menu_assign_class <?php echo e(request()->routeIs('payroll.create') ? ' treeMenuActive' : ''); ?>" data-menu__cid="irp_10"><a
                                    href="<?php echo e(route('payroll.create')); ?>"><?php echo app('translator')->get('index.add_payroll'); ?></a>
                            </li>
                        <?php endif; ?>
                        <?php if(routePermission('payroll.index')): ?>
                            <li class="menu_assign_class <?php echo e(request()->routeIs('payroll.index') ? ' treeMenuActive' : ''); ?>" data-menu__cid="irp_10"><a
                                    href="<?php echo e(route('payroll.index')); ?>"><?php echo app('translator')->get('index.list_payroll'); ?></a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </li>
            <?php endif; ?>
            
            <?php if(menuPermission('Accounting')): ?>
                <li
                    class="parent-menu treeview menu__cidirp_10<?php echo e(request()->is('accounts*') || request()->is('deposit*') || request()->is('balance-sheet*') || request()->is('trial-balance*') ? ' menu-open active_sub_menu' : ''); ?>">
                    <a href="#">
                        <iconify-icon icon="solar:wallet-money-broken"></iconify-icon>
                        <span class="match_bold"><?php echo app('translator')->get('index.accounting'); ?></span>
                    </a>                    
                    <ul class="treeview-menu">
                        
                        <?php if(routePermission('deposit.create')): ?>
                            <li class="menu_assign_class <?php echo e(request()->routeIs('deposit.create') ? ' treeMenuActive' : ''); ?>" data-menu__cid="irp_10"><a
                                    href="<?php echo e(route('deposit.create')); ?>"><?php echo app('translator')->get('index.add_deposit_or_withdraw'); ?></a>
                            </li>
                        <?php endif; ?>
                        <?php if(routePermission('deposit.index')): ?>
                            <li class="menu_assign_class <?php echo e(request()->routeIs('deposit.index') ? ' treeMenuActive' : ''); ?>" data-menu__cid="irp_10"><a
                                    href="<?php echo e(route('deposit.index')); ?>"><?php echo app('translator')->get('index.list_deposit_or_withdraw'); ?></a>
                            </li>
                        <?php endif; ?>
                        <?php if(routePermission('balancesheet')): ?>
                            <li class="menu_assign_class <?php echo e(request()->routeIs('balance-sheet') ? ' treeMenuActive' : ''); ?>" data-menu__cid="irp_10"><a
                                    href="<?php echo e(route('balance-sheet')); ?>"><?php echo app('translator')->get('index.balance_sheet'); ?></a>
                            </li>
                        <?php endif; ?>
                        
                    </ul>
                </li>
            <?php endif; ?>
            <li
                class="parent-menu treeview menu__cidirp_10<?php echo e(request()->is('sale-report*') || request()->is('expense-report*') || request()->is('salary-report*') ? ' menu-open active_sub_menu' : ''); ?>">
                <a href="#">
                    <iconify-icon icon="solar:diagram-down-broken"></iconify-icon>
                    <span class="match_bold"><?php echo app('translator')->get('index.report'); ?></span>
                </a>
                <ul class="treeview-menu">
                    
                        <li class="menu_assign_class <?php echo e(request()->routeIs('report.sales') ? ' treeMenuActive' : ''); ?>" data-menu__cid="irp_10"><a href="<?php echo e(route('report.sales')); ?>">Sales Report</a>
                        </li>
                    
                    <li class="menu_assign_class <?php echo e(request()->routeIs('expense-report') ? ' treeMenuActive' : ''); ?>" data-menu__cid="irp_10"><a href="<?php echo e(route('expense-report')); ?>">Expense Report</a></li>
                    <li class="menu_assign_class <?php echo e(request()->routeIs('salary-report') ? ' treeMenuActive' : ''); ?>" data-menu__cid="irp_10"><a href="<?php echo e(route('salary-report')); ?>">Salary Report</a></li>
                </ul>
            </li>
            <?php if(menuPermission('Settings')): ?>
                <li
                    class="parent-menu treeview menu__cidirp_10<?php echo e(request()->is('settings') || request()->is('white-label') || request()->is('taxes') || request()->is('units*') || request()->is('mail-settings') || request()->is('productionstages*') || request()->is('currency*') || request()->is('data-import') ? ' menu-open active_sub_menu' : ''); ?>">
                    <a href="#">
                        <iconify-icon icon="solar:settings-broken"></iconify-icon>
                        <span class="match_bold"><?php echo app('translator')->get('index.settings'); ?></span>
                    </a>
                    <ul class="treeview-menu">
                        <?php if(routePermission('settings')): ?>
                            <li class="menu_assign_class <?php echo e(request()->routeIs('settings') ? ' treeMenuActive' : ''); ?>" data-menu__cid="irp_10"><a
                                    href="<?php echo e(route('settings')); ?>">
                                    <?php echo app('translator')->get('index.company_profile'); ?>
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if(routePermission('taxes')): ?>
                            <li class="menu_assign_class <?php echo e(request()->routeIs('taxes') ? ' treeMenuActive' : ''); ?>" data-menu__cid="irp_10"><a
                                    href="<?php echo e(route('taxes')); ?>"><?php echo app('translator')->get('index.tax_settings'); ?></a>
                            </li>
                        <?php endif; ?>
                        <?php if(isWhiteLabelChangeAble()): ?>
                            <?php if(routePermission('white-label')): ?>
                                <li class="menu_assign_class <?php echo e(request()->routeIs('white-label') ? ' treeMenuActive' : ''); ?>" data-menu__cid="irp_10"><a
                                        href="<?php echo e(route('white-label')); ?>"><?php echo app('translator')->get('index.white_label'); ?></a>
                                </li>
                            <?php endif; ?>
                        <?php endif; ?>
                        <?php if(routePermission('data-import')): ?>
                            <li class="menu_assign_class <?php echo e(request()->routeIs('data-import') ? ' treeMenuActive' : ''); ?>" data-menu__cid="irp_10"><a
                                    href="<?php echo e(route('data-import')); ?>"><?php echo app('translator')->get('index.data_import'); ?></a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </li>
            <?php endif; ?>
            <div class="ps__rail-x">
                <div class="ps__thumb-x" tabindex="0"></div>
            </div>
            <div class="ps__rail-y">
                <div class="ps__thumb-y" tabindex="0"></div>
            </div>
        </ul>
    </div>
</section>
<?php /**PATH C:\xampp\htdocs\danish\resources\views/layouts/sidebar.blade.php ENDPATH**/ ?>