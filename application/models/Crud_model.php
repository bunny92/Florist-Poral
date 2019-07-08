<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Crud_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function admin_authenticate($credential) {
        $query = $this->db->get_where('users', $credential);
        if ($query->num_rows() > 0) {
            $row = $query->row();
            $data['status'] = 1;
            $data['last_login_time'] = date("Y-m-d h:i:sa");
            $this->update_user_data($data);
            return 'success';
        }
        return 'Invalid Credentials..!';
    }

    public function update_user_data($data) {
        $this->db->where('username', 'admin');
        $this->db->update('users', $data);
    }

    public function updatePassword($old_password, $new_password) {
        $this->db->where('username', 'admin');
        $existing_password = $this->db->get('users')->row()->password;

        if ($existing_password == $old_password) {
            $basic['password'] = $new_password;
            $result = $this->db->update('users', $basic);
            if ($result > 0) {
                return $result;
            } else {
                return 'failed';
            }
        } else {
            return 'mismatch';
        }
    }

    public function addCustomer($basic, $detials) {

        $this->db->insert('customers', $basic);
        $customer_id = $this->db->insert_id();
        if ($customer_id > 0) {
            $detials['customer_id'] = $customer_id;
            $this->db->insert('customer_details', $detials);
            return 'created';
        } else {
            return 'failed';
        }
    }

    public function addGroupCustomer($data) {
        $this->db->insert('customer_group', $data);
        $groupId = $this->db->insert_id();
        if ($groupId > 0) {
            return 'success';
        } else {
            return 'failed';
        }
    }

    public function updateCustomer($basic, $detials, $customerId) {
        $this->db->where('id', $customerId);
        $result = $this->db->update('customers', $basic);
        if ($result > 0) {
            $this->db->where('customer_id', $customerId);
            $response = $this->db->update('customer_details', $detials);
            if ($response > 0) {
                return 'updated';
            } else {
                return 'failed';
            }
        }
    }

    public function checkExistingUser($table, $coloumValue, $coloumName) {
        $this->db->where($coloumName, $coloumValue);
        return $this->db->get($table)->row();
    }

    public function getCustomerEmail($customerId) {
        $this->db->where('customer_id', $customerId);
        return $this->db->get('customer_details')->row()->customer_email;
    }

    public function getCustomerBalance($customerId) {
        $sql = "SELECT  balance_amount as advance FROM `customer_order` WHERE customer_id = $customerId  ORDER BY id DESC LIMIT 1";
        $query = $this->db->query($sql);
        if(isset($query)){
            return $query->row()->advance;
        }
    }

    public function getFlowers() {
        return $this->db->get('flowers')->result();
    }

    public function getCustomers() {
        $sql = "SELECT a.id as customer_id, a.first_name, a.last_name, a.created_at,b.customer_address,b.customer_pincode,b.customer_phone,b.customer_email,b.customer_city FROM customers a 
        LEFT JOIN customer_details b on a.id = b.customer_id
        WHERE a.status = 1 order by a.created_at DESC";
        $query = $this->db->query($sql);
        return $query->result();
    }

    public function getCustomersById($customerId) {
        $sql = "SELECT a.id as customer_id ,a.first_name,a.father_name, a.last_name, a.created_at,b.customer_address,b.customer_pincode,b.customer_phone,b.customer_email,b.customer_city FROM customers a 
        LEFT JOIN customer_details b on a.id = b.customer_id
        WHERE a.status = 1 and a.id =" . $customerId . "";
        $query = $this->db->query($sql);
        return $query->row();
    }

    public function deleteCustomer($customerId) {
        $data['status'] = 0;
        $this->db->where('id', $customerId);
        $result = $this->db->update('customers', $data);
        if ($result > 0) {
            $sql = "UPDATE customer_group SET customer_id = TRIM(BOTH ',' FROM REPLACE(CONCAT(',', customer_id, ','), ',." . $customerId . ",', ',')) WHERE FIND_IN_SET('" . $customerId . "', customer_id)";
            $this->db->query($sql);
            return 'success';
        } else {
            return 'failed';
        }
    }

    public function updateFlower($flowerId, $flowerName) {
        $data['flower_name'] = $flowerName;
        $this->db->where('id', $flowerId);
        $result = $this->db->update('flowers', $data);
        if ($result > 0) {
            return 'success';
        } else {
            return 'failed';
        }
    }

    public function updatePayment($record_id, $balance_payment, $product_price, $paid_amount) {

        $paid = ($paid_amount + $balance_payment);
        $balance = ($product_price - $paid);
        $data['paid_amount'] = $paid;
        $data['balance_amount'] = $balance;

        $this->db->where('id', $record_id);
        $result = $this->db->update('customer_order', $data);
        if ($result > 0) {
            return 'success';
        } else {
            return 'failed';
        }
    }

    public function addFlower($data) {
        $this->db->insert('flowers', $data);
        $customer_id = $this->db->insert_id();
        if ($customer_id > 0) {
            return 'success';
        } else {
            return 'failed';
        }
    }

    public function deleteFlower($flowerId) {
        $sql = "SELECT id FROM `order_details` where flower_id = $flowerId";
        $custId = $this->db->query($sql)->row()->id;
        
        $sql = "SELECT id FROM `supplier_order_details` where flower_id = $flowerId";
        $supId = $this->db->query($sql)->row()->id;
        if( $custId > 0 || $supId > 0){
            return 'existing';
        }else{
            $this->db->where('id', $flowerId);
            $result = $this->db->delete('flowers');
            if ($result > 0) {
                return 'success';
            } else {
                return 'failed';
            }
        }
    }

    public function deleteGroup($groupId) {
        $this->db->where('id', $groupId);
        $result = $this->db->delete('customer_group');
        if ($result > 0) {
            return 'success';
        } else {
            return 'failed';
        }
    }

    public function getCount($table_name) {
        $count = $this->db->get($table_name)->result();
        return count($count);
    }

    public function getCustomerCount() {
        $sql = "SELECT count(id) as customer_count FROM customers where status = 1";
        $query = $this->db->query($sql);
        return $query->row();
    }

    public function getSupplierCount() {
        $sql = "SELECT count(id) as supplier_count FROM suppliers";
        $query = $this->db->query($sql);
        return $query->row();
    }

    public function getStockCount() {
        $sql = "SELECT sum(product_price) as total_price, SUM(paid_amount) as paid_amount, SUM(balance_amount) as balance_amount FROM customer_order";
        $query = $this->db->query($sql);
        return $query->row();
    }

    public function getGroupCustomer() {
        $sql = "SELECT *, (CHAR_LENGTH(customer_id) - CHAR_LENGTH(REPLACE(customer_id, ',', '')) + 1) as count_customers , customer_id FROM customer_group";
        $query = $this->db->query($sql);
        return $query->result();
    }

    public function getCreatedGroup() {
        $sql = "SELECT * FROM customer_group";
        $query = $this->db->query($sql);
        return $query->result();
    }

    public function getGroupCustomerById($groupId) {
        $sql = "SELECT customer_id FROM customer_group where id =" . $groupId;
        $query = $this->db->query($sql);
        $customer_id = $query->row()->customer_id;
        if (isset($customer_id) && !empty($customer_id)) {

            $sql = "SELECT a.id as customer_id, a.first_name, a.last_name, a.created_at,b.customer_address,b.customer_pincode,b.customer_phone,b.customer_email,b.customer_city FROM customers a 
            LEFT JOIN customer_details b on a.id = b.customer_id
            WHERE a.status = 1 and  a.id in (" . $customer_id . ") order by a.created_at DESC";
            $sqlquery = $this->db->query($sql);
            return $sqlquery->result();
        } else {
            return false;
        }
    }

    public function deleteCustomerGroup($customerId, $groupId) {
        $sql = "UPDATE customer_group SET customer_id = TRIM(BOTH ',' FROM REPLACE(CONCAT(',', customer_id, ','), '," . $customerId . ",', ',')) WHERE id='" . $groupId . "' and  FIND_IN_SET('" . $customerId . "', customer_id)";
        $result = $this->db->query($sql);
        if ($result > 0) {
            return 'success';
        } else {
            return 'failed';
        }
    }

    public function updateCustomerGroup($customerId, $groupId) {

        $customerIds = $this->checkDuplicateCustomers($customerId, $groupId);
        if (in_array(NULL, $customerIds, true)) {

            $sql = "update customer_group set customer_id = concat(customer_id, if(length(customer_id)>0,',',''), '" . $customerId . "') where id = " . $groupId . "";
            $result = $this->db->query($sql);
            if ($result > 0) {
                return 'success';
            } else {
                return 'failed';
            }
        } else {
            return 'Duplicate Customers are identified, Remove and update';
        }
    }

    public function checkDuplicateCustomers($customerId, $groupId) {
        $array = explode(',', $customerId);
        foreach ($array as $customerIds) {
            $sql = "SELECT  customer_id  FROM customer_group WHERE id = $groupId and FIND_IN_SET('$customerIds',customer_id)";
            $result[] = $this->db->query($sql)->row();
        }
        return $result;
    }

    public function insertOrder($insertOrder, $customerId, $expenses) {
        foreach ($insertOrder as $value) {
            $flowerId = $value['flower_id'];
            $flower_price = $value['flower_price'];
            $quantity = $value['quantity'];
            $total_price = $value['total_price'];
            $date_at = $value['created_at'];
            $sql = "INSERT INTO order_details(customer_id, flower_id, flower_price, quantity, total_price,created_at) VALUES ($customerId,$flowerId,$flower_price,$quantity,$total_price,'".$date_at."')";
            $this->db->query($sql);
            $orderId[] = $this->db->insert_id();
            
        }
        
        if (!empty($orderId)) {
            $expenses['order_id'] = implode(',', $orderId);
            $expenses['customer_id'] = $customerId;
            $this->db->insert('customer_order', $expenses);
            $record_id = $this->db->insert_id();
            if($record_id > 0) {
                $service = $this->getActivationMessageServices();
                if($service->ind_message == 1){
                 $this->customerMessageDetails($customerId,$record_id);
                }
                return $record_id;
            }
        }
    }

    public function insertGroupOrder($flowerDetails, $customerId, $finalPrice,$laguage_expenses,$created_at) {
        foreach ($flowerDetails as $key => $orders) {
            foreach ($orders as $key => $order) {
                $flowerId = $order['flower_id'];
                $flower_price = $order['flower_price'];
                $quantity = $order['quantity'];
                if ($quantity == null) {
                    return 'empty';
                    exit;
                }elseif ($quantity > 0) {
                    
                    $total_price = ($order['flower_price'] * $order['quantity']);
                    $sql = "INSERT INTO order_details(customer_id, flower_id, flower_price, quantity, total_price,created_at) VALUES ($customerId,$flowerId,$flower_price,$quantity,$total_price,'".$created_at."')";
                    $this->db->query($sql);
                    $orderId[] = $this->db->insert_id();
                }
            }
            $balance = $this->getCustomerBalance($customerId);
            $expenses['order_id'] = implode(',', $orderId);
            $expenses['customer_id'] = $customerId;
            $expenses['luggage_expenses'] = $laguage_expenses;
            $expenses['product_price'] = ($finalPrice + $laguage_expenses);
            $expenses['balance_amount'] = ($balance + $finalPrice + $laguage_expenses);
            $expenses['paid_date'] = $created_at;
            $this->db->insert('customer_order', $expenses);
            $record_id = $this->db->insert_id();

            if ($record_id > 0) {
                
                $service = $this->getActivationMessageServices();
                if($service->ind_message == 1){
                 $this->customerMessageDetails($customerId, $record_id);
                }
                return $record_id;
            } else {
                return 'failed';
            }
        }
        die;
    }
    
    // Edit Order
    
    public function updateOrderQunatity($orderArray, $customer_id, $sum,$record_id){
         $sql = "SELECT  product_price as current_price, luggage_expenses as laug_exp FROM `customer_order` WHERE customer_id = $customer_id and id =$record_id";
            $query = $this->db->query($sql);
            if(isset($query)){
                $cprice =  $query->row()->current_price;
                $lang_price = $query->row()->laug_exp;
                $price = ($cprice - $lang_price);
            }else{
                $price = 0;
            }
         
            
        foreach ($orderArray as $key => $orders) {
            foreach ($orders as $key => $order) {
                $flower_price = $order['flower_price'];
                $quantity = $order['quantity'];
                $order_id =  $order['order_id'];
                if ($quantity == null || $flower_price == null) {
                    return 'empty';
                    exit;
                }elseif ($quantity > 0 && $flower_price > 0) {
                    
                    $total_price = ($order['flower_price'] * $order['quantity']);
                    $sql = "UPDATE `order_details` SET `flower_price`=$flower_price ,`quantity`= $quantity, `total_price` =$total_price WHERE id = $order_id and customer_id= $customer_id";
                    $result = $this->db->query($sql);
                }
            }
        }  
            
            if($sum > $price){
                $newaddedValue = abs($sum - $price);
                $value = ($price + ($newaddedValue + $lang_price));
                $sql = "UPDATE `customer_order` SET `product_price`= $value ,balance_amount = (balance_amount + $newaddedValue) WHERE id = $record_id and customer_id= $customer_id";
                $res = $this->db->query($sql);
                if($res == true){
                  $sql1 = "UPDATE `customer_order` SET balance_amount = (balance_amount + $newaddedValue) WHERE id > $record_id and customer_id= $customer_id";
                  $resul= $this->db->query($sql1);
                  return $resul;
              }else{
                  return false;
              }
               
           }elseif($sum < $price){
               $newaddedValue = abs($price - $sum);
               $value = ($price - $newaddedValue);
               $sql3 = "UPDATE `customer_order` SET `product_price`= ( $value + $lang_price ) ,balance_amount = (balance_amount - $newaddedValue) WHERE id = $record_id and customer_id= $customer_id";
               $res3 = $this->db->query($sql3);
               if($res3 == true){
                   $sql4 = "UPDATE `customer_order` SET balance_amount = (balance_amount - $newaddedValue) WHERE id > $record_id and customer_id= $customer_id";
                   $resul4= $this->db->query($sql4);
                   return $resul4;
               }else{
                   return false;
               }  
           }
        }

    public function updateSupplierOrderQunatity($orderArray, $supplier_id, $sum,$record_id){
        
         
        $total = 0;
        foreach ($orderArray as $key => $orders) {
          
            foreach ($orders as $key => $order) {
                $flower_price = $order['flower_price'];
                $quantity = $order['quantity'];
                $order_id =  $order['order_id'];
                if ($quantity == null || $flower_price == null) {
                    return 'empty';
                    exit;
                }elseif ($quantity > 0 && $flower_price > 0) {
                    
                    $total_price = ($order['flower_price'] * $order['quantity']);
                    $total += ($order['flower_price'] * $order['quantity']);
                    // $sql = "UPDATE `supplier_order_details` SET `flower_price`=$flower_price ,`quantity`= $quantity, `total_price` =$total_price WHERE id = $order_id and supplier_id = $supplier_id";
                    // $result = $this->db->query($sql);
                }
            }
        } 
        
         $sql = "SELECT  product_price as current_price,commission as comm FROM `supplier_order` WHERE supplier_id = $supplier_id and id =$record_id";
            $query = $this->db->query($sql);
            if(isset($query)){
                $price =  $query->row()->current_price;
                $comm =   $query->row()->comm;
                if($price > 0) {
                  $comprice = (($comm / $price) * 100);
                }else{
                  $comprice = (($comm / $total) * 100);
                }
            }else{
                $price = 0; 
                $comprice = 0;
            }
            
             if($price > 0) {
                if($sum > $price){
                    $newaddedValue = abs($sum - $price);
                    $value = ($price + $newaddedValue);
                    $commission = (($comprice / 100) * $value);
                    $sql = "UPDATE `supplier_order` SET `product_price`= $value, `commission`= $commission  WHERE id = $record_id and supplier_id = $supplier_id";
                    $res = $this->db->query($sql);
                   
               }elseif($sum < $price){
                   $newaddedValue = abs($price - $sum);
                   $value = ($price - $newaddedValue);
                   $commission = (($comprice / 100) * $value);
                   $sql3 = "UPDATE `supplier_order` SET `product_price`=  $value,`commission` = $commission WHERE id = $record_id and supplier_id = $supplier_id";
                   $res3 = $this->db->query($sql3);
               }
             }else{
                
                    $commission = (($comprice / 100) * $total);
                    // $sql = "UPDATE `supplier_order` SET `product_price`= 0, `commission`= $commission  WHERE id = $record_id and supplier_id = $supplier_id";
                    // $res = $this->db->query($sql);
                    echo $commission;
                    echo '<br/>';
                    echo $comprice;
                    echo '<br/>';
                    echo $total;
                    die;
             }
        }
        
   public function insertSupplierGroupOrder($flowerDetails, $supplierId, $finalPrice, $commission,$created_at) {

    foreach ($flowerDetails as $key => $orders) {
        foreach ($orders as $key => $order) {
            $flowerId = $order['flower_id'];
            $flower_price = $order['flower_price'];
            $quantity = $order['quantity'];
            if ($quantity == null || !isset($quantity)) {
                return 'empty';
                if ($flower_price == null || !isset($flower_price)) {
                    return 'empty';
                }
                exit;
            } else {
                $total_price = ($order['flower_price'] * $order['quantity']);
                $sql = "INSERT INTO supplier_order_details(supplier_id, flower_id, flower_price, quantity, total_price,created_at) VALUES ($supplierId,$flowerId,$flower_price,$quantity,$total_price,'".$created_at."')";
                $this->db->query($sql);
                $orderId[] = $this->db->insert_id();
            }
        }
    }
    $com_price = (($commission / 100) * $finalPrice);
    $expenses['order_id'] = implode(',', $orderId);
    $expenses['supplier_id'] = $supplierId;
    $expenses['product_price'] = $finalPrice;
    $expenses['commission'] = $com_price;
    $expenses['created_at'] = $created_at;
    $this->db->insert('supplier_order', $expenses);
    $record_id = $this->db->insert_id();

    if ($record_id > 0) {
                $service = $this->getActivationMessageServices();
                if($service->ind_message == 1){
                 $this->suplierMessageDetails($supplierId,$record_id);
                }
        
        return $record_id;
    } else {
        return 'failed';
    }
    die;
}

