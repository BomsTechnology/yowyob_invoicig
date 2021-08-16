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

import com.datastax.oss.driver.api.core.uuid.Uuids;

import boms.management.billng.api.model.Bill;
import boms.management.billng.api.repository.BillRepository;

@CrossOrigin(origins = "http://localhost:8080")
@RestController
@RequestMapping("/api")
public class BillController {
	
	@Autowired
	BillRepository billRepository;
	
	@PostMapping("/bill")
	public ResponseEntity<Bill> createBill(@RequestBody Bill bill) {
	    try {
	    	SimpleDateFormat simpleDateFormat = new SimpleDateFormat("yyyy-MM-dd HH:mm:ss");
	    	String date = simpleDateFormat.format(new Date());
	    	Bill _bill = billRepository.insert(new Bill(Uuids.timeBased(), bill.getAmount(), date, false, true, bill.getTva()));
	      return new ResponseEntity<>(_bill, HttpStatus.CREATED);
	    } catch (Exception e) {
	      return new ResponseEntity<>(null, HttpStatus.INTERNAL_SERVER_ERROR);
	    }
	  }

	@GetMapping("/bills")
	public ResponseEntity<List<Bill>> getBills() {
	    try {
	      List<Bill> bills = new ArrayList<Bill>();

	    	  billRepository.findAll().forEach(bills::add);

	      return new ResponseEntity<>(bills, HttpStatus.OK);
	    } catch (Exception e) {
	      return new ResponseEntity<>(null, HttpStatus.INTERNAL_SERVER_ERROR);
	    }
	  }


	@GetMapping("/bills/{id}")
	public ResponseEntity<Bill> getBillById(@PathVariable("id") UUID id) {
	    Optional<Bill> billData = billRepository.findById(id);

	    if (billData.isPresent()) {
	      return new ResponseEntity<>(billData.get(), HttpStatus.OK);
	    } else {
	      return new ResponseEntity<>(HttpStatus.NOT_FOUND);
	    }
	  }
	
	@PutMapping("/bill/pay/{id}")
	  public ResponseEntity<Bill> payBill(@PathVariable("id") UUID id) {
	    Optional<Bill> billData = billRepository.findById(id);

	    if (billData.isPresent()) {
	    	Bill _bill = billData.get();
	    	_bill.setState_payment(true);
	      return new ResponseEntity<>(billRepository.save(_bill), HttpStatus.OK);
	    } else {
	      return new ResponseEntity<>(HttpStatus.NOT_FOUND);
	    }
	  }
          
      @PutMapping("/bill/cancel/{id}")
	  public ResponseEntity<Bill> cancelBill(@PathVariable("id") UUID id) {
	    Optional<Bill> billData = billRepository.findById(id);

	    if (billData.isPresent()) {
	    	Bill _bill = billData.get();
	    	_bill.setState_payment(false);
	      return new ResponseEntity<>(billRepository.save(_bill), HttpStatus.OK);
	    } else {
	      return new ResponseEntity<>(HttpStatus.NOT_FOUND);
	    }
	  }
          
          
          
          

	  @DeleteMapping("/bills/{id}")
	  public ResponseEntity<HttpStatus> deleteBill(@PathVariable("id") UUID id) {
	    try {
	    	billRepository.deleteById(id);
	      return new ResponseEntity<>(HttpStatus.NO_CONTENT);
	    } catch (Exception e) {
	      return new ResponseEntity<>(HttpStatus.INTERNAL_SERVER_ERROR);
	    }
	  }
	
}
