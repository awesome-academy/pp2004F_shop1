<script src="{{ asset('vendor/jquery/dist/jquery.min.js') }}"></script>
<script src="{{ asset('vendor/bootstrap/dist/js/bootstrap.min.js') }}"></script>
{{-- 
<script src="{{ asset('vendor/raphael/raphael.min.js') }}"></script>
<script src="{{ asset('vendor/morris.js/morris.min.js') }}"></script>
<script src="{{ asset('vendor/jquery-sparkline/dist/jquery.sparkline.min.js') }}"></script>
<script src="{{ asset('vendor/jvectormap/jquery-jvectormap-1.2.2.min.js') }}"></script>
<script src="{{ asset('vendor/jvectormap/jquery-jvectormap-world-mill-en.js') }}"></script>
<script src="{{ asset('vendor/jquery-knob/dist/jquery.knob.min.js') }}"></script>
<script src="{{ asset('vendor/moment/min/moment.min.js') }}"></script>
<script src="{{ asset('vendor/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
<script src="{{ asset('vendor/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('vendor/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js') }}"></script> 
--}}
<script src="{{ asset('vendor/jquery-slimscroll/jquery.slimscroll.min.js') }}"></script>
<script src="{{ asset('vendor/fastclick/lib/fastclick.js') }}"></script>
@stack('lib-js')

{{-- Admin  --}}
<script src="{{ asset('_admin/js/admin.js')}}"></script>
<script src="{{ asset('_admin/js/demo.js') }}"></script>

@stack('js')