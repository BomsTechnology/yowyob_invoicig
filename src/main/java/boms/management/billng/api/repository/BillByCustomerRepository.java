package boms.management.billng.api.repository;

import java.util.List;
import java.util.UUID;

import org.springframework.data.cassandra.repository.CassandraRepository;
import org.springframework.data.cassandra.repository.Query;
import org.springframework.stereotype.Repository;

import boms.management.billng.api.model.BillByCustomer;
import boms.management.billng.api.model.BillbyCustomerKey;

@Repository
public interface BillByCustomerRepository extends CassandraRepository<BillByCustomer, BillbyCustomerKey>{
	
	@Query("SELECT * FROM bill_by_customer WHERE bill_id = ?0 ALLOW FILTERING")
	List<BillByCustomer> findByBillId(UUID id);
	
	@Query("SELECT * FROM bill_by_customer WHERE customer_id = ?0")
	List<BillByCustomer> findByCustomerId(UUID id);
        
}