public function getSupplierDefaultPrices($eventDate, $supplierId){
   $sql = "SELECT supplier_flowers,supplier_advance FROM suppliers where id =" . $supplierId;
   $query = $this->db->query($sql);
   $flower_id = $query->row()->supplier_flowers;

   $sql = "SELECT a.id as flower_id, a.flower_name from flowers a WHERE  a.id in (" . $flower_id . ")";
   $sqlquery = $this->db->query($sql);

   $flower_details = $this->getRecentSupplierPriceByDate($eventDate);
   $json_1 = json_decode($flower_details->flower_price);
   $json_2 = $json_1->flowers_details;


   $flowerArray = array();
   $i = 0;
   foreach ($json_2 as $key => $value) {
    $flowerArray['flowers_details'][$i]['flower_id'] = $value->flower_id;
    $flowerArray['flowers_details'][$i]['flower_price'] = $value->flower_price;
    $flowerArray['flowers_details'][$i]['flower_name'] = $value->flower_name;
    $i++;
}
$supplierArray = $sqlquery->result();
$userArray = $flowerArray['flowers_details'];
$data['advance'] = $query->row()->supplier_advance;
$data['a1'] = array_column($userArray, null, "flower_id");
$data['a2'] = array_column($supplierArray, null, "flower_id");
return $data;
} 

