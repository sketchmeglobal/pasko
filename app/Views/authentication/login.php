<?php echo view ('common/top_header_backdesk.php') ?>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
</head>
<?php //print_r($master_state); ?>


<body>
    <div class="container-scroller">
        <div class="container-fluid page-body-wrapper full-page-wrapper">
            <div class="content-wrapper d-flex align-items-center auth">
                <div class="row flex-grow">
                    <div class="col-lg-4 mx-auto">
                        <div class="auth-form-light text-left p-5">
                            <div class="brand-logo text-center">
                                <img style="width: auto" src="<?=base_url()?>assets/backdesk/img/logo.jpeg">
                                <hr>
                                <h5><?=COMPANY_FULL_NAME?></h5>
                                <hr>
                            </div>
                            <h4>Hello! let's get started</h4>
                            <h6 class="font-weight-light">Sign in to continue.</h6>
                            <form id="login_form" action="<?=base_url('login/login_form')?>" method="post" class="pt-3">
                                <?= csrf_field() ?>
                                <div class="form-group">
                                    <input type="text" class="form-control form-control-lg border border-dark" required id="username" name="username" placeholder="Username">
                                </div>
                                <div class="form-group">
                                    <input type="password" class="form-control form-control-lg border border-dark" minlength="8" required id="password" name="password" placeholder="Password">
                                </div>
                                <div class="mt-3 d-grid gap-2">
                                    <button type="submit" class="submit btn btn-block btn-gradient-primary btn-lg font-weight-medium auth-form-btn" value="SIGN IN">SIGN IN</button>
                                </div>
                                <div class="my-2 d-flex justify-content-between align-items-center">
                                    <div class="form-check">
                                        <!--<label class="form-check-label text-muted"><input type="checkbox" class="form-check-input"> Keep me signed in </label>-->
                                    </div>
                                    <!--<a href="#" class="auth-link text-primary">Forgot password?</a>-->
                                    <a href="javascript:void(0)" class="auth-link text-primary" onclick="showSwal('forget-password')">Forget Password!</a>
                                </div>
                                <!--<div class="text-center mt-4 font-weight-light"> Don't have an account? <a-->
                                <!--        href="register.html" class="text-primary">Create</a>-->
                                <!--</div>-->
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- content-wrapper ends -->
        </div>
        <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->

    <?php echo view ('common/footer_backdesk.php') ?>
    <!--validation-->
    <script>
        $("#login_form").validate();
    </script>
    <!--ajxform-->
    <script> 
        $('#login_form').ajaxForm({
            dataType: 'json',           
            success: function(data) {           
                console.log(data);
                if(data.status == 0){
                    toast('danger',data.msg);
                } else{ // success
                    toast('success',data.msg);
                    if(data.code == '011'){
                        // login success. redirect to dashboar
                        window.location = "<?= base_url('dashboard') ?>";
                    }
                }
            }       
        }); 
    </script> 
    <script>
    
        $(document).ready(function(){
            // if not logged-in
            session_val = "<?=session()->getFlashdata('fail')?>"
            if(session_val != ''){
                toast('danger', session_val);
            }
        })
    </script>
    <script>
        (function($) {
          showSwal = function(type) {
            'use strict';
            if (type === 'forget-password') {
              swal({
                content: {
                  element: "input",
                  attributes: {
                    placeholder: "Type your email-ID",
                    type: "email",
                    class: 'form-control'
                  },
                },
                button: {
                  text: "OK",
                  value: true,
                  visible: true,
                  className: "btn btn-primary btn-sm"
                }
              })
            }
  }
        })(jQuery);
    </script>
    
</body>

</html>