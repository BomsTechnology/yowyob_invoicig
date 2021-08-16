package boms.management.billng.api.controller;

import java.text.SimpleDateFormat;
import java.util.ArrayList;
import java.util.Date;
import java.util.List;
import java.util.Optional;
import java.util.UUID;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.http.HttpStatus;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.CrossOrigin;
import org.springframework.web.bind.annotation.DeleteMapping;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.PathVariable;
import org.springframework.web.bind.annotation.PostMapping;
import org.springframework.web.bind.annotation.PutMapping;
import org.springframework.web.bind.annotation.RequestBody;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RestController;

import boms.management.billng.api.model.BillByCustomer;
import boms.management.billng.api.model.BillbyCustomerKey;
import boms.management.billng.api.repository.BillByCustomerRepository;

@CrossOrigin(origins = "http://localhost:8080")
@RestController
@RequestMapping("/api")
public class BillByCustomerController {
	
	@Autowired
	BillByCustomerRepository billByCustomerRepository;
	
	  @GetMapping("/billByCustomers")
	  public ResponseEntity<List<BillByCustomer>> getAllBillByCustomers() {
	    try {
	      List<BillByCustomer> billByCustomers = new ArrayList<BillByCustomer>();

	    	  billByCustomerRepository.findAll().forEach(billByCustomers::add);

	      return new ResponseEntity<>(billByCustomers, HttpStatus.OK);
	    } catch (Exception e) {
	      return new ResponseEntity<>(null, HttpStatus.INTERNAL_SERVER_ERROR);
	    }
	  }

	  @PostMapping("/billByCustomers")
	  public ResponseEntity<BillByCustomer> createTutorial(@RequestBody BillByCustomer billByCustomer) {
	    try {
	    	SimpleDateFormat simpleDateFormat = new SimpleDateFormat("yyyy-MM-dd HH:mm:ss");
	    	String date = simpleDateFormat.format(new Date());
	    	BillByCustomer _billByCustomer = billByCustomerRepository.insert(new BillByCustomer(billByCustomer.getKey(), date, billByCustomer.getAmount(), billByCustomer.getTva(), false, true));
	      return new ResponseEntity<>(_billByCustomer, HttpStatus.CREATED);
	    } catch (Exception e) {
	    	e.printStackTrace();
	      return new ResponseEntity<>(null, HttpStatus.INTERNAL_SERVER_ERROR);
	    }
	  }
	  
	  
	  @PutMapping("/billByCustomers/pay")
	  public ResponseEntity<BillByCustomer> payBill(@RequestBody BillbyCustomerKey key) {
	    Optional<BillByCustomer> billByCustomerData = billByCustomerRepository.findById(key);

	    if (billByCustomerData.isPresent()) {
	    	BillByCustomer _billByCustomer = billByCustomerData.get();
	    	_billByCustomer.setState_payment(true);
	      return new ResponseEntity<>(billByCustomerRepository.save(_billByCustomer), HttpStatus.OK);
	    } else {
	      return new ResponseEntity<>(HttpStatus.NOT_FOUND);
	    }
	  }
	  
	  @PutMapping("/billByCustomers/cancel")
	  public ResponseEntity<BillByCustomer> cancelBill(@RequestBody BillbyCustomerKey key) {
	    Optional<BillByCustomer> billByCustomerData = billByCustomerRepository.findById(key);

	    if (billByCustomerData.isPresent()) {
	    	BillByCustomer _billByCustomer = billByCustomerData.get();
	    	_billByCustomer.setState_bill(false);
	      return new ResponseEntity<>(billByCustomerRepository.save(_billByCustomer), HttpStatus.OK);
	    } else {
	      return new ResponseEntity<>(HttpStatus.NOT_FOUND);
	    }
	  }
          
      @PutMapping("/billByCustomers/apay")
	  public ResponseEntity<BillByCustomer> aPayBill(@RequestBody BillbyCustomerKey key) {
	    Optional<BillByCustomer> billByCustomerData = billByCustomerRepository.findById(key);

	    if (billByCustomerData.isPresent()) {
	    	BillByCustomer _billByCustomer = billByCustomerData.get();
	    	_billByCustomer.setState_payment(false);
	      return new ResponseEntity<>(billByCustomerRepository.save(_billByCustomer), HttpStatus.OK);
	    } else {
	      return new ResponseEntity<>(HttpStatus.NOT_FOUND);
	    }
	  }

	  @DeleteMapping("/billByCustomers")
	  public ResponseEntity<HttpStatus> deleteBill(@RequestBody BillbyCustomerKey key) {
	    try {
	    	billByCustomerRepository.deleteById(key);
	      return new ResponseEntity<>(HttpStatus.NO_CONTENT);
	    } catch (Exception e) {
	      return new ResponseEntity<>(HttpStatus.INTERNAL_SERVER_ERROR);
	    }
	  }
	  
	  @GetMapping("/billByCustomers/bills/{id}")
	  public ResponseEntity<List<BillByCustomer>> findByBillId(@PathVariable("id") UUID id) {
	    try {
	      List<BillByCustomer> billByCustomers = billByCustomerRepository.findByBillId(id);

	      if (billByCustomers.isEmpty()) {
	        return new ResponseEntity<>(HttpStatus.NO_CONTENT);
	      }
	      return new ResponseEntity<>(billByCustomers, HttpStatus.OK);
	    } catch (Exception e) {
	      return new ResponseEntity<>(HttpStatus.INTERNAL_SERVER_ERROR);
	    }
	  }
	  
	  @GetMapping("/billByCustomers/customers/{id}")
	  public ResponseEntity<List<BillByCustomer>> findByCustomerId(@PathVariable("id") UUID id) {
	    try {
	      List<BillByCustomer> billByCustomers = billByCustomerRepository.findByCustomerId(id);

	      if (billByCustomers.isEmpty()) {
	        return new ResponseEntity<>(HttpStatus.NO_CONTENT);
	      }
	      return new ResponseEntity<>(billByCustomers, HttpStatus.OK);
	    } catch (Exception e) {
	      return new ResponseEntity<>(HttpStatus.INTERNAL_SERVER_ERROR);
	    }
	  }

}
