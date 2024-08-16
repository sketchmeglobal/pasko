<?php echo view ('common/top_header_backdesk.php') ?>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
</head>
<?php   

//print_r($rules);

?>


<body>
    <div class="container-scroller">
        <div class="container-fluid page-body-wrapper full-page-wrapper">
            <div class="content-wrapper d-flex align-items-center auth">
                <div class="row flex-grow">
                    <div class="col-lg-4 mx-auto">
                        <div class="auth-form-light text-left p-4">
                            <div class="brand-logo">
                                <img style="width:60px !important;" width="60"
                                    src="https://sketchmeglobal.com/assets/img/smg_logo.png">
                            </div>
                            <h4>New here?</h4>
                            <h6 class="font-weight-light">Signing up is easy. It only takes a few steps</h6>
                            <!-- < ?php if (!empty(session()->getFlashdata('fail'))) : ?>
                                <div class="alert alert-danger">< ?= session()->getFlashdata('fail');  ?></div>
                                < ?php endif  ?>

                                < ?php
                                $attributes = ['class' => 'form-horizontal', 'id' => 'loginForm'];
                                echo form_open('login', $attributes);
                                ?> -->
                            <?php
                            if(isset($validation)){
                                print_r($validation->listErrors());
                            }
                            ?>
                            <!-- < ?=service('Validation')->listErrors() ?> -->
                            <form id="registration_Form" class="pt-3" action="" method="post">
                                <div class="row">
                                    <div class="form-group">
                                        <input type="text" class="form-control form-control-lg" id="full_name"
                                            name="full_name" placeholder="Fullname" required>
                                        <!-- < ?=validation_show_error('first_name')?> -->
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-lg" id="username"
                                                name="username" placeholder="Username" required>
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-12">

                                        <div class="form-group">
                                            <!-- minlength="8" maxlength="10" -->
                                            <input type="password" class="form-control form-control-lg" id="password"
                                                name="password" placeholder="Password" required>
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <input type="email" class="form-control form-control-lg" id="email"
                                                name="email" placeholder="Email" required>
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <!-- pattern="[0–9]{14}" -->
                                            <input type="text" class="form-control form-control-lg" id="phone"
                                                name="phone" placeholder="Phone" required>
                                        </div>

                                    </div>


                                    <div class="form-group">

                                        <textarea id="user_address" name="user_address"
                                            class="form-control form-control-lg" rows="4" cols="50"
                                            placeholder="User Address..."></textarea>
                                        <!-- < ?=validation_show_error('user_address')?> -->
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <input pattern="[0-9]{7}" maxlength="7" type="number"
                                                class="form-control form-control-lg" id="user_pin" name="user_pin"
                                                placeholder="User PIN" required>
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <select class="form-select form-select-lg" id="state" name="state">
                                                <?php foreach($master_state as $ms){ ?>
                                                <option value="<?= $ms->id ?>">
                                                    <?=$ms->state_name ?>
                                                </option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>

                                </div>
                                <div class="mb-4">
                                    <div class="form-check">
                                        <label class="form-check-label text-muted">
                                            <input type="checkbox" class="form-check-input"> I agree to all Terms &
                                            Conditions </label>
                                    </div>
                                </div>
                                <div class="mt-3 d-grid gap-2">
                                    <input
                                        class="btn btn-block btn-gradient-primary btn-lg font-weight-medium auth-form-btn"
                                        type="submit" name="submit" value="SIGN UP">
                                </div>
                                <div class="text-center mt-4 font-weight-light"> Already have an account? <a
                                        href="login.html" class="text-primary">Login</a>
                                </div>
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
    <!-- plugins:js -->

    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>
    <script>
    $("#registration_Form").validate({
        rules: {
            password: {
                required: true,
                //pwcheck: true,
                minlength: 8
            }
        },
        messages: {
            password: {
                pwcheck: "Password must contain one capital letter,one numerical and one special character"
            }
        }
    });
    // jQuery.validator.addMethod("pwcheck", function(value, element) {
    //     if (/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z]{8,}$/.test(value)) {
    //         return true;
    //     } else {
    //         return false;
    //     }
    // }, "Please enter valid Password");
    </script>
    <?php echo view ('common/footer_backdesk.php') ?>
    <!-- endinject -->
    <script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>
    <script>
    CKEDITOR.replace('user_address');
    </script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
    $(document).ready(function() {
        $('#state').select2();
    });
    </script>
</body>

</html>