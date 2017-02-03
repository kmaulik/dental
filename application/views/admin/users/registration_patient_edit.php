<script type="text/javascript" src="<?=DEFAULT_ADMIN_JS_PATH?>pages/form_inputs.js"></script>
<script type="text/javascript" src="<?=DEFAULT_ADMIN_JS_PATH?>plugins/forms/selects/select2.min.js"></script>
<script type="text/javascript" src="<?=DEFAULT_ADMIN_JS_PATH?>plugins/pickers/anytime.min.js"></script>

<div class="page-header page-header-default">
    <div class="page-header-content">
        <div class="page-title">
            <h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Admin</span> - Patient</h4>
        </div>
    </div>
    <div class="breadcrumb-line">
        <ul class="breadcrumb">
            <li><a href="<?php echo site_url('admin/dashboard'); ?>"><i class="icon-home2 position-left"></i> Admin </a></li>
            <li><a href="<?php echo site_url('admin/patient'); ?>">Patient </a></li>
            <li class="active">Edit</li>
        </ul>
    </div>
</div>

<div class="content">
    <div class="row">
        <div class="col-md-12">
            <form class="form-horizontal form-validate" id="frmpatient" method="POST">
                <div class="panel panel-flat">
                    <div class="panel-body">
                        <div class="form-group">
                            <label class="col-lg-3 control-label">First Name:</label>
                            <div class="col-lg-3">
                                <input type="text" name="fname" class="form-control" placeholder="First Name" value="<?php echo $patient_data['fname']; ?>" >
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-lg-3 control-label">Last Name:</label>
                            <div class="col-lg-3">
                                <input type="text" name="lname" class="form-control" placeholder="Last Name" value="<?php echo $patient_data['lname']; ?>" >
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-lg-3 control-label">Email:</label>
                            <div class="col-lg-3">
                                <input type="email" name="email_id" id="email_id" class="form-control" placeholder="Email" value="<?php echo $patient_data['email_id']; ?>" >
                            </div>
                        </div>                     

                        <div class="form-group">
                            <label class="col-lg-3 control-label">Address:</label>
                            <div class="col-lg-3">
                                <textarea rows="4" name="address" class="form-control" placeholder="Your Address"><?php echo $patient_data['address']; ?></textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-lg-3 control-label">Street:</label>
                            <div class="col-lg-3">   
                                <input type="text" name="street" class="form-control" value="<?php echo $patient_data['street']; ?>" placeholder="Street name">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-lg-3 control-label">City:</label>
                            <div class="col-lg-3">
                                <input type="text" name="city" class="form-control" placeholder="City" value="<?php echo $patient_data['city']; ?>" >
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-lg-3 control-label">Country:</label>
                            <div class="col-lg-3">
                                <select name="country_id" class="form-control select2" id="country_id" disabled>
                                        <option value="" selected disabled>Select Country</option>
                                        <?php foreach($country_list as $country) : ?>
                                        <option value="<?=$country['id']?>"><?=$country['name']?></option>
                                    <?php endforeach; ?>
                                </select>   
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-lg-3 control-label">State:</label>
                            <div class="col-lg-3">
                                <select name="state_id" class="form-control select2" id="state_id">
                                        <option value="" selected>Select State</option>
                                        <?php foreach($state_list as $state) : ?>
                                        <option value="<?=$state['id']?>"><?=$state['name']?></option>
                                    <?php endforeach; ?>
                                </select>   
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-lg-3 control-label">Zipcode:</label>
                            <div class="col-lg-3">
                                <input type="text" name="zipcode" id="zipcode" class="form-control" onblur="check_zipcode()" 
                                      placeholder="Zip code" value="<?php echo $patient_data['zipcode']; ?>">
                                <span id="zipcode_error">
                                    
                                </span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-lg-3 control-label">Gender:</label>
                            <div class="col-lg-3">
                                <select name="gender" class="form-control select" id="gender">                         
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>                          
                                </select>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="col-lg-3 control-label">Phone:</label>
                            <div class="col-lg-3">
                                <input type="text" name="phone" minlength="6" class="form-control" placeholder="Phone" value="<?php echo $patient_data['phone']; ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-lg-3 control-label">Birth Date:</label>
                            <div class="col-lg-3">
                                <input type="text" name="birth_date" class="form-control" id="anytime-date" placeholder="Birth Date" 
                                       value="<?php echo $patient_data['birth_date']; ?>">
                            </div>
                        </div>

                        <div class="text-right">                            
                            <input type="hidden" name="longitude" id="longitude" value="<?php echo $patient_data['longitude']; ?>">
                            <input type="hidden" name="latitude" id="latitude" value="<?php echo $patient_data['latitude']; ?>">
                            <button class="btn btn-success" type="submit">Save <i class="icon-arrow-right14 position-right"></i></button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>


