package boms.management.billng.api.repository;

import java.util.List;
import java.util.UUID;

import org.springframework.data.cassandra.repository.CassandraRepository;
import org.springframework.data.cassandra.repository.Query;

import boms.management.billng.api.model.Customer;


public interface CustomerRepository extends CassandraRepository<Customer, UUID>{
	List<Customer> findByNameContaining(String name);
	
	@Query("SELECT * FROM customer WHERE name = ?0 ALLOW FILTERING")
	List<Customer> findByName(String name);

}
