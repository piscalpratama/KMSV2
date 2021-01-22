<script type="text/javascript">
    $(function() {
        $('input:radio[name="pilihan"]').change(function() {
            var pilihan = this.value
            //alert(pilihan);
            var base_url = "<?=base_url('Tes/InputJawaban')?>";
            $.ajax({
                type: 'POST',
                url: base_url,
                data: {
                    'id_master_pilihan' : pilihan,
                },
                success: function (response) {
                    console.log("berhasil "+pilihan);
                },
                error: function (response) {
                    console.log("gagal "+pilihan);
                }
            })
        });
    });
</script>