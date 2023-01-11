<script>
    $(".empdelete").click(function(e) {
    alert();
    e.preventDefault();
    $.ajax({
        alert();
        type: "POST",
        url: "<?= site_url('Employee/delete'); ?>",
        cache: false,
        data: {
            id: $(this).attr("id")
        }, // since, you need to delete post of particular id
        success: function(data) {
            if (data) {
                alert("Success");
            } else {
                alert("ERROR");
            }
            return false;

        }
    });
    });
    });
</script>