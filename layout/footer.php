<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">
        Select "Logout" below if you are ready to end your current session.
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
        <a class="btn btn-primary" href="<?= base_url('/logout.php'); ?>">Logout</a>
      </div>
    </div>
  </div>
</div>

<!-- scripts -->
<script src="<?= base_url('/assets/js/jquery.min.js'); ?>" type="text/javascript" charset="utf-8"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="<?= base_url('/assets/js/bootstrap.min.js'); ?>" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript" charset="utf8" src="<?= base_url('/assets/DataTables/datatables.js'); ?>"></script>
<script src="<?= base_url('/assets/js/jquery.easing.min.js'); ?>" type="text/javascript" charset="utf-8"></script>
<script src="<?= base_url('/assets/js/sb-admin-2.js'); ?>" type="text/javascript" charset="utf-8"></script>
<script src="<?= base_url('/assets/sweetalert/sweetalert2.all.min.js'); ?>" type="text/javascript" charset="utf-8"></script>
<script src="<?= base_url('/assets/js/dt.js'); ?>" type="text/javascript" charset="utf-8"></script>
<script src="<?= base_url('/assets/js/flasher.js'); ?>" type="text/javascript" charset="utf-8"></script>