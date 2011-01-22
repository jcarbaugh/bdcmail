<?
/*
Items to remember:
$a = action 
	xpn = expunge
	dlt = delete
	opn = open inbox
	rem = read email message
	udl = undelete
	mim = mark important
	lgn = login
	lgo = logout
	cmp = compose
	sdm = send message
*/

$basedir = "/";

$server = "mail.jmu.edu";				// Sets the IMAP server variable to the JMU email server
$port = "143";							// Sets the JMU IMAP email server port number

if (!isset($bx)) {
	$bx = "INBOX";
}

/////////////////////////////////////////////////////////////////////////
function cts($server, $port, $user, $pass, $box) {
	return imap_open("\{$server:$port}$box", $user, $pass);
}
function dfs($mbox) {
	imap_close($mbox);
}
/////////////////////////////////////////////////////////////////////////

?>

<html>
<head>
	<title>BDCMail - JMU Remote Email System</title>
	<STYLE type=text/css>
		A:link    { COLOR: blue; TEXT-DECORATION: none; font-weight: normal }
		A:visited { COLOR: blue; TEXT-DECORATION: none; font-weight: normal }
		A:active  { COLOR: blue; TEXT-DECORATION: none }
		A:hover   { COLOR: blue; font-weight: normal ;text-decoration:underline}
		TD, TABLE, BODY { color: black; font-family: verdana; font-size: 10px; }
		INPUT, SELECT { color: black; font-family: arial; font-size: 10px; }
		.flag { color: white; font-family: arial; font-size: 14px; font-weight: bold; }
		.login { color: black; font-family:arial; font-size: 12px; font-weight:bold;}
		.input { border-width:1px; border-style:solid; border-color:black; font-family:arial; font-size:11; background-color:white; color: black; }
		.subject { color: black; font-family: verdana; font-size: 10px; }
		.subjectdel { color: black; font-family: verdana; font-size: 10px; text-decoration: line-through; }
	</STYLE>
</head>
<body topmargin=0 leftmargin=4 rightmargin=4 bottommargin=0 marginheight=0 marginwidth=4>

<?
$mbox = cts($server, $port, $bdcmail[0], $bdcmail[1], $bx);
if ($a == "dlt") {
	imap_delete($mbox, $mn);
}
elseif ($a == "udl") {
	imap_undelete($mbox, $mn);
}
elseif ($a == "xpn") {
	imap_expunge($mbox);
}
$messages = imap_search($mbox, "ALL");
?>

<table width="100%" align="center" cellspacing="0" cellpadding="3">
	<tr>
		<td align="center">
			<a href="/list.php?bx=<? echo $bx; ?>">Refresh</a> || <a href="/list.php?a=xpn&bx=<? echo $bx; ?>">Expunge Deleted Messages</a> || <a href="/login.php?a=lgo" target="mid">Logout</a>
		</td>
	</tr>
</table>
<br>
<table width="100%" align="center" cellspacing="1" cellpadding="2" bgcolor="gainsboro">
	<?
	if (sizeof($messages) > 1) {
		rsort($messages);
		foreach ($messages as $m) {
			$header = imap_header($mbox, $m, 50, 50);
			
			if ($header->Deleted == "D") {
				?>
				<tr bgcolor="#b0c4de">
				<?
			}
			else {
				if ($header->Flagged == "F") {
					?>
					<tr bgcolor="#fbfe6d">
					<?
				}
				else {
					if ($header->Answered == "A") {
						?>
						<tr bgcolor="#faf0e6">
						<?
					}
					else {
						if ($header->Unseen == "U" || $header->Recent == "N") {
							?>
							<tr bgcolor="#8fbc8f">
							<?
						}
						else {
							?>
							<tr bgcolor="white">
							<?
						}
					}
				}
			}
			
			if ($header->Deleted == "D") { 
				?>
				<td align="center"><a href=<? echo "\"/list.php/?a=udl&mn=$m\""; ?>><b>U</b></a></td>
				<?
			}
			else {
				?>
				<td align="center"><a href=<? echo "\"/list.php/?a=dlt&mn=$m\""; ?><b>D</b></a></td>
				<?
			}
			?>
			<td><? echo substr($header->fetchfrom, 0, 18); ?></td>
			<td>
				<a href=<? echo "\"/view.php/?a=rem&mn=$m&bx=$bx\""; ?> class="subject" target="view"><? if ($header->fetchsubject) { echo substr($header->fetchsubject, 0, 40); } else { echo "-= NO SUBJECT =-"; } ?></a>
			</td>
			<td><? echo date("M d", $header->udate); ?></td>
		</tr>
		<? } ?>
	<? } ?>
</table>
<br>
<? $list = imap_listmailbox($mbox, "{imap.jmu.edu}", "*"); ?>

<table width="100%" align="center" cellspacing="0" cellpadding="3">
	<tr>
		<td align="center">
		
<form action="list.php" method="GET">
	<select name="bx" class="input">
<?
if(is_array($list)) {
  reset($list);
  while (list($key, $val) = each($list)) {
  	$listitem = imap_utf7_decode($val);
	$listitem = str_replace("{imap.jmu.edu}", "", $listitem);
  	print "<option>".$listitem."</option><br>\n";
  }
}
else
  print "imap_listmailbox failed: ".imap_last_error()."\n";
?>
	</select>
	<input type="submit" value="Change Mailbox" class="input">
</form>
</td>
	</tr>
</table>

<? dfs($mbox); ?>
</body>
</html>
