# imscode initial commit

###Queries to be updated
```sql

CREATE TABLE shippment_method (
  shipment_method_id   INT          NOT NULL PRIMARY KEY AUTO_INCREMENT,
  shipment_method_name VARCHAR(255) NOT NULL,
  created_date         DATETIME     NOT NULL                    DEFAULT current_timestamp
);

INSERT INTO shippment_method VALUES (1,'Fedex',CURRENT_TIMESTAMP);
INSERT INTO shippment_method VALUES (2,'Speed Post',CURRENT_TIMESTAMP);
INSERT INTO shippment_method VALUES (3,'Shipping',CURRENT_TIMESTAMP);

ALTER TABLE order ADD order_weight DECIMAL(10,4) after order_status_id;

```
