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
		.flag { color: black; font-family: arial; font-size: 14px; font-weight: bold; }
		.login { color: black; font-family:arial; font-size: 12px; font-weight:bold;}
		.input { border-width:1px; border-style:solid; border-color:black; font-family:arial; font-size:11; background-color:white; color: black; }
		.subject { color: black; font-family: verdana; font-size: 10px; }
		.subjectdel { color: black; font-family: verdana; font-size: 10px; text-decoration: line-through; }
	</STYLE>
</head>
<body topmargin=0 leftmargin=4 rightmargin=4 bottommargin=0 marginheight=0 marginwidth=4>

<?
$mbox = cts($server, $port, $bdcmail[0], $bdcmail[1], $bx);
$messages = imap_search($mbox, "ALL");
if ($a == "rem") {
	// Read Message
	$header = imap_header($mbox, $mn, 80, 80);
	$replyto = $header->reply_to[0];
	$replyto = $replyto->mailbox . "@" . $replyto->host;
	?>
	<table width="100%" align="center" cellspacing="0" cellpadding="3">
		<tr>
			<td align="center">
				<a href="#">Compose New Message</a> || <a href="#">Reply To Message</a> || <a href="#">Forward Message</a>
			</td>
		</tr>
	</table>
	<br>
	<table width="100%" align="center" cellspacing="1" cellpadding="2" bgcolor="gainsboro">
		<tr>
			<td width="120" bgcolor="white"><b>From:</b></td>
			<td width="480" bgcolor="white"><? echo $header->fetchfrom; ?></td>
		</tr>
		<tr>
			<td width="120" bgcolor="white"><b>Reply To:</b></td>
			<td width="480" bgcolor="white"><? echo $replyto; ?></td>
		</tr>
		<tr>
			<td width="120" bgcolor="white"><b>Subject:</b></td>
			<td width="480" bgcolor="white"><? echo $header->fetchsubject; ?></td>
		</tr>
		<tr>
			<td width="120" bgcolor="white"><b>Sent on:</b></td>
			<td width="480" bgcolor="white"><? echo date("M d Y H:i:s", $header->udate); ?></td>
		</tr>
		<tr>
			<td colspan="2" bgcolor="white">
				<?
				$mailmessage = imap_body($mbox, $mn);
				$mailmessage = str_replace("target=", "notarget=", $mailmessage);
				$mailmessage = str_replace("<a href=", "<a target=\"_blank\" href=", $mailmessage);
				echo nl2br($mailmessage);
				?>
			</td>
		</tr>
	</table>
	<?
}
elseif ($a == "cmp") {
	// Compose a Message
	?>
	<form action="/" method="POST">
	<input type="hidden" name="a" value="sdm">
	<br>
	<table width="100%" cellpadding="0" cellspacing="1" border="0" bgcolor="gainsboro" align="center"><tr><td>
		<table width="100%" align="left" cellpadding="2" bgcolor="white">
			<tr>
				<td align="right"><div class="login">From:</div></td>
				<td align="left"><input type="text" name="from" value=<? echo "\"$bdcmail[0]@jmu.edu\""; ?> class="input"></td>
			</tr>
			<tr>
				<td align="right"><div class="login">To:</div></td>
				<td align="left"><input type="text" name="to" class="input" value=<? echo "\"$rpt\""; ?></td>
			</tr>
			<tr>
				<td align="right"><div class="login">Subject:</div></td>
				<td align="left"><input type="text" name="subject" class="input"></td>
			</tr>
			<tr>
				<td width="100%" colspan="2" align="center">
				<textarea cols="60" rows="8" name="body" class="input"></textarea>
			</td>
			</tr>
			<tr>
				<td width="100%" colspan="2" align="center">
					<input type="submit" value="Send Email Message" class="input">
				</td>
			</tr>
		</table>
	</td></tr></table>
	</form>
<?
}
else {
?>
<div align="center">
	<br><br><br>
	<span class="flag">Welcome to BDCMail</span>
	<br><br>
	<span class="login">Copyright 2001 Jeremy Carbaugh</a>

</div>
<?
}
dfs($mbox);
?>
</table>

</body>
</html>
