package boms.management.billng.api.model;

import java.util.UUID;

import org.springframework.data.cassandra.core.mapping.PrimaryKey;
import org.springframework.data.cassandra.core.mapping.Table;

import lombok.AllArgsConstructor;
import lombok.Data;
import lombok.NoArgsConstructor;

@Table
@Data
@AllArgsConstructor
@NoArgsConstructor
public class Bill {
	
	@PrimaryKey
	private UUID id;

	private float amount;
	private String date;
	private boolean state_payment;
	private boolean state_bill;
	private float tva;

}
