 <!-- jQuery -->
 <script src="{{ asset('frontend/plugins/jquery/jquery.min.js') }}"></script>
 <!-- Bootstrap -->
 <script src="{{ asset('frontend/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
 <!-- datatable -->
 <script src="{{ asset('frontend/plugins/datatables/jquery.dataTables.min.js') }}"></script>
 <script src="{{ asset('frontend/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
 <script src="{{ asset('frontend/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
 <script src="{{ asset('frontend/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
 <script src="{{ asset('frontend/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
 <script src="{{ asset('frontend/plugins/select2/js/select2.full.min.js') }}"></script>
 <script src="{{ asset('frontend/plugins/bootstrap-switch/js/bootstrap-switch.min.js') }}"></script>
 <!-- overlayScrollbars -->
 <script src="{{ asset('frontend/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
 <!-- AdminLTE App -->
 <script src="{{ asset('frontend/js/adminlte.js') }}"></script>
 <script>
     var url = "{{ url('') }}"
 </script>

 <!-- PAGE PLUGINS -->
 <!-- jQuery Mapael -->
 <script src="{{ asset('frontend/plugins/jquery-mousewheel/jquery.mousewheel.js') }}"></script>
 <script src="{{ asset('frontend/plugins/raphael/raphael.min.js') }}"></script>
 <script src="{{ asset('frontend/plugins/jquery-mapael/jquery.mapael.min.js') }}"></script>
 <script src="{{ asset('frontend/plugins/jquery-mapael/maps/usa_states.min.js') }}"></script>
 <!-- ChartJS -->
 <script src="{{ asset('frontend/plugins/chart.js/Chart.min.js') }}"></script>

 <script src="{{ asset('frontend/plugins/toastr/toastr.min.js') }}"></script>
 <script src="{{ asset('frontend/plugins/sweetalert2/sweetalert2.all.min.js') }}"></script>
 <!-- <script src="{{ asset('dist/js/auth/view.js?q=') . time() }}"></script> -->
 <script>
     $(document).ready(function() {
         $("#formLogout").submit(function(e) {
             e.preventDefault();

             var form = $(this);
             var formData = new FormData(form[0]);

             if (confirm("Are you sure to logout?")) {
                 $.ajax({
                     url: url + "/logout",
                     type: "POST",
                     data: formData,
                     processData: false,
                     contentType: false,
                     success: function(responses) {
                         toastr.success("success!");
                         setTimeout(() => {
                             window.location = responses.data;
                         }, 2500);
                     },
                     error: function(response) {},
                 });
             }
         });
         // Check the theme from localStorage
         if (localStorage.getItem('theme') === 'light') {
             $('#nav-theme').removeClass('navbar-dark');
             $('#sidebar-theme').removeClass('sidebar-dark-primary');
             $('#body-theme').removeClass('dark-mode');
             //change to light
             $('#nav-theme').addClass('navbar-light');
             $('#sidebar-theme').addClass('sidebar-light-primary');
             $('#body-theme').addClass('bg-light');
             $('#name-theme').removeClass('fa fa-star text-secondary');
             $('#name-theme').addClass('fa fa-star text-primary');
             $('#name-theme').html('light');
             $('#theme-change').prop('checked', true);
         } else {
             //add dark
             $('#nav-theme').addClass('navbar-dark');
             $('#sidebar-theme').addClass('sidebar-dark-primary');
             $('#body-theme').addClass('dark-mode');
             //remove to light
             $('#nav-theme').removeClass('navbar-light');
             $('#sidebar-theme').removeClass('sidebar-light-primary');
             $('#body-theme').removeClass('bg-light');
             $('#name-theme').removeClass('fa fa-star text-primary');
             $('#name-theme').addClass('fa fa-star text-secondary');
             $('#name-theme').html('dark');
             $('#theme-change').prop('checked', false);
         }
         //  $('#name-theme').addClass('fa fa-star text-primary');
         $("#theme-change").on('click', function() {
             if ($("#theme-change").is(":checked")) {
                 //remove dark
                 $('#nav-theme').removeClass('navbar-dark');
                 $('#sidebar-theme').removeClass('sidebar-dark-primary');
                 $('#body-theme').removeClass('dark-mode');
                 //change to light
                 $('#nav-theme').addClass('navbar-light');
                 $('#sidebar-theme').addClass('sidebar-light-primary');
                 $('#body-theme').addClass('bg-light');
                 $('#name-theme').removeClass('fa fa-star text-secondary');
                 $('#name-theme').addClass('fa fa-star text-primary');
                 $('#name-theme').html('light');
                 localStorage.setItem('theme', 'light');
             } else {
                 //add dark
                 $('#nav-theme').addClass('navbar-dark');
                 $('#sidebar-theme').addClass('sidebar-dark-primary');
                 $('#body-theme').addClass('dark-mode');
                 //remove to light
                 $('#nav-theme').removeClass('navbar-light');
                 $('#sidebar-theme').removeClass('sidebar-light-primary');
                 $('#body-theme').removeClass('bg-light');
                 $('#name-theme').removeClass('fa fa-star text-primary');
                 $('#name-theme').addClass('fa fa-star text-secondary');
                 $('#name-theme').html('dark');
                 localStorage.setItem('theme', 'dark');
             }
         });
     });
 </script>
