@extends('includes.master')
@section('content')
    <!-- Main row -->
    <div class="row">
        <div class="col-md-12">
            <div class="card card-default">
                <div class="card-header">
                    <h3 class="card-title">الرئيسية</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">

                </div>

            </div>
        </div>
        <!-- /.row (main row) -->
    @stop
    @section('scripts')
        <!-- Select2 -->
            <script src="{{ asset('assets/admin-lte/plugins/select2/js/select2.full.min.js')}}"></script>
            <script src="{{ asset('assets/admin-lte/plugins/chart.js/Chart.min.js')}}"></script>

            <script>
                $(function () {
                    //Initialize Select2 Elements
                    $('.select2').select2({
                        theme: 'bootstrap4'
                    });


                })

            </script>
        @stop
        @section('styles')
            <link rel="stylesheet" href="{{ asset('assets/admin-lte/plugins/select2/css/select2.min.css')}}">
            <link rel="stylesheet"
                  href="{{ asset('assets/admin-lte/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
@stop
