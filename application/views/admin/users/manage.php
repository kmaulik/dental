<script type="text/javascript" src="<?=DEFAULT_ADMIN_JS_PATH?>pages/form_inputs.js"></script>
<script type="text/javascript" src="<?=DEFAULT_ADMIN_JS_PATH?>plugins/forms/selects/select2.min.js"></script>
<script type="text/javascript" src="<?=DEFAULT_ADMIN_JS_PATH?>plugins/pickers/anytime.min.js"></script>

<style>                                  
.valid-zip{
    margin-top: 7px;
    margin-bottom: 7px;
    display: block;
    color: #F44336;
    position: relative;
}
</style>
<div class="page-header page-header-default">
    <div class="page-header-content">
        <div class="page-title">
            <h4><i class="icon-user"></i> <span class="text-semibold"><?php echo $heading; ?></span></h4>
        </div>
    </div>
    <div class="breadcrumb-line">
        <ul class="breadcrumb">
            <li><a href="<?php echo site_url('admin/dashboard'); ?>"><i class="icon-home2 position-left"></i> Admin</a></li>
            <li><a href="<?php echo site_url('admin/users'); ?>"> Sub User</a></li>
            <li class="active"><?php echo $heading; ?></li>
        </ul>
    </div>
</div>

<div class="content">
    <div class="row">
        <div class="col-md-12">
            <form class="form-horizontal form-validate" id="frmsubadmin" method="POST" enctype="multipart/form-data" onsubmit="return zip_validate()">
                <div class="panel panel-flat">
                    <div class="panel-body">
                         <div class="form-group">
                            <label class="col-lg-3 control-label">User Role List:</label>
                            <div class="col-lg-3">
                                <select name="role_id" class="form-control" id="role_id">
                                    <option value="">Select User Role</option>
                                    <option value="2">Sub Admin</option>
                                    <option value="3">Agent</option>
                                </select>    
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label">First Name:</label>
                            <div class="col-lg-3">
                                <input type="text" name="fname" class="form-control" placeholder="First Name" value="<?php echo isset($user_data['fname'])?$user_data['fname']:''; ?>" >
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-lg-3 control-label">Last Name:</label>
                            <div class="col-lg-3">
                                <input type="text" name="lname" class="form-control" placeholder="Last Name" value="<?php echo isset($user_data['lname'])?$user_data['lname']:''; ?>" >
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-lg-3 control-label">Email:</label>
                            <div class="col-lg-3">
                                <input type="email" name="email_id" id="email_id" class="form-control" placeholder="Email" value="<?php echo isset($user_data['email_id'])?$user_data['email_id']:''; ?>" >
                            </div>
                        </div>                     

                       <!--  <div class="form-group">
                            <label class="col-lg-3 control-label">Address:</label>
                            <div class="col-lg-3">
                                <textarea rows="4" name="address" class="form-control" placeholder="Your Address"><?php echo isset($user_data['address'])?$user_data['address']:''; ?></textarea>
                            </div>
                        </div> -->

                         <div class="form-group">
                            <label class="col-lg-3 control-label">Street:</label>
                            <div class="col-lg-3">   
                                <input type="text" name="street" class="form-control" placeholder="Street name" value="<?php echo isset($user_data['street'])?$user_data['street']:''; ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-lg-3 control-label">City:</label>
                            <div class="col-lg-3">
                                <input type="text" name="city" class="form-control" placeholder="City" value="<?php echo isset($user_data['city'])?$user_data['city']:''; ?>" >
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
                                      placeholder="Zip code" value="<?php echo isset($user_data['zipcode'])?$user_data['zipcode']:''; ?>">
                                <span id="zipcode_error"></span>
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
                                <input type="text" name="phone" minlength="6" class="form-control" placeholder="Phone" value="<?php echo isset($user_data['phone'])?$user_data['phone']:''; ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-lg-3 control-label">Birth Date:</label>
                            <div class="col-lg-3">
                                <input type="text" name="birth_date" class="form-control" id="anytime-date" placeholder="Birth Date" 
                                       value="<?php echo isset($user_data['birth_date'])?$user_data['birth_date']:''; ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-lg-3 control-label">Avatar:</label>
                            <div class="col-lg-3">
                                <input type="file" class="file-styled" name="avatar" id="avatar">
                                <input type="hidden" name="H_avatar" value="<?php echo isset($user_data['avatar'])?$user_data['avatar']:''; ?>">
                            </div>
                            <div class="col-lg-3">
                                <img id="img-preview" src="<?php if(isset($user_data['avatar']) && $user_data['avatar'] != '') {
                                    echo base_url('uploads/avatars/'.$user_data['avatar']);
                                } else { echo DEFAULT_IMAGE_PATH.'user/user-img.jpg'; } ?>" style="height:100px;width:100px;"/>
                            </div>    
                        </div>

                        <div class="text-right">                            
                            <input type="hidden" name="longitude" id="longitude" value="<?php echo isset($user_data['longitude'])?$user_data['longitude']:''; ?>">
                            <input type="hidden" name="latitude" id="latitude" value="<?php echo isset($user_data['latitude'])?$user_data['latitude']:''; ?>">
                            <button class="btn btn-success" type="submit">Save <i class="icon-arrow-right14 position-right"></i></button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="<?php echo DEFAULT_ADMIN_JS_PATH ?>plugins/forms/validation/additional_methods.min.js" type="text/javascript"></script>