<script type="text/javascript">
    
    
    $(function() {
        // v! Simple Select and Live search select box
        
        $('.select2').select2();

        // Fixed width. Single select
        $('.select').select2({
            minimumResultsForSearch: Infinity,
            width: 250            
        });

        $("#anytime-date").AnyTime_picker({
            format: "%Y-%m-%d",
            firstDOW: 1
        });


    });
    

    function check_zipcode(){    
        $(".valid-zip").remove();
        var zipcode = $('#zipcode').val();
        if(zipcode != ''){
            $.ajax({
               url : "http://maps.googleapis.com/maps/api/geocode/json?components=postal_code:"+zipcode+"&sensor=false",
               method: "POST",
               success:function(data){
                   if(data.status != 'OK'){
                        $("#zipcode_error").html('<label id="zipcode-error" class="validation-error-label" for="zipcode">Zipcode is invalid.</label>');
                   }else{
                        latitude = data.results[0].geometry.location.lat;
                        longitude= data.results[0].geometry.location.lng;
                        $("#latitude").val(latitude);
                        $("#longitude").val(longitude);
                   }                
               }
            }); 
        }
     }

    function zip_validate(){
        var longitude = $('#longitude').val();
        var latitude = $('#latitude').val();
        if(longitude == '' || latitude == ''){
            return false;
        }else{
            return true;
        }
    }

    // fname ,lname
    // city country_id zipcode gender
    //---------------------- Validation -------------------
    $("#frmpatient").validate({
        errorClass: 'validation-error-label',
        successClass: 'validation-valid-label',
        highlight: function(element, errorClass) {
            $(element).removeClass(errorClass);            
        },
        unhighlight: function(element, errorClass) {
            $(element).removeClass(errorClass);            
        },
        validClass: "validation-valid-label",
        errorPlacement: function (error, element) {
            if (element[0]['id'] == "country_id") {
                error.insertAfter(element.next('span'));  // select2
            } 
            else if (element[0]['id'] == "state_id") {
                error.insertAfter(element.next('span'));  // select2
            }
            else {
                error.insertAfter(element)
            }
        },
        ignore:[],
        rules: {
            fname: {required: true },
            lname: {required: true },
            email_id:{
                required: true,
                remote:{
                    url:"<?php echo base_url().'admin/users/check_unique'; ?>",
                    type:"POST",
                    data:{email_id:function () {return $("#email_id").val();},old_email_id:function(){ return '<?php echo $patient_data["email_id"]; ?>'; }}
                }
            },            
            address:{required: true },
            street:{required: true },
            city:{required: true },
            country_id:{required: true },
            street:{required: true },
            state_id:{required: true },
            zipcode:{required: true },
            phone:{required: true,maxlength: 15 },
            birth_date:{required: true}
        },        
        messages: {
            email_id: {
                remote:"Email must be unique."
            }            
        }
    });
    
    $("#country_id").val("<?php echo $patient_data['country_id']; ?>");
    $("#state_id").val("<?php echo $patient_data['state_id']; ?>");   
    $("#gender").val("<?php echo $patient_data['gender']; ?>");

</script>