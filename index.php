<?php
session_start();
//$include = (isset($_GET["link"]))?$_GET["link"]:"_include-home.php";
include 'include/php/config/config.php';
include 'include/php/utils.php';
include 'clases/class.bbdd.php';
include 'clases/class.login.php';
include 'clases/class.seguridad.php';
include 'clases/class.gral.php';
$seguridad->verificar();

			if( $seguridad->estado == 1 ) {
				include $seguridad->decodificarURL();
			} else {
				include PATH_LOGIN;
		  } ?>
		</div>
		<div id="footer">Todos los derechos reservados</div>
	</div>	

<script type="text/javascript">
$().ready(function() {
	$("#id_tags").autocomplete('gettags.php', {
		multiple: true,
		mustMatch: true,
		/*cacheLength: 0,*/
		autoFill: true,
		selectFirst: true,
		extraParams: {
			t: function() {
				return $("#id_tags").val()
			}
		},
		formatItem: formatItem,
		formatResult: formatResult
	} );
});

function formatItem(row) {
	return row[0];
}

function formatResult(row) {
	return row[0];
}

function getTags() {
	return $("#id_tags").get(0).value;
}
</script>

</body>
</html>