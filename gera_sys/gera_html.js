<title>Gera Página HTML </title>
<meta charset="utf-8">
<!-- Bootstrap -->
<link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
<link href="../css/css_cad.css" rel="stylesheet" media="screen">
<script src="../bootstrap/js/jquery.js"></script>
<script src="../bootstrap/js/bootstrap.min.js"></script>
<script src="../bootstrap/js/jquery.validate.js" ></script> 
<script src="../bootstrap/js/jquery.maskedinput.js"></script>
<script src="../bootstrap/js/jquery.leanModal.min.js"></script>  
<script>

    $(document).ready(function() {
        $("#campostabela option").click(function(e) {
            e.preventDefault();
            alert($("#campostabela option:selected").val());
        });
    });
</script>