<br>
<br>
<div class="row">
  <div class="webview-form col-12 d-flex justify-content-center">
    <div class="col-12 col-sm-12 col-md-8 col-lg-6 col-lg-6">
      <div class="card">
        <form id="webview-form">
          <div class="card-header">
            <h4><?php echo $this->lang->line('What is your Location?'); ?></h4>
          </div>

          <input type="hidden" name="subscriber_id" value="<?php echo $subscriber_id; ?>">

          <div class="card-body">
            <!-- renders form -->

            <div class="form-group">
              <label><?php echo $this->lang->line('Street Address'); ?> * </label><input required name="street" type="text" class="form-control" placeholder=""/>
            </div>

            <div class="form-group">
              <label><?php echo $this->lang->line('State'); ?> *</label><input required name="state" type="text" class="form-control" placeholder=""/>
            </div>

            <div class="form-group">
              <label><?php echo $this->lang->line('City'); ?> *</label><input required name="city" type="text" class="form-control" placeholder=""/>
            </div>

            <div class="form-group">
              <label><?php echo $this->lang->line('Country'); ?> *</label>
              <?php 
              echo '<select name="country" required="" class="form-control select2">';
               echo '<option value="">'.$this->lang->line("Select Country").'</option>';
              foreach ($country_list as $key => $value)
              {
                 echo '<option value="'.$key.'">'.ucwords(strtolower($value)).'</option>';
              }
              echo "</select>";
              ?>
              <?php //echo form_dropdown('country', $country_list,'','required class="form-control"'); ?>
            </div>

            <div class="form-group">
              <label><?php echo $this->lang->line('Zip'); ?> *</label><input required name="zip" type="text" class="form-control" placeholder=""/>
            </div>            

            <div class="form-group text-left"><button id="webview_submit_button" type="submit" class="btn-primary btn"><i class="fas fa-paper-plane"></i> <?php echo $this->lang->line('Submit'); ?></button></div> 
            

          </div>
        </form>
      </div>
    </div>
  </div>  
</div>

<script>
  $(document).ready(function() {

    var base_url = "<?php echo base_url(); ?>";

//PSID variable comes from bare-them.php file. 

    $("form").on('submit',function(event){
      event.preventDefault();

      if( $("input[name='zip']").val()=='')
      {
        swal('<?php echo $this->lang->line("Error"); ?>', '<?php echo $this->lang->line("Please Enter your Email."); ?>', 'error');
        return false;
      }

     var psid_from_url=$("input[name='subscriber_id']").val();
     if(psid_from_url=='')
        $("input[name='subscriber_id']").val(PSID);


      $("#webview_submit_button").attr('disabled',true);

      var form_data = $(this).serialize();
      $.ajax({
         url:base_url+"webview_builder/location_submit",
         method:"POST",
         data:form_data,
         dataType:'JSON',
         success:function(response)
          {
            $("#webview_submit_button").removeAttr('disabled');
              if(response.error=='1'){
              swal('<?php echo $this->lang->line("Error"); ?>', response.error_message, 'error');
            }
            else{

              if(PSID === undefined) swal('<?php echo $this->lang->line("Success"); ?>', '<?php echo $this->lang->line("Submitted Successfully"); ?>', 'success');
            }

            MessengerExtensions.requestCloseBrowser(function success() {
           
            }, function error(err) {
              
            });



          }            

      });

    });
  });
</script>

