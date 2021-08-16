package boms.management.billng.api.repository;


import java.util.UUID;

import org.springframework.data.cassandra.repository.CassandraRepository;

import boms.management.billng.api.model.Bill;

public interface BillRepository extends CassandraRepository<Bill, UUID>{

}