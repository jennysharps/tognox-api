<?php
/**
 * GIT DEPLOYMENT SCRIPT
 * Based on https://gist.github.com/1809044
 */
	 
$JSONpayload = get_magic_quotes_gpc() ? stripslashes( $_REQUEST['payload'] ) : $_REQUEST['payload'];
$payload = json_decode( $JSONpayload );
	 
if ($payload->ref === 'refs/heads/master' || $_REQUEST['force_update'] == 'true') {
	// $tmp = shell_exec( 'git pull' );
	$tmp = shell_exec( 'git fetch --all' );
	$tmp = shell_exec( 'git reset --hard origin/master' );
	file_put_contents('git_deploy.txt', "Update triggered by " . $payload->after . ": " . $payload->commits[0]->message . "\n Response: " . 	htmlentities( trim( $tmp ) ) . "\n\n", FILE_APPEND);
} else {

	// The commands
	$gitURL = trim( shell_exec( 'git config --get remote.origin.url' ) );
	$currentBranch = trim( shell_exec( 'git rev-parse --abbrev-ref HEAD') );
	
	$commands = array(
		//'echo $PWD',
		//'whoami',
		//'git pull',
		//'git status',
		"git rev-parse HEAD",
		"git ls-remote $gitURL $currentBranch",
		//'git submodule sync',
		//'git submodule update',
		//'git submodule status'
	);

	// Run the commands for output
	$output = "\n";
	foreach($commands as $command){
		$tmp = shell_exec($command);
		$output .= '<span class="sign">$</span> <span class="command">' . $command . "\n" . '</span>';
		$output .= htmlentities( trim ( $tmp ) ) . "\n\n";
	}

	?>
<!DOCTYPE html>
	<html lang="en">
		<meta charset="utf-8">
		<title>GIT Deployment Status</title>
	    <meta name="robots" content="noindex, nofollow">
		<style>
			body {
				font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
				font-size: 14px;
				line-height: 20px;
			}
			div { 
				width: 50%; 
				margin: 0 auto; 
				padding: 0 20px;
				position: relative;
				top: 4em;
				border-radius: 8px;
				background-color: #f7f7f9;
				border: 1px solid #e1e1e8;
			}
			h1 {
				font-size: 32px;
			}
			pre {
				margin: -10px 0;
				white-space: pre-wrap;
 				white-space: -moz-pre-wrap;
 				white-space: -pre-wrap;
 				white-space: -o-pre-wrap;
 				word-wrap: break-word; 
			}
			.sign {
				color: #5BE01D;
			}
			.command {
				color: #729FCF;
			}
			
		</style>
	</head>
	<body>
		<div>
			<h1><?php echo basename( getcwd() ); ?></h1>
			<pre>
				<?php echo $output; ?>
			</pre>
		</div>
	</body>
</html>

<?php }