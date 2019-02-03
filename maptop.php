<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		
		<title>Map Top</title>
		
		<link rel="stylesheet prefetch" href="https://fonts.googleapis.com/css?family=Open+Sans:400,700,800" />
		<link rel="stylesheet" type="text/css" href="css/style.css" />
		
		<style type="text/css">
			th:nth-child(1)
			{
                		padding-left: 20px;
			}
			th:nth-child(2)
			{
				padding-left: 20px;
				padding-right: 400px;
			}
			th:nth-child(3)
			{
				padding-right: 40px;
			}
			th:nth-child(4)
			{
				padding-right: 20px;
			}
			td:nth-child(1)
			{
				padding-left: 20px;
			}
			td:nth-child(2)
			{
				padding-left: 20px;
			}
			td:nth-child(3)
			{
                		padding-right: 40px;
			}
			td:nth-child(4)
			{
				padding-right: 20px;
			}
		</style>
	</head>
	<body>
		<br />
		
		<table align="center" cellpadding="0" cellspacing="0" border="0">
			<thead>
				<tr>
					<th align="left">#</th>
					<th align="left"><img src="images/misc/player.png" /> Player</th>
					<th align="center"><img src="images/misc/clock.png" /> Time</th>
					<th align="right"><img src="images/misc/calendar.png" /> Date</th>
				</tr>
			</thead>
			<tbody><?php
				include("include/config.php");
				
				$link = mysqli_connect(DB_HOST, DB_USER, DB_PASS) or die('Could not connect: ' . mysqli_error());
				
				mysqli_select_db($link, DB_NAME) or die('Could not select database');
				
				if (isset($_GET["mapname"]))
					$mapname = mysqli_real_escape_string($link, $_GET["mapname"]);
				
				$query =
				"SELECT nickname, nationality, time, recorddate FROM `results` JOIN `runners` ON `runners`.id=`results`.id WHERE mid='".$mapname."' AND time ORDER BY time ASC LIMIT 15";
				
				
				if ($result = mysqli_query($link, $query))
				{
					if (mysqli_num_rows($result))
					{
						function getTime($time)
						{
							$minutes = $time/60000;
							$seconds = ($time/1000)%60;
							$miliseconds = $time%1000;
							
							return sprintf("%d:%02d.%03ds", $minutes, $seconds, $miliseconds);
						}
						
						$i = 1;
						
						while ($data = mysqli_fetch_assoc($result))
						{
							echo "
				<tr>";
							echo "
					<td align=\"left\">".$i."</td>";
							echo "
					<td align=\"left\"><img src=/images/flags/".$data["nationality"].".gif> <b>".htmlspecialchars($data["nickname"])."</a></b></td>";
							echo "
					<td align=\"center\">".getTime($data["time"])."</td>";
							echo "
					<td align=\"right\">".$data["recorddate"]."</td>";
							echo "
				</tr>";
							
							$i++;
						}
					}
					mysqli_free_result($result);
				}
				
				mysqli_close($link);
			?>

			</tbody>
		</table>
	</body>
</html>