<!-- DataTables -->
<script src="<?=base_url()?>assets/plugins/datatables/jquery.dataTables.js"></script>
<script src="<?=base_url()?>assets/plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>
<script>
  $(function () {
    $("#example1").DataTable({
        bAutoWidth: false, 
        aoColumns : [
            { sWidth: '5%' },
            { sWidth: '30%' },
            { sWidth: '65%' }
        ]
    });
  });
</script>
