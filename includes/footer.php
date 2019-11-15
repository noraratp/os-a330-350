    </div><!--/. container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
<!-- Control sidebar content goes here -->
</aside>


<footer class="main-footer">
    <div class="float-right d-none d-sm-inline-block">
    <?include("function/version.php")?>
    </div>
</footer>
</div>

<!-- Loading Modal !-->
<div class="wrap" id="loading_panel" style="z-index:999999">
    <div class="loading">
        <div class="bounceball"></div>
        <div class="text">กำลังค้นหาข้อมูล โปรดรอสักครู่</div>
    </div>
</div>
<!-- Modal HTML -->
<div class="modal fade" id="modalSuccess" tabindex="-1" role="dialog" aria-labelledby="modalSuccess" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success" style='color:white'>
                บันทึกข้อมูลสำเร็จ
            </div>
            <div class="modal-body text-center">
                <h3 style="color:green" id="txtSuccessMessage">บันทึกข้อมูลสำเร็จ</h3>
            </div>
            <div class="modal-footer">
                <!-- <button type="button" class="btn btn-success" onclick="document.location.reload(true)">OK</button> -->
                <button type="button" class="btn btn-success" data-dismiss="modal">OK</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modalError" tabindex="-1" role="dialog" aria-labelledby="modalError" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger" style='color:white'>
                เกิดข้อผิดพลาด
            </div>
            <div class="modal-body text-center">
                <h3 style="color:red" id='txtErrorMessage'>เกิดข้อผิดพลาด</h3>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" data-dismiss="modal">OK</button>
            </div>
        </div>
    </div>
</div>


<!-- REQUIRED SCRIPTS -->
<!-- jQuery -->
<script src="includes/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="includes/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- overlayScrollbars -->
<script src="includes/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="includes/dist/js/adminlte.js"></script>
<script src="includes/dist/js/angularjs.js"></script>
<script src="includes/dist/js/site.js"></script>

<!-- OPTIONAL SCRIPTS -->
<script src="includes/dist/js/demo.js"></script>

<!-- PAGE PLUGINS -->
<!-- jQuery Mapael -->
<script src="includes/plugins/jquery-mousewheel/jquery.mousewheel.js"></script>
<script src="includes/plugins/raphael/raphael.min.js"></script>
<script src="includes/plugins/jquery-mapael/jquery.mapael.min.js"></script>
<script src="includes/plugins/jquery-mapael/maps/usa_states.min.js"></script>

<!-- ChartJS -->
<!-- <script src="includes/plugins/chart.js/Chart.min.js"></script> -->

<!-- PAGE SCRIPTS -->
<!-- <script src="includes/dist/js/pages/dashboard2.js"></script> -->
</body>
</html>
