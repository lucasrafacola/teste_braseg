<?php

function IsNullOrEmpty($str) {
	return (is_null($str) or strlen($str) == 0);
}

?>