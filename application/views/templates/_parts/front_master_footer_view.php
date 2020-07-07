

<footer class="footer">
      <div class="container">
        <p class="text-muted">© Copyright 2020. Conçu par <a href="https://jprobeweb.com" target="_blank">JPROBEWEB</a>.</p>
      </div>
    </footer>

<script src="<?=site_url('/assets/js/bootstrap.min.js')?>"></script>
<script src="<?=site_url('/assets/js/bootbox.min.js')?>"></script>
<script src="<?=site_url('/assets/js/bootbox.locales.min.js')?>"></script>

<script type="text/javascript">

 function myFunction(){
    var box = bootbox.confirm({ 
	    size: "small",
	    message: "Vous êtes sur le point de vous deconnecter, êtes vous sûre ?",
	    callback: function(result){ 
	         /* result is a boolean; true = OK, false = Cancel*/
	         if(result==true)
	         {
	         	var url = "<?php echo site_url('admin/deconnexion') ?>";
	         	window.setTimeout(function(){
				        // Move to a new location or you can do something else
				        window.location.href =  url;

				    }, 300);
	         	//window.location.href = url;
	         }
	  }
	})
 }

 
 
 
</script>
</body>
</html>