function getRecentSupplierPriceByDate($eventDate) {
    $query = "SELECT id as event_id,flower_price, start_date, end_date FROM `supplier_event` where ('" . $eventDate . "' BETWEEN date(start_date) AND date(end_date)) ORDER BY start_date DESC limit 1;";
    $qry = $this->db->query($query)->row();
    return $qry;
}

public function getOrderCustomer() {
    $sql = "SELECT a.*,b.*,c.*,b.id as record_id FROM  customer_order b
    LEFT JOIN customers a on a.id = b.customer_id
    LEFT JOIN customer_details c on a.id = c.customer_id where a.status = 1 order by b.id DESC";
    $query = $this->db->query($sql);
    return $query->result();
}

public function getOrderCustomerById($record_id) {
    $sql = "SELECT a.*,b.*,c.*,b.id as record_id FROM  customer_order b
    LEFT JOIN customers a on a.id = b.customer_id
    LEFT JOIN customer_details c on a.id = c.customer_id where a.status = 1 and b.id= $record_id order by b.id DESC";
    return $this->db->query($sql)->row();
}

public function viewOrdersById($recordId) {
    $sql = "select order_id from customer_order where id =$recordId";
    $orderId = $this->db->query($sql)->row()->order_id;
    $array = explode(',', $orderId);
    foreach ($array as $orderIds) {
        $sql1 = "SELECT  a.*, b.flower_name  FROM order_details a
        LEFT JOIN flowers b on b.id = a.flower_id
        WHERE FIND_IN_SET($orderIds,a.id)";
        $result[] = $this->db->query($sql1)->result();
    }
    return $result;
}

