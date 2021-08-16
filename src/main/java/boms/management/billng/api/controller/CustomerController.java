package boms.management.billng.api.controller;

import java.util.ArrayList;
import java.util.List;
import java.util.Optional;
import java.util.UUID;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.http.HttpStatus;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.CrossOrigin;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.PathVariable;
import org.springframework.web.bind.annotation.PostMapping;
import org.springframework.web.bind.annotation.RequestBody;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RequestParam;
import org.springframework.web.bind.annotation.RestController;

import com.datastax.oss.driver.api.core.uuid.Uuids;

import boms.management.billng.api.model.Customer;
import boms.management.billng.api.repository.CustomerRepository;

@CrossOrigin(origins = "http://localhost:8080")
@RestController
@RequestMapping("/api")
public class CustomerController {
	
	@Autowired
	CustomerRepository customerRepository;
	
	  @PostMapping("/customers")
	  public ResponseEntity<Customer> createCustomer(@RequestBody Customer customer) {
	    try {
	    	Customer _customer = customerRepository.save(new Customer(Uuids.timeBased(), customer.getName(), customer.getFisrtname(), customer.getContact()));
	      return new ResponseEntity<>(_customer, HttpStatus.CREATED);
	    } catch (Exception e) {
	      return new ResponseEntity<>(null, HttpStatus.INTERNAL_SERVER_ERROR);
	    }
	  }
	  
	  @GetMapping("/customers")
	  public ResponseEntity<List<Customer>> getCustomers(@RequestParam(required = false) String name) {
	    try {
	      List<Customer> customers = new ArrayList<Customer>();

	      if (name == null)
	    	  customerRepository.findAll().forEach(customers::add);
	      else
	    	  customerRepository.findByNameContaining(name).forEach(customers::add);

	      if (customers.isEmpty()) {
	        return new ResponseEntity<>(HttpStatus.NO_CONTENT); 
	      }

	      return new ResponseEntity<>(customers, HttpStatus.OK);
	    } catch (Exception e) {
	      return new ResponseEntity<>(null, HttpStatus.INTERNAL_SERVER_ERROR);
	    }
	  }
	  
	  @GetMapping("/customers/{id}")
	  public ResponseEntity<Customer> getCustomerById(@PathVariable("id") UUID id) {
	    Optional<Customer> customerData = customerRepository.findById(id);

	    if (customerData.isPresent()) {
	      return new ResponseEntity<>(customerData.get(), HttpStatus.OK);
	    } else {
	      return new ResponseEntity<>(HttpStatus.NOT_FOUND);
	    }
	  }
	  
	  /*@GetMapping("/customers/name/{name}")
	  public ResponseEntity<List<Customer>> findByName(@PathVariable("name") String name) {
		  try {
		      List<Customer> customers = customerRepository.findByName(name);

		      if (customers.isEmpty()) {
		        return new ResponseEntity<>(HttpStatus.NO_CONTENT);
		      }
		      return new ResponseEntity<>(customers, HttpStatus.OK);
		    } catch (Exception e) {
		      return new ResponseEntity<>(HttpStatus.INTERNAL_SERVER_ERROR);
		    }
	  }*/

}
