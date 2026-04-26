<?php
if (!isset($base)) {
    $base = '/admin';
}
?>
<footer class="main-footer" style="display:block !important; margin-left:250px !important;">
    <div class="float-right d-none d-sm-inline">
        Admin Panel
    </div>
    <strong>&copy; <?php echo date('Y'); ?> ANE Solutions.</strong>
</footer>

</div><!-- ./wrapper -->

<script src="<?php echo $base; ?>/theme/adminlte/plugins/jquery/jquery.min.js"></script>
<script src="<?php echo $base; ?>/theme/adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="<?php echo $base; ?>/theme/adminlte/dist/js/adminlte.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    var pushBtn = document.querySelector('[data-widget="pushmenu"]');
    if (pushBtn) {
        pushBtn.addEventListener('click', function () {
            setTimeout(function () {
                window.dispatchEvent(new Event('resize'));
            }, 300);
        });
    }
});
</script>

</body>
</html>