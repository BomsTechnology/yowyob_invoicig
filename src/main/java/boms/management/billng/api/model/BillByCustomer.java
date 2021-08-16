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
@Table("bill_by_customer")
public class BillByCustomer{
	
	@Id
	@PrimaryKey
	private BillbyCustomerKey key;
	
	private String date;
	private float amount;
	private float tva;
	private boolean state_payment;
	private boolean state_bill;

}