public function viewCustomerBillingReport($fromDate, $toDate, $customerId) {
   
    $result['customer_details'] = $this->getCustomersById($customerId);
    $result['customer_balance'] = $this->getCustomerBalance($customerId);
    $sql = "SELECT b.*,b.id as record_id FROM  customer_order b where (date(b.paid_date)  BETWEEN '" . $fromDate . "' and '" . $toDate . "') and b.customer_id = $customerId order by b.id DESC";
    $result['customer_order'] = $this->db->query($sql)->result();
    foreach ($result['customer_order'] as $value) {
        if(isset($value->order_id)){
        $array = explode(',', $value->order_id);
        foreach ($array as $orderIds) {
            $sql1 = "SELECT  a.*, b.flower_name  FROM order_details a
            LEFT JOIN flowers b on b.id = a.flower_id
            WHERE FIND_IN_SET($orderIds,a.id) and a.total_price != 0";
            $result['order_details'][] = $this->db->query($sql1)->result();
        }
      }
    }
    echo json_encode ($result);
    die;
}

public function viewSupplierBillingReport($fromDate, $toDate, $supplierId) {
    $result['supplier_details'] = $this->getSupplierById($supplierId);
    $sql = "SELECT b.*,b.id as record_id FROM  supplier_order b where (date(b.created_at)  BETWEEN '" . $fromDate . "' and '" . $toDate . "') and b.supplier_id = $supplierId order by b.created_at DESC";
    $result['supplier_order'] = $this->db->query($sql)->result();
    foreach ($result['supplier_order'] as $value) {
        $array = explode(',', $value->order_id);
        foreach ($array as $orderIds) {
            $sql1 = "SELECT  a.*, b.flower_name  FROM supplier_order_details a
            LEFT JOIN flowers b on b.id = a.flower_id
            WHERE FIND_IN_SET($orderIds,a.id) and a.total_price != 0";
            $result['order_details'][] = $this->db->query($sql1)->result();
        }
    }
    return $result;
}

public function viewCustomerOrders($recordId) {
    $query = "select * from customer_order where id =$recordId";
    $result = $this->db->query($query)->row();
    return $result;
}

public function addSupplier($detials) {
    $this->db->insert('suppliers', $detials);
    $customer_id = $this->db->insert_id();
    if ($customer_id > 0) {
        return 'created';
    } else {
        return 'failed';
    }
}

public function updateSupplier($supplier_Id, $data) {
    $this->db->where('id', $supplier_Id);
    $supplierId = $this->db->update('suppliers', $data);
    if ($supplierId > 0) {
        return 'updated';
    } else {
        return 'failed';
    }
}

public function getSupplier() {
    $sql = "SELECT * FROM suppliers";
    $query = $this->db->query($sql);
    return $query->result();
}

