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
            <h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Admin</span> - Transaction List</h4>
        </div>
    </div>
    <div class="breadcrumb-line">
        <ul class="breadcrumb">
            <li><a href="<?php echo base_url() . "admin/dashboard" ?>"><i class="icon-home2 position-left"></i> Admin</a></li>
            <li>Transaction List</li>
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
        <input type="hidden" id="from_date" value="<?php if(isset($this->session->userdata['date_filter']['from_date']) &&  $this->session->userdata['date_filter']['from_date'] != '') { echo $this->session->userdata['date_filter']['from_date']; }?>">
        <input type="hidden" id="to_date" value="<?php if(isset($this->session->userdata['date_filter']['to_date']) &&  $this->session->userdata['date_filter']['to_date'] != '') { echo $this->session->userdata['date_filter']['to_date']; }?>">
        <table class="table datatable-basic">
            <thead>
                <tr>
                    <th>ID.</th>
                    <th>Transaction #</th> 
                    <th>Role</th> 
                    <th>Payee Name</th>
                    <th>RFP Title</th> 
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
        ajax: 'payment_transaction/list_transaction',
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
        $("#date_range").val(filter_date);
    }

    //------ For Load Date Range Picker ----------

    $('.daterange-basic').daterangepicker({
            applyClass: 'bg-slate-600',
            cancelClass: 'btn-default',
        }).val(filter_date);

    //------ For change Date ----------
    $("#date_range").change(function(){
       $("#frm_date_range").submit();
    });

     $(".cancelBtn").click(function(){
        $("input[name=date_search]").val('');
    });


 //------------------------------- End Date Picker ----------------------------------

});

// Auto hide Flash messages
$('div.alert').delay(4000).slideUp(350);
</script>