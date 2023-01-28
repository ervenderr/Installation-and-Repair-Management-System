<script type="text/javascript">
    $(document).ready(function () {
        $('#btn-submit').click(function (e) {
            e.preventDefault();
            $.ajax({
                method: "POST",
                url: "insertdata.php",
                data: $('#repair-form').serialize(),
                dataType: "text",
                success: function (response) {
                    $('#msgs').css('display', 'block').fadeIn(300);
                    $('#adis').css('pointer-events', 'none');
                    $('#btn-submit').css('pointer-events', 'none');
                    $('#eimg').css('pointer-events', 'none');
                    $('#shipping').css('pointer-events', 'none');
                }
            })
        })
    });
</script>