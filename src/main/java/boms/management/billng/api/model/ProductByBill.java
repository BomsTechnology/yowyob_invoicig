package boms.management.billng.api.model;

import org.springframework.data.annotation.Id;
import org.springframework.data.cassandra.core.mapping.PrimaryKey;
import org.springframework.data.cassandra.core.mapping.Table;

import lombok.AllArgsConstructor;
import lombok.Data;
import lombok.NoArgsConstructor;

@Data
@NoArgsConstructor
@AllArgsConstructor
@Table("product_by_bill")
public class ProductByBill {
	@Id
	@PrimaryKey
	ProductByBillKey key;
	
	private String name;
	private int price;
	private int quantity;
	private int amount;

}
