<?php
function json_response($code = 200, $message = null) {
    // clear the old headers
    header_remove();
    // set the actual code
    http_response_code($code);
    // set the header to make sure cache is forced
    header("Cache-Control: no-transform,public,max-age=300,s-maxage=900");
    // treat this as json
    header('Content-Type: application/json');
    $status = array(
        200 => '200 OK',
        400 => '400 Bad Request',
        422 => 'Unprocessable Entity',
        500 => '500 Internal Server Error'
        );
    // ok, validation error, or failure
    header('Status: '.$status[$code]);
    // return the encoded json
    return json_encode(array(
        'status' => $code < 300, // success or not?
        'message' => $message
        ));
}

function mysqli_get_json_object($sql, $conn){
    $query = mysqli_query($conn, $sql);
	if (!$query) {
        return json_response(500, $conn->error);
		exit();
	}
	$resultObject = mysqli_fetch_array($query,MYSQLI_ASSOC);
    
	mysqli_close($conn);

    return json_response(200, $resultObject);
}

function mysqli_get_json_list($sql, $conn){
    $query = mysqli_query($conn, $sql);
	if (!$query) {        
        return json_response(500, $conn->error);
		exit();
    }    
	$resultArray = array();
	while($result = mysqli_fetch_array($query,MYSQLI_ASSOC))
	{
		array_push($resultArray, $result);
    }
    
	mysqli_close($conn);

    return json_response(200, $resultArray);
    
}

function mysqli_execute_db($sql, $conn ,$files = null){
    try {
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

        /* set autocommit to off */
        mysqli_autocommit($conn, false);
    
        /* Run your queries */
        mysqli_query($conn, $sql);

        /* commit transaction */
        mysqli_commit($conn);

        return json_response(200, true);
    }
    catch (mysqli_sql_exception $e){
        return json_response(500, $e->getMessage());
    }
}