<?php

function redireccion(String $url):never {
		exit(header("Location: $url"));
	}

?>