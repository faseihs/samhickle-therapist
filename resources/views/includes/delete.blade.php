<script>
    function clicked(id){
        if(confirm("Are You Sure ?")){
            document.getElementById('del'+id).submit();
        }
        else{
        }
    }

    function jqueryConfirm(id){
        $.confirm({
            title: 'Are you sure?',
            buttons: {
                confirm: function () {
                    document.getElementById('del'+id).submit();
                },
                cancel: function () {

                },
            }
        });
    }
</script>