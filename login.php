<?

if ($bdcmail[0] && $bdcmail[1]) {
	header("Location: frame.html");
}

if ($a == "lgn") {
	if (isset($remember)) {
		setcookie("bdcmail[0]", $HTTP_POST_VARS[username], time() + 360000);
		setcookie("bdcmail[1]", $HTTP_POST_VARS[password], time() + 360000);
	}
	else {
		setcookie("bdcmail[0]", $HTTP_POST_VARS[username]);
		setcookie("bdcmail[1]", $HTTP_POST_VARS[password]);
	}
	header("Location: frame.html");
}
elseif ($a == "lgo") {
	setcookie("bdcmail[0]", "",  time - 3600);
	setcookie("bdcmail[1]", "",  time - 3600);
	header("Location: login.php");
}

?>
<html>
<head>
	<title>Untitled</title>
	<STYLE type=text/css>
		A:link    { COLOR: blue; TEXT-DECORATION: none; font-weight: normal }
		A:visited { COLOR: blue; TEXT-DECORATION: none; font-weight: normal }
		A:active  { COLOR: blue; TEXT-DECORATION: none }
		A:hover   { COLOR: blue; font-weight: normal ;text-decoration:underline}
		TD, TABLE, BODY { color: black; font-family: verdana; font-size: 10px; }
		INPUT, SELECT { color: black; font-family: arial; font-size: 10px; }
		.flag { color: black; font-family: arial; font-size: 14px; font-weight: bold; }
		.login { color: black; font-family:arial; font-size: 12px; font-weight:bold;}
		.input { border-width:1px; border-style:solid; border-color: black; font-family: arial; font-size:11; background-color: white; color: black; }
		.inputb { border-width:1px; border-style:solid; border-color: black; font-family: arial; font-size:11; background-color: #f4f1ed; color: black; }
		.subject { color: black; font-family: verdana; font-size: 10px; }
		.subjectdel { color: black; font-family: verdana; font-size: 10px; text-decoration: line-through; }
		.window { border: 1px solid #999999; }
		.header { font-size: 11px; font-weight: bold; }
		.spacer { background-color: #999999 }
	</STYLE>
</head>

<body>
	<br><br>
	<form method="POST" action="/login.php">
	<input type=hidden name="a" value="lgn">
	<table width="500" cellpadding="0" cellspacing="1" border="0" align="center">
		<tr>
			<td valign="top" align="left" width="300">
			
				<div class="login">Site Updates</div>
				<br>
				
				<table class="window" width="300" border="0" cellspacing="0" cellpadding="2">
					<tr bgcolor="#f4f1ed">
						<td>
							<font class="header">Wednesday, January 09, 2002</font>
						</td>
					</tr>
					<tr>
						<td class="spacer"></td>
					</tr>
					<tr>
						<td bgcolor="white">
							This area here will be a site update section to let you know how development is going.
							<br><br>
							Working on getting the login page setup and looking good.  After that I will work on user verification for the login.
							<br><br>
							And a big thanks to Jason for writing a great little table code that I stole for these updates.  Hope you don't mind! Hehehe.
						</td>
					</tr>
				</table>


			
			</td>
			<td valign="top" align="center" width="200">
			
				<table width="200" cellpadding="2" cellspacing="1" border="0" align="center">
					<tr>
						<td align="right"><div class="login">JMU ID</div></td>
						<td align="left"><input type="text" name="username" size="20" maxlength="15" class="input"></td>
					</tr>
					<tr>
						<td align="right"><div class="login">Password</div></td>
						<td align="left"><input type="password" name="password" size="20" maxlength="15" class="input"></td>
					</tr>
						<td align="right">&nbsp;</td>
						<td align="left">
							<table>
								<tr>
									<td align="left"><input type="checkbox" name="remember" value="yes" class="input"></td>
									<td align="left">
										Remember Me<br><i>(less secure)</i>
									</td>
								</tr>
							</table>
						</td>
					<tr>
						<td align="right">&nbsp;</td>
						<td align="left"><input type="submit" value="BDCMail Login" class="inputb" style="font-weight:bold;"></td>
					</tr>
				</table>
			
			</td>
		</tr>
	</table>
	</form>
	
</body>
</html>