public function getSupplierById($supplierId) {
    $sql = "SELECT * FROM suppliers where id = $supplierId";
    $query = $this->db->query($sql);
    return $query->row();
}

public function getGroupSupplier() {
    $sql = "SELECT *, (CHAR_LENGTH(supplier_id) - CHAR_LENGTH(REPLACE(supplier_id, ',', '')) + 1) as count_supplier,supplier_id FROM supplier_group";
    $query = $this->db->query($sql);
    return $query->result();
}

public function getSupplierCreatedGroup() {
    $sql = "SELECT * FROM supplier_group";
    $query = $this->db->query($sql);
    return $query->result();
}

public function getGroupSupplierById($groupId) {
    $sql = "SELECT supplier_id FROM supplier_group where id =" . $groupId;
    $query = $this->db->query($sql);
    $supplier_id = $query->row()->supplier_id;
    if (isset($supplier_id) && !empty($supplier_id)) {
        $sql = "SELECT a.*,a.id as supplier_id FROM suppliers a WHERE a.id in (" . $supplier_id . ") order by a.created_at DESC";
        $sqlquery = $this->db->query($sql);
        return $sqlquery->result();
    } else {
        return false;
    }
}

public function deleteSupplierGroup($supplierId, $group_id) {
    $sql = "UPDATE supplier_group SET supplier_id = TRIM(BOTH ',' FROM REPLACE(CONCAT(',', supplier_id, ','), '," . $supplierId . ",', ',')) WHERE id='" . $group_id . "' and FIND_IN_SET('" . $supplierId . "', supplier_id)";
    $result = $this->db->query($sql);
    if ($result > 0) {
        return 'success';
    } else {
        return 'failed';
    }
}

public function deleteGroupSupplier($groupId) {
    $this->db->where('id', $groupId);
    $result = $this->db->delete('supplier_group');
    if ($result > 0) {
        return 'success';
    } else {
        return 'failed';
    }
}

public function addGroupSupplier($data) {
    $this->db->insert('supplier_group', $data);
    $groupId = $this->db->insert_id();
    if ($groupId > 0) {
        return 'success';
    } else {
        return 'failed';
    }
}

public function updateSupplierGroup($supplierId, $groupId) {

    $supplierIds = $this->checkDuplicateSuppliers($supplierId, $groupId);
    if (in_array(NULL, $supplierIds, true)) {

        $sql = "update supplier_group set supplier_id = concat(supplier_id, if(length(supplier_id)>0,',',''), '" . $supplierId . "') where id = " . $groupId . "";
        $result = $this->db->query($sql);
        if ($result > 0) {
            return 'success';
        } else {
            return 'failed';
        }
    } else {
        return 'Duplicate Suppliers are identified, Remove and update';
    }
}

public function checkDuplicateSuppliers($supplierId, $groupId) {
    $array = explode(',', $supplierId);
    foreach ($array as $supplierIds) {
        $sql = "SELECT  supplier_id  FROM supplier_group WHERE id = $groupId and FIND_IN_SET('$supplierIds',supplier_id)";
        $result[] = $this->db->query($sql)->row();
    }
    return $result;
}

public function getSupplierOrders() {
    $sql = "SELECT b.*,a.id as record_id, a.product_price, a.commission,a.created_at as suplier_date FROM supplier_order a
    LEft join suppliers b on b.id = a.supplier_id order by a.created_at DESC";
    $query = $this->db->query($sql);
    return $query->result();
}

public function getSupplierAdvance($supplierId) {
    $sql = "SELECT supplier_advance FROM suppliers where id =" . $supplierId;
    $query = $this->db->query($sql);
    return $query->row()->supplier_advance;
}

public function getSupplierFlowers($supplierId) {
    $sql = "SELECT supplier_flowers,supplier_advance FROM suppliers where id =" . $supplierId;
    $query = $this->db->query($sql);
    $flower_id = $query->row()->supplier_flowers;

    $sql = "SELECT a.id as flower_id, a.flower_name from flowers a WHERE  a.id in (" . $flower_id . ")";
    $sqlquery = $this->db->query($sql);

    $flower_details = $this->getRecentSupplierPricelist();
    $json_1 = json_decode($flower_details->flower_price);
    $json_2 = $json_1->flowers_details;


    $flowerArray = array();
    $i = 0;
    foreach ($json_2 as $key => $value) {
        $flowerArray['flowers_details'][$i]['flower_id'] = $value->flower_id;
        $flowerArray['flowers_details'][$i]['flower_price'] = $value->flower_price;
        $flowerArray['flowers_details'][$i]['flower_name'] = $value->flower_name;
        $i++;
    }
    $supplierArray = $sqlquery->result();
    $userArray = $flowerArray['flowers_details'];
    $data['advance'] = $query->row()->supplier_advance;
    $data['a1'] = array_column($userArray, null, "flower_id");
    $data['a2'] = array_column($supplierArray, null, "flower_id");
    return $data;
}

public function updateAdvance($supplierId, $advance) {
    
    $sql1 = "UPDATE `suppliers` SET `supplier_advance`= supplier_advance + $advance WHERE id = $supplierId";
    $result = $this->db->query($sql1);
        // $data['supplier_advance'] = $advance;
        // $this->db->where('id', $supplierId);
        // $result = $this->db->update('suppliers', $data);
    if ($result > 0) {
        return 'updated';
    } else {
        return 'failed';
    }
}

public function deleteSupplier($supplierId) {
    $this->db->where('id', $supplierId);
    $result = $this->db->delete('suppliers');
    if ($result > 0) {
        return 'success';
    } else {
        return 'failed';
    }
}

//    Start Supplier Flower Prices

