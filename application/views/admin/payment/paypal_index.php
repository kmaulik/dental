<script type="text/javascript" src="<?php echo DEFAULT_ADMIN_JS_PATH . "plugins/tables/datatables/datatables.min.js"; ?>"></script>
<script type="text/javascript" src="<?php echo DEFAULT_ADMIN_JS_PATH . "plugins/forms/selects/select2.min.js"; ?>"></script>

<style>
.datepicker_filter .input-box{
   padding: 5px;    
}
.datepicker_filter i {
    margin-left: -30px;
    color: #999;
}
.datepicker_filter input{
    margin: 0px 0px 0px 20px;
    outline: 0;
    height: 36px;
    width: 200px;
    padding: 7px 36px 7px 12px;
    font-size: 13px;
    line-height: 1.5384616;
    color: #333;
    background-color: #fff;
    border: 1px solid #ddd;
    border-radius: 3px;
    
}
</style>
<!-- Page header -->
<div class="page-header page-header-default">
    <div class="page-header-content">
        <div class="page-title">
            <h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Admin</span> - Paypal Transaction List</h4>
        </div>
    </div>
    <div class="breadcrumb-line">
        <ul class="breadcrumb">
            <li><a href="<?php echo base_url() . "admin/dashboard" ?>"><i class="icon-home2 position-left"></i> Admin</a></li>
            <li>Paypal Transaction List</li>
        </ul>
    </div>
</div>
<!-- /page header -->


<!-- Content area -->
<div class="content">
    <?php
        $message = $this->session->flashdata('message');
        echo my_flash($message);
    ?>
    <!-- content area -->
    
    <div class="panel panel-flat">

         <!-- For Export Csv Icon -->
        <div class="panel-heading text-right">
            <form action="<?=base_url('admin/payment_transaction/paypal_export_csv')?>" name="export_csv_frm" id="export_csv_frm" method="post">
                <input type="hidden" name="pay_search" id="pay_search">
                <input type="hidden" name="pay_date" id="pay_date">
                <a onclick="export_csv()" class="btn btn-success btn-labeled">
                    <b><i class=" icon-download"></i></b>
                    Export CSV
                </a>
            </form>
        </div>
        <!-- End For Export Csv Icon -->

        <input type="hidden" id="from_date" value="<?php if(isset($this->session->userdata['date_filter']['from_date']) &&  $this->session->userdata['date_filter']['from_date'] != '') { echo $this->session->userdata['date_filter']['from_date']; }?>">
        <input type="hidden" id="to_date" value="<?php if(isset($this->session->userdata['date_filter']['to_date']) &&  $this->session->userdata['date_filter']['to_date'] != '') { echo $this->session->userdata['date_filter']['to_date']; }?>">
        <input type="hidden" id="filter_data" value="<?php if(isset($this->session->userdata['date_filter']['filter_data']) &&  $this->session->userdata['date_filter']['filter_data'] != '') { echo $this->session->userdata['date_filter']['filter_data']; }?>">
        
        <table class="table datatable-basic">
            <thead>
                <tr>
                    <th>ID.</th>
                    <th>Transaction #</th> 
                    <th>Payment Type</th>
                    <th>Role</th> 
                    <th>Payee Name</th>
                    <th>Request Title</th> 
                    <th>Actual Price ($)</th> 
                    <th>Payment Value ($)</th> 
                    <th>Discount (%)</th>                     
                    <th>Created Date</th>                        
                </tr>
            </thead>
        </table>
    </div>
    
</div>
<script>
$(function () {
    var table = $('.datatable-basic').dataTable({
        processing: true,
        serverSide: true,
        language: {
            search: '<span>Filter:</span> _INPUT_',
            lengthMenu: '<span>Show:</span> _MENU_',
            paginate: {'first': 'First', 'last': 'Last', 'next': '&rarr;', 'previous': '&larr;'}
        },
        dom: '<"datatable-header"fl><"datatable-scroll"t><"datatable-footer"ip>',
        order: [[0, "asc"]],
        ordering: false,
        ajax: 'list_paypal_transaction',
        columns: [
        {
            data: "payment_id",
            visible: true
        },
        {
            sortable: false,
            data: "paypal_token",
            visible: true
        },
        {
            sortable: false,
            data: "payment_type",
            visible: true,
            render: function (data, type, full, meta) {
                var action = '';
                if(full.status == 0) {
                    action += '<span class="label label-danger">Paypal</span>';  
                }else{
                    action += '<span class="label label-success">Paypal</span>';  
                }    
                return action;
            }

        },
        {
            sortable: false,
            data: "role_name",
            visible: true
        },
        {
            sortable: false,
            data: "user_name",
            visible: true
        },
        {
            sortable: false,
            data: "rfp_title",
            visible: true,
            render: function (data, type, full, meta) {
                var action = '';
                var rfp_id= encodeURIComponent(btoa(full.rfp_id));
                action += '<a href="<?php echo base_url(); ?>admin/rfp/view/' + rfp_id+'" target="_blank">'+full.rfp_title+'</a>';
                return action;
            }

        },
        {
            sortable: false,
            data: "actual_price",
            visible: true
        },
        {
            sortable: false,
            data: "payable_price",
            visible: true
        },
        {
            sortable: false,
            data: "discount",
            visible: true
        },
        {
            sortable: false,
            data: "created_date",
            visible: true
        },
       
        ]
    });

$('.dataTables_length select').select2({
    minimumResultsForSearch: Infinity,
    width: 'auto'
});


//-------------------------------- For Date Picker ----------------------------------------------
    var form_data ='';
    form_data +=  '<form action="" method="post" id="frm_date_range">';
    form_data +=  '<input type="hidden" name="date_search" value="1">';
    form_data +=  '<input type="hidden" name="filter_search" id="filter_search">';
    form_data +=  '<div class="datepicker_filter">';
    form_data +=  '<input id="date_range" type="text" name="date_filter" class="daterange-basic">';
    form_data +=  '<span class="input-box"><i class="icon-calendar22"></i></span>'; 
    form_data +=  '</div>';
    form_data +=  '</form>';
    $( ".dataTables_filter" ).after(form_data);

    // ---- For Display select date value ----------------
    var filter_date ='';

    if($("#from_date").val() != '' && $("#to_date").val() != ''){
        var filter_date = $("#from_date").val()+" - "+$("#to_date").val();
        var filter_search = $("#filter_data").val();
        $("input[type='search']").val(filter_search);
        $("#date_range").val(filter_date);

        //------------ For Manual Keyup for search ---
        $('#DataTables_Table_0_filter label input[type=search]')
        .val(filter_search)
        .trigger($.Event("keyup", { keyCode: 13 }));
        //------------ End For Manual Keyup for search ---
    }

    //------ For Load Date Range Picker ----------

    $('.daterange-basic').daterangepicker({
            applyClass: 'bg-slate-600',
            cancelClass: 'btn-default',
        }).val(filter_date);

    //------ For change Date ----------
    $("#date_range").change(function(){
       var filter_search = $("input[type='search']").val();
       $("#filter_search").val(filter_search);  
       $("#frm_date_range").submit();
    });

     $(".cancelBtn").click(function(){
        $("input[name=date_search]").val('');
    });


 //------------------------------- End Date Picker ----------------------------------

});

function export_csv(){
    var payment_search = $("#DataTables_Table_0_filter label input[type=search]").val();
    var payment_date = $("#date_range").val();
    $("#pay_search").val(payment_search);
    $("#pay_date").val(payment_date);
    $("#export_csv_frm").submit();
        
}

// Auto hide Flash messages
$('div.alert').delay(4000).slideUp(350);
</script>