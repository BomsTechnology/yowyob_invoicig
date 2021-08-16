package boms.management.billng.api.repository;

import java.util.List;
import java.util.UUID;

import org.springframework.data.cassandra.repository.CassandraRepository;
import org.springframework.data.cassandra.repository.Query;

import boms.management.billng.api.model.ProductByBill;
import boms.management.billng.api.model.ProductByBillKey;

public interface ProductByBillRepository extends CassandraRepository<ProductByBill, ProductByBillKey>{
	
	@Query("SELECT * FROM product_by_bill WHERE bill_id = ?0")
	List<ProductByBill> findByBillId(UUID id);

}
