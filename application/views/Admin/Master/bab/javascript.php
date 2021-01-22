<!-- DataTables -->
<script src="<?=base_url()?>assets/plugins/datatables/jquery.dataTables.js"></script>
<script src="<?=base_url()?>assets/plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>
<!-- Select2 -->
<script src="<?=base_url()?>assets/plugins/select2/js/select2.full.min.js"></script>
<script>
  $(function () {
    $('.select2').select2()
    $("#example1").DataTable();
  });
</script>
