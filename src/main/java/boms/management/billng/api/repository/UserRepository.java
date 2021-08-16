package boms.management.billng.api.repository;

import java.util.Optional;
import java.util.UUID;

import org.springframework.data.cassandra.repository.CassandraRepository;
import org.springframework.data.cassandra.repository.Query;

import boms.management.billng.api.model.User;

public interface UserRepository extends CassandraRepository<User, UUID>{
	
	@Query("SELECT * FROM user WHERE login = ?0 AND password = ?1 ALLOW FILTERING")
	Optional<User> authentificate(String login, String password);
	
}
