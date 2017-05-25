<?php
header('Content-Type: text/html; charset=ISO-8859-9');
if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    try {
     $db = new PDO("mysql:host=localhost;dbname=xx;charset=utf8", "root", "");
	} catch ( PDOException $e ){
		 print $e->getMessage();
	}
	if(isset($_GET["query"])){
		$query = $_GET["query"];
		if($query == "provinces"){
			$sql = $db->prepare('SELECT * FROM provinces');
			$sql->execute();
			if($sql->rowCount()){
				while ($row = $sql->fetch(PDO::FETCH_ASSOC))
				{$rows[] = $row;}
			}
		}else if($query == "districts"){
			if(isset($_GET["province_id"])){
				$province_id = $_GET["province_id"];
			}else{
				$province_id = 1; // for example..
			}
			$sql = $db->prepare('SELECT * FROM districts WHERE province_id = ?');
			$sql->execute(array($province_id));
			if($sql->rowCount()){
				while ($row = $sql->fetch(PDO::FETCH_ASSOC))
				{$rows[] = $row;}
			}
		}
	print json_encode($rows);
	}else{
		echo "<center><h2>Unauthorized access !</h2></center>";
	}	
	$db = null;
}else{
	echo "<center><h2>Unauthorized access !</h2></center>";
}
?>