<script type="text/javascript">

    function readURL(input) {
      if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
          $('#img-preview').attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
      }
    }

    $("input[name='avatar']").change(function(){
        readURL(this);
    });

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
        $("#latitude").val(''); 
        $("#longitude").val('');  
        var zipcode = $('#zipcode').val();
        if(zipcode != ''){
            $.ajax({
               url : "http://maps.googleapis.com/maps/api/geocode/json?components=postal_code:"+zipcode+"&sensor=false",
               method: "POST",
               success:function(data){
                   if(data.status != 'OK'){
                        $("#zipcode_error").html('<label class="valid-zip" for="zipcode">Zipcode is invalid.</label>');
                   }else{
                        $(".valid-zip").remove();
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
        var zipcode = $('#zipcode').val();
        if(zipcode != '' && (longitude == '' || latitude == '')){
             $("#zipcode_error").html('<label class="valid-zip" for="zipcode">Zipcode is invalid.</label>');     
             return false;
        }else{
            $(".valid-zip").remove();
            return true;
        }
    }

    // fname ,lname
    // city country_id zipcode gender
    //---------------------- Validation -------------------
    $("#frmsubadmin").validate({
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
            else if (element[0]['id'] == "avatar") {
                error.insertAfter('.uploader');  // select2
            }
            else {
                error.insertAfter(element)
            }
        },
        ignore:[],
        rules: {
            role_id: {required: true },
            fname: {required: true },
            lname: {required: true },
            email_id:{
                required: true,
                remote:{
                    url:"<?php echo base_url().'admin/users/check_unique'; ?>",
                    type:"POST",
                    data:{email_id:function () {return $("#email_id").val();},old_email_id:function(){ return '<?php echo isset($user_data["email_id"])?$user_data["email_id"]:''; ?>'; }}
                }
            },            
            //address:{required: true },
            street:{required: true },
            city:{required: true },
            country_id:{required: true },
            state_id:{required: true },
            zipcode:{required: true },
            phone:{required: true,maxlength: 15 },
            birth_date:{required: true},
            avatar: {
                 extension: "jpg|jpeg|png|gif"
                }
        },        
        messages: {
            role_id: {required: 'Please Select a User Role' },
            fname: {required: 'Please provide a First Name' },
            lname: {required: 'Please provide a Last Name' },
            email_id: {
                required: 'Please provide a Email Address' ,
                remote:"( Each email address may be used only for one profile.) This Email is already in use, please, use a different address or <a href='<?php echo base_url().'contact_us';?>'> Contact Us </a>"
            }, 
            //address:{required: 'Please provide a Address' },
            street:{required: 'Please provide a Street' },
            city:{required: 'Please Provide a City' },
            country_id:{required: 'Please Select Country' },
            state_id:{required: 'Please Select State' },
            zipcode:{required: 'Please Provide a Zipcode' }, 
            phone:{required: 'Please Provide a Phone' }, 
            birth_date:{required: 'Please Provide a Birthdate' },
            avatar: {
                 extension: "Please Provide Valid Avatar <br/>(Allow .jpg,.jpeg,.png,.gif File)"
                }           
        }
    });
    
    $("#role_id").val("<?php echo isset($user_data['role_id'])?$user_data['role_id']:''; ?>");
    $("#country_id").val("<?php echo isset($user_data['country_id'])?$user_data['country_id']:'231'; ?>");
    $("#state_id").val("<?php echo isset($user_data['state_id'])?$user_data['state_id']:''; ?>");
    $("#gender").val("<?php echo isset($user_data['gender'])?$user_data['gender']:'male'; ?>");

</script>