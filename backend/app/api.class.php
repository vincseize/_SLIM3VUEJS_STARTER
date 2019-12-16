<?php 
    /*
        Author: Vincseize
        Post: generic Php API
    */

    class Api{

        private $db; 

        /*  
            $db is your db/pdo connection
            $table is your db/pdo table for request
        */
        function __construct($db,$table){
            $this->db = $db;
            $this->table = $table;

            // $faker = Faker\Factory::create();
            // $this->faker = $faker;
        }

        /*
            Search by column name, and value
        */
        public function searchValue( $col, $value ) {
            print_r('<br>--$searchValue--<br>');
            print_r($col);
            print_r('<br>--$value--<br>');
            print_r($value);
            $sth = $this->db->prepare("SELECT * FROM $this->table WHERE $col = '$value'");
            $sth->execute();
            $result = $sth->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        }

        
        /*
            To map keys for values
            nom=>,email=>,... ----> :nom=>,:email=>,:...
        */
        public function renameKey( $array, $old_key, $new_key ) {
            $array[$new_key] = $array[$old_key];
            unset($array[$old_key]);
            return $array;
        }

        /*
            Update by $id ( default)
            The function will update an existing $col, $value
            from the database 
        */
        public function update($col, $value, $key_default='id'){
            print_r('<br>--$update--');
            print_r('<br>--$col--<br>');
            print_r($col);
            print_r('<br>--$value--<br>');
            print_r($value);
            $sth = $this->db->prepare("SELECT * FROM $this->table WHERE $col = '$value'");
            $sth->execute();
            $result = $sth->fetchAll(PDO::FETCH_ASSOC);
            print_r('<br>--$key_default--<br>');
            print_r ($key_default);
            foreach($result as $key => $key_value){
                print_r('<br>--$key_founded--<br>');
                $key_founded = $result[$key][$key_default];
                print_r ($key_founded);
                $sql = "UPDATE $this->table SET $col = '$value'  WHERE $key_default = '$key_founded'";
                $sth = $this->db->prepare($sql);
                $sth->execute();
            }

        }

        public function testConnectApi(){
            // $result = '<br>-- api CONNECT [<font color=green>OK</font>]<br>';
            // echo $result;
            return 'TRUE';
        }

        public function prepareInsert($fieldsList,$bindsList){
            $sql = "INSERT INTO $this->table ($fieldsList) VALUES ($bindsList)";
            $result = $this->db->prepare($sql);
            return $result;
        }

        /*  For Tests
            The function will bind params
            nom=>,email=>,... ----> :nom=>,:email=>,:...
        */
        public function getBinds($data){
            $result = array();

            $dataBindsList = $data;
            foreach($dataBindsList as $key => $value){
                $new_key = ':'.$key;
                $dataBindsList = $this->renameKey( $dataBindsList, $key, $new_key );
            }

            $binds = array_keys($dataBindsList); 
            $bindsList = implode(',',$binds); 
            $fields = array_keys($data);
            $fieldsList = implode(',',$fields); 
            array_push($result, $fieldsList, $bindsList);
            return $result;
        }




        /*  For Tests
            The function will populate table with fake values
        */
        public function addFake($data,$doublons){
            try {

                $doublons_value = $doublons['value'];
                $doublons_col = $doublons['col'];

                $fieldsList = $this->getBinds($data)[0];
                $bindsList = $this->getBinds($data)[1];

                print_r('<br>--$fieldsList--<br>');
                echo ($fieldsList);
                print_r('<br>--$bindsList--<br>');
                print_r($bindsList);
                print_r('<br><br>');

                if($doublons_value==true){
                    
                    $sth = $this->prepareInsert($fieldsList,$bindsList);
                    if($sth->execute($data)){
                        $title_result = '<br>-- data INSERT [<font color=green>OK</font>]<br>';
                        print_r($title_result);
                        print_r ($data);
                        print_r('<br><br>');

                    }else{
                        $result = '-- > <font color=red>FAILURE</font>';
                    }

                }else{

                    $doublons_result = $this->searchValue( $doublons_col, $data[$doublons_col] );
                    print_r('<br>--$doublons_result--<br>');
                    print_r ($doublons_result);
                    print_r ( count($doublons_result));
    
                    if(count($doublons_result)>0){
                        $result = $this->update($doublons_col, $data[$doublons_col], $key_default='id');
                        $title_result = '<br>-- data REPLACE [<font color=green>OK</font>]<br><br>';
                        print_r($title_result);
                    }

                }

                $n_results = 16;
                $result = $this->populateToHtml($n_results);

            } catch (Exception $e) {
                $error = '-- ERROR in <font color=red>' . basename(__FILE__) . '</font><br>';
                $result = $error.$e->getMessage();
                return $result;
            }
            
        }



















        /*  For Tests
            The function will populate choosed table with fake values
        */
        public function populate($data,$doublons){
            try {

                $doublons_value = $doublons['value'];
                $doublons_col = $doublons['col'];

                // $dataBindsList = $data;

                // foreach($dataBindsList as $key => $value){
                //     $new_key = ':'.$key;
                //     $dataBindsList = $this->renameKey( $dataBindsList, $key, $new_key );
                // }

                // $binds = array_keys($dataBindsList); 
                // $bindsList = implode(',',$binds); 
                // $fields = array_keys($data);
                // $fieldsList = implode(',',$fields); 

                $fieldsList = $this->getBinds($data)[0];
                $bindsList = $this->getBinds($data)[1];

                print_r('<br>--$fieldsList--<br>');
                echo ($fieldsList);
                print_r('<br>--$bindsList--<br>');
                print_r($bindsList);
                print_r('<br><br>');

                if($doublons_value==true){
                    
                    // $sth = $this->db->prepare("INSERT INTO $this->table ($fieldsList) VALUES ($bindsList)");
                    $sth = $this->prepareInsert($fieldsList,$bindsList);
                    if($sth->execute($data)){
                        $title_result = '<br>-- data INSERT [<font color=green>OK</font>]<br>';
                        print_r($title_result);
                        print_r ($data);
                        print_r('<br><br>');

                    }else{
                        $result = '-- > <font color=red>FAILURE</font>';
                    }

                }else{

                    $doublons_result = $this->searchValue( $doublons_col, $data[$doublons_col] );
                    print_r('<br>--$doublons_result--<br>');
                    print_r ($doublons_result);
                    print_r ( count($doublons_result));
    
                    if(count($doublons_result)>0){
                        $result = $this->update($doublons_col, $data[$doublons_col], $key_default='id');
                        $title_result = '<br>-- data REPLACE [<font color=green>OK</font>]<br><br>';
                        print_r($title_result);
                    }

                }

                $n_results = 16;
                $result = $this->populateToHtml($n_results);

            } catch (Exception $e) {
                $error = '-- ERROR in <font color=red>' . basename(__FILE__) . '</font><br>';
                $result = $error.$e->getMessage();
                return $result;
            }
            
        }




        public function select($n_results=100) {
            $idToDelete=1;
            $sql = "SELECT * FROM $this->table ORDER by id DESC LIMIT 0,$n_results";
            $sth = $this->db->prepare($sql);
            $sth->execute(); 
            $result = $sth->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        }







        /*  For Tests
            Human Html render
        */
        public function populateToHtml($n_results=10) {
            $idToDelete=1;
            $sql = "SELECT * FROM $this->table ORDER by id DESC LIMIT 0,$n_results";
            $sth = $this->db->prepare($sql);
            $sth->execute(); 
            $result = $sth->fetchAll(PDO::FETCH_ASSOC);
            print "<table width='100%'>";
            print "<tr>";
            foreach ($result[0] as $row => $v){
                print "<th style='background-color:grey;'>$row</th>";   
            }
            print "<th style='background-color:grey;' align='center'><font color=red><b>Delete(all)</b></font></th>"; 
            print "</tr>";
            $i = 0;
            foreach ($result as $row){
                $var = ( $i++%2 == 0 ) ? 0 : 1 ;
                $style = "style='background-color:#B0E0E6;'";
                if ( $var == 1 ){$style = "style='background-color:#E0FFFF;'";}
                print "<tr $style>";
                foreach ($row as $key => $val){
                    if($key=='id'){$idToDelete=$val;}
                    print "<td>$val</td>";
                }
                print "<td align='center'><font color=red><b>X</b></font></td>";
                print "</tr>";
            }
            print "</table>";
            echo '[...]';

            echo "<br>";
            echo "<br>";
            echo "<input type='button' value='ADD Fake Entry' onClick='window.location.reload();' style='width:200px'>";
            echo "<br>";
            echo "<br>";

            echo "<input type='button' value='SEARCH' style='width:200px'"; 
            echo " onClick=\"";
            echo " c = document.getElementById('search_select_col');";
            echo " var col = c.options[c.selectedIndex].value;";
            echo " var search = document.getElementById('search_input').value;"; 
            // echo " window.open('../api/".$this->table."/search/'+col+'/'+search+'','_blank');\">";
            echo " window.open('".$this->table."/search/'+col+'/'+search+'','_blank');\">";

            echo "&nbsp;<select id='search_select_col'>";
            foreach ($result[0] as $row => $v){
                $selected = "";
                if($row == "nom"){$selected = " selected";}
                echo "<option $selected>$row</option>";  
            }
            echo "</select>";

            echo "&nbsp;<input id='search_input' type='text' value='Vincseize'>";

            echo "<br>";
            echo "<br>";
            echo "<form action='http://127.0.0.1/_SLIM3VUEJS_STARTER/frontend/public/api/clients/delete/673' target='_blank' method='DELETE' if-match='*' enctype='multipart/form-data'>";
            echo "<input type='button' value='DELETE Entry by id' style='width:200px'"; 
            echo "onClick=\"";
            echo " var id = document.getElementById('delete_input').value;";
            echo " window.open('".$this->table."/delete/'+id+'','_blank');\">";
            // echo " window.open('api/".$this->table."/delete/'+id+'','_blank');\">";
            echo "&nbsp;<input id='delete_input' type='text' value='".$idToDelete."'>";
            echo "<input type='submit' />";
            echo "</form>";

        }

        // /*  The Delete Operation 
        //     The function will delete by id our table
        // */
        public function delete($id){
            $sql = "DELETE FROM $this->table WHERE id = '".$id."'";
            $sth = $this->db->prepare($sql);
            if(!$sth->execute()) {
                return "FALSE";
            }
        }

        // function delete_test(){
        //     $this->$app->delete('/api/{table}/delete/[{id}]', function ($request, $response, $args) {
        //         $result = 0;
        //         $sql = "DELETE FROM ".$args['table']." WHERE id=:id";
        //         $sth = $this->db->prepare($sql);
        //         $sth->bindParam("id", $args['id']);
        //         $sth->execute();
        //         $result = $sth->rowCount();
        //         return $this->response->withJson($result);
        //     });
        // }


        // /*  The Create Operation 
        //     The function will insert a new user in our database
        // */
        // public function createUser($email, $password, $name, $school){
        //    if(!$this->isEmailExist($email)){
        //         $sth = $this->con->prepare("INSERT INTO users (email, password, name, school) VALUES (?, ?, ?, ?)");
        //         $sth->bind_param("ssss", $email, $password, $name, $school);
        //         if($sth->execute()){
        //             return USER_CREATED; 
        //         }else{
        //             return USER_FAILURE;
        //         }
        //    }
        //    return USER_EXISTS; 
        // }

        // /*
        //     The Delete Operation
        //     This function will delete the user from database
        // */
        // public function deleteUser2($id){
        //     $sth = $this->con->prepare("DELETE FROM users WHERE id = ?");
        //     $sth->bind_param("i", $id);
        //     if($sth->execute())
        //         return true; 
        //     return false; 
        // }

        // /* 
        //     The Read Operation 
        //     The function will check if we have the user in database
        //     and the password matches with the given or not 
        //     to authenticate the user accordingly    
        // */
        // public function userLogin($email, $password){
        //     if($this->isEmailExist($email)){
        //         $hashed_password = $this->getUsersPasswordByEmail($email); 
        //         if(password_verify($password, $hashed_password)){
        //             return USER_AUTHENTICATED;
        //         }else{
        //             return USER_PASSWORD_DO_NOT_MATCH; 
        //         }
        //     }else{
        //         return USER_NOT_FOUND; 
        //     }
        // }

        // /*  
        //     The method is returning the password of a given user
        //     to verify the given password is correct or not
        // */
        // private function getUsersPasswordByEmail($email){
        //     $sth = $this->con->prepare("SELECT password FROM users WHERE email = ?");
        //     $sth->bind_param("s", $email);
        //     $sth->execute(); 
        //     $sth->bind_result($password);
        //     $sth->fetch(); 
        //     return $password; 
        // }

        // /*
        //     The Read Operation
        //     Function is returning all the users from database
        // */
        // public function getAllUsers(){
        //     $sth = $this->con->prepare("SELECT id, email, name, school FROM users;");
        //     $sth->execute(); 
        //     $sth->bind_result($id, $email, $name, $school);
        //     $users = array(); 
        //     while($sth->fetch()){ 
        //         $user = array(); 
        //         $user['id'] = $id; 
        //         $user['email']=$email; 
        //         $user['name'] = $name; 
        //         $user['school'] = $school; 
        //         array_push($users, $user);
        //     }             
        //     return $users; 
        // }

        // /*
        //     The Read Operation
        //     This function reads a specified user from database
        // */
        // public function getUserByEmail($email){
        //     $sth = $this->con->prepare("SELECT id, email, name, school FROM users WHERE email = ?");
        //     $sth->bind_param("s", $email);
        //     $sth->execute(); 
        //     $sth->bind_result($id, $email, $name, $school);
        //     $sth->fetch(); 
        //     $user = array(); 
        //     $user['id'] = $id; 
        //     $user['email']=$email; 
        //     $user['name'] = $name; 
        //     $user['school'] = $school; 
        //     return $user; 
        // }


        // /*
        //     The Update Operation
        //     The function will update an existing user
        //     from the database 
        // */
        // public function updateUser($email, $name, $school, $id){
        //     $sth = $this->con->prepare("UPDATE users SET email = ?, name = ?, school = ? WHERE id = ?");
        //     $sth->bind_param("sssi", $email, $name, $school, $id);
        //     if($sth->execute())
        //         return true; 
        //     return false; 
        // }

        // /*
        //     The Update Operation
        //     This function will update the password for a specified user
        // */
        // public function updatePassword($currentpassword, $newpassword, $email){
        //     $hashed_password = $this->getUsersPasswordByEmail($email);
            
        //     if(password_verify($currentpassword, $hashed_password)){
                
        //         $hash_password = password_hash($newpassword, PASSWORD_DEFAULT);
        //         $sth = $this->con->prepare("UPDATE users SET password = ? WHERE email = ?");
        //         $sth->bind_param("ss",$hash_password, $email);
        //         if($sth->execute())
        //             return PASSWORD_CHANGED;
        //         return PASSWORD_NOT_CHANGED;
        //     }else{
        //         return PASSWORD_DO_NOT_MATCH; 
        //     }
        // }

        // /*
        //     The Delete Operation
        //     This function will delete the user from database
        // */
        // public function deleteUser($id){
        //     $sth = $this->con->prepare("DELETE FROM users WHERE id = ?");
        //     $sth->bind_param("i", $id);
        //     if($sth->execute())
        //         return true; 
        //     return false; 
        // }

        // /*
        //     The Read Operation
        //     The function is checking if the user exist in the database or not
        // */
        // private function isEmailExist($email){
        //     $sth = $this->con->prepare("SELECT id FROM users WHERE email = ?");
        //     $sth->bind_param("s", $email);
        //     $sth->execute(); 
        //     $sth->store_result(); 
        //     return $sth->num_rows > 0;  
        // }





        
    }