public function insertSupplierPrice($supplierArray) {
    $flag = 0;
    foreach ($supplierArray as $key => $details) {
        foreach ($details as $key => $data) {
            $flower_price = $data['flower_price'];
            if ($flower_price == null || !isset($flower_price)) {
                $flag = 1;
            }
        }
    }

    if ($flag == 1) {
        return 'empty';
    } elseif ($flag == 0) {
        $query = "SELECT id FROM `supplier_event` WHERE end_date = '0000-00-00 00:00:00'";
        $qry = $this->db->query($query);
        $event_Id = $qry->row();
        if (isset($event_Id)) {
            $event['end_date'] = date('Y-m-d H:i:s');
            $event['class'] = 'event-warning';
            $this->db->where('id', $event_Id->id);
            $this->db->update('supplier_event', $event);
        }

        $flower_details = json_encode($supplierArray);
        $sql = "INSERT INTO supplier_event(flower_price, class) VALUES ('" . $flower_details . "','event-success')";
        $this->db->query($sql);
        $eventId = $this->db->insert_id();
        if ($eventId > 0) {
             $service = $this->getActivationMessageServices();
                if($service->group_message == 1){
                 $this->sendSupplierFlowerPrices();
                }
           
            return 'success';
        } else {
            return 'failed';
        }
    } else {
        return 'failed';
    }
}

public function updateSupplierPrice($flowerArray, $eventId) {
    $flag = 0;
    foreach ($flowerArray as $key => $details) {
        foreach ($details as $key => $data) {
            $flower_price = $data['flower_price'];
            if ($flower_price == null || !isset($flower_price)) {
                $flag = 1;
            }
        }
    }

    if ($flag == 1) {
        return 'empty';
    } elseif ($flag == 0) {
        if (isset($eventId)) {
            $event['flower_price'] = json_encode($flowerArray);
            $event['start_date'] = date('Y-m-d H:i:s');
            $this->db->where('id', $eventId);
            $updateId = $this->db->update('supplier_event', $event);
            if ($updateId > 0) {
                return 'success';
            } else {
                return 'failed';
            }
        } else {
            return 'failed';
        }
    }
}

function getSupplierPricelist() {
    $query = "SELECT flower_price, start_date, end_date FROM `supplier_event` ORDER BY start_date DESC;";
    $qry = $this->db->query($query)->result();
    return $qry;
}

function getRecentSupplierPricelist() {
    $query = "SELECT id as event_id,flower_price, start_date, end_date FROM `supplier_event` ORDER BY start_date DESC limit 1;";
    $qry = $this->db->query($query)->row();
    return $qry;
}

//    End Supplier Flower Prices
//    Start Customer Flower Prices

public function insertCustomerPrice($supplierArray) {
    $flag = 0;
    foreach ($supplierArray as $key => $details) {
        foreach ($details as $key => $data) {
            $flower_price = $data['flower_price'];
            if ($flower_price == null || !isset($flower_price)) {
                $flag = 1;
            }
        }
    }

    if ($flag == 1) {
        return 'empty';
    } elseif ($flag == 0) {
        $query = "SELECT id FROM `customer_event` WHERE end_date = '0000-00-00 00:00:00'";
        $qry = $this->db->query($query);
        $event_Id = $qry->row();
        if (isset($event_Id)) {
            $event['end_date'] = date('Y-m-d H:i:s');
            $event['class'] = 'event-warning';
            $this->db->where('id', $event_Id->id);
            $this->db->update('customer_event', $event);
        }

        $flower_details = json_encode($supplierArray);
        $sql = "INSERT INTO customer_event(flower_price, class) VALUES ('" . $flower_details . "','event-success')";
        $this->db->query($sql);
        $eventId = $this->db->insert_id();
        if ($eventId > 0) {
            return 'success';
        } else {
            return 'failed';
        }
    } else {
        return 'failed';
    }
}

public function updateCustomerPrice($flowerArray, $eventId) {
    $flag = 0;
    foreach ($flowerArray as $key => $details) {
        foreach ($details as $key => $data) {
            $flower_price = $data['flower_price'];
            if ($flower_price == null || !isset($flower_price)) {
                $flag = 1;
            }
        }
    }

    if ($flag == 1) {
        return 'empty';
    } elseif ($flag == 0) {
        if (isset($eventId)) {
            $event['flower_price'] = json_encode($flowerArray);
            $event['start_date'] = date('Y-m-d H:i:s');
            $this->db->where('id', $eventId);
            $updateId = $this->db->update('customer_event', $event);
            if ($updateId > 0) {
                return 'success';
            } else {
                return 'failed';
            }
        } else {
            return 'failed';
        }
    }
}

function getCustomerPricelist() {
    $query = "SELECT flower_price, start_date, end_date FROM `customer_event` ORDER BY start_date DESC;";
    $qry = $this->db->query($query)->result();
    return $qry;
}

function getRecentCustomerPricelist() {
    $query = "SELECT id as event_id,flower_price, start_date, end_date FROM `customer_event` ORDER BY start_date DESC limit 1";
    $qry = $this->db->query($query)->row();
    return $qry;
}

//    End Customer Flower Prices  

public function insertSupplierBilling($flowerDetails, $supplierId, $final_price, $commission, $supplier_advance,$created_at) {
    foreach ($flowerDetails as $key => $orders) {
        foreach ($orders as $key => $order) {
            $flowerId = $order['flower_id'];
            $flower_price = $order['flower_price'];
            $quantity = $order['quantity'];
            if ($quantity == null || !isset($quantity)) {
                return 'empty';
                if ($flower_price == null || !isset($flower_price)) {
                    return 'empty';
                }
                exit;
            } else {
                $total_price = ($order['flower_price'] * $order['quantity']);
                $sql = "INSERT INTO supplier_order_details(supplier_id, flower_id, flower_price, quantity, total_price, created_at) VALUES ($supplierId,$flowerId,$flower_price,$quantity,$total_price,'".$created_at."')";
                $this->db->query($sql);
                $orderId[] = $this->db->insert_id();
            }
        }
    }
    $expenses['order_id'] = implode(',', $orderId);
    $expenses['supplier_id'] = $supplierId;
    $expenses['product_price'] = $final_price;
    $expenses['commission'] = $commission;
    $expenses['created_at'] = $created_at;
    $this->db->insert('supplier_order', $expenses);
    $record_id = $this->db->insert_id();
//Start update adavance

    $sql1 = "UPDATE `suppliers` SET `supplier_advance`= $supplier_advance WHERE id = $supplierId";
    $this->db->query($sql1);

//End update advance
    if ($record_id > 0) {
         $service = $this->getActivationMessageServices();
                if($service->ind_message == 1){
                 $this->suplierMessageDetails($supplierId,$record_id);
                }
        return $record_id;
    } else {
        return 'failed';
    }
    die;
}

