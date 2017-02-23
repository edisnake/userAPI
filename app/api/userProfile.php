<?php

// Route for get all users data
$app->get('/api/userProfile', 
    function ($request, $response, $args) use ($dbConnection)
    {
        if (is_object($dbConnection)) {
            $query = 'select * from tbl_user_profile order by name';
            $result = $dbConnection->query($query);
            $data = array();
            
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
            
            if (empty($data)) {
                $data[] = 'No results found.';
            }
            
            return $response->withJson($data, 200);
        } else {
            return $response->withJson(array('Internal server error - Database connection error'), 500);
        }
    });

// Route for get one user data by id key
$app->get('/api/userProfile/{id}',
    function ($request, $response, $args) use ($dbConnection)
    {
        if (is_object($dbConnection)) {
            $query = 'select * from tbl_user_profile where id = '.$args['id'];
            $result = $dbConnection->query($query);
                        
            if (mysqli_num_rows($result) > 0) {
                $data[] = $result->fetch_assoc();
            } else {
                $data[] = 'No results found.';
            }
            
            return $response->withJson($data, 200);
        } else {
            return $response->withJson(array('Internal server error - Database connection error'), 500);
        }
    });

// Route for create user data
$app->post('/api/userProfile',
    function ($request, $response) use ($dbConnection)
    {
        if (is_object($dbConnection)) {
            // get request arguments
            $data = $request->getParsedBody();
            
            //validate data before insert into database
            if (!isset($data['name'])) {
                return $response->withJson(array('name argument is required'), 422);
            }
            
            if (!isset($data['email'])) {
                return $response->withJson(array('email argument is required'), 422);
            } else {
                if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                    return $response->withJson(array('invalid email address'), 422);
                }
            }
            
            if (!isset($data['Image'])) {
                return $response->withJson(array('Image argument is required'), 422);
            }                       
            
            // if user's "id" arg has been used in the request
            if (isset($data['id'])) {
                $query = 'INSERT INTO tbl_user_profile (id, name, email, Image) VALUES (?,?,?,?)';
                $stmt = $dbConnection->prepare($query);
                $stmt->bind_param('isss', $data['id'], $data['name'], $data['email'], $data['Image']);
            
            // otherwise mysql database increments the id for the user profile table
            } else {                
                $query = 'INSERT INTO tbl_user_profile (name, email, Image) VALUES (?,?,?)';
                $stmt = $dbConnection->prepare($query);
                $stmt->bind_param('sss', $data['name'], $data['email'], $data['Image']);
            }
            
            $result = $stmt->execute();
            $stmtError = $stmt->error;
            $stmt->close();
            
            // return data in database
            if ($result) {
                return $response->withJson(array('Successful insert'), 200);
            } else {
                return $response->withJson(array('An error has occurred. '.$stmtError), 400);
            }
        } else {
            return $response->withJson(array('Internal server error - Database connection error'), 500);
        }
    });

// Route for update one user data
$app->put('/api/userProfile',
    function ($request, $response) use ($dbConnection)
    {
        if (is_object($dbConnection)) {
            // get request arguments
            $data = $request->getParsedBody();

            //validate data before update info in database
            if (!isset($data['id'])) {
                return $response->withJson(array('id argument is required'), 422);
            }
            
            if (!isset($data['name'])) {
                return $response->withJson(array('name argument is required'), 422);
            }
            
            if (!isset($data['email'])) {
                return $response->withJson(array('email argument is required'), 422);
            } else {
                if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                    return $response->withJson(array('invalid email address'), 422);
                }
            }

            $query = 'update tbl_user_profile set name=?, email=?, Image=? where id=?';
            $stmt = $dbConnection->prepare($query);
            $stmt->bind_param('sssi', $data['name'], $data['email'], $data['Image'], $data['id']);
            $result = $stmt->execute();
            $stmtError = $stmt->error;
            $stmt->close();

            // if the row was updated
            if ($result) {
                return $response->withJson(array('Successful update'), 200);
            } else {
                return $response->withJson(array('An error has occurred. '.$stmtError), 400);
            }
        } else {
            return $response->withJson(array('Internal server error - Database connection error'), 500);
        }
    });

// Route for delete one user data
$app->delete('/api/userProfile/{id}',
    function ($request, $response, $args) use ($dbConnection)
    {
        if (is_object($dbConnection)) {
            //validate data before update info in database
            if (!isset($args['id'])) {
                return $response->withJson(array('id argument is required'), 422);
            }

            $query = 'delete from tbl_user_profile where id=?';
            $stmt = $dbConnection->prepare($query);
            $stmt->bind_param('i', $args['id']);
            $result = $stmt->execute();
            $stmtError = $stmt->error;
            $stmt->close();

            // if the row was deleted
            if ($result) {
                return $response->withJson(array('Successful delete'), 200);
            } else {
                return $response->withJson(array('An error has occurred. '.$stmtError), 400);
            }
        } else {
            return $response->withJson(array('Internal server error - Database connection error'), 500);
        }
    });


