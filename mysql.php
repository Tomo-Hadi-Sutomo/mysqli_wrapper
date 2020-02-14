<?php
if (!is_callable('mysql_connect')) {
	function mysql_connect($server = '', $user = '', $pass = '', $arg = false, $flag = 0, $persistente = '') {
		if (func_num_args() === 0 && $_SERVER['MYSQL_CONN']) foreach ($_SERVER['MYSQL_CONN'] as $hash => &$conns) return $conns;
		$hash = sha1(serialize(func_get_args()));
		if (!$arg && isset($_SERVER['MYSQL_CONN']) && $_SERVER['MYSQL_CONN'][$hash]) return $_SERVER['MYSQL_CONN'][$hash];
		if (!$server) $server = ini_get("mysqli.default_host");
		$server = trim($server);
		if (!$user) $user = ini_get("mysqli.default_user");
		if (!$pass) $pass = ini_get("mysqli.default_pw");
		$link = mysqli_init();
		$socket = null;
		if (strpos($server, ':') !== false) list($server, $port) = explode(':', $server, 2); else $port = ini_get("mysqli.default_port");
		if (!$server) $server = 'localhost';
		if (!is_numeric($port)) {
			$socket = $port;
			$port = null;
		}
		if (!$port && $port !== null) $port = 3306;
		$ok = @mysqli_real_connect($link, $persistente . $server, $user, $pass, '', $port, $socket, $flag);
		if (!$ok) return false;
		$_SERVER['MYSQL_CONN'][$hash] =& $link;
		return $link;
	}
	function mysql_pconnect($server = '', $user = '', $pass = '', $flag = 0) {
		return mysql_connect($server, $user, $pass, false, $flag, 'p:');
	}
	function mysql_create_db($db, $arg = null) {
		if (!$arg) $arg = mysql_connect();
		return !@mysqli_query($arg, "create database `$db`");
	}
	function mysql_data_seek($arg, $num) {
		mysqli_store_result($arg);
		return @mysqli_data_seek($arg, $num);
	}
	function mysql_db_name($res, $arg, $arg2 = null) {
		if (!@mysqli_data_seek($res, $arg)) return false;
		$arg = mysqli_fetch_assoc($res);
		if (!$arg2) return $arg['Database']; else return $arg[$arg2];
	}
	function mysql_db_query($db, $query, $con = null) {
		if (!$con) $con = mysql_connect();
		$rs = mysqli_query($con, "select database()");
		$prec_db = @mysqli_fetch_row($rs);
		@mysqli_query($con, "use `$db`", MYSQLI_USE_RESULT);
		$rs = mysqli_query($con, $query, MYSQLI_STORE_RESULT);
		if (strtolower($prec_db[0]) != strtolower($db)) @mysqli_query($con, "use `{$prec_db[0]}`", MYSQLI_USE_RESULT);
		return $rs;
	}
	function mysql_drop_db($db, $con = null) {
		if (!$con) $con = mysql_connect();
		return !@mysqli_query($con, "drop database `$db`");
	}
	function mysql_errno($con = null) {
		if (!$con) $con = mysql_connect();
		if (!is_object($con)) return false;
		return $con->errno;
	}
	function mysql_error($con = null) {
		if (!$con) $con = mysql_connect();
		if (!is_object($con)) return false;
		return $con->error;
	}
	function mysql_escape_string($esc) {
		return @mysql_real_escape_string($esc);
	}
	function mysql_fetch_array($res, $type = null) {
		if ($type === null) $type = MYSQLI_BOTH;
		return @mysqli_fetch_array($res, $type);
	}
	function mysql_fetch_assoc($res) {
		return @mysqli_fetch_assoc($res);
	}
	function mysql_fetch_lengths($res) {
		return @mysqli_fetch_lengths($res);
	}
	function mysql_fetch_object($res) {
		return @mysqli_fetch_object($res);
	}
	function mysql_fetch_row($res) {
		return @mysqli_fetch_row($res);
	}
	function mysql_field_seek($res, $arg) {
		return @mysqli_field_seek($res, $arg);
	}
	function mysql_free_result($res) {
		@mysqli_free_result($res);
	}
	function mysql_get_client_info($con = null) {
		if (!$con) $con = mysql_connect();
		if (!is_object($con)) return false;
		return $con->client_info;
	}
	function mysql_get_host_info($con = null) {
		if (!$con) $con = mysql_connect();
		if (!is_object($con)) return false;
		return $con->host_info;
	}
	function mysql_get_proto_info($con = null) {
		if (!$con) $con = mysql_connect();
		if (!is_object($con)) return false;
		return $con->protocol_version;
	}
	function mysql_get_server_info($con = null) {
		if (!$con) $con = mysql_connect();
		if (!is_object($con)) return false;
		return $con->server_info;
	}
	function mysql_info($con = null) {
		if (!$con) $con = mysql_connect();
		if (!is_object($con)) return false;
		return $con->info;
	}
	function mysql_insert_id($con = null) {
		if (!$con) $con = mysql_connect();
		if (!is_object($con)) return false;
		return $con->insert_id;
	}
	function mysql_list_dbs($con = null) {
		if (!$con) $con = mysql_connect();
		$rs = @mysqli_query($con, 'SHOW DATABASES');
		@mysqli_store_result($rs);
		return $rs;
	}
	function mysql_num_fields($res) {
		return @mysqli_num_fields($res);
	}
	function mysql_num_rows($res) {
		return @mysqli_num_rows($res);
	}
	function mysql_ping($con = null) {
		if (!$con) $con = mysql_connect();
		return @mysqli_ping($con);
	}
	function mysql_query($query, $con = null) {
		if (!$con) $con = mysql_connect();
		return @mysqli_query($con, $query);
	}
	function mysql_real_escape_string($esc, $con = null) {
		if (!$con) $con = mysql_connect();
		return @mysqli_real_escape_string($con, $esc);
	}
	function mysql_select_db($db, $con = null) {
		if (!$con) $con = mysql_connect();
		return @mysqli_select_db($con, $db);
	}
	function mysql_set_charset($charset, $con = null) {
		if (!$con) $con = mysql_connect();
		return @mysqli_set_charset($con, $charset);
	}
	function mysql_stat($con = null) {
		if (!$con) $con = mysql_connect();
		if (!is_object($con)) return false;
		return $con->stat;
	}
	function mysql_thread_id($con = null) {
		if (!$con) $con = mysql_connect();
		if (!is_object($con)) return false;
		return $con->thread_id;
	}
	function mysql_unbuffered_query($query, $con = null) {
		if (!$con) $con = mysql_connect();
		return @mysqli_query($con, $query, 0);
	}
	function mysql_list_fields($db, $table, $con = null) {
		if (!$con) $con = mysql_connect();
		return @mysqli_query($con, "select * FROM `$db`.`$table` limit 1");
	}
	function mysql_field_name($res, $arg) {
		$info = @mysqli_fetch_field_direct($res, $arg);
		return $info->name;
	}
	function mysql_field_flags($res, $arg) {
		$info = @mysqli_fetch_field_direct($res, $arg);
		return $info->flags;
	}
	function mysql_field_len($res, $arg) {
		$info = @mysqli_fetch_field_direct($res, $arg);
		return $info->length;
	}
	function mysql_field_type($res, $arg) {
		$info = @mysql_fetch_field($res, $arg);
		return $info->type;
	}
	function mysql_field_table($res, $arg) {
		$info = @mysqli_fetch_field_direct($res, $arg);
		return $info->table;
	}
	function mysql_list_processes($con = null) {
		if (!$con) $con = mysql_connect();
		return @mysqli_query($con, "show processlist", MYSQLI_STORE_RESULT);
	}
	function mysql_list_tables($database, $con = null) {
		if (!$con) $con = mysql_connect();
		return @mysqli_query($con, "SHOW TABLES", MYSQLI_STORE_RESULT);
	}
	function mysql_tablename($res, $i) {
		@mysqli_data_seek($res, $i);
		$row = @mysqli_fetch_row($res);
		return $row[0];
	}
	function mysql_result($res, $arg1, $arg2 = null) {
		$esito = @mysqli_data_seek($res, $arg1);
		if (!$esito && $arg2 !== null) return @mysqli_field_seek($res, $arg2);
		return $esito;
	}
	function mysql_fetch_field($res, $arg = 0) {
		mysqli_field_seek($res, $arg);
		$info = mysqli_fetch_field($res);
		$out = new stdclass();
		$out->name = $info->name;
		$out->table = $info->table;
		$out->def = '';
		$out->max_length = $info->max_length;
		$infos = array();
		if ($info->orgtable && $info->db && $info->orgname) {
			$rs = mysqli_query(mysql_connect(), "select is_nullable,column_key,numeric_precision,column_type
		                                      	from `information_schema`.`COLUMNS` where
			                                     table_schema='{$info->db}' and
			                                     table_name='{$info->orgtable}' and
		                                       	 column_name='{$info->orgname}' limit 1");
			$infos = mysqli_fetch_assoc($rs);
		}
		$out->not_null = ($infos['is_nullable'] == 'YES' ? 0 : 1);
		$out->primary_key = ($infos['column_key'] == 'PRI' ? 1 : 0);
		$out->multiple_key = ($infos['column_key'] == 'MUL' ? 1 : 0);
		$out->unique_key = ($infos['column_key'] == 'UNI' ? 1 : 0);
		$out->numeric = ($infos['numeric_precision'] > 0 ? 1 : 0);
		$out->blob = intval(preg_match('/blob$/', $infos['column_type']));
		$out->type = $info->type;
		$out->unsigned = intval(stripos(" {$infos['column_type']} ", ' unsigned ') !== false);
		$out->zerofill = intval(stripos(" {$infos['column_type']} ", ' zerofill ') !== false);
		switch ($info->type) {
			case 4:
			case 5:
			case 246:
				$out->type = 'real';
				break;
			case 7:
				$out->type = 'timestamp';
				$out->unsigned = 1;
				$out->zerofill = 1;
				break;
			case 10:
				$out->type = 'date';
				break;
			case 11:
				$out->type = 'time';
				break;
			case 12:
				$out->type = 'datetime';
				break;
			case 13:
				$out->type = 'year';
				$out->unsigned = 1;
				$out->zerofill = 1;
				break;
			case 16:
				$out->numeric = 0;
				$out->unsigned = 1;
				$out->zerofill = 0;
				$out->type = 'int';
				break;
			case 255:
				$out->type = 'geometry';
				$out->blob = 1;
				break;
			case 252:
				$out->type = 'blob';
				$out->blob = 1;
				break;
			case 253:
			case 254:
				$out->type = 'string';
				break;
		}
		return $out;
	}
	function mysql_affected_rows($arg = null) {
		if (!$arg) $arg = mysql_connect();
		if (!is_object($arg)) return false;
		return $arg->affected_rows;
	}
	function mysql_client_encoding($arg = null) {
		if (!$arg) $arg = mysql_connect();
		return @mysqli_character_set_name($arg);
	}
	function mysql_close($arg = null) {
		if (!$arg) $arg = mysql_connect();
		return @mysqli_close($arg);
	}
}
?>
