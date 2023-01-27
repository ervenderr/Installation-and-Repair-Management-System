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
                    $('#msgs').text(response);
                }
            })
        })
    });
</script>