public function viewSupplierBillingById($recordId) {
    $sql = "select order_id from supplier_order where id =$recordId";
    $orderId = $this->db->query($sql)->row()->order_id;
    $array = explode(',', $orderId);
    foreach ($array as $orderIds) {
        $sql1 = "SELECT  a.*, b.flower_name  FROM supplier_order_details a
        LEFT JOIN flowers b on b.id = a.flower_id
        WHERE FIND_IN_SET($orderIds,a.id)";
        $result[] = $this->db->query($sql1)->result();
    }
    return $result;
}

public function getOrderSupplierById($record_id) {
    $sql = "SELECT a.*,b.*,b.id as record_id,b.commission,b.product_price FROM  supplier_order b
    LEFT JOIN suppliers a on a.id = b.supplier_id where b.id= $record_id order by b.created_at DESC";
    return $this->db->query($sql)->row();
}

public function getCustomerFlowers() {

    $sql = "SELECT a.id as flower_id, a.flower_name from flowers a";
    $sqlquery = $this->db->query($sql);

    $flower_details = $this->getRecentCustomerPricelist();
    if (isset($flower_details)) {
        $json_1 = json_decode($flower_details->flower_price);
        $json_2 = $json_1->flowers_details;
        $flowerArray = array();
        $i = 0;
        foreach ($json_2 as $key => $value) {
            $flowerArray['flowers_details'][$i]['flower_id'] = $value->flower_id;
            $flowerArray['flowers_details'][$i]['flower_price'] = $value->flower_price;
            $flowerArray['flowers_details'][$i]['flower_name'] = $value->flower_name;
            $i++;
        }
        $supplierArray = $sqlquery->result();
        $userArray = $flowerArray['flowers_details'];
        $data['a1'] = array_column($userArray, null, "flower_id");
        $data['a2'] = array_column($supplierArray, null, "flower_id");
    } else {
        $data = NULL;
    }
    return $data;
}

public function getDefaultGroupFlowers() {

    $sql = "SELECT a.id as flower_id, a.flower_name from flowers a";
    $sqlquery = $this->db->query($sql);

    $flower_details = $this->getRecentSupplierPricelist();
    if (isset($flower_details)) {
        $json_1 = json_decode($flower_details->flower_price);
        $json_2 = $json_1->flowers_details;
        $flowerArray = array();
        $i = 0;
        foreach ($json_2 as $key => $value) {
            $flowerArray['flowers_details'][$i]['flower_id'] = $value->flower_id;
            $flowerArray['flowers_details'][$i]['flower_price'] = $value->flower_price;
            $flowerArray['flowers_details'][$i]['flower_name'] = $value->flower_name;
            $i++;
        }
        $supplierArray = $sqlquery->result();
        $userArray = $flowerArray['flowers_details'];
        $data['a1'] = array_column($userArray, null, "flower_id");
        $data['a2'] = array_column($supplierArray, null, "flower_id");
    } else {
        $data = NULL;
    }
    return $data;
}

public function getSupplierDateGroupFlowers($event_date) {

    $sql = "SELECT a.id as flower_id, a.flower_name from flowers a";
    $sqlquery = $this->db->query($sql);

    $flower_details = $this->getDateSupplierPricelist($event_date);
    if (isset($flower_details)) {
        $json_1 = json_decode($flower_details->flower_price);
        $json_2 = $json_1->flowers_details;
        $flowerArray = array();
        $i = 0;
        foreach ($json_2 as $key => $value) {
            $flowerArray['flowers_details'][$i]['flower_id'] = $value->flower_id;
            $flowerArray['flowers_details'][$i]['flower_price'] = $value->flower_price;
            $flowerArray['flowers_details'][$i]['flower_name'] = $value->flower_name;
            $i++;
        }
        $supplierArray = $sqlquery->result();
        $userArray = $flowerArray['flowers_details'];
        $data['a1'] = array_column($userArray, null, "flower_id");
        $data['a2'] = array_column($supplierArray, null, "flower_id");
    } else {
        $data = NULL;
    }
    return $data;
}

function getDateSupplierPricelist($event_date) {
    $query = "SELECT id as event_id,flower_price, start_date, end_date FROM `supplier_event` WHERE ('" . $event_date . "' BETWEEN date(start_date) AND date(end_date))";
    $qry = $this->db->query($query)->row();
    return $qry;
}

public function getDatePriceFlowers($event_date) {

    $sql = "SELECT a.id as flower_id, a.flower_name from flowers a";
    $sqlquery = $this->db->query($sql);

    $flower_details = $this->getCustomerDatePricelist($event_date);
    if (isset($flower_details)) {
        $json_1 = json_decode($flower_details->flower_price);
        $json_2 = $json_1->flowers_details;
        $flowerArray = array();
        $i = 0;
        foreach ($json_2 as $key => $value) {
            $flowerArray['flowers_details'][$i]['flower_id'] = $value->flower_id;
            $flowerArray['flowers_details'][$i]['flower_price'] = $value->flower_price;
            $flowerArray['flowers_details'][$i]['flower_name'] = $value->flower_name;
            $i++;
        }
        $supplierArray = $sqlquery->result();
        $userArray = $flowerArray['flowers_details'];
        $data['a1'] = array_column($userArray, null, "flower_id");
        $data['a2'] = array_column($supplierArray, null, "flower_id");
    } else {
        $data = NULL;
    }
    return $data;
}

function getCustomerDatePricelist($event_date) {
    $query = "SELECT id as event_id,flower_price, start_date, end_date FROM `customer_event` WHERE ('" . $event_date . "' BETWEEN date(start_date) AND date(end_date))";
    $qry = $this->db->query($query)->row();
    return $qry;
}


