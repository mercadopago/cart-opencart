<?php  if (isset($error)) { ?>
    <div class="warning">
    <?php
        if($debug == 1){
            echo '<strong>MercadoPago fails to connecet, and debug mode is on !!.<br /> Check the erros below and for security reasons turn it off after solve the problem:</strong><br />' ; 
            echo '<pre>'; print_r($error); echo '</pre><br />';    
        } else {
            echo '<strong>Sorry...MercadoPago fail to connect.<br /> If you are the store owner, turn on debug mode to get more details about the reason</strong><br />' ; 
        }
    ?>
    
    </div>
<?php  } else { ?>

    <?php
    switch($type_checkout):
        case "Redirect": ?>
            <script type="text/javascript">
                window.location = '<?php echo $link;?>';
            </script>
            <div class="right">Redirigiendo a MercadoPago, por favor, espere...</div>
            <?php
            break;
        case "Iframe":
                ?>
		    <iframe src="<?php echo $link ?>" name="MP-Checkout" width="740" height="600" frameborder="0"></iframe>
		    <script type="text/javascript">
			(function(){function $MPBR_load(){window.$MPBR_loaded !== true && (function(){var s = document.createElement("script");s.type = "text/javascript";s.async = true;
			s.src = ("https:"==document.location.protocol?"https://www.mercadopago.com/org-img/jsapi/mptools/buttons/":"http://mp-tools.mlstatic.com/buttons/")+"render.js";
			var x = document.getElementsByTagName("script")[0];x.parentNode.insertBefore(s, x);window.$MPBR_loaded = true;})();}
			window.$MPBR_loaded !== true ? (window.attachEvent ? window.attachEvent("onload", $MPBR_load) : window.addEventListener("load", $MPBR_load, false)) : null;})();
		    </script>
		<?php
                
            break;

        case "Lightbox":
        default:
            ?>
                <div class="right">
                    <a href="<?php echo $link ?>" name="MP-Checkout" class="blue-L-Rn" mp-mode="modal" onreturn="execute_my_onreturn">Pagar</a>
		    <script type="text/javascript">
			(function(){function $MPBR_load(){window.$MPBR_loaded !== true && (function(){var s = document.createElement("script");s.type = "text/javascript";s.async = true;
			s.src = ("https:"==document.location.protocol?"https://www.mercadopago.com/org-img/jsapi/mptools/buttons/":"http://mp-tools.mlstatic.com/buttons/")+"render.js";
			var x = document.getElementsByTagName("script")[0];x.parentNode.insertBefore(s, x);window.$MPBR_loaded = true;})();}
			window.$MPBR_loaded !== true ? (window.attachEvent ? window.attachEvent("onload", $MPBR_load) : window.addEventListener("load", $MPBR_load, false)) : null;})();
		    </script>
                </div>
                
            <?php
            break;
    endswitch;
    ?>
    
<?php  ;} ?>