package boms.management.billng.api.repository;

import java.util.List;
import java.util.UUID;

import org.springframework.data.cassandra.repository.CassandraRepository;

import boms.management.billng.api.model.Product;
import org.springframework.data.cassandra.repository.Query;


public interface ProductRepository extends CassandraRepository<Product, UUID>{
	List<Product> findByNameContaining(String name);
            
        @Query("SELECT * FROM product WHERE name = ?0")
        public List<Product> search(String value);
}
