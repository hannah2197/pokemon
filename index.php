<html>
	<head>
		<title>Pokemon Game</title>
	</head>
	<body style="padding: 0px; margin: 0px; font-family: arial; font-size: 35px; line-height: 20px;">
		<div style="padding: 100px 30px; text-align: center; color: white; background: #f6e652;">
			<h1>Pokédex</h1>
		</div>
	<div align="center" style="padding-top: 10px;">
		<div style="display:block; width: 500px; height: 70px;" align="center" >	
			<a href="./?p1=1">
				<p style="padding: 20px; color: #fff; font-size: 12px; background-color: #c52018;">List pokemon based on type or weight</p>
			</a><br>
		</div>
		<div style="display:block; width: 500px; height: 70px;" align="center">
			<a href="./?p2=1"><p style="padding: 20px; color: #fff; font-size: 12px; background-color: #e65a41;">Determine pokemon with highest number of moves relating to their primary type</p>
	</a><br>
		</div>
		
		<div style="display:block; width: 500px; height: 70px;" align="center">
			<a href="./?p2=1"><p style="padding: 20px; color: #fff; font-size: 12px; background-color: #f6bd20;">Which pokemon change types when evolved</p>
	</a><br>
		</div>
	
	<br><a href="." style="color: #333; font-size: 12px;">Start Over</a>
	
	</div>
	
	
	
	<?php 
		$con = new mysqli('localhost','teamrocket','digimon','pokedex');
		
		if(isset($_GET['p1'])) {
			$result = $con->query('
				SELECT pkm.pkm_code AS `#`, pkm.pkm_name AS Name, GROUP_CONCAT(move.move_name) AS Moves
				FROM pokemove, pkm, move
				WHERE pkm.pkm_code = pokemove.pkm_code
					AND pokemove.move_code = move.move_code
				GROUP BY pkm.pkm_code;
			');
			
			 while($row = $result->fetch_assoc()) {
		        echo '
		        <table width="900px" border="1" align="center"><tr><td>
		        <p>'.$row['#'].' '.$row['Name'].'<br>'.$row['Moves'].'</p>
		        </td></tr></table>';
		    }
		} else if(isset($_GET['p2'])) {
			$result = $con->query('
				SELECT pkm.pkm_code, pkm.pkm_name AS `Name`,`type`.type_name as `Primary Type`, COUNT(pokemove.move_code) AS `Moves of Same Type`
				FROM pkm,poketype,type,pokemove,move
				WHERE pkm.pkm_code=poketype.pkm_code
					AND pkm.pkm_code=pokemove.pkm_code
					AND `poketype`.poketype_is_primary=true
					AND pkm.pkm_code<722
					AND `type`.type_code=poketype.type_code
					AND move.move_code=pokemove.move_code
					AND move.type_code=poketype.type_code
				GROUP BY pkm.pkm_code
				ORDER BY COUNT(pokemove.move_code), pkm.pkm_code,pkm.pkm_name;
			');
			while($row = $result->fetch_assoc()) {
		        echo '<p>'.$row['pkm_code'].' '.$row['Name'].' '.$row['Primary Type'].' '.$row['Moves of Same Type'].'</p>';
		    }
		}
		$con->close();
	?>
	</body>
</html>
