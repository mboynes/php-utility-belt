<?php
if ( defined( 'E_DEPRECATED' ) )
	error_reporting( E_ALL & ~E_DEPRECATED & ~E_STRICT );
else
	error_reporting( E_ALL );
ini_set( 'display_errors', 1 );

$content_type = 'text/plain';
ob_start();

# Home module (run arbitrary PHP)
if ( isset( $_POST['code'] ) ) {
	if ( false === eval( $_POST['code'] ) )
		echo 'PHP Error encountered, execution halted';
}

# Regular Expressions Module
elseif ( isset( $_POST['regex'] ) ) {
	switch ( $_POST['regex'] ) {
		case 'Match':
			if ( preg_match( $_POST['expression'], $_POST['content'], $matches ) )
				echo htmlentities( print_r( $matches, 1 ) );
			else
				echo "No matches Found";
			break;

		case 'Match All':
			if ( $count = preg_match_all( $_POST['expression'], $_POST['content'], $matches ) )
				echo "$count matches found\n", htmlentities( print_r( $matches, 1 ) );
			else
				echo "No matches found";
			break;

		case 'Replace':
			if ( $count = preg_match_all( $_POST['expression'], $_POST['content'], $matches ) )
				echo "$count matches found\n";
			else
				echo "No matches found\n";
			echo htmlentities( preg_replace( $_POST['expression'], $_POST['replace'], $_POST['content'] ) );
			break;
	}
}

# Time module
elseif ( isset( $_POST['time'] ) ) {
	$content_type = 'text/html';
	$format = isset( $_POST['date_format'] ) ? $_POST['date_format'] : 'Y-m-d H:i:s';
	$stamp = time();
	if ( isset( $_POST['mktime'], $_POST['mktime'][0], $_POST['mktime'][1], $_POST['mktime'][2], $_POST['mktime'][3], $_POST['mktime'][4], $_POST['mktime'][5] )
		&& '' != implode( '', $_POST['mktime'] )
	) {
		array_walk( $_POST['mktime'], create_function( '&$a', '$a = (int) $a;' ) );
		$stamp = call_user_func_array( 'mktime', $_POST['mktime'] );
		// $mkstamp = call_user_func_array( 'mktime', $_POST['mktime'] );
		// echo "Make Time\n==================================================================\n";
		// echo 'mktime( ' . implode( ', ', $_POST['mktime'] ) . " ) == $mkstamp (" . date( 'Y-m-d H:i:s', $mkstamp ) . ")\n\n";
	} elseif ( isset( $_POST['timestamp'] ) && !empty( $_POST['timestamp'] ) ) {
		$stamp = (int) $_POST['timestamp'];
		// echo "Timestamp\n================================\n";
		// echo "{$_POST['timestamp']} == " . date( 'Y-m-d H:i:s', $_POST['timestamp'] ) . "\n\n";
	} elseif ( isset( $_POST['strtotime'] ) && !empty( $_POST['strtotime'] ) ) {
		$stamp = strtotime( $_POST['strtotime'] );
		// echo "String to Timestamp\n========================================================\n";
		// echo "{$_POST['strtotime']} == " . $stamp . " == " . date( 'Y-m-d H:i:s', $stamp );
	}

	?>
	<table class="table table-bordered">
		<tbody>
			<tr>
				<th scope="row">Timestamp</th>
				<td><?php echo $stamp ?></td>
			</tr>
			<tr>
				<th scope="row"><code>mktime</code></th>
				<td><?php echo "mktime( " . date( "G, i, s, n, j, Y", $stamp ) . " )" ?></td>
			</tr>
			<tr>
				<th scope="row">Formatted</th>
				<td><?php echo date( $format, $stamp ) ?></td>
			</tr>
		</tbody>
	</table>
	<?php
}

# Serialization Module
elseif ( isset( $_POST['serialization'] ) ) {
	if ( 'Serialize' == $_POST['serialization'] ) {
		echo serialize( call_user_func( create_function('', "return {$_POST['serializee']};") ) );
	} elseif ( 'JSON Encode' == $_POST['serialization'] ) {
		echo json_encode( call_user_func( create_function('', "return {$_POST['serializee']};") ) );
	} elseif ( 'JSON Decode' == $_POST['serialization'] ) {
		print_r( json_decode( $_POST['serializee'], true ) );
	} else {
		$unserialized = unserialize( $_POST['serializee'] );
		if ( false !== $unserialized ) {
			print_r( $unserialized );
		} else {
			# There was an error, try to fix it
			# common issue is with crlf
			$serializee = str_replace( array( "\n\r", "\r\n" ), "\n", $_POST['serializee'] );
			$unserialized = unserialize( $serializee );
			if ( false !== $unserialized ) {
				echo "Notice: CRLF newlines corrected\n===============================\n\n";
				print_r( $unserialized );
			} else {
				echo 'Error unserializing data';
			}
		}
	}
}

header( "Content-Type: $content_type" );
$output = ob_get_contents();
ob_end_clean();
if ( 'text/html' == $content_type )
	$output = "<html>$output</html>";
echo $output;
?>