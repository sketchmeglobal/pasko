    
    <script src="<?= base_url('assets/backdesk/js/vendor.bundle.base.js') ?>"></script>
    <script src="<?= base_url('assets/backdesk/js/off-canvas.js') ?>"></script>
    <script src="<?= base_url('assets/backdesk/js/hoverable-collapse.js') ?>"></script>
    <script src="<?= base_url('assets/backdesk/js/misc.js') ?>"></script>
    <script src="<?= base_url('assets/backdesk/js/settings.js') ?>"></script>
    <script src="<?= base_url('assets/backdesk/js/todolist.js') ?>"></script>
    <script src="<?= base_url('assets/backdesk/js/jquery.cookie.js') ?>"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.20.0/jquery.validate.min.js" integrity="sha512-WMEKGZ7L5LWgaPeJtw9MBM4i5w5OSBlSjTjCtSnvFJGSVD26gE5+Td12qN5pvWXhuWaWcVwF++F7aqu9cvqP0A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js" integrity="sha512-YUkaLm+KJ5lQXDBdqBqk7EVhJAdxRnVdT2vtCzwPHSweCzyMgYV/tgGF4/dCyqtCC2eCphz0lRQgatGVdfR0ww==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  
    <!--alert-->
    <script>
        (function($) {
          showSwal = function(type) {
            'use strict';
            if (type === 'basic') {
              swal({
                text: 'Any fool can use a computer',
                button: {
                  text: "OK",
                  value: true,
                  visible: true,
                  className: "btn btn-primary"
                }
              })
        
            } else if (type === 'title-and-text') {
              swal({
                title: 'Read the alert!',
                text: 'Click OK to close this alert',
                button: {
                  text: "OK",
                  value: true,
                  visible: true,
                  className: "btn btn-primary"
                }
              })
        
            } else if (type === 'success-message') {
              swal({
                title: 'Congratulations!',
                text: 'You entered the correct answer',
                icon: 'success',
                button: {
                  text: "Continue",
                  value: true,
                  visible: true,
                  className: "btn btn-primary"
                }
              })
        
            } else if (type === 'auto-close') {
              swal({
                title: 'Auto close alert!',
                text: 'I will close in 2 seconds.',
                timer: 2000,
                button: false
              }).then(
                function() {},
                // handling the promise rejection
                function(dismiss) {
                  if (dismiss === 'timer') {
                    console.log('I was closed by the timer')
                  }
                }
              )
            } else if (type === 'warning-message-and-cancel') {
              swal({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3f51b5',
                cancelButtonColor: '#ff4081',
                confirmButtonText: 'Great ',
                buttons: {
                  cancel: {
                    text: "Cancel",
                    value: null,
                    visible: true,
                    className: "btn btn-danger",
                    closeModal: true,
                  },
                  confirm: {
                    text: "OK",
                    value: true,
                    visible: true,
                    className: "btn btn-primary",
                    closeModal: true
                  }
                }
              })
        
            } else if (type === 'custom-html') {
              swal({
                content: {
                  element: "input",
                  attributes: {
                    placeholder: "Type your password",
                    type: "password",
                    class: 'form-control'
                  },
                },
                button: {
                  text: "OK",
                  value: true,
                  visible: true,
                  className: "btn btn-primary"
                }
              })
            }
  }
        })(jQuery);
    </script>
    <!--toaster-->
   <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.2/jquery.toast.min.js" integrity="sha512-zlWWyZq71UMApAjih4WkaRpikgY9Bz1oXIW5G0fED4vk14JjGlQ1UmkGM392jEULP8jbNMiwLWdM8Z87Hu88Fw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
   <script>
        function toast($type,$msg){
            // alert($type)
            $.toast({
              heading: ($type == 'danger') ? 'Oops!' : 'Great!',
              text: $msg,
              showHideTransition: 'slide',
              icon: ($type == 'danger') ? 'error' : 'success',
              loaderBg: '#57c7d4',
              position: 'top-right'
            })   
        }
    </script>