public function getDefaultDetails($event_date) {
    $sql = "SELECT * FROM `customer_event` WHERE ('" . $event_date . "' BETWEEN date(start_date) AND date(end_date))";
    $data['customer_event'] = $this->db->query($sql)->row();

    $sql = "SELECT * FROM `supplier_event` WHERE ('" . $event_date . "' BETWEEN date(start_date) AND date(end_date))";
    $data['supplier_event'] = $this->db->query($sql)->row();
    
    $sql ="select * from flowers";
    $data['flowers'] = $this->db->query($sql)->result();
    return $data;
    
}

public function exe_cronjob(){
    $sql="update customer_event 
    set end_date= now()
    where start_date < date_sub(now(),interval 24 hour) ORDER BY id DESC
    LIMIT 1";
    $data['customer'] = $this->db->query($sql);
    
    $sql1="update supplier_event 
    set end_date= now()
    where start_date < date_sub(now(),interval 24 hour) ORDER BY id DESC
    LIMIT 1";
    $data['supplier'] = $this->db->query($sql1);
    return $data;
}

public function customerMessageDetails($customer_id, $record_id){
     $orders = $this->viewOrdersById($record_id);
     $balance = $this->getCustomerBalance($customer_id);
     
                        $message = '%0a Date: '.date("Y-m-d");
                        $message .= '%0a -------------------- %0a';
                        foreach ($orders as $flowers) {
                            foreach ($flowers as $flower) {
                                  
                                   $message .= '%0a '.$flower->flower_name;
                                   $message .= ', %0a Price: '. $flower->flower_price .' x Quantity: '. $flower->quantity;
                                   $message .= ', %0a Total Cost: ' .$flower->total_price.'. %0a';
                                  
                            }
                        }
                        $message .= '%0a Balance:' .$balance;
                    
     $sql ="select customer_phone as mobile from customer_details where customer_id  = $customer_id";
     $query = $this->db->query($sql);
     $mobile = $query->row()->mobile;
     $this->sendMessage($message, $mobile);
}

public function suplierMessageDetails($supplierId, $record_id){
    $supplier_details = $this->getSupplierById($supplierId);
    $sql = "SELECT b.*,b.id as record_id FROM  supplier_order b where b.supplier_id = $supplierId and id = $record_id";
    $result['supplier_order'] = $this->db->query($sql)->result();
    foreach ($result['supplier_order'] as $value) {
        $array = explode(',', $value->order_id);
        foreach ($array as $orderIds) {
            $sql1 = "SELECT  a.*, b.flower_name  FROM supplier_order_details a
            LEFT JOIN flowers b on b.id = a.flower_id
            WHERE FIND_IN_SET($orderIds,a.id) and a.total_price != 0";
            $result['order_details'][] = $this->db->query($sql1)->result();
        }
    }
 
                         $message = '%0a Date: '.date("Y-m-d");
                         $message .= '%0a -------------------- %0a';
                           foreach ($result['order_details'] as $flowers) {
                                foreach ($flowers as $flower) {
                                    //  $message .=  'Date:'.date("Y-m-d",strtotime($flower->created_at)).'%0a';
                                     $message .=  '%0a '. $flower->flower_name;
                                     $message .=  ', %0a Price: ' .$flower->flower_price.'X Quantity: '.$flower->quantity;
                                     $message .=  ', %0a Total Cost: ' .$flower->total_price.'. %0a';
                                }
                              }
                        $message .= '%0a Advance: ' .$supplier_details->supplier_advance;
                        $mobile = $supplier_details->supplier_phone;
                        $this->sendMessage($message, $mobile);
                        // echo $message;
}

public function sendSupplierFlowerPrices(){
       
    $sql = "select supplier_flowers,supplier_phone from suppliers";
    $flowerId = $this->db->query($sql)->result();
    foreach($flowerId as $flowerIds){
          $array[] = array('mobile'=> $flowerIds->supplier_phone,'flower_id'=>explode(',', $flowerIds->supplier_flowers));
    }

   
     $query = "SELECT flower_price FROM `supplier_event` ORDER BY start_date DESC limit 1;";
     $data = $this->db->query($query)->row();
     $character = json_decode(json_encode($data),true);
     $jsonobj = $character['flower_price'];
     $char = json_decode(json_encode($jsonobj),true);
     $char2= json_decode($char,true);
    
     foreach($char2['flowers_details'] as $flowers){
          foreach($array as $flowersd){
            if (in_array($flowers['flower_id'], $flowersd['flower_id'])){
                if($flowers['flower_price'] > 0) {
                     $details[$flowersd['mobile']][] =  array('flower_name'=>$flowers['flower_name'],'flower_price'=>$flowers['flower_price']);
                }
            }
        }
      }
      
    
      foreach($details as $mobile => $flower){
          $message = 'Flower and Prices';
          $message .= '%0a -------------------- %0a';
           foreach($flower as $flowers){
               $message .= $flowers['flower_name']. ' = '. $flowers['flower_price'].'%0a';
            }
            $this->sendMessage($message, $mobile);
      }
}

public function sendMessage($message, $mobile) {
       
        
        // $mobile = "8008118199,7799124499";
        $curl = curl_init();
        $url = 'http://api.msg91.com/api/sendhttp.php?route=4&sender=TESTIN&mobiles='.$mobile.'&authkey=271246Axjf2vobBMmW5ca979c9&message='.$message.'&country=91';
        curl_setopt_array($curl, array(
          CURLOPT_URL => $url,
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 30,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "GET",
          CURLOPT_SSL_VERIFYHOST => 0,
          CURLOPT_SSL_VERIFYPEER => 0,
      ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

    //     if ($err) {
    //       echo "cURL Error #:" . $err;
    //   } else {
    //       echo $response;
    //   }
  }
  
  public function getActivationMessageServices() {
        $query = "SELECT * FROM message_services";
        $data = $this->db->query($query)->row();
        return $data;
  }
  
  public function updateActionMessageServices($data) {
      return $this->db->where('id', 1)->update('message_services', $data);
  }

}
