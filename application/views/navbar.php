
<div class="sidebar" data-active-color="green" data-background-color="white" data-image="<?= base_url() ?>assets/img/sidebar-1.jpg">
    <div class="logo logo-mini">
        <a href="/" class="simple-text text-success">
            Admin
        </a>
    </div>
    <div class="sidebar-wrapper">
        <div class="user">
            <div class="photo">
                <img style="margin-top: 10px;" src="<?= base_url() ?>assets/img/favicon.png" width="30%" />
            </div>
            <div class="info">
                <a data-toggle="collapse" href="#collapseExample" class="collapsed">
                    Florist
                    <b class="caret"></b>
                </a>
                <div class="collapse" id="collapseExample">
                    <ul class="nav">
                        <li>
                            <a href="<?= base_url() ?>Login/changePassword">Change Password</a>
                        </li>
                        <li>
                            <a href="login/logout">Signout</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <ul class="nav">
            <li class="dashboard">
                <a href="<?= base_url() ?>dashboard">
                    <i class="material-icons">dashboard</i>
                    <p>Dashboard</p>
                </a>
            </li>
            <li class="customer">
                <a data-toggle="collapse" href="#formsExamples">
                    <i class="material-icons">supervised_user_circle</i>
                    <p>Customers
                        <b class="caret"></b>
                    </p>
                </a>
                <div class="collapse" id="formsExamples">
                    <ul class="nav">
                        <li class="addCustomer">
                            <a href="<?= base_url() ?>customer">Add Customers</a>
                        </li>
                        <li class="modifyCustomer">
                            <a href="<?= base_url() ?>customer/viewCustomers">Modify Customers</a>
                        </li>
                        <li class="groupingCustomer">
                            <a href="<?= base_url() ?>customer/groupingCustomer">Grouping Customers</a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="product">
                <a data-toggle="collapse" href="#orders">
                    <i class="material-icons">assignment</i>
                    <p>Orders
                        <b class="caret"></b>
                    </p>
                </a>
                <div class="collapse" id="orders">
                    <ul class="nav">
                        <li class="addProduct">
                            <a href="<?= base_url() ?>product">Individual Order</a>
                        </li>
                        <li class="groupProduct">
                            <a href="<?= base_url() ?>product/addProductToGroup">Group Orders</a>
                        </li>
                        <li class="viewProduct">
                            <a href="<?= base_url() ?>product/viewProduct">View Orders</a>
                        </li>

                    </ul>
                </div>
            </li>
            <li class="suppliers">
                <a data-toggle="collapse" href="#Suppliers">
                    <i class="material-icons">shopping_basket</i>
                    <p>Suppliers
                        <b class="caret"></b>
                    </p>
                </a>
                <div class="collapse" id="Suppliers">
                    <ul class="nav">
                        <li class="addSuppliers">
                            <a href="<?= base_url() ?>Supplier">Add Suppliers</a>
                        </li>
                        <li class="viewSuppliers">
                            <a href="<?= base_url() ?>Supplier/viewSupplier">View Suppliers</a>
                        </li>
                        <li class="groupingSupplier">
                            <a href="<?= base_url() ?>Supplier/groupingSupplier">Grouping Supplier</a>
                        </li>
                        <li class="payAdvance">
                            <a href="<?= base_url() ?>Supplier/payAdvance">Supplier Advance</a>
                        </li>
                        <li class="supplierBilling">
                            <a href="<?= base_url() ?>Supplier/supplierBilling">Supplier Billing</a>
                        </li>
                        <li class="supplierGroupBilling">
                            <a href="<?= base_url() ?>product/addProductToSupplierGroup">Supplier Group Billing</a>
                        </li>
                        <li class="viewSupplierBilling">
                            <a href="<?= base_url() ?>Supplier/viewSupplierBilling">View Supplier Orders</a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="rate">
                <a data-toggle="collapse" href="#rate_details">
                    <i class="material-icons">timeline</i>
                    <p>Expenses
                        <b class="caret"></b>
                    </p>
                </a>
                <div class="collapse" id="rate_details">
                    <ul class="nav">
                        <li class="addExpenses">
                            <a href="<?= base_url() ?>Supplier/addPriceList">Supplier Add Price's</a>
                        </li>
                        <li class="viewExpenses">
                            <a href="<?= base_url() ?>Supplier/viewPriceList">View Supplier Price's</a>
                        </li>
                        <li class="editExpenses">
                            <a href="<?= base_url() ?>Supplier/modifyPriceList">Edit Supplier Price's</a>
                        </li>
                        <li class="caddExpenses">
                            <a href="<?= base_url() ?>Customer/addPriceList">Customer Add Price's </a>
                        </li>
                        <li class="cviewExpenses">
                            <a href="<?= base_url() ?>Customer/viewPriceList">Customer Price's</a>
                        </li>
                        <li class="ceditExpenses">
                            <a href="<?= base_url() ?>Customer/modifyPriceList">Edit Customer Price's</a>
                        </li>
                        <!--<li class="addedPrices">-->
                        <!--    <a href="<?= base_url() ?>welcome/calenderView">View Added Price's</a>-->
                        <!--</li>-->
                    </ul>
                </div>
            </li>
            
            <li class="Billing">
                <a data-toggle="collapse" href="#billing">
                    <i class="material-icons">attach_money</i>
                    <p>Billing
                        <b class="caret"></b>
                    </p>
                </a>
                <div class="collapse" id="billing">
                    <ul class="nav">
                        <li class="ViewBilling">
                            <a href="<?= base_url() ?>product/viewCustomerBillingReport">Customer Billing Report</a>
                        </li>
                        <li class="SViewBilling">
                            <a href="<?= base_url() ?>product/viewSupplierBillingReport">Supplier Billing Report</a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="Password">
                <a data-toggle="collapse" href="#password">
                    <i class="material-icons">settings</i>
                    <p>Settings
                        <b class="caret"></b>
                    </p>
                </a>
                <div class="collapse" id="password">
                    <ul class="nav">
                        <li class="changePassword">
                            <a href="<?= base_url() ?>Login/changePassword">Change Password</a>
                        </li>
                        <li class="messageService">
                            <a href="<?= base_url() ?>welcome/messageServices">Message Settings</a>
                        </li>
                    </ul>
                </div>
            </li>
        </ul>
    </div>
</div>
