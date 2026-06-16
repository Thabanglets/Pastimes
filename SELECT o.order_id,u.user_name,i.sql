SELECT o.order_id,u.user_name,i.ItemName,o.order_date,(i.Price*c.quantity) AS Amount,o.order_status from 
tbl_order_item oi 
JOIN tbl_orders o ON oi.order_id = o.order_id 
JOIN tbl_user u ON o.user_id = u.user_id 
JOIN tbl_item i on i.ItemID = oi.product_id 
JOIN tbl_cart c on i.ItemID = c.product_id;


-- //create a role and grant permissions to the role
CREATE ROLE sales_team;
GRANT SELECT, INSERT, UPDATE ON object::sales.orders TO sales_team;
